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
		$file = Input::get('file');
		$filePath = $module->module_folder.$file;
		if (!$module->disk()->exists($filePath)){
			return back();
		}
		$contentOriginal = $module->disk()->get($filePath);

		$phrases = vLang::getAllPotentialPhrases($contentOriginal);

		$content = htmlentities($contentOriginal);

		$search = Array("\n", "\t");
		$replace = Array("<br>", "&nbsp;&nbsp;&nbsp;&nbsp;");
		$content = str_replace($search, $replace, $content);

		$i = 0;
		foreach ($phrases as $phrase){
			$wrapPre = '<span class="bg-danger">';
			$wrapAfter = '</span>';
			$textBefore = str_replace($search, $replace, htmlentities(substr($contentOriginal, 0, $phrase["start_pos"])));
			$start_pos = strlen($textBefore) + $i * (strlen($wrapPre) + strlen($wrapAfter));

			$content = substr_replace($content, $wrapPre.htmlentities($phrase['phrase']).$wrapAfter, $start_pos, strlen(htmlentities($phrase['phrase'])));
			$i++;
		}

		$data = [
			'module'  => $module,
			'content' => $content,
			'file'    => $file,
			'phrases' => $phrases,
			'langs'   => $module->getLangsArraysForFile($filePath),
		];

		return view("bitrix.lang.edit", $data);
	}

	public function update(Bitrix $module, Request $request){
		echo "<pre>";
		print_r($request->all());
		echo "</pre>";
		$file = $request->file;
		$filePath = $module->module_folder.$file;
		if (!$module->disk()->exists($filePath)){
			return back();
		}

		if ($request->translit){
			$id = preg_replace('/.+_/', '', $request->translit);
			$action = 'translit';
		}

		if ($request->save){
			$id = preg_replace('/.+_/', '', $request->save);
			$action = 'save';
		}
		$start_pos = $request['start_pos_'.$id];
		$is_comment = $request['is_comment_'.$id];
		$code_type = $request['code_type_'.$id];
		$code = $request['code_'.$id];
		$phrase = $request['phrase_'.$id];
		$lang = $request['lang_'.$id];
		$contentOriginal = $module->disk()->get($filePath);

		if ($action == 'translit'){
			$newContent = substr_replace($contentOriginal, translit($phrase), $start_pos, strlen($phrase));
		}

		if ($action == 'save'){
			if ($code_type == 'html'){
				$langReplacement = '<?=GetMessage('.strtoupper('"'.$code.'"').');?>';
			}
			if (!$langReplacement){
				return back();
			}
			$newContent = substr_replace($contentOriginal, $langReplacement, $start_pos, strlen($phrase));

			$langRootForFile = $module->getLangRootForFile($filePath);
			$langFilePath = $langRootForFile.'/lang/'.$lang.str_replace($langRootForFile, '', $filePath);
			$module->changeVarInLangFile(strtoupper($code), $phrase, $langFilePath);
		}

		if ($newContent){
			$module->disk()->put($filePath, $newContent);
		}

		return back();
	}
}