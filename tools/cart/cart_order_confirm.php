<?
include "{$vg_cart_dir_info['include']}lock_direct_conn.inc.php";
$order_detail_info = $lh_common->get_data($vg_db_tables[order_list], "order_num", $order_num);
$order_auth = $order_number . '_' . $order_passwd;
$order_auth_saved = $order_detail_info[order_num] . '_' . $order_detail_info[order_passwd];
$auth_method_array = array(array('L', '1', $vg_cart_user_info[user_level], 'E'), array('M', $order_detail_info[order_member_serial], $vg_cart_user_info[serial_num], 'E'), array('M', $order_auth_saved, $order_auth, 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("������ �����ϴ�.");

echo("
	<table>
		<tr>
			<td><b>* �����մϴ�. ��û�� �Ϸ� �Ǿ����ϴ�. ��û�Ͻ� ������ �Ʒ��� �����ϴ�.</b></td>
		</tr>
		<tr>
			<td><font color=red><b>* <u>�ֹ���ȣ : $order_num</u></b></font></td>
		</tr>
	</table>
	$order_detail_info[order_goods_info]<br>
	<table border='0' width='100%' cellspacing='1' cellpadding='5' bgcolor='#C0C0C0'>
		<tr>
			<td bgcolor='#F3F3F3' colspan='2' width=50%><b>* �ֹ��� ����</b></td>
			<td bgcolor='#F3F3F3' colspan='2' width=50%><b>* ����� ����</b></td>
		</tr>
		<tr>
			<td width='100' bgcolor='#F3F3F3'>����</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_c_name]</td>
			<td width='100' bgcolor='#F3F3F3'>����</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_d_name]</td>
		</tr>
		<tr>
			<td bgcolor='#F3F3F3'>�ּ�</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_c_address]</td>
			<td bgcolor='#F3F3F3'>�ּ�</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_d_address]</td>
		</tr>
		<tr>
			<td bgcolor='#F3F3F3'>�̸���</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_c_email]</td>
			<td bgcolor='#F3F3F3'>��</td>
			<td bgcolor='#FFFFFF'>��</td>
		</tr>
		<tr>
			<td bgcolor='#F3F3F3'>��ȭ��ȣ</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_c_phone]</td>
			<td bgcolor='#F3F3F3'>��ȭ��ȣ</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_d_phone]</td>
		</tr>
		<tr>
			<td bgcolor='#F3F3F3'>�޴���ȭ</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_c_mobile]</td>
			<td bgcolor='#F3F3F3'>�޴���ȭ</td>
			<td bgcolor='#FFFFFF'>$order_detail_info[order_d_mobile]</td>
		</tr>
		<tr>
			<td bgcolor='#F3F3F3'>�޸�</td>
			<td bgcolor='#FFFFFF' colspan='3'>" . nl2br($order_detail_info[order_c_memo]) . "</td>
		</tr>
	</table>
");
if ($vg_cart_file[order_complete] == '') {
	$btn = "<input type=button value='Ȯ��' onclick=\"window.close()\">";
} else {
	$btn = "<input type=button value='Ȯ��' onclick=\"document.location.href='$vg_cart_file[order_complete]'\">";
}

echo("
	<br>
	<table align=center>
		<tr>
			<td>$btn</td>
		</tr>
	</table>
");
?>