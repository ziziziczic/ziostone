<?
require "header_sub.inc.php";

$design = $lib_fix->design_load($DIRS, $_GET[design_file], $site_page_info);
if ($_SESSION[view_mode] == "") $_SESSION[view_mode] = "show";

$user_level_list = array("DEFAULT"=>":: �⺻�� ::");
$user_level_list = $user_level_list + $lib_insiter->get_level_alias($site_info[user_level_alias]);

$P_page_menu = "
<table border='0' width='100%' height='100%' cellspacing='0'  background='' bgcolor='white'>
	<tr valign='top'> 
		<td width='100%'> 
			<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor=white align=center>
				<tr>
					<td align='center'> 
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr> 
								<td>
									* <b><font color=blue>$site_page_info[name]</font></b>
								</td>
							</tr>
							<tr> 
							<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=10></td></tr>
							</tr>
							<tr> 
								<td>
									* ���� : $site_page_info[file_name]
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<td>
	</tr>
</table>
";
$P_page_menu = $lib_insiter->w_get_img_box($IS_thema_left, $P_page_menu, $IS_input_box_padding, array("title"=>�������Ӽ�));

$P_sub_menu = "
<table border='0' width='100%' height='100%' cellspacing='0'  background='' bgcolor='white'>
	<tr valign='top'> 
		<td width='100%'> 
			<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor=white align=center>
				<tr>
					<td align='center'> 
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr> 
								<td>
									* <a href=\"javascript:openModifyCateWin('{$_GET[design_file]}')\"><u>�Ӽ�����</u></a>
										" . $GLOBALS[lib_common]->make_link("<u>���&��Ÿ&JS</u>", "page_designer_tag_form.php?design_file={$_GET[design_file]}", "_nw", "main_input,0, 0, 710, 700, 1, 1, 1, 0", "") . "
								</td>
							</tr>
							<tr> 
							<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=10></td></tr>
							</tr>
							<tr> 
								<td>
									* &lt;table&gt;
									" . $GLOBALS[lib_common]->make_link("<u>�����</u>", "page_designer_table_form.php?design_file={$_GET[design_file]}", "_nw", "main_input,0, 0, 530, 450, 1, 0, 1, 0, 0, 0, 0", "") . "
									" . $GLOBALS[lib_common]->make_link("<u>���̱�</u>", "table_manager.php?design_file={$_GET[design_file]}&mode=paste&current_line=-1", "_nw", "main_input,5000, 5000, 0, 0", "") . "
								</td>
							</tr>
							<tr><td background='{$DIRS[designer_root]}images/dot_line_01.gif' height=10></td></tr>
							<tr>
								<td>
									* " . $GLOBALS[lib_common]->make_link("<u>�ҽ�����</u>", "page_designer_source_form.php?design_file={$_GET[design_file]}", "_nw", "main_input,0,0,1000,700,1,0,0,0,0,0,0","") . "
									" . $GLOBALS[lib_common]->make_link("<u><font color=red>����</a></u>", "javascript:history_back_verify()", "", "", "") . "
									" . $GLOBALS[lib_common]->make_link("<u>html</u>", "page_designer_trans_html_form.php?design_file={$_GET[design_file]}", "_nw", "main_input,0,0,1000,700,1,0,0,0,0,0,0", "") . "
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<td>
	</tr>
</table>
";
$P_sub_menu = $lib_insiter->w_get_img_box($IS_thema_left, $P_sub_menu, $IS_input_box_padding, array("title"=>"������������"));

$view_mode_array = array("show"=>"�����߰�", "hide"=>"��������");
$view_real_array = array("{$root}page_designer_view.php?design_file={$_GET[design_file]}&view_level=$view_level&input_button=$input_button"=>"����ȭ��", "{$root}{$site_info[index_file]}?design_file={$_GET[design_file]}"=>"����ȭ��");
$link_mode_array = array("D"=>"�������", "R"=>"�������");

// ������ �׷� ���
$query = "select udf_group from $DB_TABLES[design_files] group by udf_group";
$result = $GLOBALS[lib_common]->querying($query);
$udf_group_array_name = array(":: �⺻�� ::");
$udf_group_array_option = array("DEFAULT");
while ($value = mysql_fetch_row($result)) $udf_group_array_name[] = $udf_group_array_option[] = $value[0];

// ������ �з�
if (trim($site_info[page_types]) != '') $T_user_page_type = "\n{$site_info[page_types]}";
$design_file_menu_array = array("DEFAULT"=>":: �⺻�� ::") + $GLOBALS[lib_common]->parse_property($T_page_type . $T_user_page_type, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');

$page_type = array('X');	 // ��� ������ ���
$design_file_list = $lib_insiter->design_file_list("import_file", $page_type, "Y", $_GET[design_file], "class='designer_select' style='width:90px' onchange=\"set_view('set_view_design_file', this.value)\"", $_SESSION[view_design_file], 'N', 'E', 'Y', "DEFAULT");

$P_view_menu = "
<table border='0' width='100%' height='100%' cellspacing='0'  background='' bgcolor='white'>
	<tr valign='top'> 
		<td width='100%'> 
			<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor=white align=center>
				<tr>
					<td align='center'> 
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<tr> 
								<td>
									* ������ " . $GLOBALS[lib_common]->get_list_boxs_array($user_level_list, "view_level", $_SESSION[view_level], 'N', "class='designer_select' style='width:90px' onchange=\"set_view('set_view_level', this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* �޴��� " . make_page_menu_list($_SESSION[view_menu], "class='designer_select' style='width:90px' onchange=\"set_view('set_view_menu', this.value)\"") . "
								</td>
							</tr>							
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* �з��� " . $GLOBALS[lib_common]->get_list_boxs_array($design_file_menu_array, "view_page_type", $_SESSION[view_page_type], 'N', "class='designer_select' style='width:90px' onchange=\"set_view('set_view_page_type', this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* ������ {$design_file_list}
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* �׷캰 " . $GLOBALS[lib_common]->make_list_box("view_group", $udf_group_array_name, $udf_group_array_option, '', $_SESSION[view_group], "class='designer_select' style='width:90px' onchange=\"set_view('set_view_group', this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* �۾��� " . $GLOBALS[lib_common]->get_list_boxs_array($view_mode_array, "input_button", $_SESSION[view_mode], 'N', "class='designer_select' style='width:90px' onchange=\"set_view('set_view_mode', this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr> 
								<td>
									* ��ũ�� " . $GLOBALS[lib_common]->get_list_boxs_array($link_mode_array, "link_mode", $_SESSION[link_mode], 'N', "class='designer_select' style='width:90px' onchange=\"set_view('set_link_mode', this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr>
								<td>
									* ȭ�麰 " . $GLOBALS[lib_common]->get_list_boxs_array($view_real_array, "view_real", '', 'N', "class='designer_select' style='width:90px' onchange=\"set_view_real(this.value)\"") . "
								</td>
							</tr>
							<tr><td height=3></td></tr>
							<tr>
								<td>
									* ��系�뺸�� " . $GLOBALS[lib_common]->make_input_box($_SESSION[view_all], "view_all", "checkbox", "class='designer_checkbox' onclick=\"set_view_all(this)\"", '', 'Y') . "
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<td>
	</tr>
</table>
";
$P_view_menu = $lib_insiter->w_get_img_box($IS_thema_left, $P_view_menu, $IS_input_box_padding, array("title"=>"������Ѻ�����"));

$quick_link = array("A"=>"����������");
$btn_quick = $GLOBALS[lib_common]->get_list_boxs_array($quick_link, "btn_quick", '', 'Y', "class='designer_select' style='width:145px' onchange=\"parent.history.back()\"", ":: �����̵� ::");

while (list($key, $value) = each($GLOBALS[VI][page_type_array])) {
	$link_head = "./page_list.php?menu=design&SCH_type=";
	$T_page_types[$link_head.$key] = $value;
}
$btn_design = $GLOBALS[lib_common]->get_list_boxs_array($T_page_types, "btn_design", '', 'Y', "class='designer_select' style='width:145px' onchange=\"MM_jumpMenu('parent',this,1)\"", ":: �������з��̵� ::");

while (list($key, $value) = each($CN_menu)) {
	$T_menus[$CN_menu_link[$key] . "?menu=$key"] = $value;
}
$T_menus["./setup_form.php?menu=setup"] = "��������";
$btn_menu = $GLOBALS[lib_common]->get_list_boxs_array($T_menus, "btn_design", '', 'Y', "class='designer_select' style='width:145px' onchange=\"MM_jumpMenu('parent',this,1)\"", ":: �޴��̵� ::");

$P_sub_menu_links = "
<table cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$btn_quick</td>
	</tr>
	<tr><td height=3></td></tr>
	<tr>
		<td>$btn_design</td>
	</tr>
	<tr><td height=3></td></tr>
	<tr>
		<td>$btn_menu</td>
	</tr>
	<tr><td height=3></td></tr>
</table>
";
$P_sub_menu_links = $lib_insiter->w_get_img_box($IS_thema_left, $P_sub_menu_links, $IS_input_box_padding, array("title"=>"�ٷΰ��� Link"));

echo("
<script language='javascript1.2'>
<!--
	function set_view_all(obj) {
		if (obj.checked == true) value = 'Y';
		else value = 'N';
		parent.designer_view.location.href = '{$root}page_designer_view.php?design_file={$_GET[design_file]}&set_view_all=' + value;
	}
	function set_view(var_name, value) {
		parent.designer_view.location.href = '{$root}page_designer_view.php?design_file={$_GET[design_file]}&' + var_name + '=' + value;
	}
	function set_view_real(mode) {
		parent.designer_view.location.href = mode;
	}	
	function history_back_verify() {
		if (confirm('���� ���·� �ǵ����ϴ�.\\n\\n����Ͻðڽ��ϱ�?')) {
			window.open('page_designer_manager.php?design_name=$design_name&design_file={$_GET[design_file]}&mode=history', 'main_input', 'left=5000,top=5000,width=0,height=0');
		}
	}
	function openModifyCateWin(file_name) {
		target_link = 'page_input_form.php?view_page_type=$view_page_type&design_file=' + file_name + '&where=page_designer';
		cateSetupWindow = window.open(target_link, 'cateSetupWindow', 'scrollbars=yes, resizables=yes,width=700,height=500,resizable=yes,menubar=no,left=0,top=0').focus();
	}
//-->
</script>
<body leftmargin='0' marginwidth='0' topmargin='0' marginheight='0'>
<table cellpadding=0 cellspacing=0 border=0 width=163>
	<tr>
		<td>$P_page_menu<td>
	</tr>
	<tr><td height=5></td></tr>
	<tr>
		<td>$P_sub_menu<td>
	</tr>
	<tr><td height=5></td></tr>
	<tr>
		<td>$P_view_menu<td>
	</tr>
	<tr><td height=5></td></tr>
	<tr>
		<td>$P_sub_menu_links</td>
	</tr>
</table>
");
require "footer_sub.inc.php";

// ������ �޴������ ����� �Լ�
function make_page_menu_list($default_value, $property, $name="page_menu", $etc_item='') {
	global $site_info;
	if ($etc_item != '') $etc_item = "\n{$etc_item}";
	if ($site_info[design_file_menu] != '') {
		$design_file_menu_array = $GLOBALS[lib_common]->parse_property($site_info[design_file_menu] . $etc_item, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
		return $GLOBALS[lib_common]->get_list_boxs_array(array("DEFAULT"=>":: �޴����� ::") + $design_file_menu_array, $name, $default_value, 'N', $property);
	}
}
?>