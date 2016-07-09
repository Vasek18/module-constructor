<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixArbitraryFiles extends Model{
	protected $table = 'bitrix_arbitrary_files';
	protected $fillable = ['module_id', 'path', 'filename', 'location'];
	public $timestamps = false;

	public function putFileInModuleFolder($path, $file, $location = 'on_site'){
		$file->move($this->getFullPath(true, $path, $location), $file->getClientOriginalName());
	}

	public function deleteFileFromModuleFolder(){
		$file = $this->getFullPath(true).$this->filename;
		if (file_exists($file)){
			unlink($file);
		}

		$this->module()->first()->removeEmptySubFolders();
	}

	public function getFullPath($full = false, $path = null, $location = null){
		if (!$path){
			$path = $this->path;
		}
		if (!$location){
			$location = $this->location;
		}
		$moduleFolder = $this->module->getFolder($full);

		if ($location == 'in_module'){
			return $moduleFolder.''.$path;
		}
		if ($location == 'on_site'){
			return $moduleFolder.'/install/files'.$path;
		}
	}

	public function getCodeAttribute(){
		$code = $this->module()->first()->disk()->get($this->getFullPath().$this->filename);

		return $code;
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
