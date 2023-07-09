<?
$root = "../../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$max_attach_file = 5;
$textarea_rows = 7;

$VG_FM_setup = array();
//$VG_FM_setup[skin] = "{$DIRS[tools_root]}form_mail/design/form_1/index.html";
$VG_FM_setup[skin] = "{$DIRS[design_root]}skin/mail.html";
$VG_FM_setup[contents_etc] = $send_mail_etc_info[contents_etc];
$VG_FM_setup[default_adver_file] = $send_mail_etc_info[default_adver_file];
?>