<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // ���� ������ �о�´�
if ($cpn > 0) {	// ����Ǿ� �ִ� �׸��� Ŭ���� ���
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "ȸ���Է»���") {		// ȸ�� �Է»����� ��츸 ������ �ҷ��´�.
		$article_item = $exp[1];					// ���� ���õ� �ʵ��׸�
		$input_box_type = $exp[2];
		$default_pp = $exp[3];					// �⺻�Ӽ�
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	}
}

$P_member_input_field = "
<table width='100%' cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "id") . "���̵�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "name") . "�̸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "passwd") . "��й�ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "passwd_re") . "��й�ȣȮ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "gender") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "homepage") . "Ȩ������</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "introduce") . "�޸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "hobby") . "���</td>					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "nick_name") . "�г���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "messenger") . "�޽����ּ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio", "", "mailing") . "���ϸ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "job_kind") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "recommender") . "��õ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=file", "", "upload_file") . "���ε�����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "admin_memo") . "�����޸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "group_1") . "�׷�1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "group_2") . "�׷�2</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "sido") . "�õ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "gugun") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_1") . "�з�1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_2") . "�з�2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_3") . "�з�3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_1") . "��Ÿ1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_2") . "��Ÿ2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_3") . "��Ÿ3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_4") . "��Ÿ4</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_5") . "��Ÿ5</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_6") . "��Ÿ6</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email") . "�̸����ּ�</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email_1") . "<font color=999999>�̸���1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email_2") . "<font color=999999>�̸���2</font>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_day") . "�������</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_1") . "<font color=999999>����</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_2") . "<font color=999999>����</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_3") . "<font color=999999>����</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post") . "�����ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post_1") . "<font color=999999>����1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post_2") . "<font color=999999>����2</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "address") . "�ּ�</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone") . "��ȭ��ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_1") . "<font color=999999>��ȭ1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_2") . "<font color=999999>��ȭ2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_3") . "<font color=999999>��ȭ3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile") . "�޴�����ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_1") . "<font color=999999>�޴���1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_2") . "<font color=999999>�޴���2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_3") . "<font color=999999>�޴���3</font>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax") . "�ѽ���ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_1") . "<font color=999999>�ѽ�1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_2") . "<font color=999999>�ѽ�2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_3") . "<font color=999999>�ѽ�3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number") . "�ֹι�ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number_1") . "<font color=999999>�ֹ�1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number_2") . "<font color=999999>�ֹ�2</font></a>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_file_html_hidden", "", '') . "<font color=999999>�����</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_company") . "ȸ���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number") . "����ڹ�ȣ</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_1") . "<font color=999999>��ȣ1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_2") . "<font color=999999>��ȣ2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_3") . "<font color=999999>��ȣ3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_ceo") . "��ǥ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_cond") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_item") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_address") . "������</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_member_input_field = $lib_insiter->w_get_img_box($IS_thema_window, $P_member_input_field, $IS_input_box_padding, array("title"=>"DB table field ���� (���̺� : TCMEMBER)"));

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	ȸ������ �Է»��� ����ȭ��
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_fld_2 = 'T', chk_fld_id_2='', chk_fld_value_2='';
	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {
			if (form.article_item[i].checked) {
				chk_fld_id = form.article_item[i].id;
				chk_fld_value = form.article_item[i].value;
			}
		}
		disable_child_radio(chk_fld_id, form.input_box_type);	// ���õ� �ʵ忡 ���� ��� �Ӽ� ����
		form.article_item_user.value = chk_fld_value;
		if (chk_fld_value == 'upload_file') form.item_index.disabled = false;
		else form.item_index.disabled = true;

		// �����׸� �⺻�� ��ȯ
		form.item_define.value = form.item_define.defaultValue;
		switch (chk_fld_value) {
			case 'gender' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_gender]}';
			break;
			case 'mailing' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_mailling]}';
			break;
			case 'phone_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_1]}';
			break;
			case 'phone_mobile_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_mobile_1]}';
			break;
			case 'phone_fax_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_fax_1]}';
			break;
		}
		inverter_1();
	}

	// �Է»��ڿ� ���� �׸� �Է� ���� ��� ����
	function inverter_1() {
		form = document.frm;
		for (i=0; i<form.input_box_type.length; i++) {
			if (form.input_box_type[i].checked) {
				chk_fld_id_2 = form.input_box_type[i].id;
				chk_fld_value_2 = form.input_box_type[i].value;
			}
		}
		if (chk_fld_id_2 == '' || chk_fld_id == 'checkbox' || chk_fld_id_2 == 'basic' || chk_fld_value == 'group') {
			form.item_define.disabled = true;	// �׸����� ����
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// �׸����� ����
			form.item_define.style.background = 'ffffff';
		}
		if (chk_fld_value_2 == 'checkbox' || chk_fld_value_2 == 'radio') {
			form.divider.disabled = false;														// �׸� ���� ����
			form.divider.style.background = 'ffffff';			
		} else {
			form.divider.disabled = true;															// �׸� ���� ����
			form.divider.style.background = 'fafafa';
		}
	}

	function verify_submit(form) {
		select_flag = 0;
		for(i=0; i<form.article_item.length; i++) if (form.article_item[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('�Է��� �׸��� �����ϼ���');
			return false;
		}
		select_flag = 0;
		for(i=0; i<form.input_box_type.length; i++) if (form.input_box_type[i].disabled == false && form.input_box_type[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('�Է� Ÿ���� �����ϼ���');
			return false;
		}
		if (form.item_index.disabled == false && form.item_index.value == '') {
			alert('�ʵ� ��ȣ�� �Է��ϼ���.');
			form.item_index.focus();
			return false;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_member_input_box_manager.php' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			$P_member_input_field
		</td>
	</tr>
	<tr>
		<td>
			$P_form_input_box
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
		<tr>
		<td>
			$P_form_blank
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
<script language='javascript1.2'>
<!--
	inverter();
//-->
</script>
");
include "footer_sub.inc.php";
?>