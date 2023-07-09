<?
if (eregi("현재일시", $user_exec)) {
	$exp = explode('~', $user_exec);
	if ($exp[1] == '') $date_format = "Y-m-d H:i:s";
	else $date_format = $exp[1];
	$tag = date($date_format, $GLOBALS[w_time]);
	return $tag;
} else if (eregi("배너", $user_exec)) {
	$exp = explode('~', $user_exec);
	include_once "{$root}service/config.inc.php";
	$banner_preview = print_banner_list($exp[1]);
	$tag = $banner_preview[0];
}
?>