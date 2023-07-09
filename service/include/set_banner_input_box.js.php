<?
if ($root == '') $root = "../../";
include_once "{$root}db.inc.php";
include_once "{$root}config.inc.php";
include "{$root}service/config.inc.php";

$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $_GET[serial_service_item]);
$exp_banner_option = explode($GLOBALS[DV][ct2], $service_item_info[item_option]);

echo("
excepts = '';
enable_child_id('$exp_banner_option[0]', document.getElementsByTagName('tr'), excepts);
");
?>