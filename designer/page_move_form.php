<?
/*----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
include "header_sub.inc.php";

$design_file_info = $GLOBALS[lib_common]->get_data($DB_TABLES[design_files], "file_name", $design_file);

$colspan = '5';
$T_sub_query = array();
$T_sub_query[] = "file_name<>'{$design_file_info[file_name]}'";																							// 선택페이지 출력안함
$T_sub_query[] = "(fid<>'{$design_file_info[fid]}' or thread not like '{$design_file_info[thread]}%')";				// 선택페이지 하위출력안함
$sub_query = $GLOBALS[lib_common]->get_sub_query($T_sub_query);
$sort_field = array("fid", "thread", "name");
$sort_sequence = array("desc", "asc", "asc");
$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
$query = "select * from {$DB_TABLES[design_files]}{$sub_query}{$sort_method}";
$list_info = $lib_insiter->get_page_list($query, 0, 0, '', "move", $colspan);
$P_contents = "
<script language='javascript'>
<!--
	function verify_move(selected_design_name, selected_design_file) {
		if (confirm('\'{$site_page_info[name]}\' 을 \'' + selected_design_name + '\' ' + '의 \'하위\'' + '로 이동하시겠습니까?\\n\\n이동을 원하시면 확인을 클릭하세요.')) {
			form = document.frm;
			form.design_file_parent.value = selected_design_file;
			form.submit();
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
	<form name='frm' method='post' action='page_manager.php'>
	<input type='hidden' name='design_file' value='$_GET[design_file]'>
	<input type='hidden' name='design_file_parent' value=''>
	<input type='hidden' name='mode' value='move'>
	<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<tr>
		<td>
			<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
				<tr align='center'>
					<td class=list_form_title width='40' height='30'>번호</td>
					<td class=list_form_title align='center'>이름</td>
					<td class=list_form_title width='45'>하위</td>
					<td class=list_form_title width='90'>파일명</td>
					<td class=list_form_title width='80'>스킨</td>
				</tr>
				<tr bgcolor='#F8F5F0'>
					<td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>[+] Root</b></td>
					<td align=center><a href=\"javascript:verify_move('Root', '')\">{$IS_btns[move]}</a></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				$list_info
			</table>
		</td>
	</tr>
	</form>
</table>
";

$P_contents = $lib_insiter->w_get_img_box($IS_thema_window, $P_contents, $IS_input_box_padding, array("title"=>"<b>이동할 페이지 선택</b>"));

$help_msg = "
Navi 링크 : 네비게이션 링크주소 설정<br>
소속메뉴, 그룹명 : 출력제한 설정을 해 둔 부분이 보일 수 있도록 상황에 맞게 지정.<br>
업로드경로 : 이미지 또는 플래시파일등을 첨부시 업로드 되는 경로 지정<br>
에러이동, 문구 : 열람권한 오류시, 이동할 페이지 및 메시지<br>
복사 : 다른 디자인 파일의 내용 및 헤더, 바디 태그등을 불러옵니다. <font color=red>(기존 내용이 삭제되니 주의하세요)</font><br>
템플릿 : 템플릿 파일의 내용 및 헤더, 바디 태그 등을 불러옵니다. <font color=red>(기존 내용이 삭제되니 주의하세요)</font>
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_contents</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>