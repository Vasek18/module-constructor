<?php

namespace App\Models\Modules;

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
			$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);
			$moduleIDForBitrix = $module->PARTNER_CODE.".".$module->MODULE_CODE;
			$installHandlersCode = '';
			$uninstallHandlersCode = '';

			$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();

			foreach ($handlers as $handler){
				$installHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->registerEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, "'.$handler->class.'", "'.$handler->method.'");'.PHP_EOL;
				$uninstallHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, "'.$handler->class.'", "'.$handler->method.'");'.PHP_EOL;
			}
			//dd($installHandlersCode);

			// записываем код установки и удаления
			$file = Storage::disk('user_modules')->get($moduleIDForBitrix.'/install/index.php');
			$file = preg_replace('/function InstallEvents\(\)\{[^\}]+\}/i', 'function InstallEvents(){'.PHP_EOL.$installHandlersCode.PHP_EOL.'}', $file);
			$file = preg_replace('/function UnInstallEvents\(\)\{[^\}]+\}/i', 'function InstallEvents(){'.PHP_EOL.$uninstallHandlersCode.PHP_EOL.'}', $file);
			Storage::disk('user_modules')->put($moduleIDForBitrix.'/install/index.php', $file);
		}
	}
}
