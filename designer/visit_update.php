<?
include "header_proc.inc.php";

if ($j == "d") {
	$query = " delete from $DB_TABLES[visit] where vi_date <= '$to_date' ";
	mysql_query($query);
}
$GLOBALS[lib_common]->alert_url('', 'E', "visit_search_form.php");
header("location:./index.php");
?>
