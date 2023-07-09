<?
/*----------------------------------------------------------------------------------
 * ���� : TCTools '�λ���Ʈ' �Խ��� ���� ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
require "header.inc.php";
if ($serial_num != '') {
	$popup_info = $lib_fix->get_popup_info($serial_num);
	$mode = "modify";
} else {
	$popup_info = array("disable_term" => "24", "popup_left" => "10", "popup_top" => "10", "popup_width" => "350", "popup_height" => "400");
	$mode = "add";
}

$option_name = array("window", "layer");
$P_popup_type = $GLOBALS[lib_common]->make_list_box("type", $option_name, $option_name, "", $popup_info[type], "class='designer_select'", "");
$option_name = array("::: ��Ų���� :::", '1', '2');
$option_value = array('', '1', '2');
$P_popup_skin = $GLOBALS[lib_common]->make_list_box("skin_num", $option_name, $option_value, '', $popup_info[skin_num], "class='designer_select'", "");

$P_html_eidtor_no_print = 'Y';
$default_text_value = htmlspecialchars(stripslashes($popup_info[contents]));
include "{$DIRS[designer_root]}include/paste_input_box.inc.php";

if ($popup_info[design_file] == '') $T_design_file="home.php";
else $T_design_file = $popup_info[design_file];
$page_type = array("��Ų", "����Ʈ", "����");


$P_contents = "
<script language='javascript'>
<!--
	function verify_submit(form) {
		submit_editor('frm');
		if (form.subject.value == '') {
			alert('�˾�â �̸��� �Է��ϼ���.');
			form.subject.focus();
			return false;
		}
		form.submit();
	}
//-->
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<form name='frm' method='post' action='popup_manager.php' enctype='multipart/form-data' onsubmit='verify_submit(this); return false;'>
	<input type='hidden' name='serial_num' value='$serial_num'>
	<input type='hidden' name='mode' value='$mode'>
	<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<input type='hidden' name='is_stripslashes' value='N'>
	<tr>
		<td width='100%' height='16' align='center'>
			<table border='0' cellpadding='5' cellspacing='1'  width='100%' class=input_form_table>
				<tr>
					<td class='input_form_title' width=10%>����</td>
					<td class='input_form_value' width=40%>
						" . $GLOBALS[lib_common]->make_input_box($popup_info[subject], "subject", "text", "size='50' maxlength='200' class='designer_text'", "", "") . "
					</td>
					<td class='input_form_title' width=10%>����</td>
					<td class='input_form_value' width=40%>
						$P_popup_type
						$P_popup_skin
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>�����Ͻ�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_date_input_box("begin_time_chk", "begin_time", $popup_info[begin_time], 0, "����", "Y-m-d, H:i:s", "class='designer_text'", 'Y') . "
					</td>
					<td class='input_form_title'>�����Ͻ�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_date_input_box("end_time_chk", "end_time", $popup_info[end_time], 7, "����+7��", "Y-m-d, H:i:s", "class='designer_text'", 'Y') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>��Ȱ���ð�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($popup_info[disable_term], "disable_term", "text", "size='3' maxlength='3' class='designer_text'", "", "") . " �˾� ��Ȱ���ð� (�湮�����ý�)
					</td>
					<td class='input_form_title'>â��ġ</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($popup_info[popup_left], "popup_left", "text", "size='5' maxlength='3' class='designer_text'", "", "") . " ���� ,
						" . $GLOBALS[lib_common]->make_input_box($popup_info[popup_top], "popup_top", "text", "size='5' maxlength='3' class='designer_text'", "", "") . " ����
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>âũ��</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($popup_info[popup_width], "popup_width", "text", "size='5' maxlength='3' class='designer_text'", "", "") . " ���� ,
						" . $GLOBALS[lib_common]->make_input_box($popup_info[popup_height], "popup_height", "text", "size='5' maxlength='3' class='designer_text'", "", "") . " ����
					</td>
					<td class='input_form_title'>��������</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($popup_info[bg_color], "bg_color", "text", "size='7' maxlength='7' class='designer_text'", "", "") . " ��� ,
						" . $GLOBALS[lib_common]->make_input_box($popup_info[font_color], "font_color", "text", "size='7' maxlength='7' class='designer_text'", "", "") . " ����
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>�̹���÷��</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->get_file_upload_box("upload_files", 1, $popup_info[upload_files], "size='30' class='designer_text'", $DIRS[popup_img]) . "
					</td>
					<td class='input_form_title'>���÷��</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->get_file_upload_box("upload_files", 2, $popup_info[upload_files], "size='30' class='designer_text'", $DIRS[popup_img]) . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>����</td>
					<td class='input_form_value' colspan='3' height=500>
						$P_html_editer_tag;
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>include</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($popup_info['include'], "include", "text", "size='30' class='designer_text'", "", "") . " ���뺸�ٿ켱
					</td>
					<td class='input_form_title'>����������</td>
					<td class='input_form_value'>
						" . $lib_insiter->design_file_list("design_file", $page_type, 'Y', '', "class=designer_select", $T_design_file, 'N', 'M', 'N') . "
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align=center height=40>
			<input type=submit value='�����ϱ�' class=designer_button>
		</td>
	</tr>
	</form>
</table>
<script language='javascript1.2'>
<!--
	document.frm.subject.focus();
//-->
</script>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"�˾�â ���� �Է�"));
echo($P_contents);
include "footer.inc.php";
?>