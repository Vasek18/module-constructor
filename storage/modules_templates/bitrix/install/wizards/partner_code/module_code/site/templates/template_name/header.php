<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xml:lang="<?=LANGUAGE_ID?>"
      lang="<?=LANGUAGE_ID?>">
<head>
	<link rel="shortcut icon"
	      type="image/x-icon"
	      href="<?=SITE_TEMPLATE_PATH?>/favicon.ico"/>
	<meta http-equiv="X-UA-Compatible"
	      content="IE=edge"/>
	<title><? $APPLICATION->ShowTitle() ?></title>
    <? $APPLICATION->ShowHead(); ?>
</head>
<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
