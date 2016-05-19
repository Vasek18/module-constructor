<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BitrixComponentsArbitraryFiles extends Model{
	protected $table = 'bitrix_components_arbitrary_files';
	protected $fillable = ['component_id', 'filename', 'path'];
	public $timestamps = false;

	public function deleteFile(){
		$file = $this->getFullPath(true).$this->filename;
		if (file_exists($file)){
			unlink($file);
		}
	}

	public function getFullPath($full = false, $path = null){
		if (!$path){
			$path = $this->path;
		}
		$componentFolder = $this->component->getFolder($full);

		return $componentFolder.$path;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}
}
