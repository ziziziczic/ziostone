<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

session_destroy();
if ($site_info[logout_next_page] != "") $GLOBALS[lib_common]->alert_url('', 'E', $site_info[logout_next_page]);
else $GLOBALS[lib_common]->alert_url('', 'E', "{$root}{$site_info[index_file]}");
?>