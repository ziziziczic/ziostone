<?
// ����
include "header.inc.php";
$query_info = array();
$query_info[] = "select name, file_name from TCSYSTEM_design_files where type='S'";
$query_info[] = "file_name";
$query_info[] = "name";
$P_skin_file = $GLOBALS[lib_common]->get_list_boxs_query($query_info, "skin_file", $site_info[skin_file], 'N', 'N', "class=designer_select");

$P_contents = "
<script language='javascript'>
<!--
	function verify_submit(form) {
		if (form.site_name.value == '') {
			alert('����Ʈ���� �Է��ϼ���');
			return false;
		}
	}
//-->
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<form name='frm' method='post' action='setup_manager.php' onsubmit='return verify_submit(this);'>
	<input type=hidden name='is_stripslashes' value='N'>
	<tr>
		<td width='100%'>
			<table border='0' cellpadding='7' cellspacing='1' width='100%' class=input_form_table>
				<tr>
					<td class='input_form_title' width=15%>����Ʈ��</td>
					<td class='input_form_value' width=35%>
						" . $GLOBALS[lib_common]->make_input_box($site_info[site_name], "site_name", "text", "size='30' maxlength='200' class='designer_text'", "") . "
					</td>
					<td class='input_form_title' width=15%><font color=red><b>�����ھ��̵�</b></font></td>
					<td class='input_form_value' width=35%>
						" . $GLOBALS[lib_common]->make_input_box($site_info[site_id], "site_id", "text", "size='20' maxlength='20' class='designer_text'", "") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'><font color=red><b>�⺻���ε���</b></font></td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[default_file_dir], "default_file_dir", "text", "size='40' maxlength='200' class='designer_text'", "") . "
					</td>
					<td class='input_form_title'>�⺻��Ų����</td>
					<td class='input_form_value'>
						$P_skin_file
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>��ǥ�̸���</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[site_email], "site_email", "text", "size='30' maxlength='200' class='designer_text'", "") . "
					</td>
					<td class='input_form_title'>�ε�������</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[index_file], "index_file", "text", "size='30' maxlength='200' class='designer_text'", "") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>
						�����ӻ�� " . $GLOBALS[lib_common]->make_input_box($site_info[is_frame], "is_frame", "checkbox", "class='designer_checkbox'", "", "Y") . "<br>
						ī���ͻ�� " . $GLOBALS[lib_common]->make_input_box($site_info[counter], "counter", "checkbox", "class='designer_checkbox'", "", "Y") . "
					</td>
					<td class='input_form_value' colspan='3'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[frame_header], "frame_header", "textarea", "rows='10' cols='115' class='designer_textarea' style='width:100%'", "") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title' height='100'>ȸ����������</td>
					<td class='input_form_value'>
						����;���Ѹ�[�ٹٲ�] ����(7~2�������ǰ���)<br>
						" . $GLOBALS[lib_common]->make_input_box($site_info[user_level_alias], "user_level_alias_1", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
					<td class='input_form_title'>�������з�����</td>
					<td class='input_form_value'>
						�ڵ��;�̸���[�ٹٲ�] (�����ڵ�:U,B,S,I,T,Y,P)<br>
						" . $GLOBALS[lib_common]->make_input_box($site_info[page_types], "page_types", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title' height='100'>�������޴�����</td>
					<td class='input_form_value'>
						�޴���[�ٹٲ�] ����<br>
						" . $GLOBALS[lib_common]->make_input_box($site_info[design_file_menu], "design_file_menu", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
					<td class='input_form_title'>�����α׷�����</td>
					<td class='input_form_value'>
						�׷��[�ٹٲ�] ����<br>
						" . $GLOBALS[lib_common]->make_input_box($site_info[design_file_group], "design_file_group", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title' height='100'>ip ���ܸ��</td>
					<td class='input_form_value'>
						ip�ּ�[�ٹٲ�] ����<br>
						" . $GLOBALS[lib_common]->make_input_box($site_info[ip_block], "ip_block", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
					<td class='input_form_title'>���м�������</td>
					<td class='input_form_value'>
						����Ʈ��;������,������[�ٹٲ�] ����
						" . $GLOBALS[lib_common]->make_input_box($site_info[referer_sites], "referer_sites", "textarea", "class='designer_text'", "width=100%;height=80%") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>�α��ο��� �̵�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[login_error_page], "login_error_page", "text", "size='30' maxlength='200' class='designer_text'", "width:100%") . "
					</td>
					<td class='input_form_title' rowspan=2>���ѿ����޽���</td>
					<td class='input_form_value' rowspan=2 height=100%>
						" . $GLOBALS[lib_common]->make_input_box($site_info[perm_err_msg], "perm_err_msg", "textarea", "class='designer_textarea'", "width=100%;height=100%") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>�α׾ƿ� �̵�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[logout_next_page], "logout_next_page", "text", "size='30' maxlength='200' class='designer_text'", "width:100%") . "
					</td>					
				</tr>
				<tr>
					<td class='input_form_title'>���ѿ��� �̵�</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->make_input_box($site_info[access_denied_page], "access_denied_page", "text", "size='30' maxlength='200' class='designer_text'", "width:100%") . "
					</td>
					<td class='input_form_title'>ȸ������</td>
					<td class='input_form_value'>
						" . $GLOBALS[lib_common]->get_list_boxs_array($S_auth_method, "auth_method", $site_info[access_denied_page], 'N', " class='designer_select'") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>ȸ���� ���������</td>
					<td class='input_form_value' colspan='3'>
						<table width='100%' cellpadding='0' cellspacing='0' border='0'>
							<tr>
								<td>
									<table width=100% cellpadding=0 cellspacing=0>
										<tr>
											<td colspan=2>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ������ <input type=checkbox name='chk_member_field_define' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\">(�����Ͻ÷��� üũ�ϼ���)</td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define], "member_field_define", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=100%") . "</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width=50%>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����7 <input type=checkbox name='chk_member_field_define_7' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_7], "member_field_define_7", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=99%") . "</td>
													</tr>
												</table>
											</td>
											<td>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����6 <input type=checkbox name='chk_member_field_define_6' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_6], "member_field_define_6", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=100%") . "</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����5 <input type=checkbox name='chk_member_field_define_5' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_5], "member_field_define_5", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=99%") . "</td>
													</tr>
												</table>
											</td>
											<td>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����4 <input type=checkbox name='chk_member_field_define_4' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_4], "member_field_define_4", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=100%") . "</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����3 <input type=checkbox name='chk_member_field_define_3' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_3], "member_field_define_3", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=99%") . "</td>
													</tr>
												</table>
											</td>
											<td>
												<table width=100% cellpadding=0 cellspacing=0 border=0>
													<tr>
														<td>* ����2 <input type=checkbox name='chk_member_field_define_2' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\"></td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($site_info[member_field_define_2], "member_field_define_2", "textarea", "rows=3 cols=100 class='designer_textarea' readonly", "width=100%") . "</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height=20>�� ���� - �ʵ��;Ÿ��;Ÿ��Ʋ;���ڼӼ�[�ٹٲ�]�ڵ�;��³���[�ٹٲ�]�ڵ�;��³���<font color=red>[�ٹٲ�2��]</font> / �ؽ�Ʈ���� �ܸ̿� ����</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align=center height=30>
			<input type=submit value='�����ϱ�'>
		</td>
	</tr>
	</form>
</table>	
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"<b>�⺻��������</b> - Ȩ������ ��� �߿��� ������ ��ĥ�� �����Ƿ� �������̸� �ʱ� ������ ������ �ֽñ� �ٶ��ϴ�."));
echo($P_contents);
include "footer.inc.php";
?>