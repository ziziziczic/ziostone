<?
$auth_method_array = array(array('L', '1', $vg_tax_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("������ �����ϴ�.");

if ($_POST[sch_kw] != '') $sub_query = "where biz_name like '%$sch_kw%' or biz_number like '%$sch_kw%' or biz_ceo like '%$sch_kw%' or biz_address like '%$sch_kw%'";
$query = "select * from $vg_tax_db_tables[buyer_list] $sub_query order by biz_name asc";
$query_ppb = str_replace("select *", "select count(serial_num)", $query);
$voucher_ppb_link = $lh_common->get_page_block($query_ppb, $vg_tax_setup[buyer_ppa], $vg_tax_setup[buyer_ppb], '', '', '');
$voucher_list_info = $lh_vg_tax->get_buyer_list($query, $voucher_ppb_link[1][0], $vg_tax_setup[buyer_ppa], $_GET[page]);

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<form name=frm method=post action='{$vg_tax_file[buyer_list]}'>
			<table align=right cellpadding=3 cellspacing=0 border=0>
				<tr>
					<td>
						<b>���հ˻� " . $lh_common->make_input_box($_POST[sch_kw], "sch_kw", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td>
						<input type=submit value='�˻�'>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<table border='0' cellpadding='5' cellspacing='1' width=100% bgcolor='#CABE8E' style='table-layout:fixed'>
				<tr>
					<td class=item_title width=40 align=center>��ȣ</td>
					<td class=item_title align=left width=120>��ȣ</td>
					<td class=item_title width=90 align=center>����ڹ�ȣ</td>
					<td class=item_title>������</td>
					<td class=item_title width=100>����</td>
					<td class=item_title width=100>����</td>
					<td class=item_title width=60 align=center>�����</td>
					<td class=item_title width=105 align=center>ó��</td>
				</tr>
				$voucher_list_info[0]
				<tr>
					<td colspan=2 class=item_title align=center><input type='button' value='�� �� ���' class='input_button' onclick=\"document.location.href='{$vg_tax_file[tax_list]}'\"></td>
					<td colspan=6 class=item_title align=center>$voucher_ppb_link[0]</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

");
?>