<?
// 회원용+관리자용 수정 프로그램에 동시 인클루드됨.
//include "{$root}logistics1/config.inc.php";

$P_member_level_form = '';
if ($_GET[user_level] != '') $T_member_level = $_GET[user_level];															// url 우선 (신규등록시)
else if ($edit_user_info[user_level] != '') $T_member_level = $edit_user_info[user_level];		// 관리자수정시
else if ($user_info[user_level] != '') $T_member_level = $user_info[user_level];								// 일반수정시

switch ($T_member_level) {
	case '7' :
	break;
	case '6' :
	break;
	case '5' :
	case '1' :
	break;
	case '4' :
	break;
	case '3' :
	break;
	case '2' :
	break;
}
?>