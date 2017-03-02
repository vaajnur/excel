<?php
define('START_TIME', time());
define('NOT_CHECK_PERMISSIONS', (strpos($_SERVER['REMOTE_ADDR'], '127.') === 0));
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
if(!NOT_CHECK_PERMISSIONS && !$USER->CanDoOperation('edit_php'))
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
IncludeModuleLangFile(__FILE__);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
CModule::IncludeModule('excel');
$APPLICATION->SetTitle(GetMessage("excel_TITLE"));

?>


<?
if (!IsModuleInstalled("excel")){
	return false;
}