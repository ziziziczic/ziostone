<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // ���� ������ �о�´�

if ($cpn > 0) {	// ����Ǿ� �ִ� �׸��� Ŭ���� ���
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	$default_value_info = $exp[7];
	if ($exp[0] == "�Խ����Է»���") {	// �Խù� ������ ��츸 ������ �ҷ��´�.
		$article_item = $exp[1];					// ���� ���õ� �ʵ��׸�
		$input_box_type = $exp[2];			// �Է»��� ����
		$default_pp = $exp[3];					// �⺻�Ӽ�
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	}
}

$P_only_board_box = 'Y';

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$P_form_input = "
	<table width='100%'>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "subject") . "<b>����</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "writer_name") . "<b>�ۼ���</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "email") . "<b>�̸���</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "homepage") . "<b>Ȩ������</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "phone") . "<b>��ȭ��ȣ</b></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "comment") . "<b>����</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=file", '', "user_file") . "<b>���ε�����</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_calendar", '', "sign_date") . "<b>�ۼ���</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "writer_id") . "<b>�ۼ��ھ��̵�</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "passwd") . "<b>��й�ȣ</b></td>
		</tr>
		<tr>											
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "etc") . "<b>��Ÿ</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "category") . "<b>�з��Է�</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "type") . "<b>�Խù�����</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_html") . "<b>HTMLüũ</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_notice") . "<b>������üũ</b></td>
		</tr>
		<tr>											
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_private") . "<b>�����üũ</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_view") . "<b>��¾���üũ</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "reply_answer") . "<b>�亯����üũ</b></td>
			<td></td>
			<td></td>
		</tr>
		<tr>											
			<td colspan=5><hr size=1 width=100% color=cccccc></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select", '', "tpa") . "<b>��ϰԽù���</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "list_select[]") . "<b>���߼���</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "search_value") . "<b>�˻����Է�</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "search_item") . "<b>�˻��ʵ弱��</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio", '', "category_go") . "<b>�з��̵�</b></td>
		</tr>
	</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>�Է��׸���</b>"));

$help_msg = "
	�Խ��� �Է»��� ����
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var checked_value = checked_id = '';
	// �ʵ忡 ���� Ȱ�� ������ �Է»��� ���� ����
	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {
			if (form.article_item[i].checked) {
				checked_id = form.article_item[i].id;
				checked_value = form.article_item[i].value;
			}
		}
		disable_child_radio(checked_id, form.input_box_type);	// ���õ� �ʵ忡 ���� ��� �Ӽ� ����
		form.article_item_user.value = checked_value;

		// �׸� �ε��� �Է»��� Ȱ��ȭ����
		if (checked_value == 'category' || checked_value == 'comment' || checked_value == 'user_file' || checked_value == 'etc' || checked_value == 'category_go' || (checked_value == 'sign_date' && form.input_box_use_mode.checked == true)) form.item_index.disabled = false;
		else form.item_index.disabled = true;
		
		// �˻��� üũ���� Ȱ��ȭ����
		if (checked_value == 'tpa' || checked_value == 'list_select[]' || checked_value == 'search_value' || checked_value == 'search_item' || checked_value == 'category_go' || checked_value == '') form.input_box_use_mode.disabled = true;
		else form.input_box_use_mode.disabled = false;

		// ���尪 ����, �Է»��� Ȱ��ȭ ����
		if (checked_value == 'list_select[]' || checked_value == 'search_value' || checked_value == 'search_item' || checked_value == 'category_go') {
			form.input_box_default_value_mode.disabled = true;
			form.input_box_default_value.disabled = true;
		} else {
			form.input_box_default_value_mode.disabled = false;
			form.input_box_default_value.disabled = false;
		}
		inverter_1();
	}

	function chg_use_mode() {
		form = document.frm;
		inverter();
		if (form.input_box_use_mode.checked == true) {
			if (form.item_index.value != '') T_str = '_' + form.item_index.value;
			else T_str = '';
			form.input_box_default_value_mode.value = 'G';
			form.input_box_default_value.value = 'SCH_' + form.article_item_user.value + T_str;
		} else {
			form.input_box_default_value_mode.value = form.input_box_default_value_mode.defaultValue;
			form.input_box_default_value.value = form.input_box_default_value.defaultValue;
		}
	}

	// �Է»��ڿ� ���� �׸� �Է� ���� ��� ����
	function inverter_1() {
		form = document.frm;
		checked_id_2 = checked_value_2 = '';
		for (i=0; i<form.input_box_type.length; i++) {
			if (form.input_box_type[i].checked) {
				checked_id_2 = form.input_box_type[i].id;
				checked_value_2 = form.input_box_type[i].value;
			}
		}
		if (checked_id == 'checkbox' || checked_id_2 == 'basic' || checked_value=='category' || checked_value=='type' || checked_value=='category_go' || checked_value=='search_item') {
			form.item_define.disabled = true;												// �׸����� ����
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// �׸����� ����
			form.item_define.style.background = 'ffffff';
		}
		if (checked_value_2 == 'checkbox' || checked_value_2 == 'radio') {
			form.divider.disabled = false;														// �׸� ���� ����
			form.divider.style.background = 'ffffff';
		} else {
			form.divider.disabled = true;															// �׸� ���� ����
			form.divider.style.background = 'fafafa';
		}
	}

	function verify_submit() {
		form = document.frm;
		select_flag = 0;
		for(i=0; i<form.article_item.length; i++) if (form.article_item[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('�Է��� �׸��� �����ϼ���');
			form.article_item[0].focus();
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
<table width=100% border=0 cellpadding=0 cellspacing=0>
	<form method='post'  name='frm' action='table_board_input_box_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit()'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
				<tr>
					<td>
						$P_form_input
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='3' id='DF_FORM' style='display:{$is_saved_default}'>	
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
			</table>
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