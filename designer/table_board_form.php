<?
/*----------------------------------------------------------------------------------
 * 제목 : 인사이트 게시판 항목 삽입 화면
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Han Sang You
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$is_save_list = $is_save_form = $is_save_view = "none";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$_GET[form_line]]);
if ($exp[4] != "") {	// 폼 설정이 있는 경우 설정을 불러온다.
	if ($exp[4] == "TC_BOARD") {
		$exp_bp = explode(":", $exp[5]);
		$board_name = $exp_bp[0];	// 이름
		$form_type = $exp_bp[1];			// 폼타입
		if ($form_type == "LIST") {
			$is_save_list = "visible";
			$query_type = $exp_bp[2];		// 쿼리타입
			$table_per_article = $exp_bp[3];	// 테이블당 출력게시물 수
			$table_per_block = $exp_bp[4];	// 테이블당 출력페이지링크 수
			$line_per_article = $exp_bp[5];		// 한줄당 출력게시물수
			$sort_field = $exp_bp[7];					// 정렬필드
			$sort_sequence = $exp_bp[8];		// 정렬순서
			$user_query = $exp[6];						// 사용자쿼리
			$list_view_mode = $exp_bp[9];		// 출력방식
			$relation_table = $exp_bp[10];		// 관련게시판
		} else if (($form_type == "WRITE") || ($form_type == "MODIFY") || ($form_type == "DELETE") || ($form_type == "REPLY") || ($form_type == "COMMENT")) {
			$is_save_form = "visible";
			$query_next_page = $exp_bp[3];
			$relation_table = $exp_bp[10];		// 관련게시판
			$saved_verify_input = explode("~", $exp_bp[2]);	 // 필수 입력항목
		} else {
			$is_save_view = "visible";
		}
	}
	// 저장되어 있는 테이블이 있는지 확인하고 있으면 이름을 얻어낸다.
	$saved_board_info = $lib_fix->get_board_info($board_name);
}

$query = "select	name, alias from $DB_TABLES[board_list] order by create_date;";		//	생성되어있는 게시판 정보를 불러온다. 
$query_info = array($query, "name", "alias");

$P_table_board_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>게시판선택</td>
		<td>" . $GLOBALS[lib_common]->get_list_boxs_query($query_info, "board_name", $saved_board_info[name], 'N', 'N', "class='designer_select'", '', $default_num_msg=":: 게시판선택 ::") . "</td>
	</tr>
	<tr>
		<td colspan='2'><hr></td>
	</tr>
	<tr> 
		<td height='30' width='80' align='center'>폼타입</td>
		<td>
			<table width='100%'>
				<tr>
					<td width=50%>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('LIST', document.getElementsByTagName('tr'), '')\"", "", "LIST") . "<b>목록보기</b> 양식</td>
					<td width=50%>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('', document.getElementsByTagName('tr'), '')\"", "", "VIEW") . "<b>내용보기</b> 양식</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "WRITE") . "<b>쓰기</b> 양식</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "MODIFY") . "<b>수정</b> 양식</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "REPLY") . "<b>답글쓰기</b> 양식</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "DELETE") . "<b>삭제</b> 양식</td>
				</tr>
				<tr>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "COMMENT") . "<b>댓글쓰기</b> 양식
						" . $GLOBALS[lib_common]->make_input_box($relation_table, "relation_table_1", "text", "size=13 maxlength=100 class=designer_text", "") . "
					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form, $IS_input_box_padding, array("title"=>"<b>게시판 & 폼타입 선택</b>"));

$query = "select * from $DB_TABLES[board_list] where view_page='$design_file'";
$result = $GLOBALS[lib_common]->querying($query, "게시물 보기 페이지 추출 쿼리중 에러");
if (mysql_num_rows($result) == 0) $is_view_page = " disabled";	// 현재 페이지가 보기 페이지일 때 관련, 이전, 다음 목록쿼리를 선택할 수 있게 한다.	

// 정렬설정
$option_name=array("::: 선택 :::", "일련번호", "등록일", "이름", "이메일", "홈페이지", "제목", "내용-1", "내용-2", "조회수", "자료", "분류-1", "분류-2", "분류-3", "아이디", "기타-1", "기타-2", "기타-3");
$option_value = array("", "serial_num", "sign_date", "name", "email", "homepage", "subject", "comment_1", "comment_2", "count", "user_file", "category_1", "category_2", "category_3", "writer_id", "etc_1", "etc_2", "etc_3");
$P_sort_field = "항목 " . $GLOBALS[lib_common]->make_list_box("sort_field", $option_name, $option_value, "", $sort_field, "class=designer_select", $style) . "<br>";
$option_name = $option_value = "";

$option_name = array("::: 선택 :::", "내림차순","오름차순");
$option_value = array("", "desc","asc");
$P_sort_sequence = "차순 " . $GLOBALS[lib_common]->make_list_box("sort_sequence", $option_name, $option_value, "", $sort_sequence, "class=designer_select", $style) . "<br>";

// 출력개수 설정
$option_name = array();
for ($i=1; $i<=100; $i++) $option_name[] = $i;
$option_name[] = 0;
$P_table_per_article = "게시물수 " . $GLOBALS[lib_common]->make_list_box("table_per_article", $option_name, $option_name, $table_per_article, "", "class=designer_select", "width=50");
$option_name = array();
for ($i=1; $i<=20; $i++) $option_name[] = $i;
$P_table_per_block = "페이지수 " . $GLOBALS[lib_common]->make_list_box("table_per_block", $option_name, $option_name, $table_per_block, "", "class=designer_select", "width=50");
$option_name = array();
for ($i=0; $i<=30; $i++) $option_name[] = $i;
$P_line_per_article = "한줄개수 " . $GLOBALS[lib_common]->make_list_box("line_per_article", $option_name, $option_name, $line_per_article, "", "class=designer_select", "width=50");

// 출력방식 선택
$option_name = array("::: 선택 :::", "일반형","FAQ형");
$option_value = array("", "","_layer");
$P_list_view_mode = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $GLOBALS[lib_common]->make_list_box("list_view_mode", $option_name, $option_value, "", $list_view_mode, "class=designer_select", $style) . "<br>";
$option_name = $option_value = "";

$P_table_board_form_list = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>쿼리타입</td>
		<td>
			<table width='100%'>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "1") . "<b>전체목록</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "2") . "<b>원래글목록</b>(답변글 제외목록)</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "3") . "<b>본인글목록</b>(회원만가능)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "4") . "<b>관련글목록</b>(원글의 답변글목록)</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "5") . "<b>이전글목록</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "6") . "<b>다음글목록</b></td>
				</tr>
				<tr>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "7") . "<b>댓글목록</b>
						" . $GLOBALS[lib_common]->make_input_box($relation_table, "relation_table", "text", "size=13 maxlength=100 class=designer_text", "") . "
					</td>
					<td>* 서브쿼리 " . $GLOBALS[lib_common]->make_input_box($user_query, "user_query", "text", "size=20 maxlength=100 class=designer_text", "") . "<span class=11px> (where 절 and 연결)</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='2'><hr></td>
	</tr>
	<tr>
		<td colspan='2'>
			<table width='100%' cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td height='30' width='80' align='center'>정렬방식</td>
					<td>
						$P_sort_field
						$P_sort_sequence
					</td>
					<td height='30' width='80' align='center'>출력개수</td>
					<td>
						$P_table_per_article ('0' 은 전체)<br>
						$P_table_per_block<br>
						$P_line_per_article<br>
					</td>
				</tr>
				<tr>
					<td height='30' align='center'>출력방식</td>
					<td>
						$P_list_view_mode
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form_list = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form_list, $IS_input_box_padding, array("title"=>"<b>목록기능설정</b>"));

// 입력후 이동페이지
$query = "select name, file_name from $DB_TABLES[design_files] where type='사용자'";
$result = $GLOBALS[lib_common]->querying($query, "파일이름추출 쿼리수행중 에러발생");
$option_name[] = "::: 기본값 :::";
$option_value[] = "";
while ($value = mysql_fetch_row($result)) {
	$option_name[] = $value[0];
	$option_value[] = $value[1];
}
$P_query_next_page = $GLOBALS[lib_common]->make_list_box("query_next_page", $option_name, $option_value, "", $query_next_page, "class=designer_select", "");

$P_table_board_form_input = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>필수입력항목</td>
		<td>
			<table width='100%'>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[0], "verify_input_1", "checkbox", "", "", "name") . "<b>이름</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[1], "verify_input_2", "checkbox", "", "", "email") . "<b>이메일</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[2], "verify_input_3", "checkbox", "", "", "homepage") . "<b>홈페이지</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[3], "verify_input_4", "checkbox", "", "", "subject") . "<b>제목</b></td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[4], "verify_input_5", "checkbox", "", "", "comment_1") . "<b>내용-1</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[5], "verify_input_6", "checkbox", "", "", "comment_2") . "<b>내용-2</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[7], "verify_input_8", "checkbox", "", "", "user_file") . "<b>파일</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[8], "verify_input_9", "checkbox", "", "", "category_1") . "<b>분류-1</b></td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[9], "verify_input_10", "checkbox", "", "", "category_2") . "<b>분류-2</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[10], "verify_input_11", "checkbox", "", "", "category_3") . "<b>분류-3</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[11], "verify_input_12", "checkbox", "", "", "etc_1") . "<b>기타-1</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[12], "verify_input_13", "checkbox", "", "", "etc_2") . "<b>기타-2</b></td>
				</tr>
				<tr>											
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[13], "verify_input_14", "checkbox", "", "", "etc_3") . "<b>기타-3</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[14], "verify_input_15", "checkbox", "", "", "phone") . "<b>전화번호</b></td>
					<!-- 비밀번호는 자동으로 설정됨 <td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[6], "verify_input_7", "checkbox", "", "", "passwd") . "<b>비밀번호</b></td>//-->
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form_input, $IS_input_box_padding, array("title"=>"<b>필수입력항목</b>"));

include "include/form_form_property.inc.php";

$help_msg = "
	게시판설정 화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript'>
<!--
	function verify_submit() {
		form = document.frm;
		if (form.board_name.value == '') {
			alert('게시판을 선택하세요');
			form.board_name.focus();
			return false;
		}
		if (submit_radio_check(form, 'form_type', 'radio') == false) {
			alert('폼 타입을 선택하세요.');
			return false;
		}

		if (get_radio_value(form.form_type) == 'COMMENT') {	// 댓글일 경우 필수 입력검사
			if (form.relation_table_1.disabled == false) {
				if (form.relation_table_1.value == '') {
					alert('연결할 테이블을 입력하세요');
					form.relation_table_1.focus();
					return false;
				}
			}
		}

		if (get_radio_value(form.form_type) == 'LIST') {	// 목록일 경우 필수 입력검사
			if (submit_radio_check(form, 'query_type', 'radio') == false) {
				alert('쿼리타입을 선택하세요');
				return false;
			}
			if (form.relation_table.disabled == false) {
				if (form.relation_table.value == '') {
					alert('연결할 테이블을 입력하세요');
					form.relation_table.focus();
					return false;
				}
			}
		}
	}
	function chg_form_type() {
		form = document.frm;
		if (get_radio_value(form.form_type) == 'COMMENT') {	// 댓글 목록 인경우 연결 테이블 활성
			form.relation_table_1.disabled = false;
			form.relation_table_1.style.background = '#FFFFFF';
			form.relation_table_1.focus();
		} else {
			form.relation_table_1.disabled = true;
			form.relation_table_1.style.background = '#FAFAFA';
		}
	}
	function chg_query_type() {
		form = document.frm;
		if (get_radio_value(form.query_type) == '7') {	// 댓글 목록 인경우 연결 테이블 활성
			form.relation_table.disabled = false;
			form.relation_table.style.background = '#FFFFFF';
			form.relation_table.focus();
		} else {
			form.relation_table.disabled = true;
			form.relation_table.style.background = '#FAFAFA';
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_form_manager.php?design_file=$design_file' onsubmit='return verify_submit();'>
	<input type='hidden' name='design_file' value='$design_file'>
	<input type='hidden' name='form_line' value='$form_line'>
	<input type='hidden' name='mode' value='$mode'>
	<tr>
		<td>
			$P_table_board_form
		</td>
	</tr>
	<tr id='LIST' style='display:$is_save_list'>
		<td>
			$P_table_board_form_list
		</td>
	</tr>
	<tr id='FORM' style='display:$is_save_form'>
		<td>
			$P_table_board_form_input
		</td>
	</tr>
	<tr>
		<td>
			$P_table_form_function
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'></a>
			<a href='javascript:parent.window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>	
</table>
<script language='javascript1.2'>
<!--
	chg_query_type();
	chg_form_type();
//-->
</script>
");

include "footer_sub.inc.php";
?>