<?
require "header.inc.php";
if ($_GET[mi_id] != '') {
	$proc_mode = "cm_modify";
	$cm_info = $GLOBALS[lib_common]->get_data($DB_TABLES[cyber_money], "mi_id", $_GET[mi_id]);
} else {
	$proc_mode = "cm_add";
}
$colspan = 6;
$search_item_array = array("A"=>"���հ˻�", "mb_id"=>"ȸ��ID", "mi_milage"=>"�ݾ�", "mi_memo"=>"����", "od_id"=>"�ֹ���ȣ", "mi_ip"=>"�������ּ�");
$search_item_array_date = array("mi_time"=>"�����");
$option_boxs = array();
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($GLOBALS[VI][state_cm], "SCH_state", $_GET[SCH_state], 'Y', "class=designer_select style='width:60px'", "����");
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "mi_time";			// �Ⱓ�˻� �⺻ �ʵ�
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"time");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("mi_time");
$sort_sequence = array("desc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $shop_ppa;
$query = "select * from {$DB_TABLES[cyber_money]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(mi_id), sum(mi_milage)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $shop_ppb, $_GET[page], $style, $font, "{$DIRS[designer_root]}images/");
$list_info = $lib_insiter->get_cm_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], "admin", $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr>
					<td colspan=$colspan bgcolor='#FFFFFF' align=center>
						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<form name='frm' method=post action='member_manager.php' onsubmit='return verify_submit(this)'>
							<input type='hidden' name='mode' value='$proc_mode'>
							<input type='hidden' name='mi_id' value='$_GET[mi_id]'>
							<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
							<tr>
								<td>
									<table cellpadding=3 cellspacing=0 border=0>
										<tr>
											<td><b>* ����&����</b> : </td>
											<td><input type='button' value='ID�˻�' onclick=\"window.open('{$DIRS[member_root]}sch_member.php?nm_id=mb_id', 'sch_member', 'left=10,top=10,width=600,height=550,scrollbars=1,resizable=1').focus()\" class=designer_button></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($cm_info[mb_id], "mb_id", "text", "size=10 class='designer_text' readonly", "") . "</td>
											<td>" . $GLOBALS[lib_common]->make_input_box($cm_info[mi_memo], "mi_memo", "text", "size=30 class='designer_text'", "") . "</td>
											<td>" . $GLOBALS[lib_common]->make_input_box($cm_info[mi_milage], "mi_milage", "text", "size=10 class='designer_text' onkeyup='ck_number(this)'", "") . "��</td>
											<td>" . $GLOBALS[lib_common]->get_list_boxs_array($GLOBALS[VI][state_cm], "mi_state", $cm_info[mi_state], 'N', "class=designer_select") . "</td>
											<td><input type='submit' value='����' class=designer_button></td>
										</tr>
									</table>
								</td>
								<td align=right>$ppb_link[0]</td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
	";
}
$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>��</b> - <b><u>" . number_format($ppb_link[1][1]) . "</u></b> ��</font></td>
					<td align=right>
						$P_search_box
					</td>
				</tr>
			</table>
";

$P_contents = "
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' align='center'>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align=center>
					<td class=list_form_title width='40'><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "mi_id", "asc", '') . "'>��ȣ</a></td>
					<td class=list_form_title width=150><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "mi_time", "asc", '') . "'>�Ͻ�</a></td>
					<td class=list_form_title>����</td>
					<td class=list_form_title width=50><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "mi_state", "asc", '') . "'>����</a></td>
					<td class=list_form_title width=80 align=right><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "mi_milage", "asc", '') . "'>�ݾ�</a></td>
					<td class=list_form_title width=65>����</td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
				$list_info
				$ppb_link[0]				
			</table>
		</td>
	</tr>
	<tr>
		<td>
			
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));

echo("
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		check_field(form.mb_id, 'ȸ�� ���̵� �˻��ϼ���', '', '#EDFBFF');
		check_field(form.mi_memo, '�����޸� �Է��ϼ���', '', '#EDFBFF');
		check_field(form.mi_milage, '�����ݾ��� �Է��ϼ���', '', '#EDFBFF');
		if (errmsg != '') {
			alert(errmsg);
			errmsg = '';
			return false;
		}
	}
	function verify_delete(mi_id) {
		if (confirm('�����Ͻ� ������ �����Ͻðڽ��ϱ�?')) {
			form = document.frm;
			form.mode.value = 'cm_delete';
			form.mi_id.value = mi_id;
			form.submit();
		}
	}
//-->
</script>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_contents</td>
	</tr>
</table>
");
include "{$DIRS[designer_root]}footer.inc.php";
?>