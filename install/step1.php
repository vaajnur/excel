<?
/** @global CMain $APPLICATION */
IncludeModuleLangFile(__FILE__);
?>
<p><?echo GetMessage("BCL_INSTALL"); ?></p>
<form action="<?echo $APPLICATION->GetCurPage(); ?>" name="form1">
<?echo bitrix_sessid_post(); ?>
<input type="hidden" name="lang" value="<?echo LANG ?>">
<input type="hidden" name="id" value="excel">
<input type="hidden" name="install" value="Y">
<input type="hidden" name="step" value="2">
<!--  -->
<input type="text" name="host" value="" placeholder="host">
<input type="text" name="user" value="" placeholder="user">
<input type="text" name="password" value="" placeholder="password">
<input type="text" name="db" value="" placeholder="db">
<select name="db_type" id="">
	<option value="MySQL">MySQL</option>
	<option value="MySQLi">MySQLi</option>
	<option value="MSSQL">MSSQL</option>
	<option value="Oracle">Oracle</option>
	<option value="Postgre">Postgre</option>
</select>
<input type="submit" name="inst" value="<?echo GetMessage("BCL_INSTALL"); ?>">
</form>