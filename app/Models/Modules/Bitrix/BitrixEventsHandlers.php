<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Auth;

class BitrixEventsHandlers extends Model{
	protected $table = 'bitrix_events_handlers';

	protected $fillable = ['class', 'method', 'params', 'php_code'];

	public $timestamps = false;

	// сохраняем обработчики в папку модуля
	static public function saveEventsInFolder(Bitrix $module){
		if (BitrixEventsHandlers::where('module_id', $module->id)->count()){

			$handlerTemplate = Storage::disk('modules_templates')->get('bitrix/lib/event.php');
			$installHandlersCode = '';
			$uninstallHandlersCode = '';

			$classes = [];
			$handlers = BitrixEventsHandlers::where('module_id', $module->id)->get();

			foreach ($handlers as $handler){
				foreach ($handler->events as $event){
					$installHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->registerEventHandler("'.$event->from_module.'", "'.$event->event.'", $this->MODULE_ID, \'\\'.$module->namespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;
					$uninstallHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler("'.$event->from_module.'", "'.$event->event.'", $this->MODULE_ID, \'\\'.$module->namespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;
				}
				if (isset($classes[$handler->class]) && $classes[$handler->class]['method'] == $handler->method){ // исключаем случаи создания двух одинаковых функций в одном файле
					continue;
				}
				if (!isset($classes[$handler->class])){ // если этого класса ещё не было
					$classes[$handler->class]['method'] = $handler->method;
					$classes[$handler->class]['class_namespace'] = $handler->class_namespace;
					$classes[$handler->class]['class'] = $handler->class;
					$classes[$handler->class]['functionsCode'] = $handler->getHandlerCode();
				}else{ // другой метод класса
					$classes[$handler->class]['functionsCode'] .= $handler->getHandlerCode();
				}
			}

			//dd($classes);

			foreach ($classes as $class){
				$template_search = Array('{MODULE_NAMESPACE}', '{CLASS_NAMESPACE}', '{CLASS}', '{FUNCTIONS}');
				$template_replace = Array($module->namespace, $class['class_namespace'], $class['class'], $class['functionsCode']);
				$handlerFile = str_replace($template_search, $template_replace, $handlerTemplate);
				$module->disk()->put($module->module_folder.'/lib/eventhandlers/'.strtolower($class['class']).'.php', $handlerFile);
			}
			//dd($installHandlersCode);

			BitrixEventsHandlers::writeHandlerRegisterAndUnregisterCodeInInstallFile($module, $installHandlersCode, $uninstallHandlersCode);
		}else{
			BitrixEventsHandlers::writeHandlerRegisterAndUnregisterCodeInInstallFile($module, "\t\t".'return true;'.PHP_EOL, "\t\t".'return true;'.PHP_EOL);
		}
	}

	protected static function writeHandlerRegisterAndUnregisterCodeInInstallFile($module, $installHandlersCode, $uninstallHandlersCode){
		$file = $module->disk()->get($module->module_folder.'/install/index.php');
		$file = preg_replace('/function InstallEvents\(\)\{[^\}]+\}/i', 'function InstallEvents(){'.PHP_EOL.$installHandlersCode.PHP_EOL.'}', $file);
		$file = preg_replace('/function UnInstallEvents\(\)\{[^\}]+\}/i', 'function UnInstallEvents(){'.PHP_EOL.$uninstallHandlersCode.PHP_EOL.'}', $file);
		$module->disk()->put($module->module_folder.'/install/index.php', $file);
	}

	protected function getHandlerCode(){
		$handlerFunctionTemplate = "\t".'static public function {METHOD}({PARAMS}){'."\n"."\t"."\t".'{PHP_CODE}'."\n"."\t".'}'."\n";

		$template_search = Array('{METHOD}', '{PARAMS}', '{PHP_CODE}');
		$template_replace = Array($this->method, $this->params, $this->php_code);
		$handlerCode = str_replace($template_search, $template_replace, $handlerFunctionTemplate);

		return $handlerCode;
	}

	public function getFileCodeAttribute(){
		$disk = $this->module()->first()->disk();
		$path = $this->module->module_folder.'/lib/eventhandlers/'.strtolower($this->class).'.php';
		if ($disk->exists($path)){
			return $disk->get($path);
		}

		return false;
	}

	public function getClassNamespaceAttribute(){
		return studly_case($this->class);
	}

	public function getFileAttribute(){
		return $this->module->module_folder.'/lib/eventhandlers/'.strtolower($this->class).'.php';
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function events(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixEventsHandlersEvents', 'handler_id');
	}
}
