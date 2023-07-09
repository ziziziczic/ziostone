<?
$vg_cart_dir_site_root = "../../";
include "config.inc.php";
$auth_method_array = array(array('L', '1', $vg_cart_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("권한이 없습니다.");;

include "{$vg_cart_dir_info['include']}post_var_filter.inc.php";

switch ($_POST[mode]) {
	case "chg_state" :
		$lh_common->db_set_field_value($vg_db_tables[order_list], "order_state", $order_state, "order_num", $order_num);
		$lh_common->alert_url('', 'E', $vg_cart_file[order_list] . "&page=$page");
	break;
	case "modify" :
	break;
}
?>