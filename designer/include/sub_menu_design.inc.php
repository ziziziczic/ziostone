<?
// �����ΰ��� ����޴�
$btn_page_type = "
	<tr><td height=5></td></tr>
";
if ($PHP_SELF == "/designer/page_list.php") {
	$btn_page_type .= "
		<tr>
			<td><a href=\"javascript:openAddCateWin('')\">{$IS_icon[form_title]}�����������</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	";
	$btn_page_default = "
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href=\"javascript:verify()\">{$IS_icon[form_title]}�������ʱ�ȭ</a></td>
		</tr>
	";
}
while (list($key, $value) = each($GLOBALS[VI][page_type_array])) {
	$btn_page_type .= "
		<tr>
			<td><a href='page_list.php?menu=design&SCH_type=$key&ppa=50'>{$IS_icon[form_title]}{$value}</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
	";
}
$btn_page_type .= "
	<tr>
		<td><a href='page_list.php?menu=design&ppa=200'>{$IS_icon[form_title]}��ü����</a></td>
	</tr>
	<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}skin_list.php?src=./images/box/'>{$IS_icon[form_title]}���̺�Ų ���</a></td>
		</tr>
	$btn_page_default
";

$sub_menu = "
	<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
		$btn_page_type
	</table>
";		
$sub_menu_design = $lib_insiter->w_get_img_box($IS_thema_left, $sub_menu, $IS_input_box_padding, array("title"=>"<b>�����ΰ���</b>"));
?>