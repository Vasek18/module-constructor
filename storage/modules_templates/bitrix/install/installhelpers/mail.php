<?php
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