<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ ������ ���̺� ���� ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0];
$line = $lib_fix->search_index($design, "���̺�", $location);
$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
if (!strcmp("�ݺ�", $exp[9])) $table_is_repeat = true;

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
$line = $lib_fix->search_index($design, "��", $location);
$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
if (!strcmp("�ݺ�", $exp[9])) $tr_is_repeat = true;

if ($table_is_repeat != "true") {
	if($tr_is_repeat == "true") $btn = "�����ϱ�";
	else $btn = "�����ϱ�";
	$msg_tr = "<a href='#' onclick='tr_repeat()'><font color='#FF3300'>$btn</font></a>";
} else {
	$msg_tr = "���̺� �ݺ� ������ ��� �� �� �ֽ��ϴ�.";
}

if ($tr_is_repeat != "true") {
	if($table_is_repeat == "true") $btn = "�����ϱ�";
	else $btn = "�����ϱ�";
	$msg_table = "<a href='#' onclick='table_repeat()'><font color='#FF3300'>$btn</font></a>";
} else {
	$msg_table = "�� �ݺ� ������ ��� �� �� �ֽ��ϴ�.";
}

$P_form_input = "
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td height='30' width='120' align='right'>���� �� �ݺ�</td>
								<td align='center' width='40'>--></td>
								<td>
									$msg_tr
								</td>
							</tr>
							<tr> 
								<td height='30' align='right'>���� ���̺� �ݺ�</td>
								<td align='center' width='40'>--></td>
								<td>
									$msg_table
								</td>
							</tr>
						</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>�Խù��ݺ� ��ġ����</b>"));

$help_msg = "
	�ݺ������ ���� ���õǾ��ִ� �� �Ǵ� ���̺��� ��µ� �Խù� �� ��ŭ �ݺ����ִ� ����Դϴ�.<br>
	�Խ����� ���� ��� �Խù� ��ϼ��� �������� �� �Ǵ� ���̺� �ݺ��� �ݵ�� �����ϼž� �մϴ�.<br>
	������ ��ģ�� ������ ȭ�鿡 ��Ÿ�� �ݺ� Ƚ���� ������ ��ŭ �Ǿ����� Ȯ���� ���ʽÿ�.
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--	
	function reload() {
		var form = eval(document.frm);
		form.reset();
	}
	function adjust_submit() {
		var form = eval(document.frm);
		form.action = form.action + '&adjust=Y';
		form.submit();
	}
	//���̺� �ݺ�
	function table_repeat() {
		window.location.href='table_designer_manager.php?design_file=$design_file&index=$index&mode=repeat&mode1=table';
	}

	//�ٹݺ�
	function tr_repeat() {
		window.location.href='table_designer_manager.php?design_file=$design_file&index=$index&mode=repeat&mode1=tr';
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			$P_form_input
		</td>
	</tr>	
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>