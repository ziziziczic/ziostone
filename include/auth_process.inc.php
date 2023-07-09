<?
$T_next_page = $T_perm_err_msg = '';
if ($T_next_page == '') $T_next_page = $site_page_info[view_err_page];
if ($T_next_page == '') $T_next_page = $site_info[access_denied_page];

if ($T_perm_err_msg == '') $T_perm_err_msg = $site_page_info[perm_err_msg];
if ($T_perm_err_msg == '') $T_perm_err_msg = $site_info[perm_err_msg];
if ($T_perm_err_msg == '') $T_perm_err_msg = $GLOBALS[VI][default_err_msg];
if ($T_perm_err_msg != '') $T_perm_err_msg = str_replace("\r\n", chr(92).r.chr(92).n, $T_perm_err_msg);

if ($_GET[prev_url] == '') {
	if ($T_next_page == '') {			// 오류 메시지 출력 페이지 설정이 안된경우 '뒤로가기'
		$GLOBALS[lib_common]->alert_url($T_perm_err_msg);
	} else {												// 출력페이지 설정이 된경우 해당 페이지로 이동
		$change_vars = array("prev_url"=>urlencode($HTTP_REFERER), "perm_err_msg"=>urlencode($T_perm_err_msg));
		$exp_T_next_page = explode('?', $T_next_page);
		$T_next_page = $exp_T_next_page[0] . '?' . $GLOBALS[lib_common]->get_change_var_url($exp_T_next_page[1], $change_vars);
		$GLOBALS[lib_common]->alert_url($T_perm_err_msg, 'E', $T_next_page);
	}
} else {
	$GLOBALS[lib_common]->alert_url($T_perm_err_msg, 'E', $_GET[prev_url]);
}
exit;
?>