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

	function InstallDB()
	{
		global $DB, $APPLICATION;

		/*RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CBitrixUtmMetki', 'OnBuildGlobalMenu');
		RegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CBitrixUtmMetki', 'OnAdminPageLoad');*/


		// if (file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/updates/main'))
		// {
			if (file_exists($f = dirname(__FILE__).'/db/install.sql'))
			{
				foreach($DB->ParseSQLBatch(file_get_contents($f)) as $sql)
					$DB->Query($sql);

			}
		// }
		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		return true;
	}

	function UnInstallDB($arParams = array())
	{
		global $DB, $APPLICATION;
/*
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CBitrixUtmMetki', 'OnBuildGlobalMenu');
		UnRegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CBitrixUtmMetki', 'OnAdminPageLoad');*/
		if (!array_key_exists("savedata", $arParams) || $arParams["savedata"] != "Y")
		{
			if (file_exists($f = dirname(__FILE__).'/db/uninstall.sql'))
			{
				foreach($DB->ParseSQLBatch(file_get_contents($f)) as $sql)
					$DB->Query($sql);
			}
		}
		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
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
		global $USER, $APPLICATION, $step, $host, $user, $password, $db, $db_type;
		if ($USER->IsAdmin())
		{
			$step = IntVal($step);
			if ($step < 2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage("BCL_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/step1.php");
			}
			elseif ($step == 2)
			{
					$this->InstallDB();
					$config_file = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/codebase/php/config.php";

					$config_text =  "<?php \n";
					$config_text .= "\$db_host = '$host';\n";
					$config_text .= "\$db_port = '3306';\n";
					$config_text .= "\$db_user = '$user';\n";
					$config_text .= "\$db_pass = '$password';\n";
					$config_text .= "\$db_name = '$db';\n";
					$config_text .= "\$db_prefix = '__';\n";
					$config_text .= "\$db_type = '$db_type';\n";
					$config_text .= "\$username = '$user';\n";
					$config_text .= "\$password = '$password';\n";
					$config_text .= "require_once('db_mysqli.php');\n?>";
					file_put_contents($config_file, $config_text);

					// $this->InstallEvents();
					$this->InstallFiles();
				}
				$GLOBALS["errors"] = $this->errors;
				// $APPLICATION->IncludeAdminFile(GetMessage("BCL_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/step2.php");
				RegisterModule(self::MODULE_ID);
		}
	}

	function DoUninstall()
	{
		global $USER, $APPLICATION, $step;
		if ($USER->IsAdmin())
		{
			$step = IntVal($step);
			if ($step < 2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage("BCL_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/unstep1.php");
			}
			elseif ($step == 2)
			{
				$this->UnInstallDB(array(
					"save_tables" => $_REQUEST["save_tables"],
				));
				//message types and templates
				if ($_REQUEST["save_templates"] != "Y")
				{
					// $this->UnInstallEvents();
				}
				$this->UnInstallFiles();
				$GLOBALS["errors"] = $this->errors;
				UnRegisterModule(self::MODULE_ID);
				$APPLICATION->IncludeAdminFile(GetMessage("BCL_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/excel/install/unstep2.php");
			}
		}
	}
}
?>
