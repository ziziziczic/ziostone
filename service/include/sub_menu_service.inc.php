<?
// 서브메뉴
$sub_menu_btn = "
<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='service_item_list.php?menu=service&code_table_name=VG_banner' onclick=\"alert('등록할 배너(상품) 우측의 구매 버튼을 클릭하세요');\">{$IS_icon[form_title]}신규배너등록</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='banner_list.php?menu=service'>{$IS_icon[form_title]}등록된배너목록</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='service_alarm.php'>{$IS_icon[form_title]}만기일알림</a></td>
	</tr>
</table>
";		
$sub_menu_btn_1 = $lib_insiter->w_get_img_box("thin_skin_round_title", $sub_menu_btn, $IS_input_box_padding, array("title"=>"배너관리"));

$sub_menu_btn = "
<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='service_item_input_form.php?menu=service'>{$IS_icon[form_title]}신규상품등록</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='service_item_list.php?menu=service&ppa=20'>{$IS_icon[form_title]}등록된 상품목록</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='buy_list.php?menu=service&search_item_date=date_sign&SCH_date_sign_1={$set_term_this_month[0]}&SCH_date_sign_2={$set_term_this_month[1]}&ppa=20'>{$IS_icon[form_title]}판매조회</a></td>
	</tr>
</table>
";		
$sub_menu_btn_2 = $lib_insiter->w_get_img_box("thin_skin_round_title", $sub_menu_btn, $IS_input_box_padding, array("title"=>"상품(서비스)관리"));
$sub_menu_service = "
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td>$sub_menu_btn_1</td>
	</tr>
	<tr><td height=5></td></tr>
	<tr>
		<td>$sub_menu_btn_2</td>
	</tr>
</table>
";
?>