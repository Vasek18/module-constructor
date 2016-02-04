<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

Class {MODULE_CLASS_NAME} extends CModule{
	const MODULE_ID = '{MODULE_ID}';
	var	$MODULE_ID = '{MODULE_ID}';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct(){
		$arModuleVersion = array();
		include(__DIR__."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("{LANG_KEY}_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("{LANG_KEY}_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("{LANG_KEY}_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("{LANG_KEY}_PARTNER_URI");
	}

	function InstallDB($arParams = array()){
		return true;
	}

	function UnInstallDB($arParams = array()){
		return true;
	}

	function InstallEvents(){
		return true;
	}

	function UnInstallEvents(){
		return true;
	}

	function InstallFiles($arParams = array()){
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin')){
			if ($dir = opendir($p)){
				while (false !== $item = readdir($dir)){
					if ($item == '..' || $item == '.' || $item == 'menu.php')
						continue;
					file_put_contents($file = $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item,
						'<'.'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'.self::MODULE_ID.'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components')){
			if ($dir = opendir($p)){
				while (false !== $item = readdir($dir)){
					if ($item == '..' || $item == '.')
						continue;
					CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = true, $Recursive = true);
				}
				closedir($dir);
			}
		}

		return true;
	}

	function UnInstallFiles(){
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/admin')){
			if ($dir = opendir($p)){
				while (false !== $item = readdir($dir)){
					if ($item == '..' || $item == '.')
						continue;
					unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.self::MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}
		if (is_dir($p = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install/components')){
			if ($dir = opendir($p)){
				while (false !== $item = readdir($dir)){
					if ($item == '..' || $item == '.' || !is_dir($p0 = $p.'/'.$item))
						continue;

					$dir0 = opendir($p0);
					while (false !== $item0 = readdir($dir0)){
						if ($item0 == '..' || $item0 == '.')
							continue;
						DeleteDirFilesEx('/bitrix/components/'.$item.'/'.$item0);
					}
					closedir($dir0);
				}
				closedir($dir);
			}
		}

		return true;
	}

	public function isVersionD7(){
		return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
	}

	function DoInstall(){

		global $APPLICATION;
		if ($this->isVersionD7()){
			\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

			$this->InstallDB();
			$this->InstallEvents();
			$this->InstallFiles();
		}else{
			$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_INSTALL_ERROR_VERSION"));
		}

		//$APPLICATION->IncludeAdminFile(Loc::getMessage("{LANG_KEY}_INSTALL"), $this->GetPath()."/install/step.php");
	}

	function DoUninstall(){

		global $APPLICATION;

		$context = Application::getInstance()->getContext();
		$request = $context->getRequest();

		$this->UnInstallFiles();
		$this->UnInstallEvents();

		if ($request["savedata"] != "Y")
			$this->UnInstallDB();

		\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

		//$APPLICATION->IncludeAdminFile(Loc::getMessage("{LANG_KEY}_UNINSTALL"), $this->GetPath()."/install/unstep.php");
	}
}
?>