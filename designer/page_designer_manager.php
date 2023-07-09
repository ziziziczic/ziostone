<?
include "header_proc.inc.php";

if ($mode == "history") {
	$query = "select * from $DB_TABLES[design_history] where file_name='$design_file' order by reg_date desc limit 1";
	$result = $GLOBALS[lib_common]->querying($query);
	$recent_history_value = mysql_fetch_array($result);
	if (trim($recent_history_value[history]) == "") $GLOBALS[lib_common]->alert_url("히스토리가 존재하지 않습니다.", 'E', '', '', "window.close()");
	$design[] = $recent_history_value[history];
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info, "N");
	$query = "delete from $DB_TABLES[design_history] where serial='$recent_history_value[serial]'";
	$result = $GLOBALS[lib_common]->querying($query);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");
} else if ($mode == "save_source") {
	$exp = explode("\r\n", $design_file_edit);
	$php_start_tag = chr(60) . chr(63);
	$php_end_tag = chr(63) . chr(62);
	$design = array();
	for ($i=0; $i<sizeof($exp); $i++) {
		$design_line = trim($exp[$i]);
		if ($design_line == "" || $design_line == $php_start_tag || $design_line == $php_end_tag) continue;
		$design[] = $design_line . "\r\n";
	}
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");
}
?>