<?
if ($root == '') $root = "../";
include_once "{$root}db.inc.php";
include_once "{$root}config.inc.php";
include_once "./config.inc.php";

$auth_method_array = array(array('L', '5', $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

echo("
<html>
<head>
<title>$site_info[site_name] - ���ã�� ����</title>
<meta http-equiv='content-type' content='text/html; charset=euc-kr'>
<script src='{$DIRS[designer_root]}include/js/javascript.js'></script>
<link rel='stylesheet' href='{$DIRS[designer_root]}include/style.css' type='text/css'>
</head>
<body bgcolor='#FFFFFF' text='#000000'>
");
?>