<?
/****************************************************
	 DB ������, 1�� �з� ���ÿ� ���� 2�� �з� ���û��� ��� ���α׷� (3������)
****************************************************/
/* �ܺ� ȯ�溯�� ���� (��Ŭ��� �ϴ� ������ ���� �ؾ� �ϴ� ������)
$SMC = array();
$SMC[name] = "";													// �з� Ÿ��Ʋ (�� : employ)
$SMC[form_name] = "";										// �� �̸�
$SMC[title_ct_1] = "";											// 1�� ���û��� Ÿ��Ʋ
$SMC[title_ct_2] = "";											// 2�� ���û��� Ÿ��Ʋ
$SMC[title_ct_3] = "";											// 3�� ���û��� Ÿ��Ʋ
$SMC[table_ct_1] = "";										// 1�� �з� ���̺� ��
$SMC[table_ct_2] = "";										// 2�� �з� ���̺� ��
$SMC[table_ct_3] = "";										// 3�� �з� ���̺� ��
$SMC[sub_query_ct_1] = "";							// 1�� �з� ��������  where is_private<>'Y' order by seq asc
$SMC[sub_query_ct_2] = "";							// 2�� �з� ��������
$SMC[sub_query_ct_3] = "";							// 3�� �з� ��������
$SMC[fld_code_ct_1] = "";									// 1�� �з� ���̺� �ʵ�� - �ڵ� (001 ...)
$SMC[fld_name_ct_1] = "";								// 1�� �з� ���̺� �ʵ�� - �̸� (������ ... )
$SMC[saved_value_ct_1] = "";						// 1�� �з� ���尪
$SMC[fld_code_ct_2] = "";									// 2�� �з� ���̺� �ʵ�� - �ڵ� (00001 ...)
$SMC[fld_name_ct_2] = "";								// 2�� �з� ���̺� �ʵ�� - �̸� (������ ...)
$SMC[fld_select_code_ct_2] = "";					// 2�� �з� ���̺� �ʵ�� - ���ð� (003 ...)
$SMC[saved_value_ct_2] = "";						// 2�� �з� ���尪
$SMC[fld_code_ct_3] = "";									// 3�� �з� ���̺� �ʵ�� - �ڵ� (00001 ...)
$SMC[fld_name_ct_3] = "";								// 3�� �з� ���̺� �ʵ�� - �̸� (������ ...)
$SMC[fld_select_code_ct_3] = "";					// 3�� �з� ���̺� �ʵ�� - ���ð� (003 ...)
$SMC[saved_value_ct_3] = "";						// 3�� �з� ���尪
$SMC[input_name_ct_1] = "";							// 1�� �з� select name
$SMC[input_name_ct_2] = "";							// 2�� �з� select name
$SMC[input_name_ct_3] = "";							// 3�� �з� select name
$SMC[fixed_value_ct_1] = "";							// 1�� �з� ������ (������ ��� ���û��� ���� hidden �±׷� ���)
$SMC[fixed_value_ct_2] = "";							// 2�� �з� ������
$SMC[call_file_name] = "";								// 2�� �з� ȣ������
$SMC[root] = "";
*/

function select_multi_category($SMC) {
	$TAG_ct = array();
	if ($SMC[saved_value_ct_1] != '') $smc_selected_ct_1 = $SMC[saved_value_ct_1];			// ����� �� �� �ִ� ���
	else $smc_selected_ct_1 = $SMC[fixed_value_ct_1];																			// ���� ��� ������ �ο�
	if ($SMC[saved_value_ct_2] != '') $smc_selected_ct_2 = $SMC[saved_value_ct_2];
	else $smc_selected_ct_2 = $SMC[fixed_value_ct_2];
	if ($SMC[saved_value_ct_3] != '') $smc_selected_ct_3 = $SMC[saved_value_ct_3];

	if ($SMC[input_name_ct_3] == '') $SMC[input_name_ct_3] = "none";										// ���������� ���� ����

	// 1�� ���(�����̸� hidden tag ��)
	if ($SMC[fixed_value_ct_1] == '') {				// 1�� �з��ڵ尡 �������� ���� ��츸 ���û��� ���
		$query = "select * from $SMC[table_ct_1]{$SMC[sub_query_ct_1]}";
		$result = $GLOBALS[lib_common]->querying($query);
		$smc_categorys = array();
		while ($value = mysql_fetch_array($result)) {
			$smc_categorys[$value[$SMC[fld_code_ct_1]]] = $value[$SMC[fld_name_ct_1]];
		}
		if ($SMC[table_ct_2] != '') $js_function_chg = " onChange=\"reset_next_select_{$SMC[name]}(this, '$SMC[input_name_ct_2]', '$SMC[form_name]', '$SMC[table_ct_2]', '$SMC[fld_select_code_ct_2]', '$SMC[fld_code_ct_2]', '$SMC[fld_name_ct_2]', '$SMC[call_file_name]', '" . urlencode($SMC[sub_query_ct_2]) . "', '$SMC[title_ct_2]');if (typeof(this.form.$SMC[input_name_ct_3]) != 'undefined') this.form.$SMC[input_name_ct_3].disabled=true\"";
		else $js_function_chg = '';
		$TAG_ct_1 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_1], $smc_selected_ct_1, 'Y', "class=designer_select{$js_function_chg}", ":: {$SMC[title_ct_1]} ::");
	} else {
		$TAG_ct_1 = "<input type=hidden name='$SMC[input_name_ct_1]' value='$smc_selected_ct_1'>";
	}
	$TAG_ct[] = $TAG_ct_1;

	// 2�� ��� (2�� �з� ���̺� �̸��� ������ ��츸)
	if ($SMC[table_ct_2] != '') {
		if ($SMC[fixed_value_ct_2] == '') {		// 2�� �з� �ڵ尡 �������� ���� ��츸 ���û��� ���
			$smc_categorys = array();
			$query = "select * from $SMC[table_ct_2] where {$SMC[fld_select_code_ct_2]}='{$smc_selected_ct_1}'{$SMC[sub_query_ct_2]}";
			$result = mysql_query($query);
			$total_cnt = mysql_num_rows($result);
			if ($total_cnt > 0) {
				while ($value = mysql_fetch_array($result)) {
					$smc_categorys[$value[$SMC[fld_code_ct_2]]] = $value[$SMC[fld_name_ct_2]];
				}
				$is_disabled = '';
			} else {
				$is_disabled = " disabled";
			}
			if ($SMC[table_ct_3] != '') $js_function_chg = " onChange=\"reset_next_select_{$SMC[name]}(this, '$SMC[input_name_ct_3]', '$SMC[form_name]', '$SMC[table_ct_3]', 'serial_ct_2', 'serial_num', 'name', '$SMC[call_file_name]', '" . urlencode($SMC[sub_query_ct_3]) . "', '$SMC[title_ct_3]')\"";
			else $js_function_chg = '';
			$TAG_ct_2 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_2], $smc_selected_ct_2, 'Y', "class=designer_select{$js_function_chg}{$is_disabled}", ":: {$SMC[title_ct_2]} ::");
		} else {
			$TAG_ct_2 = "<input type=hidden name='$SMC[input_name_ct_2]' value='$smc_selected_ct_2'>";
		}
	}
	$TAG_ct[] = $TAG_ct_2;

	// 3�� ��� (3�� �з� ���̺� �̸��� ������ ��츸)
	if ($SMC[table_ct_3] != '') {
		$smc_categorys = array();
		$query = "select * from $SMC[table_ct_3] where {$SMC[fld_select_code_ct_3]}='{$smc_selected_ct_2}'{$SMC[sub_query_ct_3]}";
		$result = mysql_query($query);
		$total_cnt = mysql_num_rows($result);
		if ($total_cnt > 0) {
			while ($value = mysql_fetch_array($result)) {
				$smc_categorys[$value[$SMC[fld_code_ct_3]]] = $value[$SMC[fld_name_ct_3]];
			}
			$is_disabled = '';
		} else {
			$is_disabled = " disabled";
		}
		$TAG_ct_3 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_3], $smc_selected_ct_3, 'Y', "class=designer_select{$is_disabled}", ":: {$SMC[title_ct_3]} ::");
	}
	$TAG_ct[] = $TAG_ct_3;

	$TAG_smc_script = "
	<script id='{$SMC[name]}_DS'></script>
	<script language='javascript1.2'>
	<!--
		function reset_next_select_{$SMC[name]}(obj, reset_obj_name, form_name, table_name, selected_fld_name, fld_code, fld_name, select_file_name, sub_query, box_title) {
			var selected_value = obj.value;		// ���õ� ��
			//alert(\"{$SMC[root]}\" + select_file_name + \"?selected_value=\" + selected_value + \"&selected_fld_name=\" + selected_fld_name + \"&reset_obj_name=\" + reset_obj_name + \"&form_name=\" + form_name + \"&table_name=\" + table_name + \"&fld_code=\" + fld_code + \"&fld_name=\" + fld_name + \"&sub_query=\" + sub_query);
			{$SMC[name]}_DS.src = \"{$SMC[root]}\" + select_file_name + \"?selected_value=\" + selected_value + \"&selected_fld_name=\" + selected_fld_name + \"&reset_obj_name=\" + reset_obj_name + \"&form_name=\" + form_name + \"&table_name=\" + table_name + \"&fld_code=\" + fld_code + \"&fld_name=\" + fld_name + \"&sub_query=\" + sub_query + \"&box_title=\" + box_title;	
		}
	//-->
	</script>
	";
	$TAG_ct[] = $TAG_smc_script;
	return $TAG_ct;
}
?>