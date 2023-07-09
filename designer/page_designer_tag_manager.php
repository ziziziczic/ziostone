<?
include "header_proc.inc.php";

$sub_query = "tag_body='$tag_body', tag_header='$tag_header', tag_body_in='$tag_body_in', tag_body_out='$tag_body_out', tag_contents_out='$tag_contents_out'";
$query = "update $DB_TABLES[design_files] set $sub_query where file_name='$design_file'";
$GLOBALS[lib_common]->querying($query);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "window.close()");
?>