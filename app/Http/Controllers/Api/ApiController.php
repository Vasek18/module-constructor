<?php

namespace App\Http\Controllers\Api;

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksPropsVals;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Yaml\Tests\B;

class ApiController extends Controller{
	public function getUserInfo(Request $request){
		return $request->user();
	}

	public function getModulesList(Request $request){
		$modules = $request->user()->modules()->get(['id', 'name', 'description', 'code', 'PARTNER_CODE']);

		$response = [];
		foreach ($modules as $c => $module){
			$moduleArr = [
				'name'         => $module['name'],
				'description'  => $module['description'],
				'code'         => $module['code'],
				'partner_code' => $module['PARTNER_CODE'],
			];
			if (BitrixComponent::where('module_id', $module->id)->count()){
				$moduleArr['components'] = BitrixComponent::where('module_id', $module->id)->get(['name', 'code', 'namespace']);
			}
			if (BitrixInfoblocks::where('module_id', $module->id)->count()){
				$iblocks = BitrixInfoblocks::where('module_id', $module->id)->get(['name', 'code']);
				foreach ($iblocks as $iblock){
					$iblock['type'] = $module->class_name.'_iblock_type';
					$moduleArr['iblocks'][] = $iblock;
				}
			}

			$response[] = $moduleArr;
		}

		return $response;
	}

	public function importIblock($moduleFullCode, Request $request){
		// получаем модуль
		list($partnerCode, $moduleCode) = explode('.', $moduleFullCode);
		$module = Bitrix::where('user_id', $request->user()->id)->where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->first();
		if (!$module){
			return ['error' => 'Not found module'];
		}

		$iblockArr = unserialize($request->IBLOCK);
		if (!isset($iblockArr['CODE']) || !$iblockArr['CODE']){
			return ['error' => 'No iblock code'];
		}
		if (!isset($iblockArr['NAME']) || !$iblockArr['NAME']){
			return ['error' => 'No iblock name'];
		}
		$iblockName = $iblockArr['NAME'];
		$iblockCode = $iblockArr['CODE'];
		// если инфоблока нет, создаём его, иначе обновим
		$iblock = BitrixInfoblocks::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'      => $iblockCode,
			],
			[
				'module_id' => $module->id,
				'code'      => $iblockCode,
				'name'      => $iblockName,
				'params'    => json_encode($iblockArr),
			]
		);

		if ($iblock->id){
			// импортируем свойства
			$propertiesArr = unserialize($request->PROPERTIES);
			if ($propertiesArr){
				foreach ($propertiesArr as $propertyArr){

					if (isset($propertyArr["CODE"]) && $propertyArr["CODE"]){
						$prop = BitrixIblocksProps::updateOrCreate(
							[
								'iblock_id' => $iblock->id,
								'code'      => $propertyArr["CODE"]
							],
							[
								'iblock_id'   => $iblock->id,
								'code'        => $propertyArr["CODE"],
								'name'        => $propertyArr['NAME'],
								'sort'        => isset($propertyArr["SORT"]) ? $propertyArr["SORT"] : '500',
								'type'        => isset($propertyArr["PROPERTY_TYPE"]) ? $propertyArr["PROPERTY_TYPE"].((isset($propertyArr['USER_TYPE']) && $propertyArr['USER_TYPE']) ? ':'.$propertyArr['USER_TYPE'] : '') : 'S',
								'multiple'    => (isset($propertyArr["MULTIPLE"]) && $propertyArr["MULTIPLE"] == "Y") ? true : false,
								'is_required' => (isset($propertyArr["IS_REQUIRED"]) && $propertyArr["IS_REQUIRED"] == "Y") ? true : false,
								'dop_params'  => json_encode($propertyArr)
							]
						);
					}

					// варианты свойства
					if ($prop->type = 'L' && isset($propertyArr["VALUES"])){
						foreach ($propertyArr["VALUES"] as $vc => $valueArr){
							if (isset($valueArr['VALUE']) && $valueArr['VALUE']){
								$val = BitrixIblocksPropsVals::updateOrCreate(
									[
										'prop_id' => $prop->id,
										'value'   => $valueArr['VALUE']
									],
									[
										'prop_id' => $prop->id,
										'value'   => $valueArr['VALUE'],
										'xml_id'  => isset($valueArr['XML_ID']) ? $valueArr['XML_ID'] : '',
										'sort'    => isset($valueArr['SORT']) ? $valueArr['SORT'] : '500',
										'default' => isset($valueArr['DEF']) ? $valueArr['DEF'] == 'Y' : false,
									]
								);
							}
						}
					}
				}
			}

			// записываем инфоблок в файлы модуля
			BitrixInfoblocks::writeInFile($module);

			return [
				'success' => true,
				'iblock'  => [
					'code' => $iblock->code
				],
			];
		}

		return ['error' => 'Undefined error'];
	}

	public function importComponent($moduleFullCode, Request $request){
		// получаем модуль
		list($partnerCode, $moduleCode) = explode('.', $moduleFullCode);
		$module = Bitrix::where('user_id', $request->user()->id)->where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->first();
		if (!$module){
			return ['error' => 'Not found module'];
		}

		$fileName = $this->moveComponentToPublic($request);
		if (!$fileName){
			return ['error' => 'Cannot upload file'];
		}
		$this->extractComponentToModuleFolder($module, $fileName, $request->namespace);
		$componentCode = $this->getComponentCodeFromFolder($fileName);
		unlink(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$component = $this->createEmptyComponent($module, $componentCode, $request->namespace);
		if ($component->id){
			$component->parseDescriptionFile();
			$component->parseParamsFile();
			$component->gatherListOfArbitraryFiles();
			$component->parseTemplates();

			return [
				'success'   => true,
				'component' => [
					'code' => $component->code
				],
			];
		}

		return ['error' => 'Undefined error'];
	}

	// полная копия с BitrixComponentsController
	public function moveComponentToPublic(Request $request){
		$uploadFolder = public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR;

		$archive = $request->file('archive');
		if (!$archive){
			return false;
		}else{
			$fileName = time().$archive->getClientOriginalName();
			$archive->move($uploadFolder, $fileName);
		}

		return $fileName;
	}

	// полная копия с BitrixComponentsController
	public function extractComponentToModuleFolder(Bitrix $module, $fileName, $namespace){
		// если вдруг папки для компонентов нет => создаём её
		$module->disk()->makeDirectory($module->module_full_id.DIRECTORY_SEPARATOR."install".DIRECTORY_SEPARATOR."components".DIRECTORY_SEPARATOR.$namespace);

		$moduleFolder = $module->getFolder();
		$zipper = new Zipper;
		$zipper->make(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$zipper->extractTo($moduleFolder.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$namespace);

		return true;
	}

	// полная копия с BitrixComponentsController
	public function getComponentCodeFromFolder($fileName){
		$zipper = new Zipper;
		$zipper->make(public_path().DIRECTORY_SEPARATOR.'user_upload'.DIRECTORY_SEPARATOR.$fileName);
		$files = $zipper->listFiles();
		$path = explode('/', $files[0]);

		return $path[0];
	}

	// полная копия с BitrixComponentsController
	public function createEmptyComponent(Bitrix $module, $componentCode, $namespace){
		BitrixComponent::where(['module_id' => $module->id, 'code' => $componentCode])->delete(); // не обновляем, а удаляем, чтобы каскадно удалить записи из связанных таблиц

		$component = new BitrixComponent;
		$component->module_id = $module->id;
		$component->code = $componentCode;
		$component->namespace = $namespace;
		$component->save();

		return $component;
	}

	public function importAdminpage($moduleFullCode, Request $request){
		// получаем модуль
		list($partnerCode, $moduleCode) = explode('.', $moduleFullCode);
		$module = Bitrix::where('user_id', $request->user()->id)->where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->first();
		if (!$module){
			return ['error' => 'Not found module'];
		}

		if (!$request->file_content){
			return ['error' => 'No file'];
		}
		if (!$request->lang_file_content){
			return ['error' => 'No lang file'];
		}
		if (!$request->name){
			return ['error' => 'No name field'];
		}
		if (!$request->code){
			return ['error' => 'No code field'];
		}
		if (!$request->parent_menu){
			return ['error' => 'No parent menu field'];
		}

		$admin_menu_page = BitrixAdminMenuItems::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'      => $request->code,
			],
			[
				'module_id'   => $module->id,
				'name'        => $request->name,
				'code'        => $request->code,
				'parent_menu' => $request->parent_menu,
				'sort'        => $request->sort ?: 500,
				'text'        => $request->text ?: $request->name,
				'php_code'    => $request->file_content,
				'lang_code'   => $request->lang_file_content,
			]
		);

		if ($admin_menu_page->id){
			BitrixAdminMenuItems::storeInModuleFolder($module);

			return [
				'success' => true,
				'file'    => [
					'code' => $admin_menu_page->code
				]
			];
		}

		return ['error' => 'Undefined error'];
	}

	public function importOtherfile($moduleFullCode, Request $request){
		// получаем модуль
		list($partnerCode, $moduleCode) = explode('.', $moduleFullCode);
		$module = Bitrix::where('user_id', $request->user()->id)->where('PARTNER_CODE', $partnerCode)->where('code', $moduleCode)->first();
		if (!$module){
			return ['error' => 'Not found module'];
		}

		$file = $request->file('file');
		if (!$file){
			return ['error' => 'Cannot upload file'];
		}

		$path = $this->validatePath($request->path);

		$aFile = BitrixArbitraryFiles::updateOrCreate(
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName(),
				'location'  => $request->location ?: 'in_module' // todo
			],
			[
				'module_id' => $module->id,
				'path'      => $path,
				'filename'  => $file->getClientOriginalName(),
				'location'  => $request->location ?: 'in_module' // todo
			]
		);

		if ($aFile->id){
			$aFile->putFileInModuleFolder($path, $file, $request->location);

			return [
				'success' => true,
				'file'    => [
					'path'     => $aFile->path,
					'filename' => $aFile->filename,
				]
			];
		}

		return ['error' => 'Undefined error'];
	}

	protected function validatePath($path){
		if (!in_array(substr($path, 0, 1), ['/', '\\'])){
			$path = '/'.$path;
		}
		if (!in_array(substr($path, -1), ['/', '\\'])){
			$path .= '/';
		}
		$path = preg_replace('/\.+/i', '', $path); // защита от ../
		$path = preg_replace('/\\\+/i', '/', $path);
		$path = preg_replace('/\/\/+/i', '/', $path);

		return $path;
	}
}
