<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;

class BitrixComponentsArbitraryFiles extends Model{
	protected $table = 'bitrix_components_arbitrary_files';
	protected $fillable = ['component_id', 'filename', 'path', 'template_id'];
	public $timestamps = false;

	public static function addInBDExistingFile($file, BitrixComponent $component, BitrixComponentsTemplates $template = null){
		preg_match('/^(.*)\/([^\/]+)/is', $file, $matches); // всегда будет слеш
		$path = $matches[1];
		$fileName = $matches[2];

		if (substr($path, -1) != '/'){
			$path .= '/';
		}

		$bdArr = [
			'component_id' => $component->id,
			'path'         => $path,
			'filename'     => $fileName,
		];

		if ($template){
			$bdArr['template_id'] = $template->id;
		}

		// dd($bdArr);

		return $aFile = BitrixComponentsArbitraryFiles::firstOrCreate($bdArr);
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
		if ($this->template_id){
			$componentFolder = $this->template->getFolder($full);
		}

		return $componentFolder.$path;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}

	public function template(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponentsTemplates');
	}

	public function scopeForAllTemplates($query){
		return $query->where('template_id', null);
	}
}
