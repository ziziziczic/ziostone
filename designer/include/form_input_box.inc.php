<?
$item_define = str_replace(chr(92).n, '
', $item_define);

$input_box_default_value_mode_array = array('X'=>"�⺻�������", 'A'=>"���尪", 'B'=>"�����+���尪", 'C'=>"ȸ������", 'D'=>"���尪->ȸ������", 'E'=>"���尪->����ڰ�", 'F'=>"���尪->GET����", 'G'=>"GET����", 'U'=>"���������");

$T_exp = explode($GLOBALS[DV][ct4], $default_value_info);
if ($T_exp[0] == '') $T_exp[0] = 'A';

if ($P_only_board_box = 'Y') $P_only_board_box = $GLOBALS[lib_common]->make_input_box($T_exp[2], "input_box_use_mode", "checkbox", "size=15 class=designer_checkbox onclick='chg_use_mode()'", '', 'Y') . " (�˻���)";

$P_form_input_box = "
	<table width='100%' border='0' cellspacing='0' cellpadding='3' >
		<tr>
			<td width=80>�ʵ���Է�</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item_user", "text", "size=20 class=designer_text", '') . "
				" . $GLOBALS[lib_common]->make_input_box($item_index, "item_index", "text", "size=3 class=designer_text", '') . "
				" . $GLOBALS[lib_common]->get_list_boxs_array($input_box_default_value_mode_array, "input_box_default_value_mode", $T_exp[0], 'N', "class='designer_select'") . "
				" . $GLOBALS[lib_common]->make_input_box($T_exp[1], "input_box_default_value", "text", "size=15 class=designer_text", '') . "
				$P_only_board_box
			</td>
		</tr>
		<tr><td colspan=2><hr size=1></td></tr>
		<tr>
			<td width=80>�Է�Ÿ�Լ���</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "text") . "Text
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "textarea") . "Textarea
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=items", '', "select") . "Select
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=items", '', "checkbox") . "Checkbox
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=items", '', "radio") . "Radio
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "file") . "File
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "password") . "Password
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "html") . "HTML
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "calendar") . "��¥(�޷�)
				" . $GLOBALS[lib_common]->make_input_box($input_box_type, "input_box_type", "radio", "onclick='inverter_1()' class='designer_radio' id=basic", '', "hidden") . "Hidden
			</td>
		</tr>
		<tr><td colspan=2><hr size=1></td></tr>
		<tr>
			<td>�⺻�Ӽ��Է�</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($default_pp, "default_pp", "text", "size=70 maxlength=200 class='designer_text'", "") . "
			</td>
		</tr>
		<tr>
			<td>�����׸�����</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($item_define, "item_define", "textarea", "rows=5 cols=70 class='designer_textarea'", '') . "<br>���尪;�̸�[�ٹٲ�] �������� �Է�
			</td>
		</tr>
		<tr>
			<td>�׸� ����</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($item_divider, "divider", "text", "size=70 class='designer_text'", '') . "
			</td>
		</tr>
	</table>
";
$P_form_input_box = $lib_insiter->w_get_img_box($IS_thema, $P_form_input_box, $IS_input_box_padding, array("title"=>"<b>�Է»��� �Ӽ�</b>"));
?>