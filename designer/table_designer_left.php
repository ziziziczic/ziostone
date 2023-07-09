<?
include "header_sub.inc.php";

require "{$DIRS[designer_root]}include/class.tree/class.tree.php";
$tree = new Tree("{$DIRS[designer_root]}include/class.tree");
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);

$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0];
$line = $lib_fix->search_index($design, "테이블", $location);

// 폼이 중첩되지 않도록 상위,하위, 현재 테이블에 폼 설정이 되어 있는지 점검한다.
// CFS => Current table Form Setup, PFS => Parent table Form Setup, ChFs => Child table Form Setup
$CFS = $lib_fix->search_current_form($design, $line[0], 4);
$PFS = $lib_fix->search_parent_form($design, $line[0]-1, "테이블", 4);
$ChFS = $lib_fix->search_child_form($design, "테이블", $line[0]+1, $line[1], 4);
if ((is_array($CFS) && is_array($PFS)) || (is_array($CFS) && is_array($ChFS)) || (is_array($PFS) && is_array($ChFS))) {
	die("폼 속성이 중첩되어 있습니다. 현재테이블 : $CFS , 상위테이블 : $PFS , 하위테이블 : $ChFS , 이 창을 닫고 되돌리기를 시도해 보십시오.");
}	// 연관된 테이블(상위, 현재, 하위)에서 두개 이상의 폼이 동시에 나오면 에러
?>
<script language='javascript1.2'>
<!--
function verify(link, mode) {
	switch (mode) {
		case 'object' :
			msg = '선택하신 항목을 삭제합니다.';
		break;
	}
	if (confirm(msg)) {
		document.location.href = link;
	}
}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<tr valign='top'> 
		<td> 
			<table width='100%' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr>
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'><b>테이블 디자이너</b></font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='100%' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>
					<td valign='top'>
<?
$tree_root  = $tree->open_tree ("테이블정보", "table_designer_view.php?design_file=$design_file&index=$index");

//$table_edit = $tree->add_folder ($tree_root, "레이아웃관리", "");
$tree->add_document($tree_root, "표편집(TABLE)", "page_designer_table_form.php", "design_file=$design_file&index=$index&current_line=$current_line","2","","");
$tree->add_document($tree_root, "줄편집(TR)", "table_tr_form.php", "design_file=$design_file&index=$index&parent=table&depth1=table&depth2=modify","2","","");
$tree->add_document($tree_root, "칸편집(TD)", "table_td_form.php", "design_file=$design_file&index=$index&parent=table&depth1=table&depth2=modify","2","","");

// 테이블에 아무 설정도 되어 있지 않으면 설정 가능한 모든 기능을 보여준다.
if (($CFS == "CURRENT_NOT_FOUND") && ($PFS == "PARENT_NOT_FOUND") && ($ChFS == "CHILD_NOT_FOUND")) {
	$form_tag = $tree->add_folder ($tree_root, "게시판/로그인/회원가입", "");
	$tree->add_document($form_tag, "게시판디자인", "table_board_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_BOARD&form_line=$line[0]","2","","");
	$tree->add_document($form_tag, "로그인폼디자인", "table_login_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_LOGIN&form_line=$line[0]","2","","");
	$tree->add_document($form_tag, "회원가입디자인", "table_member_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_MEMBER&form_line=$line[0]","2","","");
} else {	// 테이블에 어떤 설정이 되어 있는 경우
	if (!is_array($ChFS)) {	// 상위 또는 현재 테이블에 기능이 설정되어 있을 경우 기능 구현 가능, 하위테이블에는 불가.
		if (is_array($CFS)) {
			$form_value = $CFS;
			$form_line = $line[0];
		} else {
			$form_value = $PFS;
			while (list($key, $value) = each($form_value)) $form_line = $value;	// 맨 마지막으로 나오는 값을 취한다.
		}
		if ($form_value[4] == "TC_BOARD") {	// 현재 테이블에 게시판 설정이 되어 있는 경우
			$exp = explode(':', $form_value[5]);
			$board = $tree->add_folder ($tree_root, "게시판도구모음", '');
			$tree->add_document($board, "항목삽입", "table_board_article_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&board_name={$exp[0]}","2","","");
			$tree->add_document($board, "입력상자", "table_board_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&form_type={$exp[1]}","2","","");
			$tree->add_document($board, "버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");
			$tree->add_document($board, "설정수정", "table_board_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_BOARD&form_line=$form_line","2","","");
		} else if ($form_value[4] == "TC_MEMBER") {	// 현재 테이블에 회원폼 설정이 되어 있는 경우
			$member = $tree->add_folder ($tree_root, "회원도구모음", "");
			$tree->add_document($member, "회원정보삽입", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($member, "입력상자", "table_member_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($member, "버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=member","2","","");
			$tree->add_document($member, "설정수정", "table_member_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_MEMBER&form_line=$form_line","2","","");
		} else if ($form_value[4] == "TC_LOGIN") {	// 현재 테이블에 로그인폼 설정이 되어 있는 경우
			$login = $tree->add_folder ($tree_root, "로그인도구모음", "");
			$tree->add_document($login, "회원정보삽입", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($login, "입력상자", "table_login_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
			$tree->add_document($login, "버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=login","2","","");
			$tree->add_document($login, "설정수정", "table_login_form.php", "design_file=$design_file&index=$index&cpn=$cpn&mode=TC_LOGIN&form_line=$form_line","2","","");
		}
	}
}
$tree->add_document($tree_root, "버튼넣기", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "글자(TAG)넣기", "{$root}table_tag_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "그림넣기", "table_image_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "플래시넣기", "table_flash_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($tree_root, "외부파일&명령&컨텐츠", "table_import_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
if($cpn != '0') $tree->add_document($tree_root, "<a href=javascript:verify('table_designer_manager.php?design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=delete_object','object')>항목삭제</a>", "", "","4","","");
$template = $tree->add_folder ($tree_root, "템플릿전용", '');
$tree->add_document($template, "게시판항목삽입", "table_board_article_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&board_name={$exp[0]}","2","","");
$tree->add_document($template, "게시판입력상자", "table_board_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&form_type={$exp[1]}","2","","");
$tree->add_document($template, "게시판버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");
$tree->add_document($template, "반복설정", "table_board_repeat_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=board","2","","");

$tree->add_document($template, "회원정보삽입", "table_member_info_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "회원입력상자", "table_member_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "회원버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=member","2","","");

$tree->add_document($template, "로그인입력상자", "table_login_input_box_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line","2","","");
$tree->add_document($template, "로그인버튼삽입", "table_button_form.php", "design_file=$design_file&index=$index&cpn=$cpn&current_line=$current_line&mode=login","2","","");

$tree->close_tree();
?>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr>
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?
include "footer_sub.inc.php";
?>