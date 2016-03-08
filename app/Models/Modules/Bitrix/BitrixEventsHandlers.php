<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BitrixEventsHandlers extends Model{
	protected $table = 'bitrix_events_handlers';

	public static function store($fields){
		$handler = new BitrixEventsHandlers();

		// запись в БД
		$handler->module_id = $fields['module_id'];
		$handler->from_module = $fields['from_module'];
		$handler->event = $fields['event'];
		$handler->class = $fields['class'];
		$handler->method = $fields['method'];
		$handler->php_code = $fields['php_code'];
		//dd($fields);

		if ($handler->save()){
			return $handler->id;
		}
	}

	// сохраняем обработчики в папку модуля
	static public function saveEventsInFolder($module_id){
		if (BitrixEventsHandlers::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);
			$moduleIDForBitrix = $module->PARTNER_CODE.".".$module->MODULE_CODE;
			$moduleNamespace = studly_case($module->PARTNER_CODE)."\\".studly_case($module->MODULE_CODE);


			$handlerTemplate = Storage::disk('modules_templates')->get('bitrix/lib/event.php');
			$installHandlersCode = '';
			$uninstallHandlersCode = '';

			$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();
			foreach ($handlers as $handler){
				$classNamespace = studly_case($handler->class);
				$installHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->registerEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, \'\\'.$moduleNamespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;
				$uninstallHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, \'\\'.$moduleNamespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;

				$template_search = Array('{MODULE_NAMESPACE}', '{CLASS_NAMESPACE}', '{CLASS}', '{METHOD}', '{PHP_CODE}');
				$template_replace = Array($moduleNamespace, $classNamespace, $handler->class, $handler->method, $handler->php_code);
				$handlerFile = str_replace($template_search, $template_replace, $handlerTemplate);
				Storage::disk('user_modules')->put($moduleIDForBitrix.'/lib/eventhandlers/'.strtolower($handler->class).'.php', $handlerFile);
			}
			//dd($installHandlersCode);

			// записываем код установки и удаления
			$file = Storage::disk('user_modules')->get($moduleIDForBitrix.'/install/index.php');
			$file = preg_replace('/function InstallEvents\(\)\{[^\}]+\}/i', 'function InstallEvents(){'.PHP_EOL.$installHandlersCode.PHP_EOL.'}', $file);
			$file = preg_replace('/function UnInstallEvents\(\)\{[^\}]+\}/i', 'function UnInstallEvents(){'.PHP_EOL.$uninstallHandlersCode.PHP_EOL.'}', $file);
			Storage::disk('user_modules')->put($moduleIDForBitrix.'/install/index.php', $file);

			// создаём обработчики

		}
	}
}
