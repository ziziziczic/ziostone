<?
/*----------------------------------------------------------------------------------
 * 제목 : 회원 검색 페이지
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "./include/header_member.inc.php";

// 관리자전용
$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_admin], $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

$select_it = $P_hidden = '';
$define_function_ele = $call_function_ele = array();
while (list($key, $value) = each($_GET)) {
	if (substr($key, 0, 3) == "nm_") {
		$field_name = substr($key, 3);
		$call_function_ele[] = "$field_name";		
		$select_it .= "
			var $key = eval('opener.document.all.$value');
			$key.value = $field_name;
		";
		$P_hidden .= "<input type='hidden' name='$key' value='$value'>\n";
	}	
}
if (sizeof($call_function_ele) > 0) $P_call_function_ele = implode(',', $call_function_ele);

$colspan = '7';
$search_item_array = array("A"=>"통합검색", "id"=>"아이디", "name"=>"성명", "phone"=>"전화번호", "address"=>"주소", "serial_num"=>"회원번호");
$search_level_array = $lib_insiter->get_level_alias($site_info[user_level_alias], array('N', 'Y'));

$T_sub_query = array();
if ($_GET[search_level] != '') $T_sub_query[] = "user_level='$search_level'";
if (trim($_GET[search_keyword]) != '') {
	$T_exp = explode(',', $_GET[search_keyword]);
	$sub_query_1 = array();
	for ($T_i=0; $T_i<sizeof($T_exp); $T_i++) {
		switch ($_GET[search_item]) {
			case "A" :
				$sub_query_1[] = "(id like '%{$T_exp[$T_i]}%' or name like '%{$T_exp[$T_i]}%' or phone like '%{$T_exp[$T_i]}%' or phone_mobile like '%{$T_exp[$T_i]}%' or phone_fax like '%{$T_exp[$T_i]}%' or address like '%{$T_exp[$T_i]}%')";
			break;
			case "phone" :
				$sub_query_1[] = "phone like '%{$T_exp[$T_i]}%' or phone_mobile like '%{$T_exp[$T_i]}%' or phone_fax like '%{$T_exp[$T_i]}%'";
			break;
			case "serial_num" :
				$sub_query_1[] = "{$_GET[search_item]}='{$T_exp[$T_i]}'";
			break;
			default :
				$sub_query_1[] = "{$_GET[search_item]} like '%{$T_exp[$T_i]}%'";
			break;
		}
	}
	$T_sub_query[] = '(' . implode(" {$sch_method} ", $sub_query_1) . ')';
}
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("name");
$sort_sequence = array("asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $GLOBALS[VI][ppa];
$query = "select * from {$DB_TABLES[member]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $GLOBALS[VI][ppb], $_GET[page], $style, $font, "{$DIRS[designer_root]}images/");
$list_info = $lib_insiter->get_member_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], "sch_member", $colspan, $call_function_ele);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}

$P_contents_title = "
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td><b>총 <font color='#FF6600'>" . number_format($ppb_link[1][0]) . " 개</font> 결과 검색됨</b></td>
		<td align=right>
			<table cellpadding=3 border=0 cellspacing=0>
			<form name=frm_sch_member action='$PHP_SELF' method='get'>
			$P_hidden
				<tr>
					<td>
						" . $GLOBALS[lib_common]->get_list_boxs_array($search_level_array, "search_level", $_GET[search_level], "Y", "class=designer_select") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->get_list_boxs_array($search_item_array, "search_item", $_GET[search_item], "N", "class=designer_select") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($_GET[search_keyword], "search_keyword", "text", "size=20 class='designer_text'", "") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($view_ppa, "ppa", "text", "size=2 class='designer_text'", "") . "
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
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<form name=frm method='post'>
	<tr>
		<td width='100%' align='center'>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align=center>
					<td class=list_form_title width=40 height=30>선택</td>
					<td class=list_form_title width=50><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "serial_num", "asc", '') . "'>번호</a></td>
					<td class=list_form_title width=80><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "id", "asc", '') . "'>아이디</a></td>
					<td class=list_form_title width=70><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "name", "asc", '') . "'>성명</a></td>
					<td class=list_form_title><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "email", "asc", '') . "'>이메일</a></td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "phone_mobile", "asc", '') . "'>휴대폰</a></td>
					<td class=list_form_title width=90><a href='" . $GLOBALS[lib_common]->get_sort_link("SI_F_", "user_level", "asc", '') . "'>레벨</a></td>
				</tr>
				<tr><td align='center' bgcolor='#CABE8E' colspan='$colspan' height='1'></td></tr>
					$list_info
					$ppb_link[0]
			</table>
		</td>
	</tr>
	</form>
</table>
";
$P_contents = $lib_insiter->w_get_img_box("thin_skin_round_title", $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));

echo("
<html>
<head>
<title>회원검색 프로그램</title>
$html_header
<script language='javascript'>
<!--
function select_member($P_call_function_ele) {
	if (!confirm('선택하시겠습니까?')) return false;
	$select_it
	window.close();
}
//-->
</script>
<body>
$P_contents
</body>
</html>
");
?>