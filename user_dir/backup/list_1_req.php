<?
if ($table_pt != '') $table_pt = ' ' . $table_pt;
if ($target != '') $target = " target='$target'";
$goods_list = "
<table{$table_pt}>
	<tr>
		<td height=30>* 작은이미지보기로 정렬되었습니다.<br></td>
	</tr>
	<tr>
		<td>
			<table width=100% cellpadding=3 cellspacing=0 border=0>
";
$td_width = 100 / $mod;
for ($i=0; $i<sizeof($list_array); $i++) {
	$it_name = stripslashes($list_array[$i][it_name]);
	$image = get_it_image($list_array[$i][it_images], 0, $image_info, $list_array[$i][it_id], '', $target);
	$good_price = get_it_sell_amount($list_array[$i][it_id]);
	$goods_list .= "
				<form name=frm_{$list_array[$i][it_id]} method=post action='{$DIRS[shop_root]}s_bag_modify.php'>
				<input type=hidden name=it_id value='{$list_array[$i][it_id]}'>
				<input type=hidden name=sw_direct value=''>
				<input type=hidden name=it_sell_amount value='$good_price'>
				<input type=hidden name=qty value='1'>
				<tr>
					<td width=70>$image</td>
					<td><a href='{$root}insiter.php?it_id={$list_array[$i][it_id]}&design_file=goods.php' class=item{$target}><font color='#CD7400'><b>$it_name</b></font></a></td>
					<td width=90>{$list_array[$i][it_maker]}</td>
					<td width=100 align=right><font color='#CA6400'><b>" . number_format(get_it_sell_amount($list_array[$i][it_id])) . "</font> 원</td>
					<td width=100 align=right>
						<a href=\"javascript:frmitem_check(document.frm_{$list_array[$i][it_id]}, 'cart_update')\"><img src='images/btn_directbuy.gif' border=0></a>
						<!--<a href=\"javascript:frmitem_check(document.frm_{$list_array[$i][it_id]}, 'direct_buy')\"><img src='images/btn_directbuy.gif' border=0></a>//-->
					</td>
				</tr>
				</form>
				<tr>
					<td height bgcolor=f0f0f0 colspan=6></td>
				</tr>
	";
}
$goods_list .= "
			</table>
		</tr>
	</td>
</table>
<script language='Javascript'>
function frmitem_check(f, act) {
	if (f.it_sell_amount.value <= 0) {
		alert(\"전화로 문의해 주시면 감사하겠습니다.\");
		return;
	}
	for (i=1; i<=6; i++) {
		if (typeof(f.elements[\"it_opt\"+i]) != 'undefined') {
			if (f.elements[\"it_opt\"+i].value == '선택') {
				alert(f.elements[\"it_opt\"+i+\"_subject\"].value + '을(를) 선택해 주십시오.');
				f.elements[\"it_opt\"+i].focus();
				return;
			}
		}
	}
	if (act == \"direct_buy\") f.sw_direct.value = 1;
	else f.sw_direct.value = 0;
	f.submit();
}
</script>
";
?>