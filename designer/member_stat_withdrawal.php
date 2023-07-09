<?
require "header.inc.php";

switch ($_GET[view_type]) {
	case 'M' :		// 월별보기
		$length_date_format = 7;
	break;
	case 'D' :		// 일별보기
		$length_date_format = 10;
	break;
	default :		// 년별보기
		$length_date_format = 4;
	break;
}

$colspan = 4;
$search_item_array = array("A"=>"통합검색", "withdrawal_questoin_msg"=>"탈퇴사유", "memo"=>"메모", "member_info"=>"회원기록");
$search_item_array_date = array("withdrawal_date"=>"탈퇴일");
$option_boxs = array();
$view_type_array = array('Y'=>"년별보기", 'M'=>"월별보기", 'D'=>"일별보기");
$option_boxs[] = $GLOBALS[lib_common]->get_list_boxs_array($view_type_array, "view_type", $_GET[view_type], 'N', "class=designer_select style='width:73px'");
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "withdrawal_date";			// 기간검색 기본 필드
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs, "<input type='hidden' name='table_reset' value='Y'>");
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"date");
if ($_GET[table_reset] == 'Y') {
	$query = "TRUNCATE TABLE {$DB_TABLES[member_stat_withdrawal]}";
	$GLOBALS[lib_common]->querying($query);
	$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
	$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
	$sort_field = array("withdrawal_date");
	$sort_sequence = array("asc");
	$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
	$query = "select left(from_unixtime($_GET[search_item_date]), $length_date_format) as sch_date, count(serial_num) as cnt_withdrawal_member, withdrawal_question from {$DB_TABLES[member_withdrawal]}{$sub_query} group by sch_date, withdrawal_question{$sort_method}";
	$result = $GLOBALS[lib_common]->querying($query);
	while ($value = mysql_fetch_row($result)) {
		$record_info = array();
		$record_info[ymd] = $value[0];
		$record_info[cnt_withdrawal] = $value[1];
		$record_info[withdrawal_question] = $value[2];
		$GLOBALS[lib_common]->input_record($DB_TABLES[member_stat_withdrawal], $record_info);
	}
}
$T_sub_query = array();
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("ymd", "withdrawal_question");
$sort_sequence = array("asc", "asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[member];
$query = "select * from {$DB_TABLES[member_stat_withdrawal]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(ymd), max(cnt_withdrawal)");
$change_vars = array("table_reset"=>'');
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/", '', 'N', "page", 'C', $change_vars);
$list_info = $lib_insiter->get_stat_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], "member_withdrawal", $colspan, array("max"=>$ppb_link[1][1]));
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
					<td class=list_form_title width='90'><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "sch_date", "asc", '', 'N', 'N', array("table_reset"=>'')) . "'>년/월/일</a></td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "cnt_join_member", "asc", '') . "'>회원수</a></td>
					<td class=list_form_title>그래프(%)</td>
					<td class=list_form_title align=left><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "cnt_join_member", "asc", '') . "'>탈퇴사유</a></td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
					$list_info[0]
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