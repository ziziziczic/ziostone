<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // ���� ������ �о�´�
if ($cpn > 0) {	// ����Ǿ� �ִ� �׸��� Ŭ���� ���
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "�α����Է»���") {		// ȸ�� �Է»����� ��츸 ������ �ҷ��´�.
		$article_item = $exp[1];					// ���� ���õ� �ʵ��׸�
		$input_box_type = $exp[2];
		$default_pp = $exp[3];					// �⺻�Ӽ�
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	} else {
		$exp = "";
		$article_item = "user_id";
	}
} else {
	$exp = "";
	$article_item = "user_id";
}
$P_login_input_field = "
						<table width='100%' border='0' cellspacing='0' cellpadding='3' >
							<tr>
								<td valign=bottom>
									<table>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_radio_password", "", "user_id") . "<b>���̵�</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_radio_password", "", "user_passwd") . "<b>��й�ȣ</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", "", "save_user_id") . "<b>���̵�����</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", "", "save_user_passwd") . "<b>��й�ȣ����</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=radio_select", "", "user_level") . "<b>ȸ���з�</b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
";
$P_login_input_field = $lib_insiter->w_get_img_box($IS_thema_window, $P_login_input_field, $IS_input_box_padding, array("title"=>"�α��ο� �Է»��� ����"));

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	�α��ο� �Է»��� ����
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
		form.item_index.disabled = true;
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

		if (form.article_item_user.value == 'save_user_id' || form.article_item_user.value == 'save_user_passwd' || chk_fld_id_2 == '' || chk_fld_id_2 == 'basic') {
			form.item_define.disabled = true;												// �׸����� ����
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// �׸����� ����
			form.item_define.style.background = 'ffffff';
		}
		if ((chk_fld_value_2 == 'checkbox' || chk_fld_value_2 == 'radio') && (form.article_item_user.value != 'save_user_id' && form.article_item_user.value != 'save_user_passwd')) {
			form.divider.disabled = false;														// �׸� ���� ����
			form.divider.style.background = 'ffffff';			
		} else {
			form.divider.disabled = true;															// �׸� ���� ����
			form.divider.style.background = 'fafafa';
		}

		// �����׸� �⺻�� ��ȯ
		form.item_define.value = form.item_define.defaultValue;
		switch (chk_fld_value) {
			case 'user_level' :
				if (form.item_define.value == '') form.item_define.value = '" . str_replace("\r\n", chr(92).r.chr(92).n, $site_info[user_level_alias]) . "';
			break;
		}
	}

	function verify_submit() {
		form = document.frm;
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
	<form method='post'  name='frm' action='table_login_input_box_manager.php' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			$P_login_input_field
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
	inverter_1();
//-->
</script>
");
include "footer_sub.inc.php";
?>