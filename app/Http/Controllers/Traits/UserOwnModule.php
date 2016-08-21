<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;
use App\Models\Modules\Bitrix\BitrixComponentsParams;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixMailEvents;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;
use App\Models\Modules\Bitrix\BitrixMailEventsTemplate;

trait UserOwnModule{
	protected function userCreatedModule($id){
		return Bitrix::where([
			'id'      => $id,
			'user_id' => $this->user->id
		])->exists();
	}

	protected function unauthorized(Request $request){
		if ($request->ajax()){
			return response(['message' => 'Nea'], 403);
		}

		return redirect('/personal');
	}

	protected function moduleOwnsComponent(Bitrix $module, BitrixComponent $component){
		return $component->module->id == $module->id;
	}

	protected function componentOwnsArbitraryFile(BitrixComponent $component, BitrixComponentsArbitraryFiles $file){
		return $file->component->id == $component->id;
	}

	protected function componentsOwnsParam(BitrixComponent $component, BitrixComponentsParams $param){
		return $param->component->id == $component->id;
	}

	protected function componentsOwnsTemplate(BitrixComponent $component, BitrixComponentsTemplates $template){
		return $template->component->id == $component->id;
	}

	protected function moduleOwnsOption(Bitrix $module, BitrixAdminOptions $option){
		return $option->module->id == $module->id;
	}

	protected function moduleOwnsMailEvent(Bitrix $module, BitrixMailEvents $event){
		return $event->module->id == $module->id;
	}

	protected function mailEventOwnsVar(BitrixMailEvents $event, BitrixMailEventsVar $var){
		return $var->mailEvent->id == $event->id;
	}

	protected function mailEventOwnsTemplate(BitrixMailEvents $event, BitrixMailEventsTemplate $template){
		return $template->mailEvent->id == $event->id;
	}
}

?>