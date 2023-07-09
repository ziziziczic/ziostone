<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[include_root]}verify_input.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";

$query="select * from $DB_TABLES[member] where name='$mb_name' and email='{$email_1}@{$email_2}'";
$result = $GLOBALS[lib_common]->querying($query, "사용자 정보 추출 쿼리 수행중 에러발생");
$total = mysql_num_rows($result);

if ($total == 1) {
	$member_info = mysql_fetch_array($result);
	$send_id = $member_info[id];
	$send_pw = substr($GLOBALS[w_time], 0, 6);
	
	// 비밀번호 초기화
	$query = "update $DB_TABLES[member] set passwd=password('$send_pw') where serial_num='{$member_info[serial_num]}'";
	$GLOBALS[lib_common]->querying($query);

	switch ($recv_method) {
		case 'H' :
			$msg = "[{$site_info[site_name]}]\n아이디:{$send_id}\n비밀번호:{$send_pw}";
			$lib_insiter->send_sms($site_info[site_id], $member_info[phone_mobile], $host_info[phone], $msg);
			$result_msg = "요청하신 아이디와 임시비밀번호를 \\n\\n휴대폰({$member_info[phone_mobile]}) 으로 보내드렸습니다.\\n\\n감사합니다.";
		break;
		case 'E' :
			$msg = "
				아이디 : $send_id <br>
				임시비밀번호 : $send_pw <br><br>
				임시 비밀번호로 로그인 하신후 꼭 비밀번호를 변경해 주시기 바랍니다.<br>
				항상 최선을 다하는 $site_info[site_name] 가 되겠습니다.<br>
				감사합니다.
			";
			$log_info = array("owner"=>"{$member_info[id]}", "link"=>"findidpw");
			$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $member_info[email], "요청하신 ID와 비밀번호 입니다.", $msg, 1, '', "EUC-KR", '', '', $GLOBALS[VI][mail_form], $log_info, 'Y', $member_info[name]);	// 확인메일 발송
			$result_msg = "요청하신 아이디와 임시비밀번호를\\n\\n이메일({$member_info[email]}) 로 보내드렸습니다.\\n\\n감사합니다..";
		break;
	}
} else {
	if($total == 0) {
		$result_msg = "일치하는 회원정보가 없습니다.\\n\\n재검색 후에도 똑같은 상황이 발생될 경우\\n\\n관리자에게 문의해 주세요";
	} else if ($total > 1) {
		$result_msg = "일치하는 회원정보가 두명 이상입니다.\\n\\n관리자에게 문의해 주세요";
	}
}
$GLOBALS[lib_common]->alert_url($result_msg, 'E', $link);
?>