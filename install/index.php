<?
IncludeModuleLangFile(__FILE__);
Class excel extends CModule
{
	const MODULE_ID = 'excel';
	var $MODULE_ID = 'excel'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		// die();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("excel_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("excel_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("excel_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("excel_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		global $DB;

		/*RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CBitrixUtmMetki', 'OnBuildGlobalMenu');
		RegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CBitrixUtmMetki', 'OnAdminPageLoad');*/


		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/updates/main'))
		{
			if (file_exists($f = dirname(__FILE__).'/db/install.sql'))
			{
				foreach($DB->ParseSQLBatch(file_get_contents($f)) as $sql)
					$DB->Query($sql);
			}
		}
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB;
/*
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CBitrixUtmMetki', 'OnBuildGlobalMenu');
		UnRegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CBitrixUtmMetki', 'OnAdminPageLoad');*/

		if (file_exists($f = dirname(__FILE__).'/db/uninstall.sql'))
		{
			foreach($DB->ParseSQLBatch(file_get_contents($f)) as $sql)
				$DB->Query($sql);
		}
		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		if($_ENV["COMPUTERNAME"]!='BX')
		{
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
			// CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/images", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/excel", true, true);
			// CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", true, true);
			// CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/codebase", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/codebase", true, true);
			// CopyDirFiles($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/excel/install/tools", $_SERVER['DOCUMENT_ROOT']."/bitrix/tools", true, true);
		}
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		// DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/themes/.default/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes/.default");
		// DeleteDirFilesEx("/bitrix/themes/.default/icons/excel/");
		// DeleteDirFilesEx("/bitrix/images/excel/");
		DeleteDirFilesEx("/bitrix/js/codebase/");
		// DeleteDirFilesEx("/bitrix/tools/codebase/"); // scripts

		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
