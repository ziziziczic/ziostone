<?
// 일반 페이지 검색
if (trim($_POST[vg_sch_keyword_total]) == '' && $PHP_SELF != "/page_designer_view.php") $GLOBALS[lib_common]->alert_url("키워드를 입력하세요");
$s_kw = $_POST[vg_sch_keyword_total];
$query = "select * from $DB_TABLES[design_files] where type='U'";
$result = $GLOBALS[lib_common]->querying($query);

while ($page_info = mysql_fetch_array($result)) {
}

// 게시판 검색
$sch_result = '';
$query = "select * from $DB_TABLES[board_list]";
$result = $GLOBALS[lib_common]->querying($query);
while ($board_info = mysql_fetch_array($result)) {
	$sch_result_1 = '';
	$query = "select * from $DB_TABLES[board]_{$board_info[name]} where name like '%{$s_kw}%' or subject like '%{$s_kw}%' or comment_1 like '%{$s_kw}%' or comment_2 like '%{$s_kw}%' or etc_1 like '%{$s_kw}%' or etc_2 like '%{$s_kw}%' or etc_3 like '%{$s_kw}%'";
	$result_1 = $GLOBALS[lib_common]->querying($query);
	while ($article_info = mysql_fetch_array($result_1)) {
		$sch_result_1 .= "{$article_info[name]} / {$article_info[subject]} {$article_info[comment_1]} {$article_info[comment_2]} {$article_info[etc_1]} {$article_info[etc_2]} {$article_info[etc_3]}";
		$sch_result_1 = $GLOBALS[lib_common]->str_cutstring($sch_result_1, 350, "...<br><br>");
		$sch_result_1 = str_replace($s_kw, "<font color=blue><b>$s_kw</b></font>", $sch_result_1);
		$sch_result_1 = "<a href='insiter.php?design_file=$board_info[view_page]&article_num=$artcle_info[serial_num]'>{$sch_result_1}</a>";
	}
	if ($sch_result_1 != '') {
		$sch_result_1 = "<b><u>* 코너명 : <a href='insiter.php?design_file=$board_info[list_page]'><b><u>$board_info[alias]</u></b></u></b></a><br>" . $sch_result_1;
		$sch_result .= $sch_result_1;
	}
}
if ($sch_result == '') $sch_result = "<center>'<b>$s_kw</b>' 로 검색된 내용이 없습니다.</center>";
echo(stripslashes($sch_result));
?>


<?
/*	검색어 입력 폼
echo("
<script language='javascript1.2'>
<!--
	function verify_sch_total(form) {
		if (form.vg_sch_keyword_total.value == '') {
			alert('검색어를 입력하세요.');
			form.vg_sch_keyword_total.focus();
			return false;
		}
	}
//-->
</script>
<table cellpadding=2 cellspacing=0 border=0>
<form name=frm_sch_total method=post action='insiter.php?design_file=2687.php' onsubmit='return verify_sch_total(this)'>
	<tr>
		<td>" . $GLOBALS[lib_common]->make_input_box($_POST[vg_sch_keyword_total], "vg_sch_keyword_total", "text", "class=mokyang-box size=12", '') . "</td>
		<td><input type=image src=design/images/login_btn_find.gif border=0 align=absmiddle>
	</tr>
</form>
</table>
");
*/
?>