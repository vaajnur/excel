<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight('conversion') == 'D')
{
	return false;
}
else
{
	$menu = array(
		array(
			'parent_menu' => 'global_menu_services',
			'sort' => 100,
			'text' => Loc::getMessage('excel_MENU_TEXT'),
			'title' => Loc::getMessage('excel_MENU_TITLE'),
			'icon' => 'excel_menu_icon',
			'page_icon' => 'excel_menu_icon',
			'items_id' => 'menu_excel',
			'url' => 'excel.php?lang='.LANGUAGE_ID,
			'module_id' => 'excel'
//			'items' => array(
//				array(
//					'text' => Loc::getMessage('CONVERSION_MENU_SUMMARY_TEXT'),
//					'title' => Loc::getMessage('CONVERSION_MENU_SUMMARY_TEXT'),
//					'url' => 'conversion_summary.php?lang='.LANGUAGE_ID,
//				),
//			),
		),
	);

	return $menu;
}
