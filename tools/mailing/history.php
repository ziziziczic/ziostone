<?

$query = "select * from $vg_tax_db_tables[history] order by sign_date desc";
$query_ppb = str_replace("select *", "select count(sh_serial)", $query);
$sh_ppb_link = $lh_common->get_page_block($query_ppb, 20, 10, $_GET[page], '', '');
$sh_list_info = $lh_vg_mailing->get_sh_list($query, $sh_ppb_link[1][0], 20, $_GET[page], '4');

echo("
<table>
	<tr>
		<td>
			<b>[ 메일링 전송기록 ]</b>
		</td>
	</tr>
	<tr>
		<td>
			<table border='0' cellpadding='5' cellspacing='1' width=100% bgcolor='#CABE8E' style='table-layout:fixed'>
				<tr>
					<td class=item_title width=40 align=center>번호</td>
					<td class=item_title>제목</td>
					<td class=item_title width=80>발송수</td>
					<td class=item_title width=130>발송일</td>
				</tr>
				$sh_list_info[0]
");

if ($sh_ppb_link[0] != "") {
	echo("
				<tr bgcolor=white align=center>
					<td colspan=4>$sh_ppb_link[0]</td>
				</tr>
	");
}
echo("
			</table>
		</td>
	</tr>
</table>
<br>
<center><input type='button' value='닫기' onclick=\"javascript:window.close()\"></center>
");
?>
</body>
</html>