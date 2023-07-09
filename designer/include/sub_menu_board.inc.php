<?
// 게시판관리 서브메뉴
$btn_page_type = "
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='board_input_form.php?menu=board'>{$IS_icon[form_title]}게시판만들기</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='board_list.php?menu=board'>{$IS_icon[form_title]}게시판목록보기</a></td>
	</tr>
";
//$btn_page_type .= "<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=3></td></tr>";
$sub_menu = "
	<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
		$btn_page_type
	</table>
";		
$sub_menu_board = $lib_insiter->w_get_img_box($IS_thema_left, $sub_menu, $IS_input_box_padding, array("title"=>"<b>게시판관리</b>"));
?>