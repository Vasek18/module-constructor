<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

class BitrixArbitraryFiles extends Model{
	protected $table = 'bitrix_arbitrary_files';
	protected $fillable = ['module_id', 'path', 'filename'];
	public $timestamps = false;

	public function putFileInModuleFolder($path, $file){
		$file->move($this->getFullPath($path), $file->getClientOriginalName());
	}

	public function deleteFileFromModuleFolder(){
		$file = $this->getFullPath().$this->filename;
		if (file_exists($file)){
			unlink($file);
		}
	}

	public function getFullPath($path = null){
		if (!$path){
			$path = $this->path;
		}
		$moduleFolder = $this->module->getFolderD(true);

		return $moduleFolder.'/install/files'.$path;
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
