<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

class BitrixArbitraryFiles extends Model{
	protected $table = 'bitrix_arbitrary_files';
	protected $fillable = ['module_id', 'path', 'filename'];
	public $timestamps = false;
	public static $filesFolderInModule = '/install/files';

	public function saveFile($path, $file){
		$moduleFolder = $this->module->getFolderD(true);

		$file->move($moduleFolder.$this->filesFolderInModule.$path, $file->getClientOriginalName());
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

}
