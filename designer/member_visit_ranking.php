<?
require "header.inc.php";

// 기존 랭킹 삭제
$query = "delete from $DB_TABLES[member_visit_ranking]";
$result = $GLOBALS[lib_common]->querying($query);

$colspan = 8;
$search_item_array = array("A"=>"통합검색", "id"=>"아이디", "name"=>"성명", "phone;phone_mobile;phone_fax"=>"전화번호", "email"=>"이메일", "biz_company"=>"회사명", "introduce"=>"소개", "jumin_number"=>"주민번호", "address"=>"주소", "recommender"=>"추천인", "admin_memo"=>"관리메모");
$search_item_array_date = array("visit_date"=>"로그인기간");
$option_boxs = array();
$gender_array = $GLOBALS[lib_common]->parse_property($GLOBALS[VI][DD_gender], "\\n", $GLOBALS[DV][ct2], '', 'N', 'N');
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($gender_array, "SCH_gender", $_GET[SCH_gender], 'Y', "class='designer_select' style='width:50px'", "성별");
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "visit_date";			// 기간검색 기본 필드
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
					<td><font color='#FF6600'><b>검색결과</b> - " . number_format($ppb_link[1][0]) . " 개</font></td>
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
					<td class=list_form_title width='40' height='30'>순위</td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "id", "asc", '') . "'>아이디</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>성명</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "user_level", "asc", '') . "'>레벨</a></td>
					<td class=list_form_title width=95><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "phone", "asc", '') . "'>전화번호</a></td>
					<td class=list_form_title width=95><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "phone_mobile", "asc", '') . "'>휴대폰</a></td>
					<td class=list_form_title><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "email", "asc", '') . "'>이메일</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "visit_total", "asc", '') . "'>방문수</a></td>
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