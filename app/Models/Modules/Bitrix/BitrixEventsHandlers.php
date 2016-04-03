<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BitrixEventsHandlers extends Model{
	protected $table = 'bitrix_events_handlers';

	protected $fillable = ['from_module', 'event', 'class', 'method', 'php_code'];

	public static function store(Bitrix $module, $fields){
		// todo почему я должен так явно всё это расписывать?
		if (!isset($fields['from_module'])){
			return false;
		}
		if (!isset($fields['event'])){
			return false;
		}
		if (!isset($fields['class'])){
			return false;
		}
		if (!isset($fields['method'])){
			return false;
		}


		$handler = new BitrixEventsHandlers($fields);

		if ($module->handlers()->save($handler)){
			return $handler->id;
		}

		return false;
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

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
