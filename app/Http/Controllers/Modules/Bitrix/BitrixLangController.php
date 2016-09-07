<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Input;
use App\Helpers\vLang;

class BitrixLangController extends Controller{

	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$data = [
			'module' => $module,
			'files'  => $module->getListOfAllFiles(['php', 'html'], true)
		];

		return view("bitrix.lang.index", $data);
	}

	public function edit(Bitrix $module, Request $request){
		// dd(vLang::getAllPotentialPhrases('src="<?"photo.jpg";? >"'));
		$file = $module->module_folder.Input::get('file');
		if (!$module->disk()->exists($file)){
			return back();
		}
		$content = $module->disk()->get($file);

		$phrases = vLang::getAllPotentialPhrases($content);

		$content = htmlentities($content);
		$content = str_replace("\n", '<br>', $content);

		foreach ($phrases as $phrase){
			$content = str_replace(htmlentities($phrase['phrase']), '<span class="bg-danger">'.htmlentities($phrase['phrase']).'</span>', $content);
		}

		$data = [
			'module'  => $module,
			'content' => $content,
			'file'    => $file,
			'phrases' => $phrases,
		];

		return view("bitrix.lang.edit", $data);

	}
}