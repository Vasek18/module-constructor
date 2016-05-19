<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use Illuminate\Support\Facades\Storage;

class BitrixComponentsTemplatesController extends Controller{
	use UserOwnModule;

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		$data = [
			'module'    => $module,
			'component' => $component,
			'templates' => $component->templates()->get()
		];

		return view("bitrix.components.templates.index", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		$templateCode = strtolower($request->template_code);
		$template = BitrixComponentsTemplates::updateOrCreate(
			[
				'code'         => $templateCode,
				'component_id' => $component->id
			],
			[
				'component_id' => $component->id,
				'code'         => $templateCode,
				'name'         => $request->template_name
			]
		);

		$archive = $request->file('files');
		if (!$archive){
			$template_php = ''; // todo
			Storage::disk('user_modules')->put($template->getFolder().'\template.php', $template_php);
		}else{
			$template->extractUploadedZip($archive);
		}
		$component->saveStep(6);

		return back();
	}

	public function destroy(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){

		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		if (!$template->id){
			return false;
		}

		if ($template->code == '.default'){
			return redirect(route('bitrix_component_templates', ['module' => $module->id, 'component' => $component->id])); // todo возвращать ошибку
		}

		Storage::disk('user_modules')->deleteDirectory($template->getFolder());

		// удаляем запись из БД
		BitrixComponentsTemplates::destroy($template->id);

		return back();
	}
}
