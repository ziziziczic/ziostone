<?
// ÆË¾÷Ã¢°ü¸® ¼­ºê¸Þ´º
$btn_page_type = "
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='popup_input_form.php?menu=popup'>{$IS_icon[form_title]}ÆË¾÷Ã¢ÀÛ¼º</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	<tr>
		<td><a href='popup_list.php?menu=popup'>{$IS_icon[form_title]}ÆË¾÷Ã¢¸ñ·Ïº¸±â</a></td>
	</tr>
";
$sub_menu = "
	<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
		$btn_page_type
	</table>
";		
$sub_menu_popup = $lib_insiter->w_get_img_box($IS_thema_left, $sub_menu, $IS_input_box_padding, array("title"=>"<b>ÆË¾÷Ã¢°ü¸®</b>"));
?>