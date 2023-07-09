<?
// 회원관리 서브메뉴
$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias], array('N'));
$layer_contents = '';
while (list($key, $value) = each($user_level_list)) {
	$layer_name = "list_{$key}";
	$layer_contents .= "<tr bgcolor=ffffff><td><img src={$DIRS[designer_root]}images/nec_dot.gif width=13 height=13> <a href=member_input_form.php?menu=member&user_level=$key>$value</a></td></tr>";	
}
$list_layer = "get_layer_tag('$layer_name', '$layer_contents', '130', '10');\n";
$btn_page_type = "
	<tr><td height=5></td></tr>
	<tr>
		<td><a href='#;' onclick=\"open_mouse_layer('$layer_name', 'visible')\">{$IS_icon[form_title]}신규회원등록</a></td>
	</tr>
";

$T_user_level_alias = $user_level_alias;
unset($T_user_level_alias[8]);
while (list($key, $value) = each($T_user_level_alias)) {
	$btn_page_type .= "
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_list.php?menu=member&SCH_user_level=$key'>{$IS_icon[form_title]}{$value}</a></td>
		</tr>
	";
}
$btn_page_type .= "
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_cm_list.php?menu=member&ppa=20'>{$IS_icon[form_title]}적립금관리</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_visit_ranking.php?menu=member&search_item_date=visit_date&SCH_visit_date_1={$set_term_this_month[0]}&SCH_visit_date_2={$set_term_this_month[1]}&ppa=20'>{$IS_icon[form_title]}방문순위</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_visit_log.php?menu=member&search_item_date=visit_date&SCH_visit_date_1={$set_term_this_month[0]}&SCH_visit_date_2={$set_term_this_month[1]}&ppa=20'>{$IS_icon[form_title]}회원로그인기록</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_stat_join.php?menu=member&table_reset=Y&view_type=M&search_item_date=reg_date&SCH_reg_date_1={$set_term_this_month[0]}&SCH_reg_date_2={$set_term_this_month[1]}&ppa=30'>{$IS_icon[form_title]}회원가입현황분석</a></td>
		</tr>
		<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=12></td></tr>
		<tr>
			<td><a href='{$DIRS[designer_root]}member_stat_withdrawal.php?menu=member&table_reset=Y&view_type=M&search_item_date=withdrawal_date&SCH_withdrawal_date_1={$set_term_this_month[0]}&SCH_withdrawal_date_2={$set_term_this_month[1]}&ppa=30'>{$IS_icon[form_title]}회원탈퇴현황분석</a></td>
		</tr>
";
$sub_menu = "
	<table width=150 border=0 cellpadding=1 cellspacing=0 bgcolor=white align=center>
		$btn_page_type
	</table>
	<script>
		$list_layer
	</script>
";		
$sub_menu_member = $lib_insiter->w_get_img_box($IS_thema_left, $sub_menu, $IS_input_box_padding, array("title"=>"<b>회원관리</b>"));
?>