<?
include "./header.inc.php";

$colspan = "12";

$search_item_array = array("A"=>"통합검색", "name"=>"배너명", "title"=>"타이틀", "contents"=>"내용", "link_url"=>"링크주소", "serial_service_item"=>"상품번호", "serial_member"=>"회원번호");
$search_item_array_date = array("banner_close_date"=>"종료일", "banner_open_date"=>"시작일", "sign_date"=>"등록일", "modify_date"=>"수정일");
$option_boxs = array();
if ($_GET[search_item_date] == '') $_GET[search_item_date] = "banner_close_date";			// 기간검색 기본 필드
$P_search_box = $lib_insiter->get_search_input_boxs($search_item_array_date, $search_item_array, $option_boxs, $P_item_codes[2]);
$sch_info = array("method"=>$_GET[search_method], "head"=>"SCH_", "tail_date"=>"date");
$T_sub_query = $GLOBALS[lib_common]->get_query_search_all($sch_info, $_GET[search_item], $_GET[search_keyword], $search_item_array);
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("banner_close_date");
$sort_sequence = array("asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[service];
$query = "select * from {$DB_TABLES[banner]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIRS[designer_root]}images/");
$list_info = get_banner_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
			<script language='javascript1.2'>
			<!--
			function set_keyword(form, obj) {
				if (obj.value != '') form.search_date.value = '$set_term_this_month';
				else form.search_date.value = '';
			}
			//-->
			</script>
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><b><font color='#FF6600'>배너목록</font></b></td>
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
					<td class=list_form_title width=50><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "serial_num", "asc", '') . "'>사진</a></td>
					<td class=list_form_title align=left><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "title", "asc", '') . "'>타이틀</a></td>
					<td class=list_form_title width=150 align=left><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>상품명</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "banner_open_date", "asc", '') . "'>시작일</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "banner_close_date", "asc", '') . "'>종료일</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "sign_date", "asc", '') . "'>등록일</a></td>
					<td class=list_form_title width=40><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "buy_qty", "asc", '') . "'>단위</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "state", "asc", '') . "'>상태</a></td>
					<td class=list_form_title width=50><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "state_alarm", "asc", '') . "'>만료일</a></td>
					<td class=list_form_title width=50><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "serial_member", "asc", '') . "'>광고주</a></td>
					<td class=list_form_title width=65>관리</td>
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