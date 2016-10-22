<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Http\Utilities\Bitrix\BitrixComponentsParamsTypes;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixComponentsParamsGroups;

class BitrixComponentsTemplatesController extends Controller{
	use UserOwnModule;

	public function index(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'    => $module,
			'component' => $component,
			'templates' => $component->templates()->get()
		];

		return view("bitrix.components.templates.index", $data);
	}

	public function create(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'    => $module,
			'component' => $component,
			'template'  => null,
		];

		return view("bitrix.components.templates.detail", $data);
	}

	public function store(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

		$templateCode = strtolower($request->code);
		$template = BitrixComponentsTemplates::updateOrCreate(
			[
				'component_id' => $component->id,
				'code'         => $templateCode,
			],
			[
				'component_id' => $component->id,
				'code'         => $templateCode,
				'name'         => $request->name
			]
		);
		$disk = $module->disk();

		if ($request->template_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'template.php', $request->template_php);
		}
		if ($request->style_css){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'style.css', $request->style_css);
		}
		if ($request->script_js){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'script.js', $request->script_js);
		}
		if ($request->result_modifier_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'result_modifier.php', $request->result_modifier_php);
		}
		if ($request->component_epilog_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'component_epilog.php', $request->component_epilog_php);
		}

		return redirect(action('Modules\Bitrix\BitrixComponentsTemplatesController@show', [$module->id, $component->id, $template->id]));
	}

	public function upload(Bitrix $module, BitrixComponent $component, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}

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
			$module->disk()->put($template->getFolder().DIRECTORY_SEPARATOR.'template.php', $template_php);
		}else{
			$template->extractUploadedZip($archive);
		}
		$component->saveStep(6);

		return back();
	}

	public function show(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsTemplate($component, $template)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'    => $module,
			'component' => $component,
			'template'  => $template,
		];

		return view("bitrix.components.templates.detail", $data);
	}

	public function update(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsTemplate($component, $template)){
			return $this->unauthorized($request);
		}

		$disk = $module->disk();

		$template->update(
			[
				'component_id' => $component->id,
				'name'         => $request->name
			]
		);

		if ($request->template_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'template.php', $request->template_php);
		}
		if ($request->style_css){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'style.css', $request->style_css);
		}
		if ($request->script_js){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'script.js', $request->script_js);
		}
		if ($request->result_modifier_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'result_modifier.php', $request->result_modifier_php);
		}
		if ($request->component_epilog_php){
			$disk->put($template->getFolder().DIRECTORY_SEPARATOR.'component_epilog.php', $request->component_epilog_php);
		}

		return back();
	}

	public function destroy(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsTemplate($component, $template)){
			return $this->unauthorized($request);
		}

		if ($template->code == '.default'){
			return redirect(route('bitrix_component_templates', ['module' => $module->id, 'component' => $component->id])); // todo возвращать ошибку
		}

		$module->disk()->deleteDirectory($template->getFolder());

		// удаляем запись из БД
		BitrixComponentsTemplates::destroy($template->id);

		return redirect(route('bitrix_component_templates', [$module->id, $component->id]));
	}

	public function show_params(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsTemplate($component, $template)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'        => $module,
			'component'     => $component,
			'template'      => $template,
			'params'        => $template->params()->orderBy('sort', 'asc')->get(),
			'params_types'  => BitrixComponentsParamsTypes::all(),
			'params_groups' => BitrixComponentsParamsGroups::all()
		];

		return view("bitrix.components.templates.params.index", $data);
	}

	public function show_files(Bitrix $module, BitrixComponent $component, BitrixComponentsTemplates $template, Request $request){
		if (!$this->moduleOwnsComponent($module, $component)){
			return $this->unauthorized($request);
		}
		if (!$this->componentsOwnsTemplate($component, $template)){
			return $this->unauthorized($request);
		}

		$data = [
			'module'    => $module,
			'component' => $component,
			'template'  => $template,
			'files'     => $template->arbitraryFiles()->get()
		];

		return view("bitrix.components.templates.arbitrary_files.index", $data);
	}
}
