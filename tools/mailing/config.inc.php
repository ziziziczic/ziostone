<?
##########################################################################
##  ���α׷��� : insiter(�λ����� - ���ϸ�) v1.00
##  ���α׷���Ϲ�ȣ : 2002-01-23-3677
##  ���۱��� : ������
##  ���ѹα� ��ǻ�� ���α׷� ��ȣ�� �� 23�� ��1�� �� ��������� ��16���� ������ ���� ��ȣ��.
##########################################################################
##  ���� ���� �Ϸ���: 2002. 1. 20
##  2�� ������ : 2002. 12. 17
##  ���߻� : �븮����Ʈ(VALLEYGATE / 305-14-73405)
##  Ȩ������ : http://www.ohmysite.co.kr)
##  å�Ӱ����� : ������
##########################################################################
##
##  ī�Ƕ���Ʈ ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� ���α׷��� �ƴմϴ�. �� ���α׷��� ������ �� ���ѹα�
##  ������ ���Ͽ� ���۱��� ��ȣ�ް� �ִ� ��� ����Ʈ���� �Դϴ�. �� ���α׷�
##  �� ����, ���Ǹ�, �����Ǹ�, ���� �������� ������� �ҹ������Դϴ�.
##  ����, �����̻���Ʈ�� ���� ���� �� ���α׷��� ���� �������� �κ� ���� ��
##  ����, ���� ���� �ҹ������� ���ֵ˴ϴ�.
##
##  ����� ���� ����
##  ----------------------------------------------------------------------
##  �� ���α׷��� ���� �����ڴ� 1 Account �������� �־��� ���̸� �����̻���Ʈ�κ��� ������� ������ ���� ��
##  �ֽ��ϴ�. ��, �� ȭ���� ���������� ������ �ϰų�, ������ �Ǿ��� ��쿡��
##  ������� ������ �߰� ����� û���ɼ� ������, ����� ������ ������� ���� 
##  �� �ֽ��ϴ�.
##  ���α׷��� ���� �ڼ��� ���� Ȥ�� ���޻���� 0505-823-2323 �̳� help@ohmysite.co.kr �� �ֽñ� �ٶ��ϴ�.
##
##########################################################################

// ���, ���Ǽ���� (���� ����Ʈ�� ž���, �ʿ信 ���� ���� �� �� ����)
$GLOBALS[w_gmdate] = gmdate("D, d M Y H:i:s") . " GMT"; // ����ð� ����
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $GLOBALS[w_gmdate]);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
$vg_mailing_session_save_dir = "{$vg_mailing_dir_site_root}_session";	// ���������
session_save_path($vg_mailing_session_save_dir);
session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
session_start();

$GLOBALS[w_time] = time();	// ���� �ð�(������Ÿ�ӽ�����)
define("VG_MAILING_INCLUDE", "YES");

// ���丮 ������
$vg_mailing_dir_info = array();
$vg_mailing_dir_info[root] = "{$vg_mailing_dir_site_root}tools/mailing/";	// ���α׷� ��Ʈ ���丮 ($vg_mailing_dir_site_root �� �� ������ ��Ŭ��� �ϱ� ���� ��������)
$vg_mailing_dir_info['include'] = $vg_mailing_dir_info[root] . "include/";
$vg_mailing_dir_info[images] = $vg_mailing_dir_info[root] . "images/";
$vg_mailing_dir_info[contents] = $vg_mailing_dir_info[root] . "contents_file/";

// DB���� �� ���� ����Ʈ �������� ����
include "{$vg_mailing_dir_info[root]}db.inc.php";

// ������̺귯����ü����
include "{$vg_mailing_dir_site_root}include/library_common.class.php";
$lh_common = $GLOBALS[lib_common] = new library_common();

// ������̺귯����ü����
include "{$vg_mailing_dir_info['include']}library_vg_mailing.class.php";
$lh_vg_mailing = new library_vg_mailing();

// ���ڵ� ���̺귯�� ��ü ����
include "{$vg_mailing_dir_site_root}include/library_fix.class.php";
$lib_fix = new library_fix();

// ����Ʈ ���� ����
$site_info = $lib_fix->get_site_info();

// ��������� �Լ�
@include "{$vg_mailing_dir_info['include']}user_function.inc.php";

// �ֿ� ���� ���Ǻ�
$vg_mailing_setup = array("send_pack"=>100, "send_term"=>3, "default_name"=>"��", "divider"=>';', "test_email"=>$site_info[site_email], "send_email"=>$site_info[site_email], "send_name"=>$site_info[site_name]);	// ��������
$vg_mailing_inc = array('C'=>"����", 'B'=>"����");
$vg_mailing_field_name = array("name"=>"name", "email"=>"email");

// �������� ������
$vg_mailing_file[mail_form] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=send_mail_form.php";
$vg_mailing_file[history_list] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=history.php";
$vg_mailing_file[history_view] = "{$vg_mailing_dir_info[root]}index.php?vg_mailing_file_name=history_view.php";
$vg_mailing_file[die_msg] = "{$vg_mailing_dir_info['include']}skin_die.html";

if ($_SESSION[user_id] != '') {
	$vg_mailing_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
} else {
	$vg_mailing_user_info[user_level] = 8;
}
$auth_method_array = array(array('L', '1', $vg_mailing_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) $lh_common->die_msg("������ �����ϴ�.", $vg_mailing_file[die_msg]);
?>