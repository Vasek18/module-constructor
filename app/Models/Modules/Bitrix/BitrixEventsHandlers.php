<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Auth;

class BitrixEventsHandlers extends Model{
	protected $table = 'bitrix_events_handlers';

	protected $fillable = ['from_module', 'event', 'class', 'method', 'php_code'];

	public $timestamps = false;

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
		if (!$module->ownedBy(Auth::user())){
			return false;
		}

		$handler = new BitrixEventsHandlers($fields);

		if ($module->handlers()->save($handler)){
			return $handler;
		}

		return false;
	}

	// сохраняем обработчики в папку модуля
	static public function saveEventsInFolder($module_id){
		if (BitrixEventsHandlers::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);

			$handlerTemplate = Storage::disk('modules_templates')->get('bitrix/lib/event.php');
			$installHandlersCode = '';
			$uninstallHandlersCode = '';

			$classes = [];

			$handlers = BitrixEventsHandlers::where('module_id', $module_id)->get();
			foreach ($handlers as $handler){
				$installHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->registerEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, \'\\'.$module->namespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;
				$uninstallHandlersCode .= "\t\t".'\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler("'.$handler->from_module.'", "'.$handler->event.'", $this->MODULE_ID, \'\\'.$module->namespace.'\\EventHandlers\\'.$handler->class.'\', "'.$handler->method.'");'.PHP_EOL;

				if (!isset($classes[$handler->class])){
					$classes[$handler->class]['functionsCode'] = $handler->getHandlerCode();
					$classes[$handler->class]['class_namespace'] = $handler->class_namespace;
					$classes[$handler->class]['class'] = $handler->class;
				}else{
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
		}
	}

	protected static function writeHandlerRegisterAndUnregisterCodeInInstallFile($module, $installHandlersCode, $uninstallHandlersCode){
		$file = $module->disk()->get($module->module_folder.'/install/index.php');
		$file = preg_replace('/function InstallEvents\(\)\{[^\}]+\}/i', 'function InstallEvents(){'.PHP_EOL.$installHandlersCode.PHP_EOL.'}', $file);
		$file = preg_replace('/function UnInstallEvents\(\)\{[^\}]+\}/i', 'function UnInstallEvents(){'.PHP_EOL.$uninstallHandlersCode.PHP_EOL.'}', $file);
		$module->disk()->put($module->module_folder.'/install/index.php', $file);
	}

	protected function getHandlerCode(){
		$handlerFunctionTemplate = "\t".'static public function {METHOD}(){'."\n"."\t"."\t".'{PHP_CODE}'."\n"."\t".'}'."\n";

		$template_search = Array('{METHOD}', '{PHP_CODE}');
		$template_replace = Array($this->method, $this->php_code);
		$handlerCode = str_replace($template_search, $template_replace, $handlerFunctionTemplate);

		return $handlerCode;
	}

	public function getClassNamespaceAttribute(){
		return studly_case($this->class);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}
}
