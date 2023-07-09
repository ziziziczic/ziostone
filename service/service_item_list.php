<?
include "./header.inc.php";
$colspan = '8';
$search_item_array = array("A"=>"통합검색", "name"=>"서비스명");
$search_item_array_date = array("date_sign"=>"등록일");
$option_boxs = array();
// 서비스 종류 선택상자 설정
$property = array(
	"name_1"=>"SCH_code_table_name",
	"property_1"=>"class=designer_select style='width:70px'",
	"default_value_1"=>$_GET[SCH_code_table_name],
	"name_2"=>"SCH_code_field_name",
	"property_2"=>"class=designer_select style='width:70px'",
	"default_value_2"=>$_GET[SCH_code_field_name],
	"default_title_1"=>":: 분류 ::",
	"default_title_2"=>":: 유형 ::"
);
$P_item_codes = $GLOBALS[lib_common]->get_item_select_box($SI_item_table, $SI_item_field, $property);
$option_boxs[] = $P_item_codes[0];
$option_boxs[] = $P_item_codes[1];
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "date_sign";			// 기간검색 기본 필드
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs, $P_item_codes[2]);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"sign");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("date_sign");
$sort_sequence = array("desc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[service];
$query = "select * from {$DB_TABLES[service_item]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIRS[designer_root]}images/");
$list_info = get_service_item_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><b><font color='#FF6600'>서비스목록</font></b></td>
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
					<td class=list_form_title width=45 height=30><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "serial_num", "asc", '') . "'>번호</a></td>
					<td class=list_form_title width=70><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "code_table_name", "asc", '') . "'>분류</a></td>
					<td class=list_form_title width=70><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "code_field_name", "asc", '') . "'>유형</a></td>
					<td class=list_form_title><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>서비스 상품명</a></td>
					<td class=list_form_title width=85 align=right><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "price", "asc", '') . "'>판매가</a></td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "unit_code", "asc", '') . "'>단위</a></td>
					<td class=list_form_title width=65><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "state", "asc", '') . "'>사용</a></td>
					<td class=list_form_title width=88>관리</td>
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
include "{$DIRS[designer_root]}footer.inc.php";
?>