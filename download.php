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

if (!is_file($full_file_name)) $GLOBALS[lib_common]->die_msg("�ش������̳� ��ΰ� �������� �ʽ��ϴ�. <a href='javascript:history.back()'>[������������]</a>");

$extention = $GLOBALS[lib_common]->get_file_extention($full_file_name);
if (in_array($extention, $GLOBALS[VI][deny_ext])) {
	$host_info = $lib_fix->get_user_info($site_info[site_id]);
	$mail_contents = "
		{$site_info[site_name]} Ȩ�������� �̿����� �ý��������� �ٿ�ε� �Ϸ��� �õ��� �־����ϴ�.<br>
		IP Address : {$_SERVER[REMOTE_ADDR]}<br>
		����� ID : {$user_info[id]} {$user_info[name]}<br>
		�ð� : " . date("Y-m-d H:i:s", $GLOBALS[w_time]) . "<br>
		�õ��� ���� : {$full_file_name}
	";
	$log_info = array("owner"=>"system");
	$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $host_info[email], "�ý������� �ٿ�ε� �õ� ����", $mail_contents, 1, '', "EUC-KR", '', '', $GLOBALS[VI][mail_form], $log_info, 'N', $host_info[name]);
	$GLOBALS[lib_common]->alert_url("�ý��� �ʼ� ������ �ٿ�ε� �� �� �����ϴ�.\\n\\n������ �������ּ� $_SERVER[REMOTE_ADDR] �� ��� �Ǿ����� �����ڿ��� �뺸�Ǿ����ϴ�.");
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