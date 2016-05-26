<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modules\Bitrix\BitrixComponent;

class BitrixComponentsArbitraryFiles extends Model{
	protected $table = 'bitrix_components_arbitrary_files';
	protected $fillable = ['component_id', 'filename', 'path'];
	public $timestamps = false;

	public static function addInBDExistingFile($file, BitrixComponent $component){
		preg_match('/^(.*)\/([^\/]+)/is', $file, $matches); // всегда будет слеш
		$path = $matches[1];
		$fileName = $matches[2];

		if (substr($path, -1) != '/'){
			$path .= '/';
		}

		return $aFile = BitrixComponentsArbitraryFiles::updateOrCreate( // todo мб другой метод, ведь если файл есть, то мы ничего не обновляем
			[
				'component_id' => $component->id,
				'path'         => $path,
				'filename'     => $fileName
			],
			[
				'component_id' => $component->id,
				'path'         => $path,
				'filename'     => $fileName
			]
		);
	}

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
