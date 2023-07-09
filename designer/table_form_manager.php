<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
if ($_POST[mode] == "TC_BOARD") {
	$exp = explode($GLOBALS[DV][dv], $design[$form_line]);
	$exp[4] = "TC_BOARD";
	if ($form_type == "LIST") {
		$board_property = "$board_name:$form_type:$query_type:$table_per_article:$table_per_block:$line_per_article::$sort_field:$sort_sequence:$list_view_mode:$relation_table";
	} else {
		$verify_input_save = "";
		for ($i=1; $i<=15; $i++) {
			$checkbox_name = "verify_input_" . $i;
			$verify_input_save .= $$checkbox_name . "~";
		}
		$verify_input_save = substr($verify_input_save, 0, -1);
		$board_property = "$board_name:$form_type:$verify_input_save::::::::$relation_table_1";
	}	
	$exp[5] = $board_property;
	$exp[6] = stripslashes($user_query);
} else if ($_POST[mode] == "TC_MEMBER") {
	$exp = explode($GLOBALS[DV][dv], $design[$form_line]);
	$exp[4] = "TC_MEMBER";
	$verify_input_save = "";
	for ($i=1; $i<=43; $i++) {
		$checkbox_name = "verify_input_" . $i;
		$verify_input_save .= $$checkbox_name . "~";
	}
	$verify_input_save = substr($verify_input_save, 0, -1);
	$member_property = "$verify_input_save";
	$exp[5] = $member_property;
} else {
	$exp = explode($GLOBALS[DV][dv], $design[$form_line]);
	$exp[4] = "TC_LOGIN";
	$exp[6] = $login_next_method;
}
$exp[7] = "{$form_property}{$GLOBALS[DV][ct4]}{$form_function}{$GLOBALS[DV][ct4]}{$after_db_script}{$GLOBALS[DV][ct4]}{$after_db_msg}{$GLOBALS[DV][ct4]}{$login_next_method}";
$design[$form_line] = implode($GLOBALS[DV][dv], $exp);
$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>