<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						// ���� ������ �о�´�
if ($cpn > 0) {																																				// ����Ǿ� �ִ� �׸��� Ŭ���� ���
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "�÷���") {
		$pp_flash_src = $exp[1];
		$exp_property = explode($GLOBALS[DV][ct4], $exp[2]);
		$pp_flash_width = $exp_property[0];
		$pp_flash_height = $exp_property[1];
		$pp_flash_align = $exp_property[2];
		$pp_flash_wmode = $exp_property[3];
		$pp_flash_etc = $exp_property[4];
	}
}

$option_array_align = array("middle"=>"���", "left"=>"����", "right"=>"������");
$option_array_wmode = array("window"=>"�⺻", "opaque"=>"opaque", "transparent"=>"transparent");
$P_form_flash = "
<table width=100% cellpadding=2 cellspacing=0 border=0>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<tr> 
					<td height='25' width=80>���̹���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box("", "userfile", "file", "size='30' class='designer_text'", "") . "</td>
				</tr>
				<tr>
					<td>�̹������</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($pp_flash_src, "pp_flash_src", "text", "size=48 class='designer_text'", "") . "</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td><hr size=1></td></tr>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td width=80>���� x ����</td>
					<td width=150>" . $GLOBALS[lib_common]->make_input_box($pp_flash_width, "pp_flash_width", "text", "size=4 class='designer_text'", '') . " x " . $GLOBALS[lib_common]->make_input_box($pp_flash_height, "pp_flash_height", "text", "size=4 class='designer_text'", '') . "</td>
					<td width=60>Wmode</td>
					<td>" . $GLOBALS[lib_common]->get_list_boxs_array($option_array_wmode, "pp_flash_wmode", $pp_flash_wmode, 'N', "class=designer_select") . "</td>
				<tr>
				<tr>
					<td>���Ĺ��</td>
					<td>" . $GLOBALS[lib_common]->get_list_boxs_array($option_array_align, "pp_flash_align", $pp_flash_align, $exist_null='Y', "class=designer_select", $default_num_msg=":: ���� ::") . "</td>
					<td>��Ÿ�Ӽ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($pp_flash_etc, "pp_flash_etc", "text", "size=50 maxlength=200 class='designer_text'", "width:100%") . "</td>
				<tr>			
			</table>
		</td>
	</tr>
</table>
";

$P_flash_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_flash, $IS_input_box_padding, array("title"=>"<b>�÷������� �ֱ�</b>"));

$help_msg = "
	�÷��� ������ ���ε� �մϴ�.
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

echo("
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.userfile.value == '' &&  form.pp_flash_src.value == '') {
			alert('���ε��� ������ �����ϼ���');
			return false;
		}
		if (form.pp_flash_width.value == '') {
			alert('����ũ�⸦ �Է��ϼ���');
			form.pp_flash_width.focus();
			return false;
		}
		if (form.pp_flash_height.value == '') {
			alert('����ũ�⸦ �Է��ϼ���');
			form.pp_flash_height.focus();
			return false;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_flash_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit(this);'>
	<input type=hidden name=design_file value='$design_file'>
	<input type=hidden name=index value='$index'>
	<input type=hidden name=current_line value='$current_line'>
	<input type=hidden name=cpn value='$cpn'>
	<tr>
		<td>
			$P_flash_form
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
			<a href='javascript:window.close()'><flash src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>