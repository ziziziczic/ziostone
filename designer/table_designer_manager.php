<?
include "header_proc.inc.php";

if ($mode != "save_source") $design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
if ($mode == 'table_perm') {
	$index_exp = explode("_", $index);
	
	// ���̺� ���� ����
	$location_table = "index={$index_exp[0]}";
	$search_table_line = $lib_fix->search_index($design, "���̺�", $location_table);
	$exp = explode($GLOBALS[DV][dv], $design[$search_table_line[0]]);
	if ($_POST[not_perm_table] != 'Y' && ($_POST[view_level_table] != '' || $_POST[view_menu_table] != '' || $_POST[view_file_table] != '' || $_POST[view_group_table] != '' || $_POST[view_type_table] != '')) $exp[3] = $_POST[view_level_table] . $GLOBALS[DV][ct5] . $_POST[view_mode_table] . $GLOBALS[DV][ct5] . $_POST[view_menu_table] . $GLOBALS[DV][ct5] . $_POST[view_menu_mode_table] . $GLOBALS[DV][ct5] . $_POST[view_file_table] . $GLOBALS[DV][ct5] . $_POST[view_file_mode_table] . $GLOBALS[DV][ct5] . $_POST[view_group_table] . $GLOBALS[DV][ct5] . $_POST[view_group_mode_table] . $GLOBALS[DV][ct5] . $_POST[view_type_table] . $GLOBALS[DV][ct5] . $_POST[view_type_mode_table];
	else $exp[3] = '';
	$design[$search_table_line[0]] = implode($GLOBALS[DV][dv], $exp);

	// �� ���� ����
	$location_tr = "index={$index_exp[0]}_{$index_exp[1]}";
	$search_tr_line = $lib_fix->search_index($design, "��", $location_tr);
	$exp = explode($GLOBALS[DV][dv], $design[$search_tr_line[0]]);
	if ($_POST[not_perm_tr] != 'Y' && ($_POST[view_level_tr] != '' || $_POST[view_menu_tr] != '' || $_POST[view_file_tr] != '' || $_POST[view_group_tr] != '' || $_POST[view_type_tr] != '')) $exp[3] = $_POST[view_level_tr] . $GLOBALS[DV][ct5] . $_POST[view_mode_tr] . $GLOBALS[DV][ct5] . $_POST[view_menu_tr] . $GLOBALS[DV][ct5] . $_POST[view_menu_mode_tr] . $GLOBALS[DV][ct5] . $_POST[view_file_tr] . $GLOBALS[DV][ct5] . $_POST[view_file_mode_tr] . $GLOBALS[DV][ct5] . $_POST[view_group_tr] . $GLOBALS[DV][ct5] . $_POST[view_group_mode_tr] . $GLOBALS[DV][ct5] . $_POST[view_type_tr] . $GLOBALS[DV][ct5] . $_POST[view_type_mode_tr];
	else $exp[3] = '';
	$design[$search_tr_line[0]] = implode($GLOBALS[DV][dv], $exp);

	// ĭ ���� ����
	$location_td = "index={$index_exp[0]}_{$index_exp[1]}_{$index_exp[2]}";
	$search_td_line = $lib_fix->search_index($design, "ĭ", $location_td);
	$exp = explode($GLOBALS[DV][dv], $design[$search_td_line[0]]);
	if ($_POST[not_perm_td] != 'Y' && ($_POST[view_level_td] != '' || $_POST[view_menu_td] != '' || $_POST[view_file_td] != '' || $_POST[view_group_td] != '') || $_POST[view_type_td] != '') $exp[3] = $_POST[view_level_td] . $GLOBALS[DV][ct5] . $_POST[view_mode_td] . $GLOBALS[DV][ct5] . $_POST[view_menu_td] . $GLOBALS[DV][ct5] . $_POST[view_menu_mode_td] . $GLOBALS[DV][ct5] . $_POST[view_file_td] . $GLOBALS[DV][ct5] . $_POST[view_file_mode_td] . $GLOBALS[DV][ct5] . $_POST[view_group_td] . $GLOBALS[DV][ct5] . $_POST[view_group_mode_td] . $GLOBALS[DV][ct5] . $_POST[view_type_td] . $GLOBALS[DV][ct5] . $_POST[view_type_mode_td];
	else $exp[3] = '';
	$design[$search_td_line[0]] = implode($GLOBALS[DV][dv], $exp);

	// �׸� ���� ����
	if ((int)$_POST[cpn] > 0) {
		$exp = explode($GLOBALS[DV][dv], $design[$_POST[current_line]]);
		if ($_POST[not_perm_item] != 'Y' && ($_POST[view_level_item] != '' || $_POST[view_menu_item] != '' || $_POST[view_file_item] != '' || $_POST[view_group_item] != '' || $_POST[view_type_item] != '')) $exp[14] = $_POST[view_level_item] . $GLOBALS[DV][ct5] . $_POST[view_mode_item] . $GLOBALS[DV][ct5] . $_POST[view_menu_item] . $GLOBALS[DV][ct5] . $_POST[view_menu_mode_item] . $GLOBALS[DV][ct5] . $_POST[view_file_item] . $GLOBALS[DV][ct5] . $_POST[view_file_mode_item] . $GLOBALS[DV][ct5] . $_POST[view_group_item] . $GLOBALS[DV][ct5] . $_POST[view_group_mode_item] . $GLOBALS[DV][ct5] . $_POST[view_type_item] . $GLOBALS[DV][ct5] . $_POST[view_type_mode_item];
		else $exp[14] = '';
		$design[$_POST[current_line]] = implode($GLOBALS[DV][dv], $exp);
	}
	
	// ����
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == 'delete_form') {
	$exp = explode($GLOBALS[DV][dv], $design[$form_line]);
	$exp[4] = "";
	$exp[5] = "";
	$exp[6] = "";
	$exp[7] = "";
	$exp[8] = "";
	//$exp[9] = "";
	$exp[10] = "";
	$design[$form_line] = implode($GLOBALS[DV][dv], $exp);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == 'delete_object') {
	$design[$current_line] = '';
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == 'blank') {
	die("���Ȯ����.");
	if ($top_blank == "") $top_blank = 0;
	if ($bottom_blank == "") $bottom_blank = 0;
	if ($left_blank == "") $left_blank = 0;
	if ($right_blank == "") $right_blank = 0;
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	$exp[10] = $top_blank;
	$exp[11] = $bottom_blank;
	$exp[12] = $left_blank;
	$exp[13] = $right_blank;
	$design[$current_line] = implode($GLOBALS[DV][dv], $exp);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == 'repeat') {
	// ���̺� �ݺ� ����
	$index_exp = explode("_", $index);
	if ($mode1 == "table") {
		$command = "���̺�";
		$location = "index=" . $index_exp[0];
	} else {
		$command = "��";
		$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
	}
	$line = $lib_fix->search_index($design, $command, $location);
	$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
	if ($exp[9] == "�ݺ�") $exp[9] = "";
	else $exp[9] = "�ݺ�";
	$design[$line[0]] = implode($GLOBALS[DV][dv], $exp);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == "input_tag") {
	$blank_check = trim($comment_1);
	$blank_check = str_replace(" ", "", $blank_check);
	$blank_check = str_replace("\n", "" , $blank_check);
	$blank_check = str_replace("\r", "" , $blank_check);
	if (strlen($blank_check) == 0) {															// ����� �Է��� �����̸�
		$value = "";
	} else {																									// �Է� ������ ������ �Ʒ��� ��ƾ�� �����Ѵ�.
		$input_tag = stripslashes($comment_1);
		$input_tag = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv] ,$input_tag);
		$input_tag = str_replace("\r\n", chr(92).r.chr(92).n, $input_tag);
		$value = "���ڿ�{$GLOBALS[DV][dv]}{$input_tag}";
	}
	if ($value != "") $value = $lib_fix->make_design_line($value, '');
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info, 'Y');
} else if ($mode == "import") {
	$value = "����Ʈ{$GLOBALS[DV][dv]}{$import_file}";
	$value = $lib_fix->make_design_line($value, '');
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == "include") {
	$value = "��Ŭ���{$GLOBALS[DV][dv]}{$include}";
	$value = $lib_fix->make_design_line($value, '');
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == "contents") {
	$value = "������";
	$value = $lib_fix->make_design_line($value, '');
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode == "contents_out") {
	$value = "�������ܺ�";
	$value = $lib_fix->make_design_line($value, '');
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
} else if ($mode = "command") {
	$value = $command;
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";	 // �¿��±�
	$blanks = "{$blank_up}{$GLOBALS[DV][ct4]}{$blank_down}{$GLOBALS[DV][ct4]}{$blank_left}{$GLOBALS[DV][ct4]}{$blank_right}";	// ���鼳��
	$value = $lib_fix->make_design_line($value, '', $tag_both, $blanks);
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if ($cpn == "0") array_splice($design, $search[1], 0, $value);		// �׸� �߰��ΰ��
	else $design[$current_line] = $value;															// �׸� �����ΰ��
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
}

if ($adjust == "Y") $GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.reload();");
else $GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>