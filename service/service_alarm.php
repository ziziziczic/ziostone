<?
include "header_proc.inc.php";
banner_alarm("email");
banner_alarm("sms");
$change_vars = array("menu"=>"service");
$link = "./banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
$GLOBALS[lib_common]->alert_url("서비스 만기일알림을 완료하였습니다.", 'E', $link);
?>