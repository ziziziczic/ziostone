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
	$vg_cart_session_save_dir = "{$vg_cart_dir_site_root}_session";
	session_save_path($vg_cart_session_save_dir);
	session_set_cookie_params(0,"/", ".{$_SERVER[HTTP_HOST]}");
	session_start();
}
// �������
define("VG_CART_INCLUDE", "YES");

// ��ٱ��� �̸�
$vg_cart_name = "cart";
$vg_cart_var_select_serials_name = "list_select";	// ���û��� �̸�.

// DB �ʵ��Ī
$vg_cart_match[serial_num] = "serial_num";
$vg_cart_match[name] = "subject";
$vg_cart_match[price] = "email";
$vg_cart_match[quantity] = "homepage";
$vg_cart_match[option1] = "etc_1";
$vg_cart_match[option2] = "etc_2";
$vg_cart_match[option3] = "etc_3";
$vg_cart_match[option_div] = ':';

// ���丮 ������
$vg_cart_dir_info = array();
$vg_cart_dir_info[root] = "{$vg_cart_dir_site_root}tools/{$vg_cart_name}/";	// ���α׷� ��Ʈ ���丮 ($vg_cart_dir_site_root �� �� ������ ��Ŭ��� �ϱ� ���� ��������)
$vg_cart_dir_info['include'] = $vg_cart_dir_info[root] . "include/";
$vg_cart_dir_info[images] = $vg_cart_dir_info[root] . "images/";

// DB���� �� ���� ����Ʈ �������� ����
include_once "{$vg_cart_dir_site_root}db.inc.php";

// �������� ������
$vg_cart_file[search_addr] = "{$vg_cart_dir_site_root}member/zipsearch.php";
$vg_cart_file['list'] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=list.php";
$vg_cart_file[update] = "{$vg_cart_dir_info[root]}cart_update.php";
$vg_cart_file[order] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=cart_order_form.php";
$vg_cart_file[order_confirm] = "{$vg_cart_dir_info[root]}?vg_cart_file_name=cart_order_confirm.php";
$vg_cart_file[order_complete] = '';	// �ֹ��Ϸ��� �̵������� (���� ������ â�ݱ�)
$vg_cart_file[order_list] = "{$vg_cart_dir_site_root}designer/order_list.php?";								// �����ڿ�
$vg_cart_file[order_detail] = "{$vg_cart_dir_site_root}designer/order_detail.php?";					// �����ڿ�


// �ֿ� ���� ���Ǻ�
$vg_cart_setup = array("use_fix_date"=>'N', "use_bank"=>'Y', "use_card"=>'N', "use_cyber_money"=>'Y', "usable_cyber_money"=>"3000", "usable_card"=>"1000");	// �������� ����
$vg_cart_var_name[total] = "vg_cart_{$vg_cart_name}_total";
$vg_cart_var_name[board_name] = "vg_cart_{$vg_cart_name}_board_name_";
$vg_cart_var_name[serial_num] = "vg_cart_{$vg_cart_name}_serial_num_";
$vg_cart_var_name[name] = "vg_cart_{$vg_cart_name}_name_";
$vg_cart_var_name[price] = "vg_cart_{$vg_cart_name}_price_";
$vg_cart_var_name[quantity] = "vg_cart_{$vg_cart_name}_quantity_";
$vg_cart_var_name[option1] = "vg_cart_{$vg_cart_name}_option1_";
$vg_cart_var_name[option2] = "vg_cart_{$vg_cart_name}_option2_";
$vg_cart_var_name[option3] = "vg_cart_{$vg_cart_name}_option3_";
$vg_cart_account = array("�������� 350402-04-003788 ������");
$vg_cart_order_state = array('A'=>"Ȯ����", 'B'=>"�غ���", 'C'=>"�����", 'D'=>"��ۿϷ�");

$vg_db_tables = array("order_list"=>"VG_CART_order_list");

// ������̺귯����ü����
if ($GLOBALS[lib_common] == '') {
	include "{$vg_cart_dir_site_root}include/library_common.class.php";
	$lh_common = new library_common();
} else {
	$lh_common = $GLOBALS[lib_common];
}

// ������̺귯����ü����
include "{$vg_cart_dir_info['include']}library_vg_cart.class.php";
$lh_vg_cart = new library_vg_cart();

// ��������� �Լ�
@include "{$vg_cart_dir_info['include']}user_function.inc.php";

if ($_SESSION[user_id] != '') {
	$vg_cart_user_info = $lh_common->get_data("TCMEMBER", "id", $_SESSION[user_id]);
	$vg_cart_user_info[cyber_money] = vg_op_get_cyber_money($_SESSION[user_id]);
} else {
	$vg_cart_user_info[user_level] = 8;
}
?>