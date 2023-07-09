<?
echo("
<b>* 장바구니에 담긴 내용</b>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table width=100% border=0 cellspacing=1 cellpadding=5 align=center bgcolor=cccccc>
				<tr align=center height=30 bgcolor=f3f3f3> 
					<td width=55><b>번호</td>
					<td width=35><b>사진</td>
					<td><b>이름</td>
					<td width=90><b>옵션</td>
					<td width=80><b>수량</td>
					<td width=60><b>단가</td>
					<td width=60><b>소계</td>					
					<td width=40><b>삭제</td>
				</tr>
");
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
	$tag_img = "<a href='$T_img_src' target=_blank><img src='$T_img_src' border=0 width=35 height=35></a>";
	##########################

	echo("
				<form method=get action='{$vg_cart_file[update]}'>
				<input type=hidden name=mode value=modify>
				<input type=hidden name=cart_serial value=$vg_cart_i>
				<tr bgcolor=#ffffff align=center>
					<td>{$_SESSION[$T_board_name]}-{$_SESSION[$T_serial_num]}</td>
					<td>$tag_img</td>
					<td align=left>$_SESSION[$T_name]</td>
					<td>$T_option</td>
					<td>" . $lh_common->make_input_box($_SESSION[$T_quantity], "qty", "text", "class=design_text size=1", '') . ' ' . $lh_common->make_input_box("변경", "", "submit", "class=design_button", '') . "</td>
					<td>$_SESSION[$T_price] 원</td>
					<td>$vg_cart_sub_sum 원</td>					
					<td>" . $lh_common->make_input_box("삭제", "del_ct", "button", "class='design_button' onclick=\"document.location.href='{$vg_cart_file[update]}?mode=delete&cart_serial={$vg_cart_i}'\"", '') . "</td>
				</tr>
				</form>
	");
}
echo("
			</table>
		</td>
	</tr>	
	<tr><td height=5></td></tr>
	<tr>
		<td align=right>
			<table cellpadding=2>
				<tr>
					<td><u><b><font color=blue>합계 : " . number_format($vg_cart_amount) . "</font></b></u></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
");
?>