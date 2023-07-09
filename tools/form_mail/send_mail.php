<?
include "config.inc.php";
if ($_POST[flag] != $_SERVER[HTTP_HOST]) die("비정상적인 입력은 허용되지 않습니다.");

// 시간제한 없음
set_time_limit(0);
for ($i=1; $i<=$attach; $i++) {
	$var = "var";
	$$var = "file$i";
	$var_name = "var_name";
	$$var_name = "file$i" . "_name";
	if ($$var_name != "") $file[] = $GLOBALS[lib_common]->attach_file($$var_name, $$var);
}
if ($is_html != 'Y') $contents = nl2br(htmlspecialchars(stripslashes($contents)));
else $contents = stripslashes($contents);
$host_info = $lib_insiter->get_user_info($site_info[site_id]);
if ($host_info[mobile_phone] != '') $mobile_phone = ", $host_info[mobile_phone]";
if ($host_info[email] != '') $T_email = ", $host_info[email]";
if ($host_info[homepage] != '') $homepage = ", $host_info[homepage]";
$VG_FM_setup[footer] = "
	상호 : $site_info[site_name] / $host_info[address]<br>
	연락처 : {$host_info[phone]}{$mobile_phone}{$T_email}{$homepage}
";
$GLOBALS[lib_common]->mailer($from_name, $from_email, $to_email, stripslashes($subject), $contents, "1", $file, "EUC-KR", $ccmail, $bccmail, $VG_FM_setup[skin], '', 'Y', $to_name, 'Y', $VG_FM_setup);
?>
<script language="JavaScript">
<!--
    alert('메일을 정상적으로 발송하였습니다.');
    window.close();
//-->
</script>