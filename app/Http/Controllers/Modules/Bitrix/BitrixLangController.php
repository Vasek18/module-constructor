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
		// dd(vLang::getAllPotentialPhrases('<a>ololo</a><p>ololo</p>'));
		$file = $module->module_folder.Input::get('file');
		if (!$module->disk()->exists($file)){
			return back();
		}
		$contentOriginal = $module->disk()->get($file);

		$phrases = vLang::getAllPotentialPhrases($contentOriginal);

		$content = htmlentities($contentOriginal);
		$content = str_replace("\n", '<br>', $content);

		$i = 0;
		foreach ($phrases as $phrase){
			$wrapPre = '<span class="bg-danger">';
			$wrapAfter = '</span>';
			$textBefore = str_replace("\n", '<br>', htmlentities(substr($contentOriginal, 0, $phrase["start_pos"])));
			$start_pos = strlen($textBefore) + $i * (strlen($wrapPre) + strlen($wrapAfter));

			if ($phrase['phrase'] == 'close'){
				// dd(substr($contentOriginal, 0, $phrase["start_pos"]));
				// dd($phrase);
				// dd(htmlentities(substr($contentOriginal, 0, $phrase["start_pos"])));
				// dd(strlen(''));
			}
			$content = substr_replace($content, $wrapPre.htmlentities($phrase['phrase']).$wrapAfter, $start_pos, strlen(htmlentities($phrase['phrase'])));
			$i++;
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