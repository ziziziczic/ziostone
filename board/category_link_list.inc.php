<?
// 디자인 관리에서 해당 페이지에 게시판 설정이 되어 있어야 함.

$CLL_category_1 = $GLOBALS[lib_common]->parse_property($board_info[category_1], $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
$CLL_category_2 = $GLOBALS[lib_common]->parse_property($board_info[category_2], $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');

$T_list = array();
while (list($key, $value) = each($CLL_category_1)) {
	$query = "select count(serial_num) from {$DB_TABLES[board]}_{$board_info[name]} where category_1='$key'";
	$result = $GLOBALS[lib_common]->querying($query);
	$category_article_nums = mysql_result($result, 0, 0);
	if ($_GET[category1] == $key) {
		$T_bold_open = "<b>";
		$T_bold_close = "</b>";
	} else {
		$T_bold_open = '';
		$T_bold_close = '';
	}
	$T_list[] = "<a href='{$site_info[index_file]}?design_file=$board_info[list_page]&category1=$key'>{$T_bold_open}$value($category_article_nums){$T_bold_close}</a>";
}
$P_category_1 = implode(" | ", $T_list);

$T_list = array();
$code_head_nums = strlen($_GET[category1]);
if ($_GET[category1] != '') {
	while (list($key, $value) = each($CLL_category_2)) {
		if ($_GET[category1] == substr($key, 0, $code_head_nums)) {
			$query = "select count(serial_num) from {$DB_TABLES[board]}_{$board_info[name]} where category_1='$_GET[category1]' and category_2='$key'";
			$result = $GLOBALS[lib_common]->querying($query);
			$category_article_nums = mysql_result($result, 0, 0);
			if ($_GET[category2] == $key) {
				$T_bold_open = "<b>";
				$T_bold_close = "</b>";
			} else {
				$T_bold_open = '';
				$T_bold_close = '';
			}
			$T_list[] = "<a href='{$site_info[index_file]}?design_file=$board_info[list_page]&category1=$_GET[category1]&category2=$key'>{$T_bold_open}$value($category_article_nums){$T_bold_close}</a>";
		}
	}
	if (sizeof($T_list) > 0) {
		$P_category_2 = "
			<tr><td><hr size=1 width=100%></td></tr>
			<tr>
				<td>" . implode(" | ", $T_list) . "</td>
			</tr>
		";
	}
}

$CLL_category_box = "
	<table width=100% cellapdding=5 cellspacing=0 border=0>
		<tr>
			<td>$P_category_1</td>
		</tr>
		$P_category_2
	</table>
";

// 사용자정의부
$CLL_category_box = $lib_insiter->w_get_img_box("halfsurface_gray_sq", $CLL_category_box, 5);
switch ($board_info[name]) {
	case "3009";
		$CLL_title_img = "images/title_02_01.gif";
	break;
	case "3017";
		$CLL_title_img = "images/title_03_01.gif";
	break;
}

$P_contents = "
	<table width=100% cellapdding=0 cellspacing=0 border=0>
		<tr>
			<td><img src='$CLL_title_img' border=0></td>
		</tr>
		<tr><td height=10></td></tr>
		<tr>
			<td>$CLL_category_box</td>
		</tr>
	</table>
";
echo($P_contents);
?>