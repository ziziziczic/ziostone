<?
if ($root == '') $root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[designer_root]}config.inc.php";

$auth_method_array = array(array('L', 1, $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) {
	$GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin], $STSV_VE[die_msg]);
}

echo("
<html>
<head>
<title>인사이터 - 관리</title>
<meta http-equiv='content-type' content='text/html; charset=euc-kr'>
<script src='{$DIRS[designer_root]}include/js/javascript.js'></script>
<link rel='stylesheet' href='{$DIRS[designer_root]}include/style.css' type='text/css'>
</head>
<body text='#000000' leftmargin=3 topmargin=3>
<table cellpadding=0 cellspacing=0 border='0' width=100%>
	<tr> 
		<td> 
");