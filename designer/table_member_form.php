<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ �Խ��� �׸� ���� ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$_GET[form_line]]);
$saved_verify_input = explode("~", $exp[5]);

$P_table_member_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td>
			" . $GLOBALS[lib_common]->make_input_box("id", "", "checkbox", "checked disabled", "", "") . "���̵�
			" . $GLOBALS[lib_common]->make_input_box("passwd", "", "checkbox", "checked disabled", "", "") . "��й�ȣ (ȸ�� ���̵�� ��й�ȣ�� �׻� �ʼ� �Է�)
		</td>
	</tr>
	<tr><td><hr size=1></td></tr>
	<tr> 
		<td>
			<table width='100%' cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[0], "verify_input_0", "checkbox", '', '', "name") . "�̸�</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[1], "verify_input_1", "checkbox", '', '', "gender") . "����</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[2], "verify_input_2", "checkbox", '', '', "homepage") . "Ȩ������</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[3], "verify_input_3", "checkbox", '', '', "introduce") . "�޸�</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[4], "verify_input_4", "checkbox", '', '', "hobby") . "���</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[5], "verify_input_5", "checkbox", '', '', "nick_name") . "�г���</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[6], "verify_input_6", "checkbox", '', '', "messenger") . "�޽����ּ�</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[7], "verify_input_7", "checkbox", '', '', "mailing") . "���ϸ�</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[8], "verify_input_8", "checkbox", '', '', "job_kind") . "����</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[9], "verify_input_9", "checkbox", '', '', "recommender") . "��õ��</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[10], "verify_input_10", "checkbox", '', '', "group_1") . "�׷�1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[11], "verify_input_11", "checkbox", '', '', "group_2") . "�׷�2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[12], "verify_input_12", "checkbox", '', '', "category_1") . "�з�1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[13], "verify_input_13", "checkbox", '', '', "category_2") . "�з�2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[14], "verify_input_14", "checkbox", '', '', "category_3") . "�з�3</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[15], "verify_input_15", "checkbox", '', '', "etc_1") . "��Ÿ1</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[16], "verify_input_16", "checkbox", '', '', "etc_2") . "��Ÿ2</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[17], "verify_input_17", "checkbox", '', '', "etc_3") . "��Ÿ3</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[18], "verify_input_18", "checkbox", '', '', "email") . "�̸���</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[19], "verify_input_19", "checkbox", '', '', "email_1") . "<font color=999999>�̸���1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[20], "verify_input_20", "checkbox", '', '', "email_2") . "<font color=999999>�̸���2</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[21], "verify_input_21", "checkbox", '', '', "birth_day") . "�������</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[22], "verify_input_22", "checkbox", '', '', "birth_1") . "<font color=999999>����</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[23], "verify_input_23", "checkbox", '', '', "birth_2") . "<font color=999999>����</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[24], "verify_input_24", "checkbox", '', '', "birth_3") . "<font color=999999>����</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>								
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[25], "verify_input_25", "checkbox", '', '', "post") . "�����ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[26], "verify_input_26", "checkbox", '', '', "post_1") . "<font color=999999>����1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[27], "verify_input_27", "checkbox", '', '', "post_2") . "<font color=999999>����2</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[28], "verify_input_28", "checkbox", '', '', "address") . "�ּ�</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[29], "verify_input_29", "checkbox", '', '', "jumin_number") . "�ֹι�ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[30], "verify_input_30", "checkbox", '', '', "jumin_number_1") . "<font color=999999>�ֹ�1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[31], "verify_input_31", "checkbox", '', '', "jumin_number_2") . "<font color=999999>�ֹ�2</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[32], "verify_input_32", "checkbox", '', '', "phone") . "��ȭ��ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[33], "verify_input_33", "checkbox", '', '', "phone_1") . "<font color=999999>��ȭ1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[34], "verify_input_34", "checkbox", '', '', "phone_2") . "<font color=999999>��ȭ2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[35], "verify_input_35", "checkbox", '', '', "phone_3") . "<font color=999999>��ȭ3</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[36], "verify_input_36", "checkbox", '', '', "phone_mobile") . "�޴�����ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[37], "verify_input_37", "checkbox", '', '', "phone_mobile_1") . "<font color=999999>�޴���1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[38], "verify_input_38", "checkbox", '', '', "phone_mobile_2") . "<font color=999999>�޴���2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[39], "verify_input_39", "checkbox", '', '', "phone_mobile_3") . "<font color=999999>�޴���3</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[40], "verify_input_40", "checkbox", '', '', "phone_fax") . "�ѽ���ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[41], "verify_input_41", "checkbox", '', '', "phone_fax_1") . "<font color=999999>�ѽ�1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[42], "verify_input_42", "checkbox", '', '', "phone_fax_2") . "<font color=999999>�ѽ�2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[43], "verify_input_43", "checkbox", '', '', "phone_fax_3") . "<font color=999999>�ѽ�3</font>)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[44], "verify_input_44", "checkbox", '', '', "biz_company") . "ȸ���</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[45], "verify_input_45", "checkbox", '', '', "biz_number") . "����ڹ�ȣ</td>
								<td>(" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[46], "verify_input_46", "checkbox", '', '', "biz_number_1") . "<font color=999999>��ȣ1</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[47], "verify_input_47", "checkbox", '', '', "biz_number_2") . "<font color=999999>��ȣ2</font></td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[48], "verify_input_48", "checkbox", '', '', "biz_number_3") . "<font color=999999>��ȣ3</font>)</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[49], "verify_input_49", "checkbox", '', '', "biz_ceo") . "��ǥ��</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[50], "verify_input_50", "checkbox", '', '', "biz_cond") . "����</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[51], "verify_input_51", "checkbox", '', '', "biz_item") . "����</td>
								<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[52], "verify_input_52", "checkbox", '', '', "biz_address") . "������</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_member_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_member_form, $IS_input_box_padding, array("title"=>"<b>ȸ������ �ʼ� �Է��׸���</b>"));

include "include/form_form_property.inc.php";

$help_msg = "
	ȸ�������� ����ȭ��
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo ("
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_form_manager.php'>
	<input type='hidden' name='design_file' value='$design_file'>
	<input type='hidden' name='form_line' value='$form_line'>
	<input type='hidden' name='mode' value='$mode'>
	<tr>
		<td>
			$P_table_member_form
		</td>
	</tr>
	<tr>
		<td>
			$P_table_form_function
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'></a>
			<a href='javascript:parent.window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
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