<?
include "./header.inc.php";

$colspan = "11";
$T_sub_query = array();
$search_item_array = array("A"=>"통합검색", "name"=>"배너명", "title"=>"타이틀", "comment"=>"내용", "link_url"=>"링크주소", "serial_service_item"=>"상품번호", "serial_member"=>"회원번호");
$search_item_array_date = array("banner_close"=>"종료일", "banner_open"=>"시작일", "date_sign"=>"등록일", "date_modify"=>"수정일");

if ($_GET[sch_method] != '') $sch_method = $_GET[sch_method];
else $sch_method = $IS_sch_method;
if ($_GET[sch_kw_top] != '') $_GET[search_keyword] = $_GET[sch_kw_top];
if (trim($_GET[search_keyword]) != '') {
	$T_exp = explode($IS_sch_divider, $_GET[search_keyword]);
	$sub_query_1 = array();
	for ($T_i=0; $T_i<sizeof($T_exp); $T_i++) {
		switch ($_GET[search_item]) {
			case "A" :
				$sub_query_1[] = "(name like '%{$T_exp[$T_i]}%')";
			break;
			case "serial_service_item" :
			case "serial_member" :
				$sub_query_1[] = "{$_GET[search_item]}='{$T_exp[$T_i]}'";
			default :
				$sub_query_1[] = "{$_GET[search_item]} like '%$T_exp[$T_i]%'";
			break;
		}
	}
	$T_sub_query[] = '(' . implode(" {$sch_method} ", $sub_query_1) . ')';
}
if (trim($_GET[search_date]) != '') {
	$sub_query_1 = array();
	$sch_date = explode("~", $_GET[search_date]);							// 범위 구분
	$ymd = explode("-", $sch_date[0]);
	$sch_start_date = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
	$ymd = explode("-", $sch_date[1]);
	$sch_end_date = mktime(0, 0, 0, $ymd[1], $ymd[2]+1, $ymd[0]);
	$T_sub_query[] = "{$_GET[search_item_date]}>=$sch_start_date and {$_GET[search_item_date]}<$sch_end_date";
}
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("date_sign");
$sort_sequence = array("desc");
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
						<table cellpadding=3 border=0 cellspacing=0>
						<form name=frm_sch_member action='$PHP_SELF' method='get'>
							<tr>
								<td>$P_item_codes[0] $P_item_codes[1] $P_item_codes[2]</td>
								<td>
									" . $GLOBALS[lib_common]->get_list_boxs_array($search_item_array, "search_item", $_GET[search_item], "N", "class=designer_select") . "
								</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($_GET[search_keyword], "search_keyword", "text", "size=20 class='designer_text'", "") . "
								</td>
								<td>
									" . $GLOBALS[lib_common]->get_list_boxs_array($search_item_array_date, "search_item_date", $_GET[search_item_date], "Y", " onchange=\"set_keyword(this.form, this)\" class=designer_select", "기간검색") . "
								</td>								
								<td>
									" . $GLOBALS[lib_common]->make_input_box($_GET[search_date], "search_date", "text", "size='25' maxlength='60' class=designer_text", "", "") . "
								</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($view_ppa, "ppa", "text", "size=2 class='designer_text'", "") . "
									<input type='submit' value='검색' class=designer_button>
									<input type='button' value='등록하기' onclick=\"document.location.href='banner_input_form.php?menu=service'\" class=designer_button>
								</td>
							</tr>
						</form>
						</table>
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
					<td class=list_form_title align=left><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "title", "asc", '') . "'>타이틀</a></td>
					<td class=list_form_title width=150 align=left><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>상품명</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "banner_open", "asc", '') . "'>시작일</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "banner_close", "asc", '') . "'>종료일</a></td>
					<td class=list_form_title width=60><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "date_sign", "asc", '') . "'>등록일</a></td>
					<td class=list_form_title width=40><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "buy_qty", "asc", '') . "'>단위</a></td>
					<td class=list_form_title width=40><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "state", "asc", '') . "'>상태</a></td>
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
$P_contents = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));
echo($P_contents);
include "{$DIRS[designer_root]}footer.inc.php";
?>