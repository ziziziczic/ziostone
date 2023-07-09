<?
if ($_GET[tax_serial_num] == '') $lh_common->die_msg("계산서 번호 오류");
$tax_info = $lh_common->get_data($vg_tax_db_tables[tax_list], "serial_num", $_GET[tax_serial_num]);

$tax_auth_value = $tax_info[serial_num] . $tax_info[sign_date] . $tax_info[biz_issue_date];
$tax_auth_value_get = $_GET[tax_serial_num] . $_GET[tsd] . $_GET[bid];

$auth_method_array = array(array('L', '1', $vg_tax_user_info[user_level], 'E'), array('M', $tax_auth_value, $tax_auth_value_get, 'E'));
if (!$lh_common->auth_process($auth_method_array)) $lh_common->die_msg("계산서를 볼 수 없습니다.", "{$vg_tax_dir_info['include']}skin_die.html");

include "{$vg_tax_dir_info['include']}form_tax.inc.php";

$auth_method_array = array(array('L', '1', $vg_tax_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) {
	$voucher_tax_value_seller = $btn_list = '';							// 관리자가 아닌경우 공급자 정보는 제거
	if (eregi($_SERVER[HTTP_HOST], $_SERVER[HTTP_REFERER]) == false) {
		$lh_common->db_set_field_value($vg_tax_db_tables[tax_list], "biz_tax_count", $tax_info[biz_tax_count]+1, "serial_num", $tax_info[serial_num]);
	}
} else {
	$btn_list = "<a href='{$vg_tax_file[tax_list]}&buyer_serial_num=$tax_info[biz_b_serial]'><img src='images/btn_list.gif' width='52' height='20' border='0'></a> ";
	$voucher_tax_value_buyer = "<br><hr size=1 color=cccccc> . $voucher_tax_value_buyer <div style='z-index:-1; top:595px; left:260px;position:absolute;'><img src='{$vg_tax_dir_info[images]}/stamp.gif' width=60 border='0' align='absmiddle'></div>";
}
echo("
<table border=0 width=580>
  <tr>
	 <td align=right>$btn_list<a href='#' onclick='javascript:window.print()'><img src='images/btn_print.gif' width='52' height='20' border='0'></a> <a href='javascript:window.close();'><img src='images/btn_cancel2.gif' width='52' height='20' border='0'></a></td>
  </tr>
</table>
<div style='z-index:-1; top:115px; left:260px;position:absolute;'><img src='{$vg_tax_dir_info[images]}/stamp.gif' width=60 border='0' align='absmiddle'></div>
$voucher_tax_value_seller
$voucher_tax_value_buyer
");
?>