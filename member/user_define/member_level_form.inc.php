<?
// ȸ����+�����ڿ� ���� ���α׷��� ���� ��Ŭ����.
//include "{$root}logistics1/config.inc.php";

$P_member_level_form = '';
if ($_GET[user_level] != '') $T_member_level = $_GET[user_level];															// url �켱 (�űԵ�Ͻ�)
else if ($edit_user_info[user_level] != '') $T_member_level = $edit_user_info[user_level];		// �����ڼ�����
else if ($user_info[user_level] != '') $T_member_level = $user_info[user_level];								// �Ϲݼ�����

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