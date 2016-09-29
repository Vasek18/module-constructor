<?
// todo_sokratit_odinakovye_uchastki_koda
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
IncludeModuleLangFile(__FILE__);

if (!check_bitrix_sessid() || $_SERVER["REQUEST_METHOD"] != "POST"){
	die();
}

if (!CModule::IncludeModule("iblock")){
	die();
}

global $USER, $APPLICATION;

// na_sluchay_ne_utf
CUtil::JSPostUnescape();

$answer = Array();
$answer["success"] = 0;
$arErrors = array();
// $answer = array_merge($answer, $_POST); // для тестов

$action = $_POST["action"];

$module_id = "aristov.vcomments";
$commentsIblockID = $_SESSION["AVC_AR_PARAMS"]["IBLOCK_ID"];
$link = $_POST["page"];

// dobavlenie_kommentariya
if ($_POST['action'] == "add-comment"){
	// todo_mogno_ostavlyat_ochischennye_sslyki
	$parentID = IntVal($_POST["parentID"]);
	$text = strip_tags(trim($_POST["text"]));
	$name = strip_tags(trim($_POST["authorName"]));
	$ava = strip_tags($_POST["ava"]); // todo
	$linkPropertyCode = strip_tags($_SESSION["AVC_AR_PARAMS"]["PARENT_PROP"]);
	$authorNamePropertyCode = strip_tags($_SESSION["AVC_AR_PARAMS"]["AUTHOR_PROP"]);

	$el = new CIBlockElement;

	$PROP = array();
	$PROP[$linkPropertyCode] = $parentID;
	$PROP[$authorNamePropertyCode] = $name;

	$arLoadProductArray = Array(
		"IBLOCK_ID"       => $commentsIblockID,
		"PROPERTY_VALUES" => $PROP,
		"NAME"            => GetMessage("ARISTOV_COMMENTS_COMMENT_FROM").$name." ".GetMessage("ARISTOV_COMMENTS_FROM").date('d-m-Y h:m:s'),
		"ACTIVE"          => "Y",            // aktiven
		"DETAIL_TEXT"     => $text
	);
	// $answer = array_merge($answer, $arLoadProductArray); // для тестов

	if ($commentID = $el->Add($arLoadProductArray)){ // uspech
		$answer["success"] = 1;
		$answer["comment_id"] = $commentID;
		$answer["ava"] = $ava;
		$answer["name"] = $name;
		$answer["text"] = $text;
		$answer["answer"] = GetMessage("ARISTOV_COMMENTS_COMMENT_ADD_SUCCESS");

		// zapominaem_avtora
		AristovComments::rememberAuthor($commentID);

		// otpravlyaem_pismo
		$mailType = COption::GetOptionString("aristov.comments", "mail_event_code");
		$event = new CEvent;
		if ($message_id = $event->Send($mailType, SITE_ID, Array(
			'IMYA_AVTORA' => $name,
			'TEKST'       => $text,
			'SSYLKA'      => $_POST["page"],
			'VREMYA'      => date('Y-m-d h:m:s'),
		))
		){
			$answer["mail_success"] = 1;
		}else{
			$answer["mail_success"] = 0;
		}

	} // neudacha
	else{
		$answer["error_text"] = $el->LAST_ERROR;
	}
}

echo json_encode($answer);

// mogno_inicializirovat_pri_kagdom_sozdanii_izmenenii_kommentariya_chtoby_chranit_parametry_v_$this
class AristovComments{
	public static function rememberAuthor($commentID){
		$_SESSION["AVC_CREATED_COMMENTS"][] = $commentID;
	}
}

?>
