<?
$auth_method_array = array(array('L', '1', $vg_cart_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("������ �����ϴ�.");;

$query = "select * from $vg_db_tables[order_list] order by order_sign_date desc";
$T_ppa = 20;
$query_ppb = str_replace("select *", "select count(order_num)", $query);
$ppb_link = $lh_common->get_page_block($query_ppb, $T_ppa, 10, $_GET[page], '', '', "images/", '', 'N', "page");
$list_info = $lh_vg_cart->get_order_list($query, $ppb_link[1][0], $T_ppa, $_GET[page]);
echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	$btn_add
	<tr>
		<td>
			<table width=100% border=0 cellspacing=1 cellpadding=5 align=center bgcolor=cccccc>
				<tr align=center height=40 bgcolor=f3f3f3> 
					<td width=60><b>�ֹ���ȣ</td>
					<td width=50><b>����</td>
					<td width=85><b>��ȭ</td>
					<td align=left><b>�̸���</td>
					<td width=60 align=right><b>�ݾ�</td>
					<td width=90><b>����</td>
					<td width=70><b>����</td>
					<td width=50><b>�ֹ���</td>
				</tr>
				$list_info[0]
				<tr bgcolor=ffffff>
					<td align=center height=30 colspan=8>
						$ppb_link[0]
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
");
?>