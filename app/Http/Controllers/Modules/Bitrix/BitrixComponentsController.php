<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Storage;

class BitrixComponentsController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function show($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		$components = BitrixAdminOptions::where('module_id', $module_id)->get();
		$data = [
			'module'     => Bitrix::find($module_id),
			'components' => $components
		];

		return view("bitrix.components.components", $data);
	}

	// страница добавления компонента
	public function create($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module' => Bitrix::find($module_id),
		];

		return view("bitrix.components.new", $data);
	}

	// добавление компонента
	public function store($module_id, Request $request){
		if (!$this->userCreatedModule($module_id)){
			return $this->unauthorized($request);
		}
		//dd($request->all());
		$id = BitrixComponent::store($module_id, $request);

		//
		return redirect(route('bitrix_module_detail', $module_id));
	}

	// загрузка архива с компонентом
	// todo сейчас работает только с зипом
	public function upload_zip(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		//dd($request->file('archive'));
		//dd(Storage::disk('user_modules')->);

		$fileName = $this->moveComponentToPublic($request);
		$this->extractComponentToModuleFolder($module, $fileName);

		return redirect(route('bitrix_module_components', $module->id));
	}

	public function moveComponentToPublic(Request $request){
		$archive = $request->file('archive');
		$fileName = time().$archive->getClientOriginalName();
		$archive->move('user_upload/', $fileName);
		return $fileName;
	}

	public function extractComponentToModuleFolder(Bitrix $module, $fileName){
		$moduleFullID = $module->PARTNER_CODE.".".$module->MODULE_CODE; // todo вынести в вычисляемое поле
		// если вдруг папки для компонентов нет => создаём её
		Storage::disk('user_modules')->makeDirectory($moduleFullID."/install/components/".$moduleFullID);

		$moduleFolder = $module::getFolder($module);
		$zipper = new \Chumper\Zipper\Zipper;
		$zipper->make('user_upload/'.$fileName)->extractTo($moduleFolder.'/install/components/'.$moduleFullID);
	}
}
