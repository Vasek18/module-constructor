<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

class BitrixInfoblocks extends Model{
	protected $table = 'bitrix_infoblocks';
	protected $fillable = ['module_id', 'name', 'code', 'params'];
	public $timestamps = false;

	// todo рефакторинг
	public static function writeInFile(Bitrix $module){
		$module_folder = $module->module_folder;
		$path = $module_folder.'/install/index.php';
		$file = Storage::disk('user_modules')->get($path);

		$iblocksCreationFunctionCodeTemplate = static::findInfoblockCreationAndDeletionCodeInInstallFile($file, 'createNecessaryIblocks');
		$iblocksCreationFunctionCode = $module->generateInfoblocksCreationFunctionCode();

		$iblocksDeletionFunctionCodeTemplate = static::findInfoblockCreationAndDeletionCodeInInstallFile($file, 'deleteNecessaryIblocks');
		$iblocksDeletionFunctionCode = $module->generateInfoblocksDeletionFunctionCode();

		$search = [$iblocksCreationFunctionCodeTemplate, $iblocksDeletionFunctionCodeTemplate];
		$replace = [$iblocksCreationFunctionCode, $iblocksDeletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		Storage::disk('user_modules')->put($path, $file);

		return true;
	}

	protected static function findInfoblockCreationAndDeletionCodeInInstallFile($file, $functionName){
		$beginningCode = "\t".'public function '.$functionName.'(){';
		$beginningPosition = strpos($file, $beginningCode);
		$endingCode = "\t".'} // '.$functionName;
		$endingPosition = strpos($file, $endingCode);
		$codeLength = $endingPosition - $beginningPosition + strlen($endingCode);

		return substr($file, $beginningPosition, $codeLength);
	}

	public function getParamsAttribute($value){
		return json_decode($value);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
