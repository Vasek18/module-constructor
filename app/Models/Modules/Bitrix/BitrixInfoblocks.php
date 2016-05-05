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

		$iblocksCreationFunctionCodeTemplate = substr($file, strpos($file, "\t".'public function createNecessaryIblocks(){'), strpos($file, "\t".'} // createNecessaryIblocks') - strpos($file, "\t".'public function createNecessaryIblocks(){') + strlen("\t".'} // createNecessaryIblocks'));
		$iblocksDeletionFunctionCodeTemplate = substr($file, strpos($file, "\t".'public function deleteNecessaryIblocks(){'), strpos($file, "\t".'} // deleteNecessaryIblocks') - strpos($file, "\t".'public function deleteNecessaryIblocks(){') + strlen("\t".'} // deleteNecessaryIblocks'));
		//dd($iblocksDeletionFunctionCodeTemplate);

		$iblocksDeletionFunctionCode = "\t".'public function deleteNecessaryIblocks(){'.PHP_EOL.
			"\t"."\t".'$this->removeIblockType();'.PHP_EOL.
			"\t".'} // createNecessaryIblocks';

		$iblocksCreationFunctionCode = "\t".'public function createNecessaryIblocks(){'.PHP_EOL;
		$iblocksCreationFunctionCode .= "\t\t".'$this->createIblockType();'.PHP_EOL;

		$iblocks = $module->infoblocks();
		foreach ($iblocks as $iblock){
			$iblocksCreationFunctionCode .= "\t\t".'$this->createIblock('.PHP_EOL;
			$iblocksCreationFunctionCode .= "\t\t\t".'Array('.PHP_EOL;
			foreach ($iblock->params as $paramCode => $paramVal){
				$iblocksCreationFunctionCode .= "\t\t\t\t\t".'"'.$paramCode.'"'." => ".'"'.$paramVal.'",'.PHP_EOL;
			}
			$iblocksCreationFunctionCode .= "\t\t\t".')'.PHP_EOL;
			$iblocksCreationFunctionCode .= "\t\t".');'.PHP_EOL;
		}

		$iblocksCreationFunctionCode .= "\t".'} // createNecessaryIblocks'.PHP_EOL;


		$search = [$iblocksCreationFunctionCodeTemplate, $iblocksDeletionFunctionCodeTemplate];
		$replace = [$iblocksCreationFunctionCode, $iblocksDeletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		Storage::disk('user_modules')->put($path, $file);

		return true;
	}

	public function getParamsAttribute($value){
		return json_decode($value);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
