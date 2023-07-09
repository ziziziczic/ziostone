<?
require "header.inc.php";

$colspan = '9';
$T_sub_query = array();
if ($_SESSION[dfg] != '') $T_sub_query[] = "design_file_group='$_SESSION[dfg]'";
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("alias");
$sort_sequence = array("asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
if ($_GET[ppa] != '') $view_ppa = $_GET[ppa];
else $view_ppa = $IS_ppa[board];
$query = "select * from {$DB_TABLES[board_list]}{$sub_query}{$sort_method}";
$query_ppb = $GLOBALS[lib_common]->get_ppb_query($query, "select count(serial_num)");
$ppb_link = $GLOBALS[lib_common]->get_page_block($query_ppb, $view_ppa, $IS_ppb, $_GET[page], $style, $font, "{$DIR[designer_root]}images/");
$list_info = $lib_insiter->get_board_list($query, $ppb_link[1][0], $view_ppa, $_GET[page], '', $colspan);
if ($ppb_link[0] != '') {
	$ppb_link[0] = "
				<tr><td colspan=$colspan bgcolor='#FFFFFF' align=center>$ppb_link[0]</td></tr>
	";
}
$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>게시판목록</b> - {$ppb_link[1][0]} Boards</font></td>
					<td>$design_group</td>
				</tr>
			</table>
";
$P_contents = "
<script language='javascript1.2'>
<!--
function verify_delete(board_name) {
	if (confirm('게시판 프로그램과 모든 게시물이 삭제됩니다.\\n삭제된정보는 복구할 수 없습니다.\\n\\n게시판을 삭제하시려면 확인 버튼을 누르십시오')) {
		document.location.href = 'board_manager.php?board_name=' + board_name + '&mode=delete';
	}
}
//-->
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%' height='16' align='center'>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align=center>
					<td class=list_form_title width=40 height=30>번호</td>
					<td class=list_form_title>이름</td>
					<td class=list_form_title width=70>DB Table</td>
					<td class=list_form_title width=100>관리자ID</td>
					<td class=list_form_title width=90>권한</td>
					<td class=list_form_title width=70>게시물</td>
					<td class=list_form_title width=80>생성일</td>
					<td class=list_form_title width=100>디자인</td>
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


$help_msg = "
디자인 '수정' : 해당게시판 '목록페이지'의 디자인 편집화면으로 이동
디자인 '보기' : 실제 화면보기 (실제화면 보기시 '디자인 파일이 없습니다' 라고 나오는 경우 게시판 스킨을 다시 지정해 주세요.
디자인 '템플릿' : 해당 게시판 디자인을 다른 홈페이지에서 그대로 사용 할 수 있도록 합니다. {$DIRS[template]} 내에 각 디렉토리별로 관리 됩니다.
관리 '속성' : 게시판의 타이틀, 각 페이지별속성 일괄 수정, 필터링단어, 분류(category), 아이콘등을 정의 합니다.
관리 '삭제' : 게시판의 DB 테이블 및 파일, 게시물등을 모두 삭제 합니다.
<font color=red>※ 게시판을 삭제하시면 홈페이지 운영이 원활하지 못할 수 있습니다. 확실하지 않은경우 절대 삭제하지 마세요.</font>
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_contents</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td></td>
	</tr>$P_table_form_help
</table>
");
include "footer.inc.php";
?>