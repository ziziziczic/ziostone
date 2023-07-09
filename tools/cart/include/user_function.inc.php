<?
// 사용가능한 마일리지를 얻음
function vg_op_get_cyber_money($mb_id) {
	global $lh_common;
	$query = "select sum(mi_milage) from TCSYSTEM_cyber_money where mb_id = '$mb_id' and mi_state<>'R'";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	mysql_free_result($result);
	return (float)$row[0];
}
?>