<?
// 서브메뉴
$sub_menu_btn = "
<table width=150 border=0 cellpadding=0 cellspacing=0 bgcolor=white align=center>
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='index.php?menu=favorite_link'>{$IS_icon[form_title]}기본설정&대표링크</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=15></td></tr>
</table>
";		
$sub_menu_btn_1 = $lib_insiter->w_get_img_box("thin_skin_round_title", $sub_menu_btn, $IS_input_box_padding, array("title"=>"<b>즐겨찾기관리</b>"));

$sub_menu_service = "
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td>$sub_menu_btn_1</td>
	</tr>
</table>
";
?>