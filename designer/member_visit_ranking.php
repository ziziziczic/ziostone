<?
require "header.inc.php";

// ���� ��ŷ ����
$query = "delete from $DB_TABLES[member_visit_ranking]";
$result = $GLOBALS[lib_common]->querying($query);

$colspan = 8;
$search_item_array = array("A"=>"���հ˻�", "id"=>"���̵�", "name"=>"����", "phone;phone_mobile;phone_fax"=>"��ȭ��ȣ", "email"=>"�̸���", "biz_company"=>"ȸ���", "introduce"=>"�Ұ�", "jumin_number"=>"�ֹι�ȣ", "address"=>"�ּ�", "recommender"=>"��õ��", "admin_memo"=>"�����޸�");
$search_item_array_date = array("visit_date"=>"�α��αⰣ");
$option_boxs = array();
$gender_array = $GLOBALS[lib_common]->parse_property($GLOBALS[VI][DD_gender], "\\n", $GLOBALS[DV][ct2], '', 'N', 'N');
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($gender_array, "SCH_gender", $_GET[SCH_gender], 'Y', "class='designer_select' style='width:50px'", "����");
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "visit_date";			// �Ⱓ�˻� �⺻ �ʵ�
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"date");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
$T_sub_query[] = "{$DB_TABLES[member_visit]}.serial_member={$DB_TABLES[member]}.serial_num";
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$query = "select *, count(serial_log) as count_serial_log from {$DB_TABLES[member_visit]}, {$DB_TABLES[member]}{$sub_query} group by serial_num";
$result = $GLOBALS[lib_common]->querying($query);
while ($value = mysql_fetch_array($result)) {
	$record_info = array();
	$record_info[serial_member] = $value[serial_num];
	$record_info[visit_total] = $value[count_serial_log];
	$GLOBALS[lib_common]->input_record($DB_TABLES[member_visit_ranking], $record_info);
}
$T_sub_query = array();
$T_sub_query[] = "{$DB_TABLES[member_visit_ranking]}.serial_member={$DB_TABLES[member]}.serial_num";
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("visit_total");
$sort_sequence = array("desc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
$query = "select * from {$DB_TABLES[member_visit_ranking]}, {$DB_TABLES[member]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_log)");
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[member];
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_member_visit_log($query, $ppb_link[1][0], $view_ppa, $_GET[page], "ranking", $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>�˻����</b> - " . number_format($ppb_link[1][0]) . " ��</font></td>
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
					<td class=list_form_title width='40' height='30'>����</td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "id", "asc", '') . "'>���̵�</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>����</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "user_level", "asc", '') . "'>����</a></td>
					<td class=list_form_title width=95><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "phone", "asc", '') . "'>��ȭ��ȣ</a></td>
					<td class=list_form_title width=95><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "phone_mobile", "asc", '') . "'>�޴���</a></td>
					<td class=list_form_title><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "email", "asc", '') . "'>�̸���</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "visit_total", "asc", '') . "'>�湮��</a></td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
					$list_info
					$ppb_link[0]
			</table>
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));
echo($P_contents);
include "footer.inc.php";
?>