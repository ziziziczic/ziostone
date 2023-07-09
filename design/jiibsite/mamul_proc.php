<?
$root = "../../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$auth_method_array = array(array('L', 1, $user_info[user_level], 'E'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) {
	$prev_url_encode = urlencode($_SERVER[HTTP_REFERER]);
	$GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin], "{$DIRS[designer_root]}include/skin_die.html");
}

for ($T_i=0; $T_i<sizeof($serial_num); $T_i++) {
	$F_is_selected = array_search($serial_num[$T_i], $list_select);
	if (!is_int($F_is_selected)) continue;
	switch ($_GET[mode]) {
		case "delete" :
			$query = "delete from TCBOARD_1704 where serial_num='$serial_num[$T_i]'";
		break;
		case "chg_state" :
			$query = "select * from TCBOARD_1704 where serial_num='$serial_num[$T_i]'";
			$result = $GLOBALS[lib_common]->querying($query);
			$value = mysql_fetch_array($result);
			if ($value[name] == "분양중") $chg_value = "분양완료";
			else $chg_value = "분양중";
			$query = "update TCBOARD_1704 set name='$chg_value' where serial_num='$serial_num[$T_i]'";
		break;
	}
	$GLOBALS[lib_common]->querying($query);
}
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.document.location.reload();window.close();");
?>