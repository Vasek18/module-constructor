<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CAristovComponent extends CBitrixComponent{
	public function saveParamsInSession(){
		// poskolku_inache_v_ayaksovom_fayle_ich_ne_poluchit
		$_SESSION["AVC_AR_PARAMS"] = $this->arParams;
	}

	public function getDateInFormat($datetime){
		$formattedDate = "";

		$formattedDate = FormatDate("x", MakeTimeStamp($datetime));

		return $formattedDate;
	}

	public function generateArOrder(){
		$this->arParams["AR_ORDER"] = Array();
	}

	public function generateArSelect(){
		$this->arParams["AR_SELECT"] = Array();
	}

	public function generateArFilter(){
		$this->arParams["FILTER"] = Array();
		$this->arParams["FILTER"]["IBLOCK_ID"] = $this->arParams["IBLOCK_ID"];
	}

	public function getItems(){
		// obyazatelno_nugen_modul_infoblokov
		if (!CModule::IncludeModule("iblock")){
			$this->AbortResultCache();
			ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));

			return;
		}

		$arFilter = $this->arParams["FILTER"];
		$arOrder = $this->arParams["AR_ORDER"];
		$arSelect = $this->arParams["AR_SELECT"];

		$this->arResult["ITEMS"] = Array();
		$rs = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
		while ($ob = $rs->GetNextElement()){
			$arFields = $ob->GetFields();
			$arFields["PROPS"] = $ob->GetProperties();

			$arFields["DATE_CREATE"] = $this->getDateInFormat($arFields["DATE_CREATE"]);

			$arFields["HERE_IS_AUTHOR"] = false;
			if (in_array($arFields["ID"], $this->arParams["CREATED_COMMENTS"])){
				$arFields["HERE_IS_AUTHOR"] = true;
			}

			$this->arResult["ITEMS"][] = $arFields;
		}
	}

	public function setAdditionalParams(){
		$this->arParams["CREATED_COMMENTS"] = $_SESSION["AVC_CREATED_COMMENTS"];
	}

	public function executeComponent(){
		// print_r($this->arParams);
		$this->setAdditionalParams();
		$this->saveParamsInSession();
		$this->generateArOrder();
		$this->generateArFilter();
		$this->generateArSelect();

		\Bitrix\Main\Page\Asset::getInstance()->addJs($this->GetPath()."/script.js");

		if ($this->startResultCache()){
			$this->getItems();
			$this->includeComponentTemplate();
		}
	}
}

?>