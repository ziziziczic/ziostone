<?
include "header_sub.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0];
$line = $lib_fix->search_index($design, "���̺�", $location);

// ���� ��ø���� �ʵ��� ����,����, ���� ���̺� �� ������ �Ǿ� �ִ��� �����Ѵ�.

// CFS => Current table Form Setup, PFS => Parent table Form Setup, ChFs => Child table Form Setup
$CFS = $lib_fix->search_current_form($design, $line[0], 4);
$PFS = $lib_fix->search_parent_form($design, $line[0]-1, "���̺�", 4);
$ChFS = $lib_fix->search_child_form($design, "���̺�", $line[0]+1, $line[1], 4);

if ((is_array($CFS) && is_array($PFS)) || (is_array($CFS) && is_array($ChFS)) || (is_array($PFS) && is_array($ChFS))) {
	die("�� �Ӽ��� ��ø�Ǿ� �ֽ��ϴ�. �������̺� : $CFS , �������̺� : $PFS , �������̺� : $ChFS , �� â�� �ݰ� �ǵ����⸦ �õ��� ���ʽÿ�.");
}	// ����, ����, ���� ���̺��� �ΰ� �̻��� ���� ���ÿ� ������ ����

// ������ ���̺� �ƹ� ������ �Ǿ� ���� ������ ���� ������ ��� �׸��� �����ش�.
if (($CFS == "CURRENT_NOT_FOUND") && ($PFS == "PARENT_NOT_FOUND") && ($ChFS == "CHILD_NOT_FOUND")) {
	$special_operation = "<p style='line-height: 150%'><b>�� �Ϲ� ���̺��Դϴ�.</b><br>������ �Խ���&������ �޴��� �̿��Ͽ� �Խ����� ����ų�, �α��� ��, ȸ�� �������� ���� �� �ֽ��ϴ�.<br>������� ���� DB ���� ���α׷����� ��� ���� �Ǿ� �����Ƿ� ������ ���α׷��� ������ �ʿ䰡 �����ϴ�..";
} else {
	if (is_array($CFS)) {
		$form_location = "�������̺�";
		$form_value = $CFS;
		$form_line = $line[0];
	} else if (is_array($PFS)) {
		$form_location = "�������̺�";
		$form_value = $PFS;
		while (list($key, $value) = each($form_value)) $form_line = $value;	// �� ���������� ������ ���� ���Ѵ�.
	} else {
		$form_location = "�������̺�";
		$form_value = $ChFS;
	}

	if ($form_value[4] == "TC_BOARD") {	// ���� ���̺� �Խ��� ������ �Ǿ� �ִ� ���
		$exp_bp = explode($GLOBALS[DV][ct5], $form_value[5]);	 // ���̺� ������ �Խ��� ��� �Ӽ�
		$board_info = $lib_fix->get_board_info($exp_bp[0]);
		$page_type = $exp_bp[1];
		$form_name = "�Խ��Ǳ��";
		$special_operation_1 = "<hr size=1>�̸� : $board_info[alias]<br>���� : $page_type";
		if (!strcmp($page_type, "LIST")) {
			$query_type = $exp_bp[2];
			$table_per_article = $exp_bp[3];
			$table_per_block = $exp_bp[4];
			$div_article = $exp_bp[5];
			$verify_input = $exp_bp[6];
			$sort_field = $exp_bp[7];
			$sort_sequence = $exp_bp[8];
			$special_operation_1 .= "<br>TPA : $table_per_article (���̺� ���� �Խù� ��)";
			if ($board_info[14] == "image") $special_operation .= "<br>LPI : $exp_bp[5] (�� �ٿ� ��µ� �̹�����)";
			$special_operation .= "<br>TPB : $table_per_block (���̺� �ݺ��� ������ ��ũ ��)";
			if ($sort_field == "") $sort_field = "�⺻";
			if ($sort_sequence == "") $sort_sequence = "�⺻";
			$special_operation_1 .= "<br>Sort Field : $form_value[13] (������ �����ʵ�)";
			$special_operation_1 .= "<br>Sort Sequence : $form_value[14] (���ļ���)";
			$special_operation_1 .= "<br>�������� : $query_type (�Խù� ���� ���� ����)";
			$special_operation_2 = "
				<hr size=1>
					�Խù� ����� ���� ��!! <a href='table_board_repeat_form.php?design_file=$design_file&index=$index'><font color='CC3300'>[�ݺ�����]</font></a>�� ���ּ���
			";
		}
		$setup_link = "table_board_form.php?design_file=$design_file&index=$index&mode=TC_BOARD&form_line=$form_line";
		
	} else if ($form_value[4] == "TC_MEMBER") {	// ���� ���̺� ȸ�� ������ �Ǿ� �ִ� ���
		$form_name = "ȸ��������";
		$special_operation = "<font color=#CC3300><b>$form_location</b>�� <b>$form_name</b>�� ���� �Ǿ� �ֽ��ϴ�.</font><hr size=1>";
		$setup_link = "table_member_form.php?design_file=$design_file&index=$index&mode=TC_MEMBER&form_line=$form_line";
		
	} else if ($form_value[4] == "TC_LOGIN") {		// ���� ���̺� �α��� ������ �Ǿ� �ִ� ���
		$form_name = "�α�����";
		$special_operation = "<font color=#CC3300><b>$form_location</b>�� <b>$form_name</b>�� ���� �Ǿ� �ֽ��ϴ�.</font><hr size=1>";
		$setup_link = "table_login_form.php?design_file=$design_file&index=$index&mode=TC_LOGIN&form_line=$form_line";
	}

	$special_operation = "<font color=#CC3300><b>{$form_location}</b>�� �Ʒ��� ���� {$form_name}�� ���� �Ǿ� �ֽ��ϴ�.</font>";

	if ($form_location != "�������̺�") {
		$special_operation_3 = "
		<hr size=1>
		�⺻���� ������ <a href='$setup_link'><font color='CC3300'>[�⺻��������]</font></a> �� �̿��ϼ���&nbsp;&nbsp;&nbsp;<a href=\"javascript:verify('table_designer_manager.php?design_file=$design_file&mode=delete_form&form_line=$form_line', '�����������Ͻðڽ��ϱ�?')\">[���(��)��������]</a>
	";
	} else {
		$special_opeartion = $special_opeartion_1 = $special_opeartion_2 = "";
		$special_operation_3 = "
		<hr size=1>
		���� ���̺��� ���� ���� ù��° �� �����Դϴ�.<br>�������� 2�� �̻� ������ ���� ������ ������ �ش� ���̺����� �����մϴ�.";
	}
}

$table_info_explain = $special_operation . $special_operation_1 . $special_operation_2 . $special_operation_3;
$P_table_info_form = $lib_insiter->w_get_img_box($IS_thema_window, $table_info_explain, $IS_input_box_padding, array("title"=>"���̺� ����"));

// ���̺� ��±��� �ε�
$index_exp = explode("_", $index);
$location_table = "index=" . $index_exp[0];
$search_table_line = $lib_fix->search_index($design, "���̺�", $location_table);
$table_info = $lib_fix->search_current_form($design, $search_table_line[0], 0);
if ($table_info[3] == '') {
	$is_disabled_table = " disabled";
	$is_checked_table = " checked";
} else {
	$exp_table = explode($GLOBALS[DV][ct5], $table_info[3]);
}

// �� ��±��� �ε�
$location_tr = "index={$index_exp[0]}_{$index_exp[1]}";
$search_tr_line = $lib_fix->search_index($design, "��", $location_tr);
if ($search_tr_line[0] > 0) {
	$T_exp = explode($GLOBALS[DV][dv], $design[$search_tr_line[0]]);
	if ($T_exp[3] == '') {
		$is_disabled_tr = " disabled";
		$is_checked_tr = " checked";
	} else {
		$exp_tr = explode($GLOBALS[DV][ct5], $T_exp[3]);
	}
}

// ĭ ��±��� �ε�
$location_td = "index={$index_exp[0]}_{$index_exp[1]}_{$index_exp[2]}";
$search_td_line = $lib_fix->search_index($design, "ĭ", $location_td);
if ($search_td_line[0] > 0) {
	$T_exp = explode($GLOBALS[DV][dv], $design[$search_td_line[0]]);
	if ($T_exp[3] == '') {
		$is_disabled_td = " disabled";
		$is_checked_td = " checked";
	} else {
		$exp_td = explode($GLOBALS[DV][ct5], $T_exp[3]);
	}
}

// �׸� ��±��� �ε�
$T_exp = explode($GLOBALS[DV][dv], $design[$current_line]);
if ($T_exp[14] == '') {
	$is_disabled_item = " disabled";
	$is_checked_item = " checked";
} else {
	$exp_item = explode($GLOBALS[DV][ct5], $T_exp[14]);
}

// �Է»��ڼ�������
$skip_target_array = array("table", "tr", "td", "item");
$skip_user_level_array = array(''=>":: ���ȸ�� ::");																					// �������� ����
$skip_user_level_array = $skip_user_level_array + $lib_insiter->get_level_alias($site_info[user_level_alias]);	
$skip_mode_array = array('U'=>"�̻�", 'L'=>"����", 'O'=>"��");
$skip_mode2_array = array('T'=>"��", 'O'=>"����");
$view_file_type = array('U', 'I', 'Y', 'T');																												// �������� ������Ÿ��
$query = "select udf_group from $DB_TABLES[design_files] group by udf_group";						// ������ �׷� ���
$result = $GLOBALS[lib_common]->querying($query);
$udf_group_array_name = array(":: �׷� ::");
$udf_group_array_option = array('');
while ($value = mysql_fetch_row($result)) $udf_group_array_name[] = $udf_group_array_option[] = $value[0];
if (trim($site_info[page_types]) != '') $T_user_page_type = "\n{$site_info[page_types]}";	// ������ �з�
$design_file_menu_array = array(''=>":: �������з� ::") + $GLOBALS[lib_common]->parse_property($T_page_type . $T_user_page_type, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
for ($i=0; $i<sizeof($skip_target_array); $i++) {
	// ����
	$var_name_is_disabled = "is_disabled_" . $skip_target_array[$i];
	$var_name_saved = "exp_" . $skip_target_array[$i];
	$T_var_name_saved = $$var_name_saved;

	// ����ڷ���
	$var_name = "select_level_" . $skip_target_array[$i];
	$var_name_box = "view_level_" . $skip_target_array[$i];	
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_user_level_array, $var_name_box, $T_var_name_saved[0], 'N', "class='designer_select' style='width:150px'{$$var_name_is_disabled}");
	// ����ڷ��� ���
	$var_name = "select_mode_" . $skip_target_array[$i];
	$var_name_box = "view_mode_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_mode_array, $var_name_box, $T_var_name_saved[1], 'N', "class='designer_select'{$$var_name_is_disabled}");

	// �޴�
	$var_name = "select_menu_" . $skip_target_array[$i];
	$var_name_box = "view_menu_" . $skip_target_array[$i];
	$$var_name = $lib_insiter->make_page_menu_list($T_var_name_saved[2], "multiple class='designer_select' style='width:150px'{$$var_name_is_disabled}", $var_name_box);
	// �޴� ���
	$var_name = "select_menu_mode_" . $skip_target_array[$i];
	$var_name_box = "view_menu_mode_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_mode2_array, $var_name_box, $T_var_name_saved[3], 'N', "class='designer_select'{$$var_name_is_disabled}");

	// ����������
	$var_name = "select_file_" . $skip_target_array[$i];
	$var_name_box = "view_file_" . $skip_target_array[$i];
	$$var_name = $lib_insiter->design_file_list($var_name_box, $view_file_type, 'Y', $_GET[design_file], "multiple class='designer_select' style='width:150px'{$$var_name_is_disabled}", $T_var_name_saved[4], 'N', 'T', 'Y');
	// ���������
	$var_name = "select_file_mode_" . $skip_target_array[$i];
	$var_name_box = "view_file_mode_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_mode2_array, $var_name_box, $T_var_name_saved[5], 'N', "class='designer_select'{$$var_name_is_disabled}");

	// �������׷�
	$var_name = "select_group_" . $skip_target_array[$i];
	$var_name_box = "view_group_" . $skip_target_array[$i];
	$multi_sep = '!';
	$new_name = $var_name_box . "_multi";
	$etc_tag = "<input type='hidden' name='$var_name_box' value='$T_var_name_saved[6]'>";
	$property .= " onchange=\"multi_select(this.form, '$new_name', '$var_name_box', '$multi_sep')\"";
	$GLOBALS[JS_CODE][MULTI_SELECT] = "Y";
	$default_value = explode($multi_sep, $T_var_name_saved[6]);
	$$var_name = $GLOBALS[lib_common]->make_list_box($new_name, $udf_group_array_name, $udf_group_array_option, '', $default_value, "multiple class='designer_select' style='width:150px'{$property}{$$var_name_is_disabled}") . $etc_tag;
	// �������׷���
	$var_name = "select_group_mode_" . $skip_target_array[$i];
	$var_name_box = "view_group_mode_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_mode2_array, $var_name_box, $T_var_name_saved[7], 'N', "class='designer_select'{$$var_name_is_disabled}");

	// �������з�
	$var_name = "select_type_" . $skip_target_array[$i];
	$var_name_box = "view_type_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($design_file_menu_array, $var_name_box, $T_var_name_saved[8], 'N', "multiple class='designer_select'{$$var_name_is_disabled}");
	// �������з� ���
	$var_name = "select_type_mode_" . $skip_target_array[$i];
	$var_name_box = "view_type_mode_" . $skip_target_array[$i];
	$$var_name = $GLOBALS[lib_common]->get_list_boxs_array($skip_mode2_array, $var_name_box, $T_var_name_saved[9], 'N', "class='designer_select'{$$var_name_is_disabled}");
}

if ((int)$_GET[cpn] > 0) {
	$P_item_skip = "
			<table cellpadding=0 cellspacing=0 border=0>
				<tr> 
					<td width=60>
						�׸�<br>
						�׻����<br>
						<input type='checkbox' name='not_perm_item' value='Y' onclick=\"on_off_perm(this.form, 'item');\"$is_checked_item>
					</td>
					<td>
						<table cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td>$select_level_item</td>
								<td>$select_mode_item</td>
							</tr>
							<tr>
								<td>$select_menu_item</td>
								<td>$select_menu_mode_item</td>
							</tr>
							<tr>
								<td>$select_file_item</td>
								<td>$select_file_mode_item</td>
							</tr>
							<tr>
								<td>$select_type_item</td>
								<td>$select_type_mode_item</td>
							</tr>
							<tr>
								<td>$select_group_item</td>
								<td>$select_group_mode_item</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	";
}

$P_set_skip = "
<table width='100%' border='0' cellspacing='0' cellpadding='7'>
	<tr>
		<td>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr> 
					<td width=60>
						ǥ(table)<br>
						�׻����<br>
						<input type='checkbox' name='not_perm_table' value='Y' onclick=\"on_off_perm(this.form, 'table');\"$is_checked_table>
					</td>
					<td>
						<table cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td>$select_level_table</td>
								<td>$select_mode_table</td>
							</tr>
							<tr>
								<td>$select_menu_table</td>
								<td>$select_menu_mode_table</td>
							</tr>
							<tr>
								<td>$select_file_table</td>
								<td>$select_file_mode_table</td>
							</tr>
							<tr>
								<td>$select_type_table</td>
								<td>$select_type_mode_table</td>
							</tr>
							<tr>
								<td>$select_group_table</td>
								<td>$select_group_mode_table</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr> 
					<td width=60>
						��(tr)<br>
						�׻����<br>
						<input type='checkbox' name='not_perm_tr' value='Y' onclick=\"on_off_perm(this.form, 'tr');\"$is_checked_tr>
					</td>
					<td>
						<table cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td>$select_level_tr</td>
								<td>$select_mode_tr</td>
							</tr>
							<tr>
								<td>$select_menu_tr</td>
								<td>$select_menu_mode_tr</td>
							</tr>
							<tr>
								<td>$select_file_tr</td>
								<td>$select_file_mode_tr</td>
							</tr>
							<tr>
								<td>$select_type_tr</td>
								<td>$select_type_mode_tr</td>
							</tr>
							<tr>
								<td>$select_group_tr</td>
								<td>$select_group_mode_tr</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr> 
					<td width=60>
						ĭ(td)<br>
						�׻����<br>
						<input type='checkbox' name='not_perm_td' value='Y' onclick=\"on_off_perm(this.form, 'td');\"$is_checked_td>
					</td>
					<td>
						<table cellpadding=1 cellspacing=0 border=0>
							<tr>
								<td>$select_level_td</td>
								<td>$select_mode_td</td>
							</tr>
							<tr>
								<td>$select_menu_td</td>
								<td>$select_menu_mode_td</td>
							</tr>
							<tr>
								<td>$select_file_td</td>
								<td>$select_file_mode_td</td>
							</tr>
							<tr>
								<td>$select_type_td</td>
								<td>$select_type_mode_td</td>
							</tr>
							<tr>
								<td>$select_group_td</td>
								<td>$select_group_mode_td</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>
			$P_item_skip
		</td>
	</tr>	
	<tr>
		<td colspan=2>
			<hr size=1 color=f3f3f3>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=right>
			<input type=button value='���߼��û���Ȯ��' onclick='chg_size_select(100)' class=designer_button>
			<input type=button value='���' onclick='chg_size_select(20)' class=designer_button>
		</td>
	</tr>
</table>
";
$P_set_skip = $lib_insiter->w_get_img_box($IS_thema, $P_set_skip, $IS_input_box_padding, array("title"=>"���̺� ������� ����"));

echo("
<script language='javascript1.2'>
<!--
	function on_off_perm(form, mode) {
		not_perm = eval('form.not_perm_' + mode);
		view_level = eval('form.view_level_' + mode);
		view_mode = eval('form.view_mode_' + mode);
		view_menu = eval('form.view_menu_' + mode);
		view_menu_multi = eval('form.view_menu_' + mode + '_multi');
		view_menu_mode = eval('form.view_menu_mode_' + mode);
		view_file = eval('form.view_file_' + mode);
		view_file_multi = eval('form.view_file_' + mode + '_multi');
		view_file_mode = eval('form.view_file_mode_' + mode);
		view_group = eval('form.view_group_' + mode);
		view_group_multi = eval('form.view_group_' + mode + '_multi');
		view_group_mode = eval('form.view_group_mode_' + mode);
		view_type = eval('form.view_type_' + mode);
		view_type_multi = eval('form.view_type_' + mode + '_multi');
		view_type_mode = eval('form.view_type_mode_' + mode);
		if (not_perm.checked == true) {
			view_level.disabled = true;
			view_mode.disabled = true;
			view_menu.disabled = true;
			view_menu_multi.disabled = true;
			view_menu_mode.disabled = true;
			view_file.disabled = true;
			view_file_multi.disabled = true;
			view_file_mode.disabled = true;
			view_group.disabled = true;
			view_group_multi.disabled = true;
			view_group_mode.disabled = true;
			view_type.disabled = true;
			view_type_multi.disabled = true;
			view_type_mode.disabled = true;
		} else {
			view_level.disabled = false;
			view_mode.disabled = false;
			view_menu.disabled = false;
			view_menu_multi.disabled = false;
			view_menu_mode.disabled = false;
			view_file.disabled = false;
			view_file_multi.disabled = false;
			view_file_mode.disabled = false;
			view_group.disabled = false;
			view_group_multi.disabled = false;
			view_group_mode.disabled = false;
			view_type.disabled = false;
			view_type_multi.disabled = false;
			view_type_mode.disabled = false;
		}
	}
	function verify(url, msg) {
		if (confirm(msg)) {
			document.location.href = url;
		}
	}
	function chg_size_select(height_value) {
		selecte_boxs = document.getElementsByTagName('select');
		for (i=0; i<selecte_boxs.length; i++) {																		// �˻��� �ڽ� ��ŭ �ݺ��Ͽ�
			obj_select_box = selecte_boxs[i];
			if (obj_select_box.disabled == false && obj_select_box.multiple == true) {
				obj_select_box.style.height = height_value;
			}
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='in_fo' method='post' action='table_designer_manager.php?design_file=$design_file&index=$index&mode=table_perm'>
	<input type=hidden name=current_line value={$_GET[current_line]}>
	<input type=hidden name=cpn value={$_GET[cpn]}>
	<tr>
		<td>$P_table_info_form</td>
	</tr>
	<tr>
		<td>
			$P_set_skip
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:document.frm.reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' border='0'></a>
		</td>
	</tr>
 </form>
</table>
");
include "footer_sub.inc.php";
?>