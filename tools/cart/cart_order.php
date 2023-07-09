<?
$vg_cart_dir_site_root = "../../";
include "config.inc.php";
if ($_SESSION[$vg_cart_var_name[total]] <= 0) $lh_common->alert_url("구매할 품목을 먼저 담으세요");
include "{$vg_cart_dir_info['include']}post_var_filter.inc.php";

$goods_info = "
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table width=100% border=0 cellspacing=1 cellpadding=5 align=center bgcolor=cccccc>
				<tr align=center height=30 bgcolor=f3f3f3> 
					<td width=55><b>번호</td>
					<td width=35><b>사진</td>
					<td><b>품명</td>
					<td width=90><b>옵션</td>
					<td width=80><b>수량</td>
					<td width=60><b>단가</td>
					<td width=60><b>소계</td>					
				</tr>
";
$vg_cart_amount = 0;
for($vg_cart_i=0; $vg_cart_i<$_SESSION[$vg_cart_var_name[total]]; $vg_cart_i++) {			// 장바구니 배열수만큼 루프 돌린다..
	$vg_cart_sub_sum = 0;
	$T_board_name = $vg_cart_var_name[board_name] . $vg_cart_i;
	$T_serial_num = $vg_cart_var_name[serial_num] . $vg_cart_i;
	$T_name = $vg_cart_var_name[name] . $vg_cart_i;
	$T_price = $vg_cart_var_name[price] . $vg_cart_i;
	$T_quantity = $vg_cart_var_name[quantity] . $vg_cart_i;
	$T_opt1 = $vg_cart_var_name[option1] . $vg_cart_i;
	$T_opt2 = $vg_cart_var_name[option2] . $vg_cart_i;
	$T_opt3 = $vg_cart_var_name[option3] . $vg_cart_i;
	$T_option = '';
	if ($_SESSION[$T_opt1] != '') $T_option .= $_SESSION[$T_opt1] . "<br>";
	if ($_SESSION[$T_opt2] != '') $T_option .= $_SESSION[$T_opt2] . "<br>";
	if ($_SESSION[$T_opt3] != '') $T_option .= $_SESSION[$T_opt3] . "<br>";
	$vg_cart_sub_sum = (int)$_SESSION[$T_price] * (int)$_SESSION[$T_quantity];
	$vg_cart_amount += $vg_cart_sub_sum;

	## 사용자정의부 ################
	$article_info = $lh_common->get_data("TCBOARD_" . $_SESSION[$T_board_name], "serial_num", $_SESSION[$T_serial_num]);
	$T_exp = explode(';', $article_info[user_file]);
	$T_img_src = "http://{$_SERVER[HTTP_HOST]}/design/upload_file/{$_SESSION[$T_board_name]}/{$T_exp[0]}";
	$tag_img = "<a href=$T_img_src target=_blank><img src=$T_img_src border=0 width=35 height=35></a>";
	##########################

	$goods_info .= "
				<tr bgcolor=#ffffff align=center>
					<td>{$_SESSION[$T_board_name]}-{$_SESSION[$T_serial_num]}</td>
					<td>$tag_img</td>
					<td align=left>$_SESSION[$T_name]</td>
					<td>$T_option</td>
					<td>$_SESSION[$T_quantity]</td>
					<td>$_SESSION[$T_price] 원</td>
					<td>$vg_cart_sub_sum 원</td>					
				</tr>
	";
}
$goods_info .= "
			</table>
		</td>
	</tr>	
</table>
";

$od_receipt_card = str_replace(',', '', $od_receipt_card);
$od_receipt_bank = str_replace(',', '', $od_receipt_bank);
$od_receipt_milage = str_replace(',', '', $od_receipt_milage);

$order_info = array();
$order_info[order_num] = time();
$order_info[order_passwd] = $od_pwd;
$order_info[order_member_serial] = $vg_cart_user_info[serial_num];
$order_info[order_goods_info] = $goods_info;
$order_info[order_c_name] = $od_name;
$order_info[order_c_email] = $od_email;
$order_info[order_c_address] = "($od_zip1-$od_zip2) $od_addr";
$order_info[order_c_phone] = $od_tel;
$order_info[order_c_mobile] = $od_hp;
$order_info[order_c_hope_date] = $od_hope_date;
$order_info[order_c_memo] = $od_memo;
$order_info[order_c_bank] = $od_bank_account;
$order_info[order_c_dep_name] = $od_deposit_name;
$order_info[order_d_name] = $od_b_name;
$order_info[order_d_email] = $od_b_email;
$order_info[order_d_address] = "($od_b_zip1-$od_b_zip2) $od_addr";
$order_info[order_d_phone] = $od_b_tel;
$order_info[order_d_mobile] = $od_b_hp;
$order_info[order_cost_goods] = $od_amount;
$order_info[order_cost_delivery] = $od_send_cost;
$order_info[order_pay_method] = $od_settle_case;
$order_info[order_pay_card] = $od_receipt_card;
$order_info[order_pay_bank] = $od_receipt_bank;
$order_info[order_pay_cyber_money] = $od_receipt_milage;
$order_info[order_state] = 'A';
$order_info[order_sign_date] = $order_info[order_num];

$lh_common->input_record($vg_db_tables[order_list], $order_info);
if ($order_info[order_pay_cyber_money] > 0) $lh_vg_cart->insert_milage($vg_cart_user_info[id], -$order_info[order_pay_cyber_money], "$order_info[order_num]-주문에 사용", $order_info[order_num], '', 'F');
$lh_vg_cart->cart_delete_all();
$lh_common->alert_url('', 'E', $vg_cart_file[order_confirm] . "&order_num={$order_info[order_num]}&order_passwd={$od_pwd}");
?>