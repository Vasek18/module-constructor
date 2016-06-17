<?php

//use App\Models\Modules\Bitrix\BitrixAdminOptions;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//use App\Helpers\vArrParse;
//
//class BitrixInfoblockFormFilesTest extends TestCase{
//
//	use DatabaseTransactions;
//
//	function createIblockOnForm($module, $params){
//		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
//		$inputs = [];
//		if (isset($params['name'])){
//			$inputs['NAME'] = $params['name'];
//		}
//		if (isset($params['code'])){
//			$inputs['CODE'] = $params['code'];
//		}
//		if (isset($params['sort'])){
//			$inputs['SORT'] = $params['sort'];
//		}
//
//		$this->submitForm('save', $inputs);
//
//		if (isset($params['code'])){
//			return BitrixInfoblocks::where('code', $params['code'])->where('module_id', $module->id)->first();
//		}
//
//		return true;
//	}
//
//	function getPropsArrayFromFile($module){
//		$optionsFileContent = $this->disk()->get($module->module_folder.'/options.php');
//		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'aTabs');
//
//		return $optionsArr;
//	}
//
//}

?>