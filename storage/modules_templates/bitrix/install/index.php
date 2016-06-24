<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

Class {MODULE_CLASS_NAME} extends CModule{
	var	$MODULE_ID = '{MODULE_ID}';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	function __construct(){
		$arModuleVersion = array();
		include(__DIR__."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("{LANG_KEY}_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("{LANG_KEY}_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("{LANG_KEY}_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("{LANG_KEY}_PARTNER_URI");

		$this->exclusionAdminFiles=array(
			'..',
			'.',
			'menu.php',
			'operation_description.php',
			'task_description.php'
		);
	}

	function InstallDB($arParams = array()){
		$this->createNecessaryIblocks();
	}

	function UnInstallDB($arParams = array()){
		\Bitrix\Main\Config\Option::delete($this->MODULE_ID);
		$this->deleteNecessaryIblocks();
	}

	function InstallEvents(){
		return true;
	}

	function UnInstallEvents(){
		return true;
	}

	function InstallFiles($arParams = array()){
		$path = $this->GetPath()."/install/components";

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path)){
			CopyDirFiles($path, $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		}

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath().'/admin')){
			CopyDirFiles($this->GetPath()."/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin"); //если есть файлы для копирования
			if ($dir = opendir($path)){
				while (false !== $item = readdir($dir)){
					if (in_array($item, $this->exclusionAdminFiles))
						continue;
					file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$item,
						'<'.'? require($_SERVER["DOCUMENT_ROOT"]."'.$this->GetPath(true).'/admin/'.$item.'");?'.'>');
				}
				closedir($dir);
			}
		}

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath().'/install/files')){
			$this->copyArbitraryFiles();
		}

		return true;
	}

	function UnInstallFiles(){
		\Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"].'/bitrix/components/'.$this->MODULE_ID.'/');

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath().'/admin')){
			DeleteDirFiles($_SERVER["DOCUMENT_ROOT"].$this->GetPath().'/install/admin/', $_SERVER["DOCUMENT_ROOT"].'/bitrix/admin');
			if ($dir = opendir($path)){
				while (false !== $item = readdir($dir)){
					if (in_array($item, $this->exclusionAdminFiles))
						continue;
					\Bitrix\Main\IO\File::deleteFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$item);
				}
				closedir($dir);
			}
		}

		if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath().'/install/files')){
			$this->deleteArbitraryFiles();
		}

		return true;
	}

	function copyArbitraryFiles(){
		$rootPath = $_SERVER["DOCUMENT_ROOT"];
		$localPath = $this->GetPath().'/install/files';

		$dirIterator = new RecursiveDirectoryIterator($localPath, RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $object){
			$destPath = $rootPath.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
			($object->isDir()) ? mkdir($destPath) : copy($object, $destPath);
		}
	}

	function deleteArbitraryFiles(){
		$rootPath = $_SERVER["DOCUMENT_ROOT"];
		$localPath = $this->GetPath().'/install/files';

		$dirIterator = new RecursiveDirectoryIterator($localPath, RecursiveDirectoryIterator::SKIP_DOTS);
		$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $object){
			if (!$object->isDir()){
				$file = str_replace($localPath, $rootPath, $object->getPathName());
				\Bitrix\Main\IO\File::deleteFile($file);
			}
		}
	}

	public function createNecessaryIblocks(){
		return true;
	}

	public function deleteNecessaryIblocks(){
		return true;
	}

	public function createIblockType(){
		global $DB, $APPLICATION;
		CModule::IncludeModule("iblock");

		$iblockType = "{MODULE_CLASS_NAME}_iblock_type";
		$db_iblock_type = CIBlockType::GetList(Array("SORT" => "ASC"), Array("ID" => $iblockType));
		if (!$ar_iblock_type = $db_iblock_type->Fetch()){
			$arFieldsIBT = Array(
				'ID'       => $iblockType,
				'SECTIONS' => 'Y',
				'IN_RSS'   => 'N',
				'SORT'     => 500,
				'LANG'     => Array(
					'en' => Array(
						'NAME' => Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_NAME_EN"),
					),
					'ru' => Array(
						'NAME' => Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_NAME_RU"),
					)
				)
			);

			$obBlocktype = new CIBlockType;
			$DB->StartTransaction();
			$resIBT = $obBlocktype->Add($arFieldsIBT);
			if (!$resIBT){
				$DB->Rollback();
				$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_ALREADY_EXISTS"));
			}else{
				$DB->Commit();

				return $iblockType;
			}
		}
	}

	function removeIblockType(){
		global $APPLICATION, $DB;
		CModule::IncludeModule("iblock");

		$iblockType = "{MODULE_CLASS_NAME}_iblock_type";

		$DB->StartTransaction();
		if (!CIBlockType::Delete($iblockType)){
			$DB->Rollback();
			$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_TYPE_DELETION_ERROR"));
		}
		$DB->Commit();
	}

	public function createIblock($params){
		global $APPLICATION;
		CModule::IncludeModule("iblock");

		$ib = new CIBlock;

		$resIBE = CIBlock::GetList(Array(), Array('TYPE' => $params["IBLOCK_TYPE_ID"], 'SITE_ID' => $params["SITE_ID"], "CODE" => $params["CODE"]));
		if ($ar_resIBE = $resIBE->Fetch()){
			$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_IBLOCK_ALREADY_EXISTS"));

			return false;
		}else{
			$ID = $ib->Add($params);

			return $ID;
		}

		return false;
	}

	function createIblockProp($arFieldsProp){
		CModule::IncludeModule("iblock");
		$ibp = new CIBlockProperty;
		return $ibp->Add($arFieldsProp);
	}

	public function createNecessaryMailEvents(){
		return true;
	} // createNecessaryMailEvents

	public function deleteNecessaryMailEvents(){
		return true;
	} // deleteNecessaryMailEvents

	function createMailEvent($code, $name, $description, $sort, $LID = 'ru'){
		$params = Array(
			"LID"         => $LID,
			"EVENT_NAME"  => $code,
			"NAME"        => $name,
			"SORT"        => $sort,
			"DESCRIPTION" => $description
		);
		$rsET = CEventType::GetList(Array("TYPE_ID" => $code, "LID" => $LID));
		if ($arET = $rsET->Fetch()){
			$event = CEventType::Update(array("ID" => $arET["ID"]), $params);
			$eventID = $arET["ID"];
		}else{
			$event = new CEventType;
			$eventID = $event->Add($params);
		}

		return $eventID;
	}

	function createMailTemplate($params){
		$params["ACTIVE"] = "Y";
		if (!isset($params["LID"])){
			$params["LID"] = 's1';
		}

		$template = new CEventMessage;
		$templateID = $template->Add($params);

		return $templateID;
	}

	function deleteMailEvent($code){
		$rsMess = CEventMessage::GetList($by, $order, Array('TYPE_ID' => $code));
		while ($arMess = $rsMess->Fetch()){
			$template = new CEventMessage;
			$template->Delete($arMess["ID"]);
		}

		$et = new CEventType;
		$et->Delete($code);
	}

	public function isVersionD7(){
		return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
	}

	public function GetPath($notDocumentRoot = false){
		if ($notDocumentRoot){
			return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
		}else{
			return dirname(__DIR__);
		}
	}

	function DoInstall(){

		global $APPLICATION;
		if ($this->isVersionD7()){
			\Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

			$this->InstallDB();
			$this->createNecessaryMailEvents();
			$this->InstallEvents();
			$this->InstallFiles();
		}else{
			$APPLICATION->ThrowException(Loc::getMessage("{LANG_KEY}_INSTALL_ERROR_VERSION"));
		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage("{LANG_KEY}_INSTALL"), $this->GetPath()."/install/step.php");
	}

	function DoUninstall(){

		global $APPLICATION;

		$context = Application::getInstance()->getContext();
		$request = $context->getRequest();

		$this->UnInstallFiles();
		$this->deleteNecessaryMailEvents();
		$this->UnInstallEvents();

		if ($request["savedata"] != "Y")
			$this->UnInstallDB();

		\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(Loc::getMessage("{LANG_KEY}_UNINSTALL"), $this->GetPath()."/install/unstep.php");
	}
}
?>