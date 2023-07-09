<?
if ($_GET[root] == '') $root = "./";
else $root = $_GET[root];

include "{$root}db.inc.php";
include "{$root}config.inc.php";
if(!eregi($PU_host[host], $_SERVER[HTTP_REFERER])) die();

if ($_GET[full_file_name] != '') {
	$full_file_name = $_GET[full_file_name];
} else {
	if ($_GET[od_serial] != '') $save_dir = "{$DIRS[nexall_upload]}order/{$_GET[od_serial]}/";
	$full_file_name = $save_dir . $_GET[file_name];
}
$file_alias = $_GET[file_alias];

if (!is_file($full_file_name)) $GLOBALS[lib_common]->die_msg("해당파일이나 경로가 존재하지 않습니다. <a href='javascript:history.back()'>[이전페이지로]</a>");

$extention = $GLOBALS[lib_common]->get_file_extention($full_file_name);
if (in_array($extention, $GLOBALS[VI][deny_ext])) {
	$host_info = $lib_fix->get_user_info($site_info[site_id]);
	$mail_contents = "
		{$site_info[site_name]} 홈페이지의 이용자중 시스템파일을 다운로드 하려는 시도가 있었습니다.<br>
		IP Address : {$_SERVER[REMOTE_ADDR]}<br>
		사용자 ID : {$user_info[id]} {$user_info[name]}<br>
		시간 : " . date("Y-m-d H:i:s", $GLOBALS[w_time]) . "<br>
		시도한 파일 : {$full_file_name}
	";
	$log_info = array("owner"=>"system");
	$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $host_info[email], "시스템파일 다운로드 시도 보고", $mail_contents, 1, '', "EUC-KR", '', '', $GLOBALS[VI][mail_form], $log_info, 'N', $host_info[name]);
	$GLOBALS[lib_common]->alert_url("시스템 필수 파일은 다운로드 할 수 없습니다.\\n\\n귀하의 아이피주소 $_SERVER[REMOTE_ADDR] 가 기록 되었으며 관리자에게 통보되었습니다.");
}

if ($file_alias == '') $file_alias  = $GLOBALS[lib_common]->get_file_name($full_file_name);

if (eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) {
	Header("Content-type:application/octet-stream"); 
	Header("Content-Length:".filesize($full_file_name));
	Header("Content-Disposition:attachment;filename=" . $file_alias);
	Header("Content-Transfer-Encoding:binary"); 
	Header("Pragma:no-cache"); 
	Header("Expires:0"); 
} else {
	Header("Content-type:file/unknown"); 
	Header("Content-Length:".filesize($full_file_name));
	Header("Content-Disposition:attachment; filename=" . $file_alias);
	Header("Content-Description:PHP3 Generated Data"); 
	Header("Pragma: no-cache"); 
	Header("Expires: 0"); 
}

if (is_file($full_file_name)) { 
	$fp = fopen($full_file_name, "rb"); 
	if (!fpassthru($fp)) fclose($fp); 
	clearstatcache();
}
?>