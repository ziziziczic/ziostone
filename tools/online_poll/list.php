<?
$sub_query = $sub_query_1 = '';
$auth_method_array = array(array('L', '1', $VG_OP_user_info[level], 'E'));
if ($lh_common->auth_process($auth_method_array)) {
	$btn_add = "<tr height=30><td align=right><input type='button' value='등록하기' class='input_button' onclick=\"document.location.href='{$VG_OP_dir_info[root]}?VG_OP_file_name=input_form.php'\"></td></tr>";
}
$sort_method = "order by sign_date desc";
$query = "select * from $VG_OP_db_table[title_list] $sort_method";
$T_ppa = 20;
$query_ppb = str_replace("select *", "select count(serial_num)", $query);
$ppb_link = $lh_common->get_page_block($query_ppb, $T_ppa, 10, $_GET[VG_OP_page], '', '', "images/", '', 'N', "VG_OP_page");
$list_info = $lh_vg_op->get_op_list($query, $ppb_link[1][0], $T_ppa, $_GET[VG_OP_page]);
echo("
<table width=680 cellpadding=0 cellspacing=0 border=0>
	$btn_add
	<tr>
		<td>
			<table width=100% border=0 cellspacing=1 cellpadding=5 align=center bgcolor=cccccc>
				<tr align=center height=40 bgcolor=f3f3f3> 
					<td width=50>번호</td>
					<td>설문제목</td>
					<td width=40>문항수</td>
					<td width=90>등록일</td>
					<td width=90>편집</td>
				</tr>
				$list_info[0]
				<tr bgcolor=ffffff>
					<td align=center height=30 colspan=5>
						$ppb_link[0]
					</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
");
?>