<?
##########################################################################
##  ���α׷��� : insiter(�λ����� - ���ݰ�꼭) v1.00
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
	$vg_tax_session_save_dir = "{$vg_tax_dir_site_root}_session";
	session_save_path($vg_tax_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}
// �������
define("VG_TAX_INCLUDE", "YES");

// �ֿ� ���� ���Ǻ�
$vg_tax_setup = array("dir_name"=>"tax_accounts", "tax_ppa"=>10, "tax_ppb"=>10, "buyer_ppa"=>10, "buyer_ppb"=>10, "use_buyer_id"=>'Y');	// ��������
$vg_tax_setup[tax_inc] = 'B';					// �ΰ��� ���Կ��� �⺻�� (��꼭 �߱޽� ��������)
$vg_tax_biz_info = array("name"=>"�븮����Ʈ", "number"=>"3051473405", "ceo"=>"������", "address"=>"����Ư���� �������� �븲2�� 993-2���� 301ȣ", "cond"=>"��ǻ�Ϳ����üҸ�", "type"=>"����Ʈ������Ǹ�,���ڻ�ŷ�", "default_email"=>"help@ohmysite.co.kr");
$vg_tax_pay = array('A'=>"����", 'B'=>"û��");
$vg_tax_inc = array('C'=>"����", 'B'=>"����");

// ���丮 ������
$vg_tax_dir_info = array();
$vg_tax_dir_info[root] = "{$vg_tax_dir_site_root}tools/{$vg_tax_setup[dir_name]}/";	// ���α׷� ��Ʈ ���丮 ($vg_tax_dir_site_root �� �� ������ ��Ŭ��� �ϱ� ���� ��������)
$vg_tax_dir_info['include'] = $vg_tax_dir_info[root] . "include/";
$vg_tax_dir_info[images] = $vg_tax_dir_info[root] . "images/";

// DB���� �� ���� ����Ʈ �������� ����
include "{$vg_tax_dir_info[root]}db.inc.php";

// �������� ������
$vg_tax_file[tax_view] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_view.php";
$vg_tax_file[tax_input_form] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_list.php";
$vg_tax_file[tax_list] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=tax_list.php";
$vg_tax_file[buyer_list] = "{$vg_tax_dir_info[root]}index.php?vg_tax_file_name=buyer_list.php";
$vg_tax_file[skin_die] = "{$vg_tax_dir_info['include']}skin_die.html";
$vg_tax_file[skin_mail] = "{$vg_tax_dir_info['include']}skin_mail.html";


// ������̺귯����ü����
if ($GLOBALS[lib_common] == '') {
	include "{$vg_tax_dir_site_root}include/library_common.class.php";
	$lh_common = new library_common();
} else {
	$lh_common = $GLOBALS[lib_common];
}

// ������̺귯����ü����
include "{$vg_tax_dir_info['include']}library_vg_tax.class.php";
$lh_vg_tax = new library_vg_tax();

// ��������� �Լ�
@include "{$vg_tax_dir_info['include']}user_function.inc.php";

if ($_SESSION[user_id] != '') {
	$vg_tax_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
} else {
	$vg_tax_user_info[user_level] = 8;
}
?>