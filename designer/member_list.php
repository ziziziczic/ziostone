<?
require "header.inc.php";

if ($DIRS[shop_root] != '') {
	$item_title_sm = "<td class=list_form_title width=65>SM</td>";
	$colspan = '9';
} else {
	$colspan = '8';
}
$search_item_array = array("A"=>"���հ˻�", "id"=>"���̵�", "name"=>"����", "phone;phone_mobile;phone_fax"=>"��ȭ��ȣ", "email"=>"�̸���", "biz_company"=>"ȸ���", "introduce"=>"�Ұ�", "jumin_number"=>"�ֹι�ȣ", "address"=>"�ּ�", "recommender"=>"��õ��", "admin_memo"=>"�����޸�");
$search_item_array_date = array("reg_date"=>"������", "rec_date"=>"�α���");
$option_boxs = array();
$skip_user_level_array = array(''=>":: ���ȸ�� ::");																					// �������� ����
$skip_user_level_array = $skip_user_level_array + $lib_insiter->get_level_alias($site_info[user_level_alias], array('N'));	
//$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($skip_user_level_array, "SCH_user_level", $_GET[SCH_user_level], 'N', "class='designer_select'");
$gender_array = $GLOBALS[lib_common]->parse_property($GLOBALS[VI][DD_gender], "\\n", $GLOBALS[DV][ct2], '', 'N', 'N');
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($gender_array, "SCH_gender", $_GET[SCH_gender], 'Y', "class='designer_select' style='width:50px'", "����");
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($S_user_state, "SCH_state", $_GET[SCH_state], 'Y', " class='designer_select' style='width:60px'", "����");
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "reg_date";			// �Ⱓ�˻� �⺻ �ʵ�
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"date");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("reg_date");
$sort_sequence = array("desc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[member];
$query = "select * from {$DB_TABLES[member]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_member_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

if ($_GET[SCH_user_level] == '') {
	$title_page_list = "��ü";
} else {
	$title_page_list = $user_level_alias[$_GET[SCH_user_level]];
}
$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>$title_page_list</b> - " . number_format($ppb_link[1][0]) . " ��</font></td>
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
					<td class=list_form_title width='40' height='30'>��ȣ</td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "id", "asc", '') . "'>���̵�</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>����</a></td>
					<td class=list_form_title><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "email", "asc", '') . "'>�̸���</a></td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "user_level", "asc", '') . "'>����</a></td>
					$item_title_sm
					<td class=list_form_title width=75><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "rec_date", "asc", '') . "'>�����湮��</a></td>
					<td class=list_form_title width=75><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "reg_date", "asc", '') . "'>������</a></td>
					<td class=list_form_title width=100>����</td>
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