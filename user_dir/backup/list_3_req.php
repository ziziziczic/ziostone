<?
/*
$width = 50;
$height = 50;
$mod = 1;
$ppa = 20;
*/

$image_info = array("width"=>$value_category[ca_list_img_width], "height"=>$value_category[ca_list_img_height], "is_thumb"=>$value_category[ca_use_thumb]);
$table_pt = "width=638";
if ($table_pt != '') $table_pt = ' ' . $table_pt;
if ($target != '') $target = " target='$target'";
$goods_list = "
<table{$table_pt}> 
	<tr> 
		<td valign='top' background='{$shop_design_dir}images/r_header.gif' height=38 style='padding:0 20 8 20;'>
			<table width='100%' height='100%' > 
				<tr> 
					<td width='53'style='padding-left:7px;'><img src='{$shop_design_dir}images/01.gif'></td> 
					<td background='{$shop_design_dir}images/line01.gif'></td> 
					<td width='80' align='center'><img src='{$shop_design_dir}images/02.gif'></td> 
					<td class='rBhline'></td> 
					<td width='90' align='center'><img src='{$shop_design_dir}images/03.gif'></td> 
					<td class='rBhline'></td> 
					<td width='50' align='center'><img src='{$shop_design_dir}images/04.gif'></td> 
					<td class='rBhline'></td> 
					<td width='50' align='center'><img src='{$shop_design_dir}images/05.gif'></td> 
					<td class='rBhline'></td> 
					<td width='50' align='center'><img src='{$shop_design_dir}images/06.gif'></td> 
					<td class='rBhline'></td> 
					<td width='80' align='center'><img src='{$shop_design_dir}images/07.gif'></td> 
					<td class='rBhline'></td> 
					<td width='60' align='center'><img src='{$shop_design_dir}images/08.gif'></td> 
					<td class='rBhline'></td> 
					<td align='center'><img src='{$shop_design_dir}images/09.gif'></td> 
				</tr> 
			</table>
		</td> 
	</tr> 
";
$td_width = 100 / $value_category[ca_list_mod];
for ($i=0; $i<sizeof($list_array); $i++) {
	$it_name = stripslashes($list_array[$i][it_name]);
	$image = get_it_image($list_array[$i][it_images], 0, $image_info, $list_array[$i][it_id], '', $target);
	$goods_price = get_it_sell_amount($list_array[$i][it_id]);
	$good_price_unit = display_amount($goods_price[1]);
	$good_price_sum = display_amount($goods_price[0]);
	$link_detail = "<a href='{$root}insiter.php?it_id={$list_array[$i][it_id]}&design_file=goods.php' class=item{$target}>";
	$goods_list .= "
	<form name=frm_{$list_array[$i][it_id]} method=post action='{$DIRS[shop_root]}s_bag_modify.php'>
	<input type=hidden name=it_id value='{$list_array[$i][it_id]}'>
	<input type=hidden name=sw_direct value=''>
	<input type=hidden name=it_sell_amount value='$good_price_sum'>
	<input type=hidden name=qty value='1'>
	<input type=hidden name=proc_mode value='add'>
	<input type=hidden name=Q_STRING value='$QUERY_STRING'>
	<tr> 
		<td height='55' valign='top' class='rBc'><!-- 제품 한개소개 시작 --> 
			<table width='100%' height='50' > 
				<tr> 
					<td width='60'>
						<table width='50' height='50'> 
							<tr> 
								<td align='center'>$image</td> 
							</tr> 
						</table>
					</td> 
					<td width='82' align='center'>{$link_detail}{$it_name}</a></td> 
					<td width='90' align='center'>{$link_detail}<span class='cBlue'><b>{$list_array[$i][it_width]}x{$list_array[$i][it_length]}x{$list_array[$i][it_height]}</b></span></td> 
					<td width='52' align='center'>{$link_detail}{$list_array[$i][it_meterial]}</td> 
					<td width='50' align='center'>{$link_detail}$good_price_unit</td> 
					<td width='52' align='center'>{$link_detail}{$list_array[$i][it_sell_unit]}{$list_array[$i][it_ea_subject]}</td> 
					<td width='80' align='center'>{$link_detail}<span class='cPurple'><b>$good_price_sum</b></span></td> 
					<td width='62' align='center'><a href=\"javascript:frmitem_check(document.frm_{$list_array[$i][it_id]}, 'cart_update')\"><img src='{$shop_design_dir}images/btn/btn_chart.gif' width=39 height=18 border=0></a></td> 
					<td align='center'><a href=\"javascript:frmitem_check(document.frm_{$list_array[$i][it_id]}, 'direct_buy')\"><img src='{$shop_design_dir}images/btn/btn_order.gif' width=61 height=18 border=0></a></td> 
				</tr> 
			</table> 
		</td> 
	</tr>
	</form>
	<tr> 
		<td class='rBline'></td> 
	</tr>
	";
}
$goods_list .= "
	<tr> 
		<td class='rBbm'></td> 
	</tr> 
</table> 
<script language='Javascript'>
function frmitem_check(f, act) {
	if (f.it_sell_amount.value <= 0) {
		alert('전화로 문의해 주시면 감사하겠습니다.');
		return;
	}
	for (i=1; i<=6; i++) {
		if (typeof(f.elements['it_opt'+i]) != 'undefined') {
			if (f.elements['it_opt'+i].value == '선택') {
				alert(f.elements['it_opt'+i+'_subject'].value + '을(를) 선택해 주십시오.');
				f.elements['it_opt'+i].focus();
				return;
			}
		}
	}
	if (act == 'direct_buy') f.sw_direct.value = 1;
	else f.sw_direct.value = 0;
	f.submit();
}
</script>
";
?>
