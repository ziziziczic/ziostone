<?
if ($root == '') $root = "./";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$root}service/config.inc.php";

//if(!eregi($HTTP_HOST, $_SERVER[HTTP_REFERER])) die();

if ($_GET[serial_banner] != '') {
	$banner_info = $GLOBALS[lib_common]->get_data($DB_TABLES[banner], "serial_num", $_GET[serial_banner]);
	$url = $banner_info[link_url];
	$banner_log_info = array();
	$banner_log_info[serial_banner] = $banner_info[serial_num];
	$banner_log_info[serial_member] = $user_info[serial_num];
	$banner_log_info[url_referer] = $_SERVER[HTTP_REFERER];
	$banner_log_info[url_destination] = $url;
	$banner_log_info[ip_addr] = $_SERVER[REMOTE_ADDR];
	$banner_log_info[date_sign] = $GLOBALS[w_time];
	$GLOBALS[lib_common]->input_record($DB_TABLES[banner_log], $banner_log_info);
}/* else if ($_GET[serial_site] != '') {
	$site_info = $GLOBALS[lib_common]->get_data($DB_TABLES[site_list], "serial_num", $_GET[serial_site]);
	$url = $site_info[url];	
	$query = "update $DB_TABLES[site_list] set visit_count=visit_count+1 where serial_num=$_GET[serial_site]";
	$GLOBALS[lib_common]->querying($query);
	$site_visit_log_info = array();
	$site_visit_log_info[serial_site] = $banner_info[serial_num];
	$site_visit_log_info[serial_member] = $user_info[serial_num];
	$site_visit_log_info[url_referer] = $_SERVER[HTTP_REFERER];
	$site_visit_log_info[url_destination] = $url;
	$site_visit_log_info[date_sign] = $GLOBALS[w_time];
	$GLOBALS[lib_common]->input_record($DB_TABLES[site_visit_log], $site_visit_log_info);
} else {
	$url = $_GET[url];
	$site_visit_log_info = array();
	$site_visit_log_info[serial_site] = "jiib";
	$site_visit_log_info[serial_member] = $user_info[serial_num];
	$site_visit_log_info[url_referer] = $_SERVER[HTTP_REFERER];
	$site_visit_log_info[url_destination] = $url;
	$site_visit_log_info[date_sign] = $GLOBALS[w_time];
	$GLOBALS[lib_common]->input_record($DB_TABLES[site_visit_log], $site_visit_log_info);
}*/

header("Referer: $_SERVER[HTTP_REFERER]");
header("Location: $url");
exit;
?>