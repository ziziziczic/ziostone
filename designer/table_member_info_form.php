<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // ���� ������ �о�´�
if ($cpn > 0) {																											// ����Ǿ� �ִ� �׸��� Ŭ���� ���
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "ȸ������") {																			// �Խù� ������ ��츸 ������ �ҷ��´�.
		$article_item = $T_article_item = $exp[1];										// ���� ���õ� �ʵ��׸�
		$exp_1 = explode($GLOBALS[DV][ct4], $exp[2]);
		$prt_type = $exp_1[0];
		switch ($prt_type) {				// ������º� ����Ӽ�
			case 'T' :									// �ؽ�Ʈ
				// �ؽ�Ʈ �Ӽ� �ҷ���
				$define_property = array("face", "size", "color");
				$pp_font = $GLOBALS[lib_common]->parse_property($exp_1[2], ' ', '=', $define_property);
				$pp_font_face = $pp_font[face];
				$pp_font_size = $pp_font[size];
				$pp_font_color = $pp_font[color];
				$pp_font_etc = $pp_font[etc];
				$max_string = $exp_1[1];
			break;
			case 'H' :								// HTML �±�
				$max_string = $exp_1[1];
			break;
			case 'F' :								// ����
				$prt_type_file = $exp_1[1];
				if ($prt_type_file != 'F') {	// �̹����� �������ΰ��
					// �̹��� �Ӽ� �ҷ���
					$define_property = array("width", "height", "border", "align");
					$pp_img = $GLOBALS[lib_common]->parse_property($exp_1[2], ' ', '=', $define_property);
					$pp_img_width = $pp_img[width];
					$pp_img_height = $pp_img[height];
					$pp_img_align = $pp_img[align];
					$pp_img_border = $pp_img[border];
					$pp_img_etc = $pp_img[etc];
					$size_method = $exp_1[3];
				} else {
					$max_string = $exp_1[4];
				}
			break;
			case 'N' :								// ����
				$sosujum = $exp_1[1];
			break;
			case 'D' :								// ��¥
				$format_date = $exp_1[1];
			break;
			case 'C' :								// �ڵ尪
				$code_define = str_replace(chr(92).n, '
', $exp_1[1]);
			break;
			case 'U' :								// ���������
				$saved_user_define_img = $exp_1[2];
				$user_define_text = $exp_1[3];
			break;
		}
		$exp_pp_fld = explode($GLOBALS[DV][ct4], $exp[3]);
		$item_index = $exp_pp_fld[0];

		$exp_tag_both = explode($GLOBALS[DV][ct4], $exp[12]);
		$tag_open = $exp_tag_both[0];
		$tag_close = $exp_tag_both[1];
	}
}

if ($T_article_item == '') $T_article_item = "id";
if ($prt_type == '') $prt_type = 'T';
if ($prt_type_file == '') $prt_type_file = 'A';
if ($sosujum == '') $sosujum = '0';
if ($format_date == '') $format_date = 'Y-m-d';
if ($size_method == '') $size_method = 'A';
if ($user_define_text == '') $user_define_text = "��������ǹ���";

$T_code_user_level = array();
$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
while (list($key, $value) = each($user_level_list)) {
	$T_code_user_level[] = trim("{$key}{$GLOBALS[DV][ct2]}{$value}");
}
$code_user_level = implode("\\n", $T_code_user_level);

if ($DIRS[shop_root] != '') $P_buy_cnt = "<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "buy_cnt") . "����ȸ��</td>";

$P_member_item = "
<table width='100%' cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "id") . "���̵�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "name") . "�̸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "passwd") . "��й�ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "passwd_re") . "��й�ȣȮ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "gender") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "homepage") . "Ȩ������</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "introduce") . "�޸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "hobby") . "���</td>					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "nick_name") . "�г���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "messenger") . "�޽����ּ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=C", "", "mailing") . "���ϸ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "job_kind") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "recommender") . "��õ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=F", "", "upload_file") . "���ε�����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "admin_memo") . "�����޸�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "group_1") . "�׷�1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "group_2") . "�׷�2</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "sido") . "�õ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "gugun") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_1") . "�з�1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_2") . "�з�2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "category_3") . "�з�3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_1") . "��Ÿ1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_2") . "��Ÿ2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_3") . "��Ÿ3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_4") . "��Ÿ4</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_5") . "��Ÿ5</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "etc_6") . "��Ÿ6</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "email") . "�̸����ּ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "birth_day") . "�������</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "post") . "�����ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "address") . "�ּ�</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "jumin_number") . "�ֹι�ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", '') . "<font color=999999>�����</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone") . "��ȭ��ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone_mobile") . "�޴�����ȣ</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", "", "phone_fax") . "�ѽ���ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=C", "", "user_level") . "����ڷ���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "visit_num") . "�湮ȸ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=N_T", "", "cyber_money") . "������</td>
					$P_buy_cnt
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_company") . "ȸ���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_number") . "����ڹ�ȣ</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_ceo") . "��ǥ��</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_cond") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_item") . "����</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($T_article_item, "article_item", "radio", "onclick='inverter()' id=T_H_F_N_D_C_U", '', "biz_address") . "������</td>
					<td width=20></td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($article_item_user, "article_item_user", "text", "size=10 class='designer_text'", '', '') . "
						" . $GLOBALS[lib_common]->make_input_box($item_index, "item_index", "text", "size=3 maxlength=1class='designer_text'", '', '') . "
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_member_item = $lib_insiter->w_get_img_box($IS_thema_window, $P_member_item, $IS_input_box_padding, array("title"=>"<b>�׸���</b>"));

include "./include/pp_form_font.inc.php";

$FL_upload_image = 'N';
include "{$DIRS[designer_root]}include/pp_form_img.inc.php";

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$P_form_input_print_type = "
						<table width='100%' border='0' cellspacing='0' cellpadding='5' >
							<tr>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-T_LY-M", '', 'T') . "�Ϲݱ���
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-M", '', 'H') . "HTML�±�
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-F", '', 'F') . "����
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-N", '', 'N') . "����
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-D", '', 'D') . "��¥
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-C", '', 'C') . "�ڵ尪
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-U", '', 'U') . "���������
									" . $GLOBALS[lib_common]->make_input_box($prt_type, "prt_type", "radio", "class='designer_radio' onclick='inverter_2()' id=LY-X", '', 'X') . "����
								</td>
							</tr>
							<tr id='LY-T' style='display:none'>
								<td>
									$P_pp_form_font
								</td>
							</tr>
							<tr><td><hr size=1></td</tr>
							<tr id='LY-M' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77 height=25>���ڼ�����</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($max_string, "max_string", "text", "size='3' maxlength='3'{$input_disable}class='designer_text'", "") . " 500byte�̳�
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-F' style='display:none'>
								<td>
									<table border=0 cellpadding=0 cellspacing=0 width=100%>
										<tr>
											<td width=70>�������</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'A') . "�ڵ�(��������)
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'F') . "���ϸ�
												" . $GLOBALS[lib_common]->make_input_box($prt_type_file, "prt_type_file", "radio", "class='designer_radio'", '', 'I') . "���Ͼ�����
											</td>
										</tr>
										<tr><td>�̹����Ӽ�</td><td><hr size=1></td></tr>
										<tr>
											<td height='25'>ũ���������</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($size_method, "size_method", "radio", "class='designer_radio'", '', "A") . "���Ѻ���
												" . $GLOBALS[lib_common]->make_input_box($size_method, "size_method", "radio", "class='designer_radio'", '', "H") . "��������
											</td>
										</tr>
										<tr>
											<td colspan=2>
												$P_form_img
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-C' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=120>�ڵ尪��Ī<br>�ڵ�;��°�[�ٹٲ�]</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($code_define, "code_define", "textarea", "cols=70 rows=5 class='designer_textarea'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-U' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>����(html)</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($user_define_text, "user_define_text", "text", "size='60' class='designer_text'", '') . "
											</td>
										</tr>
										<tr>
											<td width=77>�̹���</td>
											<td>
												" . $GLOBALS[lib_common]->get_file_upload_box("user_define_img", 0, $saved_user_define_img, "size='60' class='designer_text'") . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-N' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>�Ҽ����ڸ���</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($sosujum, "sosujum", "text", "size='5' class='designer_text'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='LY-D' style='display:none'>
								<td>
									<table cellpadding=0 cellspacing=0 border=0 width=100%>
										<tr>
											<td width=77>��¥����</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($format_date, "format_date", "text", "size='20' class='designer_text'", '') . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
";
$P_form_input_print_type = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_print_type, $IS_input_box_padding, array("title"=>"<b>��¼Ӽ� ����</b>"));

$help_msg = "
	ȸ������ ���� ȭ��
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var msg, c1;
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_prt = 'T', chk_prt_id='', chk_prt_value='';

	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {	 // ���õ� �ʵ� ���� ����
			if (form.article_item[i].checked) {
				chk_fld = form.article_item[i];
				chk_fld_id = form.article_item[i].id;
				chk_fld_value = form.article_item[i].value;
			}
		}
		disable_child_radio(chk_fld_id, form.prt_type);	// ���õ� �ʵ忡 ���� ��� �Ӽ� ����
		form.article_item_user.value = chk_fld_value;
		if (chk_fld_value == 'upload_file') form.item_index.disabled = false;
		else form.item_index.disabled = true;
		//if (chk_fld_id == 'C') form.code_define.disabled = true;
		//else form.code_define.disabled = false;

		// �����׸� �⺻�� ��ȯ
		form.code_define.value = form.code_define.defaultValue;
		switch (chk_fld_value) {
			case 'user_level' :
				if (form.code_define.value == '') form.code_define.value = '$code_user_level';
			break;
		}
	}

	function inverter_2() {
		form = document.frm;
		for (i=0; i<form.prt_type.length; i++) {
			if (form.prt_type[i].checked) {
				chk_prt = form.prt_type[i];
				chk_prt_id = form.prt_type[i].id;
				chk_prt_value = form.prt_type[i].value;
			}
		}
		enable_child_id(chk_prt_id, document.getElementsByTagName('tr'));
	}

	function verify_submit() {
		form = document.frm;
		if ((chk_fld.disabled == true) || (chk_fld_value == '')) {
			alert('�Է��� �׸��� �����ϼ���');
			return false;
		}
		if ((chk_prt == 'T') || (chk_prt.disabled == true) || (chk_prt_value == '')) {
			alert('��� �Ӽ� �׸��� �����ϼ���');
			return false;
		}
		if (form.item_index.disabled == false && form.item_index.value == '') {
			alert('�׸� ��ȣ�� �Է��ϼ���');
			form.item_index.focus();
			return false;			
		}
		form.submit();
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_member_info_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>$P_member_item</td>
	</tr>
	<tr>
		<td>
			$P_form_input_print_type
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
	inverter_2();
//-->
</script>
");
include "footer_sub.inc.php";
?>