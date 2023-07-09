<?
require "header.inc.php";


$colspan = '7';
$T_sub_query = array();
if ($_GET[G_user_level] != '') $T_sub_query[] = "user_level='$_GET[G_user_level]'";
$search_item_array = array("A"=>"통합검색", "subject"=>"제목", "contents"=>"내용");
if ($_GET[sch_method] != '') $sch_method = $_GET[sch_method];
else $sch_method = $IS_sch_method;
if (trim($_GET[search_keyword]) != '') {
	$T_exp = explode($IS_sch_divider, $_GET[search_keyword]);
	$sub_query_1 = array();
	for ($T_i=0; $T_i<sizeof($T_exp); $T_i++) {
		switch ($_GET[search_item]) {
			case "A" :
				$sub_query_1[] = "(subject like '%{$T_exp[$T_i]}%' or contents like '%{$T_exp[$T_i]}%')";
			break;
			default :
				$sub_query_1[] = "$_GET[search_item] like '%$T_exp[$T_i]%'";
			break;
		}
	}
	$T_sub_query[] = '(' . implode(" {$sch_method} ", $sub_query_1) . ')';
}
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("reg_date");
$sort_sequence = array("desc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[popup];
$query = "select * from {$DB_TABLES[popup]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_popup_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>팝업목록</b> - " . number_format($ppb_link[1][0]) . " 개</font></td>
					<td align=right>
						<table cellpadding=3 border=0 cellspacing=0>
						<form name=frm_sch_member action='$PHP_SELF' method='get'>
							<tr>
								<td>
									" . $GLOBALS[lib_common]->get_list_boxs_array($search_item_array, "search_item", $_GET[search_item], "N", "class=designer_select") . "
								</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($_GET[search_keyword], "search_keyword", "text", "class='designer_text'", "") . "
								</td>
								<td>
									<input type='submit' value='검색' class=designer_button>
								</td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
			</table>
";

$P_contents = "
<script language='javascript1.2'>
<!--
function verify_delete(serial_num) {
	if (confirm('삭제한 정보는 복구 할 수 없습니다. 삭제하시겠습니까?')) {
		document.location.href = 'popup_manager.php?serial_num=' + serial_num + '&mode=delete';
	}
}
//-->
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' height='16' align='center'>
			<table border='0' cellpadding='5' cellspacing='1'  width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align=center>
					<td class=list_form_title width=40 height='30'>번호</td>
					<td class=list_form_title>제목</td>
					<td class=list_form_title width='100'>적용</td>
					<td class=list_form_title width='70'>종류</td>
					<td class=list_form_title width='130'>시작일시</td>
					<td class=list_form_title width='130'>종료일시</td>
					<td class=list_form_title width=65>관리</td>
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
