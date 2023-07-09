<?
$VG_OP_dir_site_root = "../../";
include "config.inc.php";

$auth_method_array = array(array('L', '1', $VG_OP_user_info[level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) $lh_common->die_msg("관리자만 가능합니다.", '');

if ($_GET[VG_OP_mode] == "delete") {							// 설문그룹삭제
	$query = "delete from $VG_OP_db_table[que_list] where title_num='$title_num'";
	$result = $lh_common->querying($query);
	$query = "delete from $VG_OP_db_table[title_list] where serial_num='$title_num'";
	$result = $lh_common->querying($query);
	$lh_common->alert_url('', 'E', '', '', "opener.location.reload(); window.close();");
} else if ($_GET[VG_OP_mode] == "delete_que") {	 // 설문문항삭제
	$query = "delete from $VG_OP_db_table[que_list] where serial_num='$serial_num'";
	$result = $lh_common->querying($query);
	$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=input_form.php&title_num=$title_num");
} else if ($_GET[VG_OP_mode] == "change_op") {
	$query = "update $VG_OP_db_table[title_list] set ing='$_GET[sw_code]' where serial_num='$_GET[title_num]'";
	$result = $lh_common->querying($query);
	$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=input_form.php&title_num=$title_num");
}

if ($_POST[VG_OP_mode] == "add_op_gp") {						// 설문그룹추가
	include "{$VG_OP_dir_info['include']}post_var_filter.inc.php";
	$op_gp_info = array();
	$op_gp_info[subject] = $subject;	
	$op_gp_info[method] = $method;	
	$op_gp_info[sign_date] = $GLOBALS[w_time];
	$lh_common->input_record($VG_OP_db_table[title_list], $op_gp_info);
	//$lh_common->alert_url('', 'E', '', '', "opener.location.reload(); window.close();");
	$lh_common->alert_url('', 'E', "index.php");
} else if ($_POST[VG_OP_mode] == "mod_op_gp") {			// 설문그룹수정
	$query = "update $VG_OP_db_table[title_list] set subject='$subject', method='$method' where serial_num='$title_num';";
	$result = $lh_common->querying($query);
	$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=input_form.php&title_num=$title_num");
} else if ($_POST[VG_OP_mode] == "add_op_que") {		// 설문문항추가
	$op_que_info = array();
	$op_que_info[que_num] = $que_num;
	$op_que_info[title_num] = $title_num;
	$op_que_info[subject] = $subject;
	$op_que_info['count'] = $count;
	$op_que_info[sign_date] = $GLOBALS[w_time];
	$lh_common->input_record($VG_OP_db_table[que_list], $op_que_info);
	$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=input_form.php&title_num=$title_num");
} else if ($_POST[VG_OP_mode] == "mod_op_que") {		// 설문문항수정
	$T_exp = explode(',', $serial_nums);
	
	for ($i=0; $i<sizeof($T_exp); $i++) {
		$que_num = "q_num_" . $T_exp[$i];
		$que_subject = "q_subject_" . $T_exp[$i];
		$que_count = "q_count_" . $T_exp[$i];
		$query = "update $VG_OP_db_table[que_list] set que_num='{$$que_num}', subject='{$$que_subject}', count='{$$que_count}' where title_num='$title_num' and serial_num='$T_exp[$i]';";
		$result = $lh_common->querying($query);
	}
	$lh_common->alert_url('', 'E', "index.php?VG_OP_file_name=input_form.php&title_num=$title_num");
}

?>