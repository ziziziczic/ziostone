<?
////////////////////////////////////////////////////////////////////////////
//        디자인파일을 화면에 보여주는 프로그램
////////////////////////////////////////////////////////////////////////////

// 분류설정
$GLOBALS[categorys] = array();	 // get 으로 넘어오는 게시판 분류변수 앞에 ! 가 있는 경우 해당 분류를 제외한 값을 추출함

if ($_GET[design_file] == '') {
	$design_file = "home.php"; // db.inc.php, config.inc.php 파일은 프로그램 전 영역에서 공유됨. 디자이너 디버깅시 문제가 발생하므로 디자인 파일 "home.php" 파일은 뷰어에서만 디폴트로 설정함
	$site_page_info = $lib_fix->get_site_page_info($design_file);
} else {
	$design_file = $_GET[design_file];
}

if ($site_page_info[view_level] <= 8 && $site_page_info[view_level] > 0) {	 // 권한 설정이 되어 있는 경우
	$auth_method_array = array(array('L', $site_page_info[view_level], $user_info[user_level], $site_page_info[view_level_mode]));
	$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
	if ($auth_result == false) include "{$DIRS[include_root]}auth_process.inc.php";
} else {
	$GLOBALS[lib_common]->die_msg("디자인 파일 링크 오류입니다. <a href='javascript:history.back()'>[뒤로이동]</a>");
}

if ($_GET[search_value2] != '') $search_value = $_GET[search_value2];
$lib_insiter->design_file_count($design_file); // 페이지뷰 설정

if (!$page) $page = 1;
else $page = $page;

$GLOBALS[JS_CODE] = array();		// 코드값만 저장한다.(인자값없이 한번만 나오면 되는 함수들)
$GLOBALS[JS] = array();						// 자바스크립트 내용을 저장한다.
$GLOBALS[ETC_CODE] = array();	// 기타 레이어 코드값만 저장한다.
$GLOBALS[ETC] = array();					// 기타 레이어 등을 저장한다.
$GLOBALS[TABLE_INDEX] = $GLOBALS[TABLE_INDEX_SKIN] = '';

$import_files = $import_lines = array();	// 임포트된 파일, 라인들을 저장
$import_files_size = 0;

$repeat_number = 0;	// 반복 회수차감용

if ($_GET[ssf] != '') $_SESSION[user_skin_file] = $_GET[ssf];											// get 변수로 스킨파일 정보가 넘어오면 세션에저장
if ($site_page_info[skin_file] != '') {																								// 스킨설정된 페이지인경우
	if ($site_page_info[skin_file] == "session") {
		if ($_SESSION[user_skin_file] != '') $skin_file = $_SESSION[user_skin_file];	// 세션 스킨 적용
		else $skin_file = $site_info[skin_file];
	} else {
		$skin_file = $site_page_info[skin_file];																				// 아니면 내부 스킨 적용
	}
}
if ($skin_file != '') {	// 현재 페이지에 스킨이 있는 경우
	$site_skin_page_info = $lib_fix->get_site_page_info($skin_file);	// 스킨 파일을 불러 출력하다가 컨텐츠 명령을 만나면 다시 현재 파일을 불러 삽입한다.
	$design = $lib_fix->design_load($DIRS, $site_skin_page_info[file_name], $site_skin_page_info);
	$tag_info = $site_skin_page_info;
} else {							// 스킨이 없는경우 
	$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
	$tag_info = $site_page_info;
}

// 스킨이 있는 경우 스킨에 적용된 헤드 태그 적용(실제 페이지 헤더는 '컨텐츠' 명령에서 출력)
$open_html_tag = "<html>\n";
$close_html_tag = "</html>";
if ($tag_info[tag_header] != '') $header_tag = "{$tag_info[tag_header]}\n";
$open_body_tag = "{$tag_info[tag_body]}\n";
$body_in_tag = "{$tag_info[tag_body_in]}\n";
$body_out_tag = "{$tag_info[tag_body_out]}\n";
$close_body_tag = "</body>\n";

// 내용보호
if ($site_page_info[page_lock] != '') {
	$pl_exp = explode($GLOBALS[DV][ct2], $site_page_info[page_lock]);
	for ($T_i=0,$cnt=sizeof($pl_exp); $T_i<$cnt; $T_i++) {
		switch ($pl_exp[$T_i]) {
			case 'L' :	 // 왼쪽클릭차단
				$page_lock_info[btn_left] = 'Y';
			break;
			case 'R' :	 // 오른쪽클릭차단
				$page_lock_info[btn_right] = 'Y';
			break;
			case 'C' :	 // Ctrl 키 차단
				$page_lock_info[key_ctrl] = 'Y';
			break;
			case 'A' :	 // Alt 키 차단
				$page_lock_info[key_alt] = 'Y';
			break;
			case 'M' :	 // 메시지출력
				$page_lock_info[msg] = 'Y';
			break;
		}
	}
	$header_tag .= $GLOBALS[lib_common]->page_lock($page_lock_info);
}
ob_start();
print($open_html_tag . $header_tag . $open_body_tag . $body_in_tag);	// 헤더등 태그 출력
$skip_info = array("page_menu"=>$site_page_info[menu], "design_file"=>$site_page_info[file_name], "udf_group"=>$site_page_info[udf_group], "page_type"=>$site_page_info[type]);
$T_tab_index = 0;
for($i_viewer=0,$cnt_viewer=sizeof($design); $i_viewer<$cnt_viewer; $i_viewer++) {
	$is_print_tab = 'Y';																																				// 탭문자삽입
	if ($exp[0] == "그림" || $exp[0] == "버튼" || $exp[0] == "문자열") $is_print_tab = 'N';		// 이전 출력중 몇 가지 다음에는 탭출력안함
	$exp = explode($GLOBALS[DV][dv], $design[$i_viewer]);																// 명령줄분리
	if ($T_tab_index > 0) {																																	// 탭출력
		if (ereg("끝", $exp[0])) $T_tab_index = $T_tab_index - 1;
		for ($i_table_index=0; $i_table_index<$T_tab_index; $i_table_index++) if ($is_print_tab == 'Y') echo("\t");
	}
	switch ($exp[0]) {
		case "테이블시작" :
			$exp = str_replace("%SERIAL_NUM%", $article_value[serial_num], $exp);	 // 게시물 일련번호로 치환
			if ($exp[3] != '') {					// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $user_info[user_level], $i_viewer, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$i_viewer = $is_skip;
					break;
				}
			}
			if ($exp[13] != '') {
				$skin_info = explode($GLOBALS[DV][ct4], $exp[13]);
				$img_dir = "{$DIRS[designer_root]}images/box/{$skin_info[0]}/";
				$skin_file_contents = $lib_insiter->get_skin_file("{$img_dir}index.html", array("img_dir"=>$img_dir, "title"=>$skin_info[1], "padding"=>$skin_info[2]));
				if ($skin_file_contents != '') {
					$skin_file_contents = explode("%CONTENTS%", $skin_file_contents);
					print($skin_file_contents[0]);
					$T_val_name = "TS_{$exp[1]}_close";
					$$T_val_name = $skin_file_contents[1];
				}
			}
			if ($exp[2] != '') $table_property = " $exp[2]";
			else $table_property = '';
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			// 테이블에 기능설정이 되어 있는지 확인한다.
			if (!strcmp($exp[4], "TC_BOARD")) {
				$article_num = $_GET[article_num];
				$GLOBALS[categorys] = array($_GET[category_1], $_GET[category_2], $_GET[category_3], $_GET[category_4], $_GET[category_5], $_GET[category_6]);
				$article_value = $exp[4] = $form_name = '';
				$design[$i_viewer] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
				$exp_1 = explode(':', $exp[5]);		// 게시판 기능 속성을 불러온다.
				$board_name = $exp_1[0];				// 게시판 이름을 설정한다.
				$page_type = $exp_1[1];					// 게시판 형식을 설정한다.(LIST:목록,WRITE:쓰기,MODIFY:수정,DELETE:삭제,REPLY:답변)
				$board_info = $lib_fix->get_board_info($board_name);		// 게시판 정보 추출
				if ($board_info[name] == '') print("존재하지 않는 게시판입니다.");
				$error_msg = "{$page_type} 쿼리중 에러발생";
				switch ($page_type) {
					case "LIST" :													// 목록폼
						if ($_GET["tpa_{$board_info[name]}"] != '') $table_per_article = $_GET["tpa_{$board_info[name]}"];		// 테이블당 출력될 게시물 수 (유동)
						else $table_per_article = $exp_1[3];																																				// 테이블당 출력될 게시물 수 (고정)
						$table_per_block = $exp_1[4];		// 테이블당 출력될 페이지링크 수
						$div_article = $exp_1[5];					// 한줄에 출력될 게시물수
						if ($exp_1[9] == "_layer") $GLOBALS[JS_CODE][SUBJECT_LAYER] = 'Y';
						$query = get_query($board_info, $page_type, $article_num, array("query_type"=>$exp_1[2], "sort_field"=>$exp_1[7], "sort_sequence"=>$exp_1[8], "user_query"=>$exp[6], "relation_table"=>$exp_1[10]));		// 현재 보여 주어야할 내용에 적당한 쿼리를 수행한다.
						$query_count = str_replace("select *", "select count(serial_num)", $query);
						$total_record = mysql_result($GLOBALS[lib_common]->querying($query_count, $error_msg), 0, 0);
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7]);
						if ($table_per_article > 0) {
							$page_name = "page_" . str_replace("index=", '', $GLOBALS[TABLE_INDEX]);
							$page = $_GET[$page_name];
							if ($page <= 0) $page = 1;
							$limit_start = $table_per_article * ($page-1);
							$limit_end = $table_per_article;
							$query_limit = " limit $limit_start, $limit_end";
							$query .= $query_limit;
						}
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);		// 적당한 쿼리를 수행한다.
						$article_value = mysql_fetch_array($article_result);
						$repeat_number = $abs_repeat = mysql_num_rows($article_result);				// 실제 반복될 개수
					break;
					case "VIEW" :												// 보기폼
						$query = get_query($board_info, $page_type, $article_num);
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);
						$article_value = mysql_fetch_array($article_result);
						$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "view");
						if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("\'열람\' 권한이 없습니다.");
					break;
					case "WRITE" :												// 쓰기폼
						$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "write");
						if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("\'등록\' 권한이 없습니다.");
						$verify_input = $exp_1[2];
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7]);
					break;
					case "MODIFY" :											// 수정폼
						$query = get_query($board_info, $page_type, $article_num);
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);
						$article_value = mysql_fetch_array($article_result);
						$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "modify");
						if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("\'수정\' 권한이 없습니다.");
						$verify_input = $exp_1[2];
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7]);
					break;
					case "DELETE" :											// 삭제폼
						$query = get_query($board_info, $page_type, $article_num);
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);
						$article_value = mysql_fetch_array($article_result);
						$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "delete");
						if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("\'삭제\' 권한이 없습니다.");
						$verify_input = $exp_1[2];
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7]);
					break;
					case "REPLY" :												// 답변폼 (답변폼은 페이지 단위로 막아줌)
						$query = get_query($board_info, $page_type, $article_num);
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);
						$article_value = mysql_fetch_array($article_result);
						$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "reply");
						if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("권한이 없습니다.");
						$verify_input = $exp_1[2];
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7]);
					break;
					case "COMMENT" :											// 댓글폼 (답변폼은 페이지 단위로 막아줌)
						$query = get_query($board_info, $page_type, $article_num);
						$article_result = $GLOBALS[lib_common]->querying($query, $error_msg);
						$article_value = mysql_fetch_array($article_result);
						//$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "comment");
						//if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("권한이 없습니다.");
						$verify_input = $exp_1[2];
						$relation_table = $exp_1[10];
						$form_name = board_form($board_info, $page_type, $verify_input, $exp[1], $exp[7], $relation_table);
					break;
				}
			} else if (!strcmp($exp[4], "TC_LOGIN")) {	
				$page_type = "LOGIN";
				$form_name = member_form($page_type, $_GET[prev_url], "", $exp[1], $exp[7]);
			} else if (!strcmp($exp[4], "TC_MEMBER")) {
				$verify_input = $exp[5];
				$page_type = "MEMBER";
				$form_name = member_form($page_type, $_GET[prev_url], $verify_input, $exp[1], $exp[7]);
				$member_field_defines = $lib_insiter->member_field_define($site_info, $user_info);	// 회원 필드 사용자정의
			}
			if ($exp[9] == "반복" && $page_type == "LIST")	{	// 반복되는 위치의 시작을 기억해두고 반복될때 마다 레코드를 하나씩 가져온다.
				if ($total_record == 0) {
					$i_viewer = $lib_fix->search_first_index($design, $exp[1], $i_viewer+1);
					continue;
				}
				$repeat_table_line = $i_viewer;
				$repeat_table_index = $exp[1] . "_" . $import_files_size;
				$exp[9] = '';
				$design[$i_viewer] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
			}
			print("{$tag_both[$exp[1]][0]}<table{$table_property}>\n");
			$T_tab_index++;
		break;
		case "테이블끝" :
			if ($GLOBALS[TABLE_INDEX] == $exp[1] . "_" . $import_files_size) {
				print("</form>\n");
				$GLOBALS[TABLE_INDEX] = '';
			}
			if ($repeat_table_index == $exp[1] . "_" . $import_files_size) {	 // 테이블반복이 설정된 경우
				if ($repeat_number > 1) {
					$i_viewer = $repeat_table_line - 1;	 // 현재 인덱스를 테이블 반복 시작 인덱스로 바꿈.
					if ($total_record > 0) $article_value = mysql_fetch_array($article_result);
					$repeat_number--;				// 반복회수 차감
				} else {
					$article_value = '';
					$repeat_table_index = '';
					$repeat_table_line = '';
				}
			}
			print("</table>{$tag_both[$exp[1]][1]}\n");
			if ($repeat_table_index == $exp[1] . "_" . $import_files_size) if (($div_article > 0) && (($abs_repeat-$repeat_number)%$div_article == 0)) print("\n<br clear=all>\n");
			$T_val_name = "TS_{$exp[1]}_close";
			if ($$T_val_name != '') {
				print($$T_val_name);
				unset($$T_val_name);
			}
		break;

		case "줄시작" :
			$exp = str_replace("%SERIAL_NUM%", $article_value[serial_num], $exp);
			if ($exp[3] != '') {					// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $user_info[user_level], $i_viewer, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$i_viewer = $is_skip;
				break;
				}
			}
			if ($exp[2] != "") $tr_property = " $exp[2]";
			else $tr_property = '';
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			if ($exp[9] == "반복" && $page_type == "LIST")	{	// 반복되는 위치의 시작을 기억해두고 반복될때 마다 레코드를 하나씩 가져온다.
				if ($total_record == 0) {
					$i_viewer = $lib_fix->search_first_index($design, $exp[1], $i_viewer+1);
					continue;
				}
				$repeat_tr_line = $i_viewer;
				$repeat_tr_index = $exp[1];
				$exp[9] = '';
				$design[$i_viewer] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
			}
			print("{$tag_both[$exp[1]][0]}<tr{$tr_property}>\n");
			$T_tab_index++;
		break;	

		case "줄끝" :
			if ($repeat_tr_index == $exp[1]) {	 // 줄반복이 설정된 경우
				if ($repeat_number > 1) {
					$i_viewer = $repeat_tr_line - 1;	 // 현재 인덱스를 테이블 반복 시작 인덱스로 바꿈.
					if ($total_record > 0) $article_value = mysql_fetch_array($article_result);
					$repeat_number--;				// 반복회수 차감
				} else {
					$article_value = '';
					$repeat_tr_index = '';
				}
			}				
			print("</tr>{$tag_both[$exp[1]][1]}\n");
		break;
	
		case "칸시작" :
			$exp = str_replace("%SERIAL_NUM%", $article_value[serial_num], $exp);
			if ($exp[3] != '') {	// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $user_info[user_level], $i_viewer, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$i_viewer = $is_skip;
				break;
				}
			}
			if ($exp[2] != "") $td_property = " $exp[2]";
			else $td_property = '';
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			print("{$tag_both[$exp[1]][0]}<td{$td_property}>\n");
			$T_tab_index++;
		break;

		case "칸끝" :
			print("</td>{$tag_both[$exp[1]][1]}\n");
		break;
		
		case "문자열" :
			$saved_text = str_replace(chr(92).r.chr(92).n, "\r\n", $exp[1]);
			$component_view = str_replace("%레이어%", "", $saved_text);
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;
			
		case "그림" :
			$tag = input_image($root, $exp[3], $exp[4], $exp[5]);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		case "플래시" :
			$flash_src = $exp[1];
			$flash_property = explode($GLOBALS[DV][ct4], $exp[2]);
			$tag = "<script src='/flash_viewer.js.php?file_name=" . urlencode($flash_src) . "&width={$flash_property[0]}&height={$flash_property[1]}&align={$flash_property[2]}&wmode=$flash_property[3]'></script>";
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		case "회원정보" :
			$tag = make_member_info($user_info, $exp);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		// 게시물정보|subject|size=3 color=000000|<b>|</b>|글자수;링크여부;타겟;새창속성;최근글아이콘;시간;답변아이콘;공지아이콘;비공개아이콘|||||||||||||||||||
		//	 제목 : 글자수제한;HTML허용여부;링크여부;타겟;창속성;최근아이콘;시간;답변글아이콘
		//	 내용 : 글자수
		//	 이름, 이메일 : 이메일(홈페이지)링크여부
		// 홈페이지 : 링크여부;타겟
		//	 날짜 : 형식
		//	 비공개 : 비공개이미지;공개이미지
		//	 타입 : 공지글이미지;추천글이미지
		case "게시물정보" :
			$exp = str_replace("%SERIAL_NUM%", $article_value[serial_num], $exp);
			$exp = str_replace("%COMMENT_1%", str_replace($GLOBALS[DV][ct4], '-', $GLOBALS[lib_common]->replace_cr($article_value[comment_1], '', 'Y')), $exp);
			$tag = make_article_value($board_info, $page_type, $article_value, $exp);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;
		
		// 게시판 입력 도구부분(게시판입력상자|name|checkbox|size=15 maxlength=30|width=200 height=300||||||0|0|0|0||)
		case "게시판입력상자" :
			$exp = str_replace("%I_VIEWER%", $i_viewer, $exp);
			$tag = make_board_input_box($article_value, $exp);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		// 로그인 입력상자
		case "로그인입력상자" :
			$tag = make_login_box($exp);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		// 회원입력상자|id|text|size=20 maxlength=20|width=100||||||0|0|0|0|||||||||||||||||||||
		case "회원입력상자" :
			$tag = make_join_box($user_info, $exp, $member_field_defines);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		// 버튼 출력부분		버튼|list|그림|design/images/btn.gif|width=100|target;name,20,20,20,20|style
		case "버튼" :
			$tag = $lib_insiter->make_button($exp);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		case "컨텐츠" :		// 컨텐츠
			if ($site_page_info[type] != 'S') {
				if ($skin_file != $design_file) {	// 자기 자신을 스킨파일로 지정한 경우 제외
					print($site_page_info[tag_header]);
					print($site_page_info[tag_body_in]);
					$contents_design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
					array_splice($design, $i_viewer+1, 0, $contents_design);
					$cnt_viewer = sizeof($design);
				}
			} else {
				print("스킨 디자인의 내용이 들어갈 영역입니다.");
			}
		break;

		case "컨텐츠외부" :		// 스킨외부컨텐츠(스킨에 컨텐츠를 넣고자 할때
			if ($site_page_info[tag_contents_out] != '') print($site_page_info[tag_contents_out]);
			else print("페이지의 컨텐츠 외부값이 없습니다.");
		break;

		case "인클루드" :
			// 인클루드 변수를 설정한다.
			$inc_exp = explode($GLOBALS[DV][ct2], $exp[1]);
			if ($inc_exp[1] != '') {
				$var_include = $GLOBALS[lib_common]->parse_property($inc_exp[1], ',', '=', '', 'N');
				while (list($key_inc, $value_inc) = each($var_include)) $$key_inc = $value_inc;
			}
			include $inc_exp[0];
		break;

		case "임포트" :
			if ($design_file == $exp[1]) die("자신의 페이지는 임포트 할 수 없습니다.");							// 교착상태방지
			if (array_search($exp[1], $import_files)) die("교차 임포트는 허용되지 않습니다.");
			$site_import_page_info = $lib_fix->get_site_page_info($exp[1]);
			print($site_import_page_info[tag_header]);
			print($site_import_page_info[tag_body_in]);
			$import_design = $lib_fix->design_load($DIRS, $exp[1], $site_import_page_info);
			array_splice($design, $i_viewer+1, 0, $import_design);	// 임포트 파일 내용 삽입
			$cnt_viewer = sizeof($design);
			$import_design_size = sizeof($import_design);
			if ($import_files_size > 0) {	// 상위 임포트 라인이 있으면 현재 임포트파일의 줄 수를 각 라인에 더한다.
				for ($ifsi=0; $ifsi<$import_files_size; $ifsi++) $import_lines[$ifsi] += $import_design_size;
			}
			$new_start_line = $i_viewer + $import_design_size;	// 임포트 파일 다음라인(현재파일 시작점 저장)
			array_push($import_files, $exp[1]);
			array_push($import_lines, $new_start_line);
			$import_files_size = sizeof($import_files);								// 임포트된 회수를 기록
		break;
		
		case "게시판타이틀" :
			if ($board_info[title_type] == 'I') {												// 이미지
				$title_src = $board_info[title_img];
				$tag = "<img src='$title_src' {$exp[1]} border=0>";
				$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
				print($component_view);
			} else if ($board_info[title_type] == 'F') {									// 인클루드파일
				// 인클루드 변수를 설정한다.
				$inc_exp = explode($GLOBALS[DV][ct2], $board_info['include']);
				if ($inc_exp[1] != '') {
					$var_include = $GLOBALS[lib_common]->parse_property($inc_exp[1], ',', '=', '', 'N');
					while (list($key_inc, $value_inc) = each($var_include)) $$key_inc = $value_inc;
				}
				include $inc_exp[0];
			} else if ($board_info[title_type] == 'T') {									// 태그
				$tag = stripslashes($board_info[title_tag]);
				$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
				print($component_view);
			} else {
				print("'$board_info[alias]' 게시판타이틀이 설정되지 않았습니다.");
			}
		break;

		case "게시판상단" :
			$tag = $board_info[header];
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		case "게시판하단" :
			$tag = $board_info[footer];
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;

		case "네비게이션" :
			if ($exp[2] == '') $exp[2] = 'Y';
			if ($_GET[category_id] != '' || $_GET[it_id] != '') $tag = $P_navigation_link;
			else $tag = $lib_insiter->make_navigation($site_page_info, $exp[1], $exp[2], $board_info);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;
		// 업로드파일|flash|../design/images/main.swf|500;500|||||||0|0|0|0|||||||||||||||
		// |인덱스|형식|경로|속성|||
		case "업로드파일" :
		break;
		default :
			$tag = exec_user_command($exp[0]);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			print($component_view);
		break;
	}
	if (($i_viewer >= $import_lines[$import_files_size-1]) && ($import_files_size > 0)) {
		array_pop($import_files);
		array_pop($import_lines);
		$import_files_size = sizeof($import_files);	// 임포트된 회수를 기록
	}
}
print_javascript();
print($close_body_tag . $body_out_tag . $close_html_tag);
ob_end_flush();
include "{$DIRS[designer_root]}include/popup_open.inc.php";

// 게시물정보 출력함수
function make_article_value($board_info, $page_type, $article_value, $exp) {
	global $root, $lib_insiter, $design_file, $article_num, $site_info, $search_value, $page, $user_info, $DB_TABLES, $board_info, $total_record, $table_per_article, $table_per_block, $DIRS;
	$article_item = $exp[1];
	$exp_prt_type = explode($GLOBALS[DV][ct4], $exp[2]);	// 출력속성 불러옴
	$prt_type = $exp_prt_type[0];
	$exp_pp_item = explode($GLOBALS[DV][ct4], $exp[3]);	// 필드값 전용 속성 불러옴
	$item_index = $exp_pp_item[0];
	if ($item_index != '' && $article_item != "user_file") $article_item_index = $article_item . "_{$item_index}";
	else $article_item_index = $article_item;
	
	// 제목, pb, 오름, 내림번호가 아닌경우는 값이 없으면 바로 리턴
	if ($article_item_index != "subject" && $article_item_index != "page_block" && $article_item_index != "asc_num" && $article_item_index != "desc_num" && $article_item_index != "total_article" && $article_item_index != "total_comment") if (trim($article_value[$article_item_index]) == '') return '';
	
	// 출력될 값 설정
	switch ($article_item_index) {
		case 'total_article' :
			$T_value = $total_record;
		break;
		case 'total_comment' :
			if ($exp_pp_item[2] == '') $exp_pp_item[2] = "{$DB_TABLES[board]}_{$board_info[name]}";
			if ($exp_pp_item[3] == '') $exp_pp_item[3] = "serial_num";
			$query_comments = "select count(serial_num) from {$exp_pp_item[1]} where relation_table='{$exp_pp_item[2]}' and relation_serial='{$article_value[$exp_pp_item[3]]}'";
			$result_comments = $GLOBALS[lib_common]->querying($query_comments);
			$total_comment = mysql_result($result_comments, 0, 0);
			if ($total_comment > 0) $T_value = $total_comment;
			else return;
		break;
		case 'asc_num' :
			$T_value = read_article_num("asc");
		break;
		case 'desc_num' :
			$T_value = read_article_num("desc");
		break;
		case "user_file" :							// 업로드 파일은 한 필드에 여러 파일명이 ; 로 구분되어 저장되므로 지정된 인덱스를 찾아야 함
			$saved_upload_files = explode(';', $article_value[user_file]);
			$T_value = $saved_upload_files[$item_index-1];
		break;
		case "sign_date" :							// 공지인 경우 현재 시간 출력
			if ($article_value[is_notice] == 'A') $T_value = time();
			else $T_value = $article_value[sign_date];
		break;		
		case "user_ip" :								// 아이피 주소인경우 관리자만 모두 노출, 이외는 부분노출
			$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_user], $user_info[user_level], 'U'), array('M', $board_info[admin], $user_info[serial_num], 'E'), array('M', $article_value[writer_id], $user_info[id], 'E'));
			if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) {
				$T_value = $article_value[user_ip];
			} else {
				$T_exp_ip = explode('.', $article_value[user_ip]);
				$T_exp_ip[2] = "xxx";
				$T_value = implode('.', $T_exp_ip);
			}
		break;
		case "page_block" :						// 페이지 목록인경우
			if ($exp_pp_item[7] == '') $page_block_link_file_name = $site_info[index_file];
			else $page_block_link_file_name = $exp_pp_item[7];
			$page_block_page_var_name = "page_" . str_replace("index=", '', $GLOBALS[TABLE_INDEX]);
			array_shift($exp_pp_item);
			$page_block_info = $lib_insiter->get_page_block($total_record, $table_per_article, $table_per_block, $page, $exp_pp_item, $font, "{$DIRS[designer_root]}images/", $page_block_link_file_name, 'N', $page_block_page_var_name, 'C', array("design_file"=>$page_block_link));
			$T_value = $page_block_info[0];
		break;
		default :
			$T_value = $article_value[$article_item_index];	 // 기타 필드인 경우
			$T_value = stripslashes($T_value);
		break;
	}
	if ($article_item_index != "subject" && $T_value == '') return '';

	// 출력될 값에 출력 형태별(텍스트, 숫자, 코드값 등등) 전용 속성을 적용한다.
	switch ($prt_type) {				
		case 'T' :									// 텍스트
			$max_string = $exp_prt_type[1];
			$T_value = nl2br(htmlspecialchars($T_value));
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			$pp_font = $exp_prt_type[2];
			if ($pp_font != '') $T_value = "<font $pp_font>$T_value</font>";	// 폰트 속성 적용
		break;
		case 'H' :								// HTML 태그
			$max_string = $exp_prt_type[1];
			if ($article_item_index == "comment_1" && $article_value[is_html] != 'Y') $T_value = nl2br(htmlspecialchars($T_value));	 // html 체크 안되어 있으면 텍스트 취급
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
		break;
		case 'F' :								// 파일
			$prt_type_file = $exp_prt_type[1];
			if ($prt_type_file != 'F') {	// 이미지나 아이콘인경우				
				// 이미지 속성 불러옴
				$define_property = array("width", "height", "border", "align");
				$pp_img = $GLOBALS[lib_common]->parse_property($exp_prt_type[2], ' ', '=', $define_property);
				$size_method = $exp_prt_type[3];
				$use_thumb = $exp_prt_type[4];
				$pp_file = array($pp_img, $size_method, $use_thumb);
				$T_exp = explode('/', $T_value);
				if (sizeof($T_exp) > 1) {	// 디렉토리 경로까지 지정된 경우
					$T_file_name = $T_exp[sizeof($T_exp)-1];
					array_pop($T_exp);
					$file_dir = $root . implode('/', $T_exp) . '/';
				} else {
					$T_file_name = $T_value;
					$file_dir = "{$root}design/upload_file/$board_info[name]/";
				}
				if ($prt_type_file == 'A') $T_value = $GLOBALS[lib_common]->view_files($T_file_name, $file_dir, $pp_file);				
				else $T_value = $GLOBALS[lib_common]->make_file_ext_icon($T_value, "{$DIRS[designer_root]}images/ext_icon/");
			} else {
				$max_string = $exp_prt_type[4];
				if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
				else $T_value = $T_value;
			}
		break;
		case 'N' :								// 숫자
			$sosujum = $exp_prt_type[1];
			if (is_numeric($T_value) && is_numeric($sosujum)) $T_value = number_format($T_value, $sosujum);
		break;
		case 'D' :								// 날짜
			$format_date = $exp_prt_type[1];
			$T_value = date($format_date, $T_value);
		break;
		case 'C' :								// 코드값
			if ($article_item == "category") $code_define = $board_info["category_" . $item_index];
			else if ($article_item == "type") $code_define = $board_info[type_define];
			else  $code_define = $exp_prt_type[1];
			//$T_codes = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).r.chr(92).n, "\r\n", $code_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
			$T_codes = $GLOBALS[lib_common]->parse_property($code_define, "\n", $GLOBALS[DV][ct2], '', 'N');
			$T_value = trim($T_codes[$T_value]);
		break;
		case 'U' :								// 사용자정의
			$T_value_ud = '';
			if ($exp_prt_type[2] != '') $T_value_ud = "<img src='$exp_prt_type[2]' border=0 align=absmiddle>";
			if ($exp_prt_type[1] != '') $T_value_ud .= $exp_prt_type[1];
			if ($T_value_ud != '') $T_value = $T_value_ud;
		break;
	}
	
	// 최종 값을 설정한다. (추가 내용 붙이는 부분)
	switch ($article_item_index) {
		case 'subject' :
			if ($T_value != '') {
				$article_thread_length = strlen($article_value[thread]);
				if ($page_type == "LIST") for($i = 1; $i < $article_thread_length; $i++) $spacer .= "&nbsp;$spacer_ext";
				if (($page_type == "LIST") && ($article_num == $article_value[serial_num])) $T_value = "<font color=red><b>=></b></font> $T_value";	// 현재 읽고 있는글이거나, 방금 수정 한 글인경우
				if ((time() < ($article_value[sign_date] + ($exp_pp_item[2]*3600))) && ($exp_pp_item[2] > 0)) {	// 시간이 설정되어 있을 경우 새글 아이콘표시
					if ($exp_pp_item[1] != "") $T_value = "{$T_value} <img src='$exp_pp_item[1]' border=0 align='absmiddle'>"; 
					else $T_value = "{$T_value} <img src='{$root}designer/images/board/new.gif' border=0 align='absmiddle'>"; 
				}
				// 공지글인경우 아이콘있으면 출력, 없으면 관리자만 기본아이콘 출력
				if ($article_value[is_notice] == 'A') {
					$T_value = "<b>{$T_value}</b>";
					if ($exp_pp_item[4] != '') {
						$T_value = "<img src='$exp_pp_item[4]' border=0 align='absmiddle'> {$T_value}";
					} else {
						// 게시판 관리 권한이 있는 경우
						if ($user_info[user_level] == "1" || $user_info[id] == $board_info[admin]) $T_value = "<img src='{$root}designer/images/board/notice.gif' border=0 align='absmiddle'> {$T_value}"; 
					}
				}
				// 원글아이콘이 있는경우 원글+공지글아니면 출력
				if ($exp_pp_item[6] != '' && $article_thread_length == 1 && $article_value[is_notice] != 'A') $T_value = "<img src='$exp_pp_item[6]' border=0 align='absmiddle'> {$T_value}";
				// 답변글 아이콘
				if ($article_thread_length > 1 && $page_type == "LIST") {
					if ($exp_pp_item[3] != '') $T_value = "{$spacer}<img src='$exp_pp_item[3]' border=0 align='absmiddle'>{$T_value}";
					else $T_value = "{$spacer}<img src='{$root}designer/images/board/re.gif' border=0 align='absmiddle'>{$T_value}"; 
				}
				// 비공개글 아이콘
				if ($article_value[is_private] == 'Y') {
					if ($exp_pp_item[5] != '') $T_value = "<img src='$exp_pp_item[5]' border=0 align='absmiddle'> {$T_value}";
					else $T_value = "<img src='{$root}designer/images/board/private.gif' border=0 align='absmiddle'> {$T_value}"; 
				}
				// 출력안함 아이콘
				if ($article_value[is_view] == 'N') {
					$T_value = "<img src='{$root}designer/images/board/not_view.gif' border=0 align='absmiddle'> {$T_value}"; 
				}
				$value = $T_value;
			} else {
				$value = "검색된 게시물이 없습니다.";
				if ($user_info[user_level] != '1' && $user_info[id] != $board_info[admin]) $F_link_disable = 'Y';
			}
		break;		
		case 'comment_1' :
			// 게시물 내용을 불러올때 카운터를 증가시킨다.
			$table_name = "{$DB_TABLES[board]}_" . $board_info[name];		//  테이블이름 설정
			if ($board_info[count_term] == '' || $board_info[count_term] == 1) {
				$count_term = 1;
			} else {
				srand((float)microtime() * 10000000);
				$count_term = rand(1, $board_info[count_term]);
			}
			$count = $article_value[count]+$count_term;
			$query = "update $table_name set count=$count where serial_num=$article_value[serial_num]";
			$result = $GLOBALS[lib_common]->querying($query);
			if ($GLOBALS[JS_CODE][SUBJECT_LAYER] == 'Y') $T_value = "<div id='A{$article_value[serial_num]}' style='display:none'>{$T_value}</div>";
			$value = $T_value;
		break;
		default :
			$value = $T_value;
		break;
	}

	// 출력될 값에 링크를 설정한다.
	$exp_link_info = explode($GLOBALS[DV][ct4], $exp[6]);	// 링크정보 불러옴
	$pp_link_target = $exp_link_info[0];
	$pp_link_nw = $exp_link_info[1];
	$pp_link_etc = $exp_link_info[2];
	$pp_link_rollover = $exp_link_info[3];
	$link_field = $exp_link_info[4];
	$link_field_part = $exp_link_info[5];
	$link_method = $exp_link_info[6];
	$user_link = $exp_link_info[7];
	$origin_img_name = $exp_link_info[8];
	
	if ($F_link_disable != 'Y') {	 // 링크 없어야 할 조건이 아니면 링크 적용
		switch ($link_field) {
			case 'D' :
				$value = $lib_insiter->make_article_common_link($value, $article_value[user_file], $exp_link_info);
			break;
			case 'U' :
				$change_vars = array("design_file"=>'', "article_num"=>$article_value[serial_num]);
				if (ereg('\?', $user_link)) $T_conn = '&';
				else $T_conn = '?';
				$link_url = $user_link . $T_conn . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
				if ($link_url != '') $value = $GLOBALS[lib_common]->make_link($value, $link_url, $pp_link_target, $pp_link_nw, $pp_link_etc);
			break;
			default :
				if ($link_field_part != '') $link_field .= '_' . $link_field_part;
				$link_url = $article_value[$link_field];
				if ($link_url != '') $value = $GLOBALS[lib_common]->make_link($value, $link_url, $pp_link_target, $pp_link_nw, $pp_link_etc);
			break;
		}
	}
	return $value;
}

// 게시물입력상자 생성 함수
function make_board_input_box($article_value, $exp_design_line) {
	global $lib_insiter, $search_item, $search_value, $board_info, $page_type, $user_info, $site_info, $DIRS;
	$name = $T_name = $exp_design_line[1];
	$type = $exp_design_line[2];
	$default_pp = $exp_design_line[3];
	$item_define = $exp_design_line[4];
	if ($exp_design_line[5] != '') $divider = $exp_design_line[5];
	else $divider = "&nbsp;";
	if ($exp_design_line[6] != '') {
		$item_index = $exp_design_line[6];
		if ($type != "file") $name = $name . "_{$item_index}";
	}
	
	if ($board_info[member_info] != 'Y') $T_user_info = '';
	else $T_user_info = $user_info;
	
	// 입력상자 기본값 모드 정보
	$exp_1 = explode($GLOBALS[DV][ct4], $exp_design_line[7]);

	$default_value = 'Y';

	// 페이지 타입별 기본값 설정부분
	if ($page_type == "REPLY") {
		$T_subject = $article_value[subject];
		$T_comment_1 = $article_value[comment_1];
		$article_value = array();
		$article_value[subject] = "[RE] " . $T_subject;
		$article_value[comment_1] = "\r\n\r\n\r\n===========  원래글   ============\r\n" . $T_comment_1;
	}

	// 입력상자 기본값 정의부
	$saved_value = $article_value[$name];															// 저장된내용 불러옴
	switch($exp_1[0]) {
		case 'B' :											// 사용자 + 저장값
			$saved_value = $exp_1[1] . $saved_value;
		break;
		case 'C' :											// 회원정보
			$saved_value = $T_user_info[$exp_1[1]];
		break;
		case 'D' :											// 저장값우선 회원정보
			if ($saved_value == '') $saved_value = $T_user_info[$exp_1[1]];
		break;
		case 'F' :											// 저장값우선 GET 변수값
			if ($saved_value == '') $saved_value = $_GET[$exp_1[1]];
		break;
		case 'G' :											// GET 변수값
			$saved_value = $_GET[$exp_1[1]];
		break;
		case 'U' :											// 사용자값
			if (substr($exp_1[1], 0, 6) == "%DATE%") $exp_1[1] = date(substr($exp_1[1], 6));
			$saved_value = $exp_1[1];
		break;
		case 'E' :											// 저장값우선 사용자값
			if ($saved_value == '') {
				if (substr($exp_1[1], 0, 6) == "%DATE%") $exp_1[1] = date(substr($exp_1[1], 6));
				$saved_value = $exp_1[1];
			}
		break;
		case 'X' :
			$saved_value = '';
		break;
	}

	// 필드별 기본값 재설정등 개별 설정
	if (substr($name, 0, 9) == "category_") {					// 카테고리 상자인 경우		
		if ($T_name == "category_go") {								// 이동상자인경우 링크설정
			$T_name_1 = "category_" . $item_index;
			if ($board_info[$T_name_1] != '') {						// 카테고리 설정된경우
				$item_define = ";분류-{$item_index} 전체\n" . $board_info[$T_name_1];
				$T_items = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).n, "\n", $item_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
				$new_option_value = array();
				$change_vars = array("category_1"=>$GLOBALS[categorys][0], "category_2"=>$GLOBALS[categorys][1], "category_3"=>$GLOBALS[categorys][2], "category_4"=>$GLOBALS[categorys][3], "category_5"=>$GLOBALS[categorys][4], "category_6"=>$GLOBALS[categorys][5], "page"=>'', "article_num"=>'', 'x'=>'', 'y'=>'');
				while (list($key, $value) = each($T_items)) {
					if ($key == "etc") continue;
					$change_vars["category_" . $item_index] = $key;
					$change_vars[design_file] = $board_info[list_page];
					$T_link = $site_info[index_file] . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
					$T_index = (int)$item_index-1;
					if ($key == $GLOBALS[categorys][$T_index]) $saved_value = $T_link;
					$new_option_value[] = $T_link . $GLOBALS[DV][ct2] . $value;
				}
				$item_define = implode($GLOBALS[DV][ct1], $new_option_value);
				$default_pp = " onChange=\"MM_jumpMenu('this',this,0)\"";
				$GLOBALS[JS_CODE][CATEGORY_GO] = "Y";
			}
		} else {
			if ($board_info[$name] != '') $item_define = $board_info[$name];			// 카테고리 설정된경우
		}
		if ($item_define == '') {
			$category_cnt = substr($name, -1);
			if ($T_name == "category_go") return '';
			else return "<font color='#AAAAAA'>[분류-{$category_cnt} 설정없음]</font>";
		}
	} else if ($name == "type") {								// 글 유형인경우
		if ($board_info[type_define] != '') {
			$item_define = $board_info[type_define];
		} else {
			return "게시판관리에서 글 유형을 정의해 주십시오.";
		}
	} else if ($name == "search_item") {
		if ($board_info[search_field] != '') $item_define = $board_info[search_field];
		else $item_define = $GLOBALS[VI][DD_search_field];
		$saved_value = $_GET[$name];
	} else if ($name == "search_value") {
		$saved_value = $_GET[$name];
	} else if ($name == "is_notice") {
		if ($article_value[thread] != '' && $article_value[thread] != 'A') $default_pp .= " disabled";	// 답변글인경우 공지할 수 없음
		$default_value = 'A';
	} else if ($name == "is_view") {
		$default_value = 'N';	
	} else if ($name == 'list_select[]') {		// 게시물 선택상자인 경우
		$default_value = $article_value[serial_num];
		$etc_tag = "<input type='hidden' name='serial_num[]' value='$article_value[serial_num]'>";
	} else if ($T_name == "user_file") {
		$value = $GLOBALS[lib_common]->get_file_upload_box($name, $item_index, $article_value[user_file], $default_pp, "{$DIRS[upload_root]}{$board_info[name]}");
	} else if ($name == "passwd") {
		$saved_value = $_POST[submit_passwd];
	} else if ($name == "tpa") {
		$T_items = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).n, "\n", $item_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
		$new_option_value = array();
		$change_vars = array("design_file"=>$_GET[design_file]);
		while (list($key, $T_value) = each($T_items)) {
			if ($key == "etc") continue;
			$change_vars["tpa_{$board_info[name]}"] = $key;
			$T_link = $site_info[index_file] . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$T_index = (int)$item_index-1;
			if ($key == $_GET["tpa_{$board_info[name]}"]) $saved_value = $T_link;
			$new_option_value[] = $T_link . $GLOBALS[DV][ct2] . $T_value;
		}
		$item_define = implode($GLOBALS[DV][ct1], $new_option_value);
		$default_pp = " onChange=\"MM_jumpMenu('this',this,0)\"";
		$GLOBALS[JS_CODE][CATEGORY_GO] = "Y";		
	}

	// 검색용 상자이면 입력상자 이름에 헤더붙임
	if ($exp_1[2] == 'Y') $name = "SCH_{$name}";

	// 입력상자 형태별 설정
	if ($value == '') {
		if ($item_define != '') {									// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
			$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $saved_value, $divider, $default_pp);
		} else {
			if ($type != "calendar") $value = $GLOBALS[lib_common]->make_input_box($saved_value, $name, $type, $default_pp, '', $default_value) . $etc_tag;
			else $value = $GLOBALS[lib_common]->make_date_input_box('', $name, $saved_value, 0, '', "Y-m-d", $default_pp, 'Y');
		}
	}
	return $value;
}
		
// 회원 정보 출력함수
function make_member_info($user_info, $exp) {
	global $lib_insiter, $site_info;
	$article_item = $exp[1];
	$exp_prt_type = explode($GLOBALS[DV][ct4], $exp[2]);	// 출력속성 불러옴
	$prt_type = $exp_prt_type[0];
	$exp_pp_item = explode($GLOBALS[DV][ct4], $exp[3]);	// 필드값 전용 속성 불러옴
	$item_index = $exp_pp_item[0];
	if ($item_index != '') $article_item_index = $article_item . "_{$item_index}";
	else $article_item_index = $article_item;
	switch ($article_item_index) {											// 출력될 값 설정
		case "upload_file" :															// 업로드 파일은 한 필드에 여러 파일명이 ; 로 구분되어 저장되므로 지정된 인덱스를 찾아야 함
			$saved_upload_files = explode(';', $user_info[upload_file]);
			$T_value = $saved_upload_files[$item_index];
		break;
		case "cyber_money" :
			$T_value = $lib_insiter->get_mb_cyber_money($user_info[id]);
		break;		
		case "buy_cnt" :
			$T_value = get_member_order_cnt($user_info[id]);
		break;
		default :
			$T_value = $user_info[$article_item_index];	 // 기타 필드인 경우
			$T_value = stripslashes($T_value);
		break;
	}
	switch ($prt_type) {				// 출력될 값에 출력 형태별(텍스트, 숫자, 코드값 등등) 전용 속성을 적용한다.	
		case 'T' :									// 텍스트
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			$pp_font = $exp_prt_type[2];
			if ($pp_font != '') $T_value = "<font $pp_font>$T_value</font>";	// 폰트 속성 적용
		break;
		case 'H' :									// HTML 태그 (태그입력이 전혀 없는 경우는 nl2br 함)
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			if (strlen($T_value) == strlen(strip_tags($T_value))) $T_value = nl2br($T_value);
		break;
		case 'F' :								// 파일
			$prt_type_file = $exp_prt_type[1];
			if ($prt_type_file != 'F') {	// 이미지나 아이콘인경우				
				// 이미지 속성 불러옴
				$define_property = array("width", "height", "border", "align");
				$pp_img = $GLOBALS[lib_common]->parse_property($exp_prt_type[2], ' ', '=', $define_property);
				$size_method = $exp_prt_type[3];
				$use_thumb = $exp_prt_type[4];
				$pp_file = array($pp_img, $size_method, $use_thumb);
				$T_exp = explode('/', $T_value);
				if (sizeof($T_exp) > 1) {	// 디렉토리 경로까지 지정된 경우
					$T_file_name = $T_exp[sizeof($T_exp)-1];
					array_pop($T_exp);
					$file_dir = $root . implode('/', $T_exp) . '/';
				} else {
					$T_file_name = $T_value;
					$file_dir = $DIRS[member_img];
				}
				if ($prt_type_file == 'A') $T_value = $GLOBALS[lib_common]->view_files($T_file_name, $file_dir, $pp_file);				
				else $T_value = $GLOBALS[lib_common]->make_file_ext_icon($T_value, "{$DIRS[designer_root]}images/ext_icon/");
			} else {
				$max_string = $exp_prt_type[4];
				if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
				else $T_value = $T_value;
			}
		break;
		case 'N' :								// 숫자
			$sosujum = $exp_prt_type[1];
			if (is_numeric($T_value) && is_numeric($sosujum)) $T_value = number_format($T_value, $sosujum);
		break;
		case 'D' :								// 날짜
			$format_date = $exp_prt_type[1];
			$T_value = date($format_date, $T_value);
		break;
		case 'C' :								// 코드값
			$code_define = $exp_prt_type[1];
			$T_codes = $GLOBALS[lib_common]->parse_property($code_define, "\\n", $GLOBALS[DV][ct2], '', 'N');
			$T_value = trim($T_codes[$T_value]);
		break;
		case 'U' :								// 사용자정의
			$T_value_ud = '';
			if ($exp_prt_type[2] != '') $T_value_ud = "<img src='$exp_prt_type[2]' border=0 align=absmiddle>";
			if ($user_define_text != '') $T_value_ud .= $user_define_text;
			if ($T_value_ud != '') $T_value = $T_value_ud;
		break;
	}
	return $T_value;
}

// 게시물 가상 번호 생성함수
function read_article_num($mode) {
	global $total_record, $table_per_article, $repeat_number, $abs_repeat, $page;
	if ($mode == "desc") $article_virtual_num = $total_record - ($table_per_article * ($page-1)) - ($abs_repeat - $repeat_number);
	else $article_virtual_num = ($table_per_article * ($page-1)) + ($abs_repeat-($repeat_number-1));
	if ($article_virtual_num > 0) return $article_virtual_num;
}

function get_query($board_info, $page_type, $article_num, $list_info='') {	
	global $lib_insiter, $DB_TABLES, $search_item, $search_value, $user_info;
	$table_name = "{$DB_TABLES[board]}_" . $board_info[name];																																	//  게시판이름을 데이터 베이스 테이블이름과 매칭시킨다.
	if (!strcmp($page_type, "LIST")) {
		// 검색어 서브쿼리 설정
		if ($_GET[sch_method] == '') $T_method = "or";																																								// 다중 키워드간 (and, or 설정)
		else $T_method = $_GET[sch_method];
		$sch_query = $GLOBALS[lib_common]->get_query_search("SCH_", "date", $T_method);																			// 필드 검색 서브쿼리 설정
		if (sizeof($sch_query) > 0) $T_sub_query = $sch_query;
		else $T_sub_query = array();
		if (trim($_GET[search_value]) != '') {																																														// 검색 키워드가 있는 경우
			if ($_GET[search_item] == '') $_GET[search_item] = 'A';
			$T_exp_sch_item = explode(';', $_GET[search_item]);																																				// 검색항목 분리(체크상자인경우 여러개선택 가능)
			for ($T_sch_item_i=0,$T_sch_item_cnt=sizeof($T_exp_sch_item); $T_sch_item_i<$T_sch_item_cnt; $T_sch_item_i++) {	// 검색항목 개수만큼(제목, 내용..)
				if (trim($T_exp_sch_item[$T_sch_item_i]) == '') continue;
				$sub_query_1 = $sub_query_3 = array();
				$T_exp = explode(' ', $_GET[search_value]);																																								// 다중키워드 (사이띄움으로 구분)
				if ($T_exp_sch_item[$T_sch_item_i] == 'A') {																																								// 통합검색인경우
					if ($board_info[search_field] == '') $total_sch_fields = $GLOBALS[VI][DD_search_field];
					else $total_sch_fields = $board_info[search_field];
					$search_items = $GLOBALS[lib_common]->parse_property($total_sch_fields, "\n", ';', '', 'N');
					while (list($key, $value) = each($search_items)) {																																				// 검색 필드 수 만큼
						if ($key == 'A') continue;
						$sub_query_2 = array();
						for ($T_i=0,$cnt=sizeof($T_exp); $T_i<$cnt; $T_i++) {																																	// 키워드 개수만큼
							$sub_query_2[] = $GLOBALS[lib_common]->get_query_operator($key, $T_exp[$T_i]);															// 각 키워드별 쿼리모음(앞의 문자를 연산처리)
						}
						$sub_query_1[] = '(' . implode(" {$T_method} ", $sub_query_2) . ')';																									// 설정된 필드 만큼의 쿼리모임(현재의통합검색전용임)
					}
					$sub_query_3[] = '(' . implode(" or ", $sub_query_1) . ')';																																// 다중선택된 검색항목 쿼리모음
				} else {																																																											// 단일항목검색인경우 (셀렉트 또는 라디오 상자면 한번, 체크상자면 여러번
					for ($T_i=0,$cnt=sizeof($T_exp); $T_i<$cnt; $T_i++) {																																		// 키워드 개수만큼
						$sub_query_1[] = $GLOBALS[lib_common]->get_query_operator($T_exp_sch_item[$T_sch_item_i], $T_exp[$T_i]);	// 각 키워드 앞의 문자를 연산처리
					}
					$sub_query_3[] = '(' . implode(" {$T_method} ", $sub_query_1) . ')';
				}
			}
			if (sizeof($sub_query_3) > 0) $T_sub_query[] = '(' . implode(" or ", $sub_query_3) . ')';
		}
		
		if ($list_info[sort_field] == '') $sort_field = array("is_notice", "fid", "thread");																									// 정렬 서브쿼리 설정 (예 : SI_F_fldname , SI_S_fldname);
		else $sort_field = array($list_info[sort_field]);
		if ($list_info[sort_sequence] == '') $sort_sequence = array("desc", "desc", "asc");
		else $sort_sequence = array($list_info[sort_sequence]);
		$sort_method = $GLOBALS[lib_common]->get_query_sort("SI_F_", $sort_field, $sort_sequence);
		switch ($list_info[query_type]) {
			case "1" :
				if ($user_info[user_level] > $GLOBALS[VI][admin_level_user] && !in_array($user_info[serial_num], explode(',', $board_info[admin]))) $T_sub_query[] = "is_view<>'N'";
				$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
			break;
			case "2";		// 원래게시물
				if ($user_info[user_level] > $GLOBALS[VI][admin_level_user] && !in_array($user_info[serial_num], explode(',', $board_info[admin]))) $T_sub_query[] = "thread='A' and is_view<>'N'";
				else  $T_sub_query[] = "thread='A'";
				$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
			break;
			case "3";		// 본인게시물
				if ($user_info[user_level] > $GLOBALS[VI][admin_level_user] && !in_array($user_info[serial_num], explode(',', $board_info[admin]))) {
					$query = "select fid from $table_name where writer_id='{$user_info[id]}' group by fid";
					$result_mine = $GLOBALS[lib_common]->querying($query);
					$sub_query_mine = '';
					while ($value_mine = mysql_fetch_row($result_mine)) $sub_query_mine .= "fid='$value_mine[0]' or ";
					if ($sub_query_mine != "") $sub_query_mine = "and (" . substr($sub_query_mine, 0, -4) . ")";
					else $sub_query_mine = "and fid=''";	// 쓴 글이 없는 경우
					$T_sub_query[] = "is_view<>'N' {$sub_query_mine}";
					$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";					
				} else {
					$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
				}
			break;
			case "4" :	// 관련게시물
				if ($article_num != '') {
					$article_fid_query = "select fid from $table_name where serial_num='$article_num'";
					$result = $GLOBALS[lib_common]->querying($article_fid_query, "fid 추출 쿼리 수행중 에러발생");
					$article_fid = mysql_result($result, 0, 0);
					//$T_sub_query[] = "fid='$article_fid' and serial_num<>'{$article_num}'";
					$T_sub_query[] = "fid='$article_fid'";
					$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
				} else {
					$article_fid_query = "select serial_num, fid from $table_name limit 1";
					$result = $GLOBALS[lib_common]->querying($article_fid_query, "fid 추출 쿼리 수행중 에러발생");
					$article_fid = mysql_fetch_array($result);
					//$T_sub_query[] = "fid='$article_fid[fid]' and serial_num<>'{$article_fid[serial_num]}'";
					$T_sub_query[] = "fid='$article_fid[fid]'";
					$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
				}
			break;
			case "5" :	// 이전게시물
				$T_sub_query[] = "serial_num < $article_num";
				$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " order by serial_num desc limit 1";
			break;
			case "6" :	// 다음게시물
				$T_sub_query[] = "serial_num > $article_num";
				$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " order by serial_num asc limit 1";
			break;
			case "7" :	// 댓글
				$T_sub_query[] = "relation_table='{$list_info[relation_table]}'";
				$T_sub_query[] = "relation_serial='{$article_num}'";
				$sub_query = $lib_insiter->make_sub_query($T_sub_query, $list_info[user_query], $list_info[category_disabled]) . " $sort_method";
			break;
		}
	} else {
		if ($article_num != '') $sub_query = " where serial_num='$article_num'";
		else $sub_query = '';
		$error_msg = "지정 게시물 추출 쿼리 수행중 에러";
	}
	$query = "select * from $table_name $sub_query";
	return $query;
}

// 로그인 입력상자 생성 함수
function make_login_box($exp_design_line) {
	global $lib_insiter;
	$name = $exp_design_line[1];
	$type = $exp_design_line[2];
	$default_pp = $exp_design_line[3];
	$item_define = $exp_design_line[4];
	$divider = $exp_design_line[5];
	if ($exp_design_line[6] != '') $name = $name . "_{$exp_design_line[6]}";
	switch ($name) {
		case "user_id" :
			$GLOBALS[JS_CODE][LOGIN_FOCUS] = "Y";	
			if ($_COOKIE[VG_save_user_id] != '') $saved_value = $_COOKIE[VG_save_user_id];
		break;
		case "user_passwd" :
			if ($_COOKIE[VG_save_user_passwd] != '') $saved_value = $_COOKIE[VG_save_user_passwd];
		break;
		case "save_user_id" :
			$default_value = 'Y';
			if ($_COOKIE[VG_save_user_id] != '') $saved_value = 'Y';
		break;
		case "save_user_passwd" :
			$default_value = 'Y';
			if ($_COOKIE[VG_save_user_passwd] != '') $saved_value = 'Y';
		break;
	}

	// 입력상자 형태별 설정
	if ($item_define != '') {		// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
		$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $saved_value, $divider, $default_pp);
	} else {															// 기타.
		$value = $GLOBALS[lib_common]->make_input_box($saved_value, $name, $type, $default_pp, '', $default_value);
	}
	return $value;
}

// 회원 입력상자 생성함수
function make_join_box($user_info, $exp_design_line, $member_field_defines) {
	global $lib_insiter, $site_info, $DIRS;
	$name = $exp_design_line[1];
	if (is_array($member_field_defines[$name]) && ($member_field_defines[$name][0] == "select" || $member_field_defines[$name][0] == "checkbox" || $member_field_defines[$name][0] == "radio")) {
		$type = $member_field_defines[$name][0];
		$default_pp = $member_field_defines[$name][3];
		$item_define = $member_field_defines[$name][1];
	} else {
		$type = $exp_design_line[2];
		$default_pp = $exp_design_line[3];
		$item_define = $exp_design_line[4];
	}	
	if ($exp_design_line[5] != '') $divider = $exp_design_line[5];
	else $divider = "&nbsp;";	
	
	// 필드별 기본값 재설정등 개별 설정
	if ($_GET[real_name] != '') $T_saved_name = $_GET[real_name];
	else $T_saved_name = $user_info[name];
	if ($_GET[real_jumin_number] != '') $T_saved_jumin_number = $_GET[real_jumin_number];
	else $T_saved_jumin_number = $user_info[jumin_number];
	switch ($name) {
		case 'passwd' :
			$saved_value = '';
		break;
		case 'name' :
			$saved_value = $T_saved_name;
		break;
		case 'jumin_number' :
			$saved_value = $T_saved_jumin_number;
		break;
		case 'jumin_number_1' :
			$jumin_number = explode($GLOBALS[DV][ct6], $T_saved_jumin_number);
			$saved_value = $jumin_number[0];
		break;
		case 'jumin_number_2' :
			$jumin_number = explode($GLOBALS[DV][ct6], $T_saved_jumin_number);
			$saved_value = $jumin_number[1];
		break;
		case "birth_1" :
			$birth = explode($GLOBALS[DV][ct6], $user_info[birth_day]);
			$saved_value = $birth[0];
		break;
		case "birth_2" :
			$birth = explode($GLOBALS[DV][ct6], $user_info[birth_day]);
			$saved_value = $birth[1];
		break;
		case "birth_3" :
			$birth = explode($GLOBALS[DV][ct6], $user_info[birth_day]);
			$saved_value = $birth[2];
		break;
		case 'post_1' :
			$post = explode($GLOBALS[DV][ct6], $user_info[post]);
			$saved_value = $post[0];
		break;
		case 'post_2' :
			$post = explode($GLOBALS[DV][ct6], $user_info[post]);
			$saved_value = $post[1];
		break;
		case 'phone_1' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone]);
			$saved_value = $phone_number[0];
		break;
		case 'phone_2' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone]);
			$saved_value = $phone_number[1];
		break;
		case 'phone_3' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone]);
			$saved_value = $phone_number[2];
		break;
		case 'phone_mobile_1' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_mobile]);
			$saved_value = $phone_number[0];
		break;
		case 'phone_mobile_2' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_mobile]);
			$saved_value = $phone_number[1];
		break;
		case 'phone_mobile_3' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_mobile]);
			$saved_value = $phone_number[2];
		break;
		case 'phone_fax_1' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_fax]);
			$saved_value = $phone_number[0];
		break;
		case 'phone_fax_2' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_fax]);
			$saved_value = $phone_number[1];
		break;
		case 'phone_fax_3' :
			$phone_number = explode($GLOBALS[DV][ct6], $user_info[phone_fax]);
			$saved_value = $phone_number[2];
		break;
		case 'email_1' :
			$email = explode('@', $user_info[email]);
			$saved_value = $email[0];
		break;
		case 'email_2' :
			$email = explode('@', $user_info[email]);
			$saved_value = $email[1];
		break;
		case 'biz_number_1' :
			$biz_number_number = explode($GLOBALS[DV][ct6], $user_info[biz_number]);
			$saved_value = $biz_number_number[0];
		break;
		case 'biz_number_2' :
			$biz_number_number = explode($GLOBALS[DV][ct6], $user_info[biz_number]);
			$saved_value = $biz_number_number[1];
		break;
		case 'biz_number_3' :
			$biz_number_number = explode($GLOBALS[DV][ct6], $user_info[biz_number]);
			$saved_value = $biz_number_number[2];
		break;
		default :
			$saved_value = $user_info[$name];
		break;
	}

	// 입력상자 형태별 설정
	if ($item_define != '') {		// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
		$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $saved_value, $divider, $default_pp);
	} else if ($type == "file") {
		$value = $GLOBALS[lib_common]->get_file_upload_box($name, $exp_design_line[6], $saved_value, $default_pp) . $etc_tag;
	} else {															// 기타
		$value = $GLOBALS[lib_common]->make_input_box($saved_value, $name, $type, $default_pp, '', $default_value) . $etc_tag;
	}
	return $value;
}

##### 이미지를 출력하는 함수 #####
function input_image($root, $img_src, $property, $style) {
	if ($property != "") $property = " $property";
	if ($style != "") $style = " $style";
	$image = "<img src='{$img_src}'{$property}{$style}>";
	return $image;
}

######### 폼 속성을 결정하는 함수 #########
function board_form($board_info, $page_type, $verify_input, $table_index, $form_property, $relation_table='') {
	global $root, $design_file, $lib_insiter, $article_num, $site_info, $DB_TABLES, $DIRS;
	$T_exp = explode('=', $table_index);
	$form_name = "{$DB_TABLES[board]}_{$board_info[name]}_{$page_type}_{$T_exp[1]}";
	switch($page_type) {
		case "LIST" :
			$form_action = $site_info[index_file];
			$form_method = "get";
			$hidden_tag = "<input type=hidden name=design_file value='$board_info[list_page]'>";
		break;
		case "WRITE" :
			$form_action = "{$DIRS[board_root]}article_write.php";
		break;
		case "MODIFY" :
			$form_action = "{$DIRS[board_root]}article_modify.php";
			$hidden_tag = "<input type=hidden name=article_num value='$article_num'>";
		break;
		case "DELETE" :
			$form_action = "{$DIRS[board_root]}article_delete.php";
			$hidden_tag = "<input type=hidden name=article_num value='$article_num'>";
		break;
		case "REPLY" :
			$form_action = "{$DIRS[board_root]}article_reply.php";
			$hidden_tag = "<input type=hidden name=article_num value='$article_num'>";
		break;
		case "COMMENT" :
			$form_action = "{$DIRS[board_root]}article_comment.php";
			$hidden_tag = "<input type=hidden name=relation_table value='$relation_table'><input type=hidden name=relation_serial value='$article_num'>";
		break;
	}
	if ($page_type != "LIST") {		// 목록이 아닌경우 기본적인 폼 정보.
		$form_method = "post";
		$hidden_tag .= "
				<input type='hidden' name='flag' value='{$_SERVER[HTTP_HOST]}'>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
				<input type='hidden' name='board' value='$board_info[name]'>
		";
	}
	// 폼속성 정의
	$exp_form_property = explode($GLOBALS[DV][ct4], $form_property);
	if (trim($exp_form_property[0]) != '') $property = $exp_form_property[0];
	if (trim($exp_form_property[2]) != '') $hidden_tag .="<input type='hidden' name='after_db_script' value=\"$exp_form_property[2]\">";
	if (trim($exp_form_property[3]) != '') $hidden_tag .="<input type=hidden name='after_db_msg' value='$exp_form_property[3]'>";
	make_form($form_name, $form_method, $form_action, $property, $verify_input, $table_index, $page_type, $hidden_tag, $exp_form_property[1]);
	return $form_name;
}

function member_form($page_type, $prev_url, $verify_input, $table_index, $form_property) {
	global $DIRS, $design, $lib_insiter, $lib_fix, $form_close_line, $site_info;
	$table_end_index = $lib_fix->search_line($design, $table_index);
	$form_close_line = $table_end_index[1];
	$form_name = "TCSYSTEM_" . $page_type . "_FORM";
	switch($page_type) {
		case "LOGIN" :
			$form_action = "{$DIRS[member_root]}login_process.php";
		break;
		case "MEMBER" :
			$form_action = "{$DIRS[member_root]}member_manager.php";
			if (!$lib_insiter->is_login()) $hidden_tag = "<input type=hidden name=proc_mode value='add'><input type=hidden name=id_hidden value=''>";		// 로그인 상태가 아닌경우
			else $hidden_tag = "<input type=hidden name=proc_mode value='modify'>";													// 로그인 상태인 경우			
		break;
	}
	// 폼속성 정의
	$exp_form_property = explode($GLOBALS[DV][ct4], $form_property);
	if (trim($exp_form_property[0]) != '') $property = $exp_form_property[0];
	if (trim($exp_form_property[2]) != '') $hidden_tag .="<input type=hidden name='after_db_script' value=\"" . stripslashes($exp_form_property[2]) . "\">";
	if (trim($exp_form_property[3]) != '') $hidden_tag .="<input type=hidden name='after_db_msg' value='$exp_form_property[3]'>";
	if ($prev_url == '') {
		switch ($exp_form_property[4]) {
			case 'C' :																			// 현재페이지
				$prev_url = "http://{$_SERVER[SERVER_NAME]}{$_SERVER[REQUEST_URI]}";
			break;
			case 'S' :																			// 기본설정에 로그인 다음페이지로 설정된값
				$prev_url = $site_info[login_next_page];
			break;
			default :
				$prev_url = $_SERVER[HTTP_REFERER];
			break;
		}
	}
	$hidden_tag .= "
		<input type='hidden' name='flag' value='{$_SERVER[HTTP_HOST]}'>
		<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
		<input type=hidden name='http_referer' value='$prev_url'>
	";	
	make_form($form_name, "post", $form_action, $form_property, $verify_input, $table_index, $page_type, $hidden_tag, $exp_form_property[1]);
	return $form_name;
}

function make_form($form_name, $form_method="post", $form_action, $property, $verify_input, $table_index, $page_type, $hidden_tag='', $submit_script) {
	global $import_files_size;
	$GLOBALS[TABLE_INDEX] = $table_index . "_" . $import_files_size;	// 폼 닫는 태그를 넣기 위한 플래그 (임포트와 실제를 구분하여 저장함)
	if ($form_property == '') $form_property = "name='$form_name' method='$form_method' action='$form_action' enctype='multipart/form-data' onsubmit='return {$form_name}_submit()'";
	print("<form {$form_property}>{$hidden_tag}");
	$GLOBALS[JS][] = make_submit($page_type, $form_name, $verify_input, $submit_script);	 // 각 폼에따른 입력값 검사 자바스크립트를 만든다.
}

function dep_make_j_source($name, $msg) {
	$returnValue = "
		if (form.{$name}.value == '') {
			alert('$msg');
			{$exception_str}form.{$name}.focus();
			if (button_type == 'text') return;
			else return false;
			//return false;
		}
	";
	return $returnValue;
}

function make_submit($page_type, $form_name, $input_code, $submit_script) {
	global $lib_insiter;
	$GLOBALS[JS_CODE][RADIO_CHECK] = 'Y';
	$j_source = "
		function {$form_name}_submit(button_type) {
			var form = document.{$form_name};
	";
	$exp_code = explode($GLOBALS[DV][ct4], $input_code);
	if (($page_type == "WRITE") || ($page_type == "MODIFY") || ($page_type == "REPLY") || ($page_type == "DELETE") || ($page_type == "COMMENT")) {
		$j_source .= "if (form.editor_yn != undefined) submit_editor('$form_name');\n";	 // html 편집기가 폼에 포함되어 있는 경우(html 편집모드, 일반모드 선택버튼 존재유무로 판단)
		$j_source .= "if (form.passwd != undefined) {\n" . dep_make_j_source("passwd", "비밀번호를 입력하세요, 포커스가 이동합니다.") . "\n }";
		for ($Ai=0,$cnt=sizeof($exp_code); $Ai<$cnt; $Ai++) {
			if ($exp_code[$Ai] == "" || $exp_code[$Ai] == "passwd") continue;
			$j_source .= dep_make_j_source($exp_code[$Ai], "필수 입력사항을 채워주세요, 포커스가 이동합니다.");
		}
	} else if ($page_type == "LOGIN") {
		$j_source .= "
			if (typeof(form.user_level) != 'undefined') {
				if (radio_check(form, 'user_level', 'radio') == 0) {
					alert('회원 분류를 선택하세요');
					if (button_type == 'text') return;
					else return false;
				}
			}
		";
		$j_source .= dep_make_j_source("user_id", "아이디를 입력해주세요");
		$j_source .= dep_make_j_source("user_passwd", "비밀번호를 입력해주세요");
	} else if ($page_type == "MEMBER") {
		if ($lib_insiter->is_login() != true) {
			$j_source .= "
				if (form.id.value == '' || form.id_hidden.value == '' || (form.id.value != form.id_hidden.value)) {
					alert('아이디 검색을 이용해서 아이디를 입력해주세요');
					form.id.focus();
					if (button_type == 'text') return;
					else return false;
				}
				if (form.passwd.value == '') {
					alert('비밀번호를 입력해주세요');
					form.passwd.focus();
					if (button_type == 'text') return;
					else return false;
				}
				if (form.passwd_re.value == '') {
					alert('비밀번호확인란을 입력해주세요');
					form.passwd_re.focus();
					if (button_type == 'text') return;
					else return false;
				}
			";
		}
		$j_source .= "
			if (typeof(form.passwd) != 'undefined') {
				if (form.passwd.value != form.passwd_re.value) {
					alert('입력된 비밀번호가 서로 맞지 않습니다. 다시 입력해주세요');
					form.passwd.focus();
					if (button_type == 'text') return;
					else return false;
				}
			}
		";

		for ($Ai=0,$cnt=sizeof($exp_code); $Ai<$cnt; $Ai++) {
			if ($exp_code[$Ai] == "") continue;
			if ($exp_code[$Ai] == "jumin_number") {
				$j_source .= "
					T_jumin_number = '';
					if (typeof(form.jumin_number) != 'undefined') {	// 단일 주민번호입력 상자인경우
						T_jumin_number = form.jumin_number.value;
						jumin_obj = form.jumin_number;
					} else {
						T_jumin_number = form.jumin_number_1.value + '-' + form.jumin_number_2;
						jumin_obj = form.jumin_number_1;
					}
					var chk =0
					var yy = T_jumin_number.substring(0, 2)
					var mm = T_jumin_number.substring(2, 4)
					var dd = T_jumin_number.substring(4, 6)
					var sex = T_jumin_number.substring(7, 8)
					if ((T_jumin_number.length != 14) || (yy < 25 || mm < 1 || mm > 12 || dd < 1) || (sex != 1 && sex !=2 )) {
						alert('주민등록번호를 바로 입력하여 주십시오.');
						jumin_obj.focus();
						if (button_type == 'text') return;
						else return false;
					}
					// 주민등록번호 체크
					T_jumin_number_one = T_jumin_number.substring(0, 6);
					T_jumin_number_two = T_jumin_number.substring(7, 14);
					for (var i = 0; i <=5 ; i++){ 
						chk = chk + ((i%8+2) * parseInt(T_jumin_number_one.substring(i,i+1)))
					}
					for (var i = 6; i <=11 ; i++){ 
						chk = chk + ((i%8+2) * parseInt(T_jumin_number_two.substring(i-6,i-5)))
					}
					chk = 11 - (chk %11)
					chk = chk % 10
					if (chk != T_jumin_number_two.substring(6,7)) {
						alert ('유효하지 않은 주민등록번호입니다.');
						jumin_obj.focus();
						if (button_type == 'text') return;
						else return false;
					}
				";
			} else {
				$j_source .= dep_make_j_source($exp_code[$Ai], "필수 입력사항을 채워주세요, 포커스가 이동합니다.");
			}
		}
	}
	$j_source .= "
			$submit_script
			if (button_type == 'text') form.submit();
			else return true;
		}
	";
	return $j_source;
}

// 공백을 넣는 함수
function insert_blank($tag, $tag_both, $blanks, $perm) {
	global $lib_insiter, $design, $user_info, $i_viewer, $skip_info;
	// 태그가 없거나, 출력 조건에 맞지 않으면
	if (($tag == '') || (($perm != '') && ($lib_insiter->is_skip($design, $perm, $user_info[user_level], $i_viewer, '', $skip_info) != "VIEW"))) return;
	$exp_tag_both = explode($GLOBALS[DV][ct4], $tag_both);	// 좌우 태그 불러옴
	$tag_open = $exp_tag_both[0];
	$tag_close = $exp_tag_both[1];
	$tag = $tag_open . $tag . $tag_close;
	$blanks = explode($GLOBALS[DV][ct4], $blanks);	 // 공백개수 불러옴.
	for ($i=0; $i<$blanks[0]; $i++) $tag = "<br>{$tag}";
	for ($i=0; $i<$blanks[1]; $i++) $tag = "{$tag}<br>";		
	for ($i=0; $i<$blanks[2]; $i++) $tag = "&nbsp;{$tag}";
	for ($i=0; $i<$blanks[3]; $i++) $tag = "{$tag}&nbsp;";
	return $tag;
}

function print_javascript() {
	global $DIRS;
	print("
		<script language='javascript1.2'>
			<!--
	");
	while (list($key, $value) = each($GLOBALS[JS_CODE])) {
		if ($value == 'Y') {
			switch ($key) {
				case "RADIO_CHECK" :
					print("
						function radio_check(form, name, input_type) {
							frm_els = form.elements;
							cnt = frm_els.length ;
							select_flag = 0;
							for (i=0; i<cnt; ++i) {
								if (frm_els[i].type == input_type && frm_els[i].name == name) {
									if (frm_els[i].checked && frm_els[i].value != '') select_flag = 1;
								}
							}
							return select_flag;
						}
					");
				break;
				case "MULTI_SELECT" :
					print("
						function multi_select(form, new_name, name, divider) {
							multi_value = divider;
							T_name = eval(\"form.\" + name);
							T_new_name = eval(\"form.\" + new_name);
							select_flag = 0;						
							for (var i=0; i<T_new_name.length; i++) {
								if (T_new_name.options[i].selected && T_new_name.options[i].value != '') {
									multi_value += T_new_name.options[i].value + divider;
									select_flag = 1;
								}
							}						
							if (select_flag == 1) T_name.value = multi_value;
							else T_name.value = '';
						}
					");
				break;
				case "MULTI_CHECK" :
					print("
						function multi_check(form, new_name, name, divider) {
							multi_value = divider;
							frm_els = form.elements;
							cnt = frm_els.length ;
							nm_cnt = new_name.length;
							select_flag = 0;
							for (i=0; i<cnt; ++i) {
								if (frm_els[i].type == 'checkbox' && frm_els[i].name.substring(0, nm_cnt) == new_name) {
									if (frm_els[i].checked && frm_els[i].value != '') multi_value += frm_els[i].value + divider;
									select_flag = 1;
								}
							}
							T_name = eval(\"form.\" + name);
							if (select_flag == 1) T_name.value = multi_value;
							else T_name.value = '';
						}
					");
				break;
				case "MOUSEOVER_VIEW" :
					print("
						var version = 0;
						if (navigator.userAgent.indexOf('Mozilla/3.') >=0) {
							version = 3;
						}
						if (navigator.userAgent.indexOf('Mozilla/4.') >=0) {
							version = 4;
						}
						function mouseover_view(origin_image, img) {
							if (version >= 3) { 
								source1 = eval(img + '.src');
								origin = eval('document.' + origin_image);
								origin.src = source1;
							 }
						}
					");
				break;
				case "SUBJECT_LAYER" :
					print("
						function show_answer(q, a) {
							var tagName = '';
							var id = '';
							if (a.style.display != 'none') {	// 클릭한 레이어가 열려 있으면
								hide_answer(a);
								return;
							}
							// 레이어 자동 닫힘 부분
							for(var obj in document.all) {
								tagName = document.all[obj].tagName;
								id = document.all[obj].id;
								if (tagName == 'DIV') {
									if (!id.indexOf('A')) document.all[obj].style.display = 'none';
								}
							}
							a.style.display = 'block';
						}
						function hide_answer(a) {
							a.style.display = 'none';
						}
						function show_all_answer() {
							var tagName = '';
							var id = '';
							for(var obj in document.all) {
								tagName = document.all[obj].tagName;
								id = document.all[obj].id;
								if (tagName == 'DIV') {
									if (!id.indexOf('A') && document.all[obj].style.display == 'none') document.all[obj].style.display = 'block';
									else document.all[obj].style.display = 'none';
								}
							}
						}
					");
					break;
				case "DELETE_ITEM" :
					print("
						function delete_user_image(item) {
							object_item = 'document.all.' + item;
							eval(object_item).value= '';
						}
					");
				break;
				case "LOGIN_FOCUS" :
					print("document.all.user_id.focus();document.all.user_id.focus();");
				break;
				case "PRIVATE_ARTICLE" :
					print("
						function SYSTEM_on_passwd_input(form_action, target, e) {
							if (passwd_box.style.visibility != 'visible') {
								passwd_box.style.visibility = 'visible';								
								var x = (e.pageX) ? e.pageX : document.body.scrollLeft+event.clientX;
								var y = (e.pageY) ? e.pageY : document.body.scrollTop+event.clientY;								
								passwd_box.style.left = x - 200;
								passwd_box.style.top = y - 80;
								document.TC_FORM_PASSWD.submit_passwd.focus();
								document.TC_FORM_PASSWD.action= form_action;
								document.TC_FORM_PASSWD.target= target;
							} else {
								passwd_box.style.visibility = 'hidden';
							}
						}
						function SYSTEM_off_passwd_input() {
							passwd_box.style.visibility = 'hidden';
						}
						function SYSTEM_input_check(form) {
							if (form.submit_passwd.value == '') {
								alert('비밀번호를 입력하세요');
								form.submit_passwd.focus();
								return 0;
							}
							form.submit();
						}
					");
				break;
				case "SEARCH_ID" :
					print("
						function open_search_id(ref) {
							id = eval(document.all.id);
							if (!id.value) {
								alert('아이디(ID)를 입력하신 후에 확인하세요!');
								id.focus();
								return;
							}
							reg_express = new RegExp('^[a-z0-9]{6,15}$');
							if (!reg_express.test(id.value)) {
								alert('6~15자리의 영문 또는 숫자로 이루어진 아이디만 사용 가능합니다.');
								id.value = '';
								return
							}
							ref = ref + \"&id=\" + id.value;
							var window_left = (screen.width-640)/2;
							var window_top = (screen.height-480)/2;
							window.open(ref,\"win_search_id\",'width=400,height=220,status=no,top=' + window_top + ',left=' + window_left + '').focus();
						}
					");
				break;
				case "SEARCH_POST" :
					print("
						function open_search_post(ref) {
							var window_left = (screen.width-700)/2;
							var window_top = (screen.height-480)/2;
							window.open(ref,\"win_search_post\",'width=550,height=450,status=yes,resizable=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '').focus();
						}
					");
				break;
				case "CATEGORY_GO" :
					print("
						function MM_jumpMenu(targ,selObj,restore){ //v3.0
							if (selObj.tagName == \"SELECT\") {
								eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
								if (restore) selObj.selectedIndex = 0;
							} else {
								eval(targ+\".location='\"+selObj.value+\"'\");
								if (restore) selObj.checkedIndex = 0;
							}
						}
					");
				break;
				case "VERIFY_MULTI_CHECK" :
					print("
						function verify_multi_check(form, box_name) {
							frm_els = form.elements;
							cnt = frm_els.length ;
							nm_cnt = box_name.length;
							select_flag = 0;
							for (i=0; i<cnt ; ++i) {
								if (frm_els[i].type == 'checkbox' && frm_els[i].name.substring(0, nm_cnt) == box_name) {
									if (frm_els[i].checked) select_flag = 1;
								}
							}
							return select_flag;
						}
					");
				break;
			}
		}
	}
	for ($i=0,$cnt=sizeof($GLOBALS[JS]); $i<$cnt; $i++) print($GLOBALS[JS][$i] . "\n");			// 출력할 자바스크립트 출력
	print("
			//-->
		</script>
	");
	while (list($key, $value) = each($GLOBALS[ETC_CODE])) {
		if ($value == "Y") {
			switch ($key) {
				case "PRIVATE_LAYER" :
					print("
						<div id='passwd_box' align='center' valign='middle' style='width=500 height:300; visibility:hidden; position:absolute; left:0; top:0; z-index:1'>
						<form name='TC_FORM_PASSWD' action='real_time' method='post' onsubmit='SYSTEM_input_check(document.TC_FORM_PASSWD); return false'>
						<table width='400' border='0' cellspacing='1' cellpadding='0' bgcolor='#CCCCCC'>
							<tr>
								<td bgcolor='#FFFFFF'><img src='{$DIRS[designer_root]}images/board/pass.gif' width='400' height='50'></td>
							</tr>
							<tr>
								<td bgcolor='#FDFDFD' height='100' valign='middle' align='center' background='{$DIRS[designer_root]}images/board/back.gif'> 
									<table width='200' border='0' cellspacing='0' cellpadding='2'>
										<tr>
											<td>
												<input type='password' name='submit_passwd' size='12' maxlangth='12' style='BORDER-RIGHT: #7D9CB8 1px solid; BORDER-TOP: #7D9CB8 1px solid; BORDER-LEFT: #7D9CB8 1px solid; BORDER-BOTTOM: #7D9CB8 1px solid'>
											</td>
											<td><input type='image' src='{$DIRS[designer_root]}images/board/write.gif' width='52' height='19'></td>
											<td><a href='javascript:SYSTEM_off_passwd_input()'><img src='{$DIRS[designer_root]}images/board/close.gif' width='52' height='19' border='0'></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</form>
						</div>
					");
				break;
			}
		}
	}
	for ($i=0,$cnt=sizeof($GLOBALS[ETC]); $i<$cnt; $i++) print($GLOBALS[ETC][$i] . "\n");		// 기타 태그 출력(레이어등)
}

// 사용자 명령 처리부
function exec_user_command($user_exec) {
	global $root, $DIRS, $DB_TABLES;
	include "{$DIRS[user_define]}exec_user_command.inc.php";
	return $tag;
}
?>