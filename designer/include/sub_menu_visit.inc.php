<?
// 방문통계관리 서브메뉴
$btn_page_type = "
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='visit_search_form.php?menu=visit'>{$IS_icon[form_title]}방문통계검색</a></td>
	</tr>
";
$sub_menu = "
	<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
		$btn_page_type
	</table>
";		
$sub_menu_visit = $lib_insiter->w_get_img_box($IS_thema_left, $sub_menu, $IS_input_box_padding, array("title"=>"<b>방문통계관리</b>"));
?>