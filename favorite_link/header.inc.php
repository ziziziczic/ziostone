<?
if ($root == '') $root = "../";
include_once "{$root}db.inc.php";
include_once "{$root}config.inc.php";
include_once "{$DIRS[designer_root]}config.inc.php";
include_once "config.inc.php";

$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_admin], $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

echo("
<html>
<head>
<title>$site_info[site_name] - 관리자모드</title>
<meta http-equiv='content-type' content='text/html; charset=euc-kr'>
<script src='{$DIRS[designer_root]}include/js/javascript.js'></script>
<link rel='stylesheet' href='{$DIRS[designer_root]}include/style.css' type='text/css'>
</head>
<body bgcolor='#FFFFFF' text='#000000' leftmargin=5 topmargin=0>
<table cellpadding=0 cellspacing=0 border='0' width=100%>
	<tr><td height=7></td></tr>
	<tr> 
		<td> 
");
include "{$DIRS[designer_root]}include/top_menu.inc.php";
echo("
		</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td width=166 valign=top>
");
include "./include/sub_menu.inc.php";
echo("
					</td>
					<td width=10></td>
					<td align=center valign=top>
						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td>
");
?>