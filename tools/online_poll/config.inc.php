<?
if (INSITER_INCLUDE != "YES") {
	// ��� �����
	$GLOBALS[w_gmdate] = gmdate("D, d M Y H:i:s") . " GMT"; // ����ð� ����
	$GLOBALS[w_time] = time();	// ���� �ð�(������Ÿ�ӽ�����)
	$GLOBALS[JS_CODE] = array();		// �ڹٽ�ũ��Ʈ �ڵ尪�� �����Ѵ�.(���ڰ����� �ѹ��� ������ �Ǵ� �Լ����� �����ϰ� �� �Ʒ��ʿ� ���)

	header("Expires: 0"); // rfc2616 - Section 14.21
	header("Last-Modified: " . $GLOBALS[w_gmdate]);
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
	header("Pragma: no-cache"); // HTTP/1.0

	// ���������(���� ����Ʈ�� ž���, �ʿ信 ���� ���� �� �� ����)
	$VG_OP_session_save_dir = "{$VG_OP_dir_site_root}_session";
	session_save_path($VG_OP_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}

// �������
define("VG_OP_INCLUDE", "YES");

// ���丮 ������
$VG_OP_dir_info = array();
$VG_OP_dir_info[root] = "{$VG_OP_dir_site_root}tools/online_poll/";	// ���α׷� ��Ʈ ���丮 ($VG_OP_dir_site_root �� �� ������ ��Ŭ��� �ϱ� ���� ��������)
$VG_OP_dir_info['include'] = $VG_OP_dir_info[root] . "include/";
$VG_OP_dir_info[images] = $VG_OP_dir_info[root] . "images/";
$VG_OP_dir_info[skin] = $VG_OP_dir_info[root] . "skin/";
$VG_OP_dir_info[upload_file] = $VG_OP_dir_info[root] . "upload_file/";
$VG_OP_dir_info[etc] = $VG_OP_dir_info[root] . "etc/";
$VG_OP_dir_info[user_define] = $VG_OP_dir_info[root] . "user_define/";

// DB���� �� ���� ����Ʈ �������� ����
if ($root == '') $root = "../../";
include_once "{$VG_OP_dir_info['include']}db.inc.php";
include_once "{$root}/config.inc.php";	

// �������� ������
$VG_OP_file['list'] = "{$VG_OP_dir_info[root]}?VG_OP_file_name=list.php";

// �ֿ� ���� ���Ǻ�
$VG_OP_setup = array("admin_id"=>$site_info[site_id], "method"=>array('R'=>"����", 'C'=>"üũ����"), "q_num"=>10);	// 1���з�

// ������̺귯����ü����
//include "{$VG_OP_dir_info['include']}library_common.class.php";
//$lh_common = new library_common();
$lh_common = $lib_common;

// ������̺귯����ü����
include "{$VG_OP_dir_info['include']}library_vg_op.class.php";
$lh_vg_op = new library_vg_op();

// �����������Ī (���� : ������ 1 / ��� 2~6 / �Ϲ� 7)
$VG_OP_user_info = array("serial_num"=>$user_info[serial_num], "id"=>$user_info[id], "name"=>$user_info[name], "level"=>$user_info[user_level]); // array(�Ϸù�ȣ / ���̵� / ���� / ��Ÿ)
$VG_OP_user_level = '7';
$VG_OP_admin_level = '1';

// ��������� �Լ�
@include "{$VG_OP_dir_info[user_define]}user_function.inc.php";
?>