<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminLogsController extends Controller{

	public function disk(){
		return Storage::disk('logs');
	}

	public function index(){
		$logFiles = $this->disk()->allFiles();

		// удаляем скрытые файлы
		foreach ($logFiles as $c => $logFile){
			if (substr($logFile, 0, 1) == '.'){
				unset($logFiles[$c]);
			}
		}

		$data = [
			'logs' => $logFiles
		];

		return view("admin.logs.index", $data);
	}

	public function show($file_name, Request $request){
		$content = $this->disk()->get($file_name);

		$content = nl2br($content);

		$data = [
			'file_name' => $file_name,
			'content'   => $content
		];

		return view("admin.logs.detail", $data);
	}

	public function delete($file_name, Request $request){
		$this->disk()->delete($file_name);

		return redirect(action('Admin\AdminLogsController@index'));
	}
}