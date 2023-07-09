<?
$is_repeat = "N";	// 반복라인은 라인수와 편집버튼에 반영하지 않는다.
$repeat_number = 0;
$repeat_table_index = $repeat_tr_index = ""; // 반복되는 인덱스를 저장함.
$read_line = 0;	// 임포트를 제외한 현재 라인을 저장하는 변수
$import_files = $import_lines = array();	// 임포트된 파일, 라인들을 저장
$import_files_size = 0;

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$open_html_tag = "<html>\n";
$close_html_tag = "</html>";
$header_tag = "<script src='designer/include/js/javascript.js'></script>\n";
if ($site_page_info[tag_header] != '') $header_tag .= "{$site_page_info[tag_header]}\n";
if ($site_page_info[tag_body] == '') $open_body_tag = "<body>\n";
else $open_body_tag = "{$site_page_info[tag_body]}\n";
$body_in_tag = "{$site_page_info[tag_body_in]}\n";
$body_out_tag = "{$site_page_info[tag_body_out]}\n";
$close_body_tag = "</body>\n";

ob_start();
echo($open_html_tag . $header_tag . $open_body_tag . $body_in_tag);
// 테이블별 출력권한 정보
if ($_SESSION[view_design_file] == '') $T_view_design_file = $site_page_info[file_name];
else $T_view_design_file = $_SESSION[view_design_file];
if ($_SESSION[view_menu] == '') $T_view_menu = $site_page_info[menu];
else $T_view_menu = $_SESSION[view_menu];
if ($_SESSION[view_group] == '') $T_view_group = $site_page_info[udf_group];
else $T_view_group = $_SESSION[view_group];
if ($_SESSION[view_page_type] == '') $T_view_page_type = $site_page_info[type];
else $T_view_page_type = $_SESSION[view_page_type];
$skip_info = array("page_menu"=>$T_view_menu, "design_file"=>$T_view_design_file, "udf_group"=>$T_view_group, "page_type"=>$T_view_page_type);

for($i_class_review = 0; $i_class_review < sizeof($design); $i_class_review++) {
	$exp = explode($GLOBALS[DV][dv], $design[$i_class_review]);
	switch ($exp[0]) {
		case "테이블시작" :
			if ($exp[3] != '' && $_SESSION[view_all] != 'Y') {	// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $_SESSION[view_level], $i_class_review, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$table_lines = $is_skip - $i_class_review;
					$i_class_review = $is_skip;
					if ($import_files_size == 0) $read_line += $table_lines;
					break;
				}
			}
			if ($exp[13] != '') {
				$skin_info = explode($GLOBALS[DV][ct4], $exp[13]);
				$img_dir = "{$DIRS[designer_root]}images/box/{$skin_info[0]}/";
				$skin_file_contents = $lib_insiter->get_skin_file("{$img_dir}index.html", array("img_dir"=>$img_dir, "title"=>$skin_info[1], "padding"=>$skin_info[2]));
				if ($skin_file_contents != '') {
					$skin_file_contents = explode("%CONTENTS%", $skin_file_contents);
					echo($skin_file_contents[0]);
					$T_val_name = "TS_{$exp[1]}_close";
					$$T_val_name = $skin_file_contents[1];
				}
			}
			if (!strcmp($exp[4], "TC_BOARD")) {
				$exp[4] = '';
				$design[$i_class_review] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
				$exp_1 = explode(":", $exp[5]);		// 게시판 기능 속성을 불러온다.
				$page_type = $exp_1[1];					// 게시판의 형식을 나타낸다.(LIST:목록,WRITE:쓰기,MODIFY:수정,DELETE:삭제,REPLY:답변)
				if ($exp_1[3] == '0') $exp_1[3] = 10;
				$table_per_article = $repeat_number = $exp_1[3];
				$table_per_block = $exp_1[4];
				$div_article = $exp_1[5];
				$board_info = $lib_fix->get_board_info($exp_1[0]);		//게시판의 정보를 디비에서 읽어온다.
			} else if (!strcmp($exp[4], "TC_LOGIN")) {
				$page_type = "LOGIN";
			} else if (!strcmp($exp[4], "TC_MEMBER")) {
				$pageType = "MEMBER";
				$member_field_defines = $lib_insiter->member_field_define($site_info, $user_info);	// 회원 필드 사용자정의
			}
			$index = $exp[1];
			if ($_SESSION[view_mode] != "hide") $exp[2] = " border=1 " . $exp[2];
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			echo("{$tag_both[$exp[1]][0]}<table {$exp[2]}>\n");
			if ($exp[9] == "반복")	{	// 반복되는 위치의 시작을 기억해두고 반복될때 마다 레코드를 하나씩 가져온다.
				$repeat_table_line = $i_class_review;
				$repeat_table_index = $exp[1] . "_" . $import_files_size;
				$exp[9] = "";
				$design[$i_class_review] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
			}
		break;

		case "테이블끝" :
			if ($repeat_table_index == $exp[1] . "_" . $import_files_size) {		 // 테이블반복이 설정된 인덱스와 비교
				$is_repeat = "Y";
				if ($repeat_number > 1) {
					$i_class_review = $repeat_table_line - 1;		 // 현재 인덱스를 테이블 반복 시작 인덱스로 바꿈.
					$repeat_number--;							// 반복회수 차감
				} else {
					$repeat_table_index = "";
					$is_repeat = "N";
				}
			}
			echo("</table>{$tag_both[$exp[1]][1]}");
			if ($repeat_table_index == $exp[1] . "_" . $import_files_size) if (($div_article > 0) && (($table_per_article-$repeat_number)%$div_article == 0)) echo("\n<br clear=all>\n");
			$T_val_name = "TS_{$exp[1]}_close";
			if ($$T_val_name != '') {
				echo($$T_val_name);
				unset($$T_val_name);
			}
		break;

		case "줄시작" :
			if ($exp[3] != '' && $_SESSION[view_all] != 'Y') {	// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $_SESSION[view_level], $i_class_review, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$table_lines = $is_skip - $i_class_review;
					$i_class_review = $is_skip;
					if ($import_files_size == 0) $read_line += $table_lines;
				break;
				}
			}
			$index = $exp[1];
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			echo("{$tag_both[$exp[1]][0]}<tr $exp[2]>\n");
			if (!strcmp("반복", $exp[9]))	{	// 반복되는 위치의 시작을 기억해두고 반복될때 마다 레코드를 하나씩 가져온다.
				$repeat_tr_line = $i_class_review;
				$repeat_tr_index = $exp[1] . "_" . $import_files_size;
				$exp[9] = "";
				$design[$i_class_review] = implode($GLOBALS[DV][dv], $exp);	// 반복될 경우를 대비해서 테이블 설정을 삭제한다.
			}
		break;

		case "줄끝" :
			if ($repeat_tr_index == $exp[1] . "_" . $import_files_size) {	 // 줄반복이 설정된 인덱스와 비교.
				$is_repeat = "Y";
				if ($repeat_number > 1) {
					$i_class_review = $repeat_tr_line - 1;	 // 현재 인덱스를 테이블 반복 시작 인덱스로 바꿈.
					$repeat_number--;				// 반복회수 차감
				} else {
					$repeat_tr_index = "";
					$is_repeat = "N";
				}
			}
			echo("</tr>{$tag_both[$exp[1]][1]}\n");
		break;

		case "칸시작" :
			if ($exp[3] != '' && $_SESSION[view_all] != 'Y') {	// 출력 권한 처리부
				$is_skip = $lib_insiter->is_skip($design, $exp[3], $_SESSION[view_level], $i_class_review, $exp[1], $skip_info);
				if ($is_skip != "VIEW") {	// 볼수 없는 권한 테이블 이면 건너 뜀
					$table_lines = $is_skip - $i_class_review;
					$i_class_review = $is_skip;
					if ($import_files_size == 0) $read_line += $table_lines;
				break;
				}
			}
			$index = $exp[1];
			if ($exp[12] != '') $tag_both[$exp[1]] = explode($GLOBALS[DV][ct4], $exp[12]);
			else $tag_both[$exp[1]] = array();
			echo("{$tag_both[$exp[1]][0]}<td {$exp[2]}>\n");
			// 칸 안쪽에 테이블이 있거나 비어 있는 칸인경우 입력버튼이 자리를 차지하고 그렇지 않은경우 자리를 차지 하지 않는다.
			if((substr($design[$i_class_review+1], 0, 6) == "테이블") || (substr($design[$i_class_review+1], 0, 4) == "칸끝") || (substr($design[$i_class_review+1], 0, 6) == "업로드")) $iPosition = "fixed";
			else $iPosition = "absolute";
			if ($import_files_size == 0 && $is_repeat == "N") {	// 실제 페이지인경우
				$td_input_button_link = $GLOBALS[lib_common]->make_link("<font size='1' color='#CCCCCC'>[i]</font>", "{$DIRS[designer_root]}table_designer.php?design_file=$design_file&$index&current_line=$read_line&cpn=0", "_nw", "table_designer,100,100,837,550,1,1,1", "", '#');
				if ($_SESSION[view_mode] != "hide") $td_input_button = "<div align='left' style='position:{$iPosition};z-index:10;'>$td_input_button_link</div>";
				else $td_input_button = "<div align='left' style='position:absolute; visibility:hidden;'>$td_input_button_link</div>";
			} else {
				$td_input_button = "";
			}
			echo("{$td_input_button}");
			$cpn = 0;
		break;

		case "칸끝" :			// TD TPL파일을 구성하는 부분.
			echo("</td>{$tag_both[$exp[1]][1]}\n");
		break;

		case "문자열" :
			$cpn++;
			$text_value = str_replace(chr(92).r.chr(92).n, "\r\n", $exp[1]);
			$text_value = str_replace("%레이어%", "<div style='font-size:8pt'>[Layer]</div>", $text_value);

			$a_tag_pattern = "<a[^>]*>";	// 링크를 제거한다.
			$text_value = eregi_replace($a_tag_pattern, "", $text_value);
			if ($_SESSION[view_mode] != "hide") $T_view = "hidden";
			else $T_view = "show";
			if (trim(strip_tags($text_value)) == "") $text_value = "<div align='left' style='position:absolute;visibility:{$T_view}'><font size='1' color='000033'>[T]</font></div>" . $text_value;		
			$text_value = eregi_replace("</a>", "", $text_value);
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, "$text_value", "문자열");
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "인클루드" :
			// 인클루드 변수를 설정한다.
			$inc_exp = explode($GLOBALS[DV][ct2], $exp[1]);
			if ($inc_exp[1] != '') {
				$var_include = $GLOBALS[lib_common]->parse_property($inc_exp[1], ',', '=', '', 'N');
				while (list($key_inc, $value_inc) = each($var_include)) $$key_inc = $value_inc;
			}
			$cpn++;
			echo(make_edit_link($exp[0], $read_line, $index, $cpn, "<div align='right' style='position:absolute; cursor:hand;z-index:1;'>불러온파일 : $exp[1]</div>", "인클루드"));
			include $inc_exp[0];
		break;
		
		case "그림" :
			$cpn++;
			if ($exp[4] != '') $default_property = " border=0 $exp[4]";
			else $default_property = " border=0";
			$img_src = $exp[3];
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, "<img src='$img_src'{$default_property}{$style}>", "그림");
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "플래시" :
			$cpn++;
			$flash_src = $exp[1];
			$flash_property = explode($GLOBALS[DV][ct4], $exp[2]);
			if ($flash_property[0] == '') $flash_property[0] = 100;
			if ($flash_property[1] == '') $flash_property[1] = 100;
			if ($import_files_size == 0 && $is_repeat == "N") $P_cursor = "cursor:hand;";
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, "<div style='position:absolute;{$P_cursor}'><img src='{$DIRS[designer_root]}images/flash_view.gif' width='$flash_property[0]' height='$flash_property[1]' border='0'></div><script src='/flash_viewer.js.php?file_name={$flash_src}&width={$flash_property[0]}&height={$flash_property[1]}&align={$flash_property[2]}&wmode=opaque'></script>", "그림");
			$component_view = insert_blank($component_view . $flash_tag, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;
		case "버튼" :
			$cpn++;
			if ($_SESSION[link_mode] != 'R') {
				if (!strcmp($exp[2], "그림")) {
					$tag = $image_button = "<img src='$exp[3]' $exp[4] $exp[6]>";
					$tag = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
				} else if (!strcmp($exp[2], "글자")) {
					if (trim($exp[4]) != "") {
						$font_tag_s = "<font $exp[4]>";
						$font_tag_e = "</font>";
					} else {
						$font_tag_s = $font_tag_e = '';
					}
					$tag = "{$font_tag_s}{$exp[3]}{$font_tag_e}";
					$tag = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
				} else {
					$tag = $GLOBALS[lib_common]->make_input_box($exp[3], "", "button", "onclick=\"window.open('{$DIRS[designer_root]}table_designer.php?design_file=$design_file&$index&current_line=$read_line&cpn=$cpn','tableDesigner','left=100,top=100,width=837,height=550,status=yes,toolbar=no,resizable=yes,scrollbars=yes,menubar=no').focus()\" title='{$exp[0]}({$exp[1]})'", $exp[6]);
				}				
			} else {
				$tag = $lib_insiter->make_button($exp);
			}
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "게시물정보" :
			$cpn++;
			$tag = make_article_value($page_type, $exp);
			$tag = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "회원정보" :
			$cpn++;
			$tag = make_member_info($user_info, $site_info, $exp);			
			$tag = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "게시판입력상자" :
			$cpn++;
			$tag = make_board_input_box($exp);
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, $tag[0], "게시물 {$tag[1]} 입력상자");
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "게시판멘트" :
			$tag = $board_info[comment];
			$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;
		
		case "카테고리이동상자" :
			$cpn++;
			$option_name = array("분류1 이동", "분류2 이동", "분류3 이동");
			$tag = $GLOBALS[lib_common]->make_list_box($exp[1], $option_name, $option_name, $selected_name, $selected_value, $exp[3], $exp[4]);
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;
		
######## 회원 가입 입력상자 미리보기 부분

		case "회원입력상자" :
			$cpn++;
			$tag = make_join_box($exp, $member_field_defines);
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, $tag[0], "회원 {$tag[1]} 입력상자");
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "로그인입력상자" :
			$cpn++;
			$tag = make_login_box($exp);
			$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, $tag, $exp[1]);
			$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
			echo($component_view);
		break;

		case "임포트" :
			if ($design_file == $exp[1]) die("자신의 페이지는 임포트 할 수 없습니다.");					// 교착상태 방지
			if (array_search($exp[1], $import_files)) die("교차 임포트는 허용되지 않습니다.");
			$cpn++;
			$change_vars = array("design_file"=>$exp[1]);
			$move_page_link_tail = $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			echo(make_edit_link($exp[0], $read_line, $index, $cpn, "<div align='right' style='position:absolute; cursor:hand;z-index:1;'>불러온페이지</a> : <a href='{$DIRS[designer_root]}page_designer.php?{$move_page_link_tail}' target=_parent>$exp[1]</div>", "인클루드"));
			$site_import_page_info = $lib_fix->get_site_page_info($exp[1]);
			echo($site_import_page_info[tag_header]);
			echo($site_import_page_info[tag_body_in]);
			$import_design = $lib_fix->design_load($DIRS, $exp[1], $site_import_page_info);
			array_splice($design, $i_class_review+1, 0, $import_design);
			$import_design_size = sizeof($import_design);
			if ($import_files_size > 0) {	// 상위 임포트 라인이 있으면 현재 임포트파일의 줄 수를 각 라인에 더한다.
				for ($ifsi=0; $ifsi<$import_files_size; $ifsi++) $import_lines[$ifsi] += $import_design_size;
			}
			$new_start_line = $i_class_review + $import_design_size;	// 임포트 파일 다음라인(현재파일 시작점 저장)
			array_push($import_files, $exp[1]);
			array_push($import_lines, $new_start_line);
			$import_files_size = sizeof($import_files);								// 임포트된 회수를 기록
		break;
/*
		case "게시판타이틀" :
			if ($board_info[title_type] == 'I') {												// 이미지
				$title_src = $board_info[title_img];
				$tag = "<img src='$title_src' {$exp[1]} border=0>";
				$component_view = insert_blank($tag, $exp[12], $exp[13], $exp[14]);
				echo($component_view);
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
				echo($component_view);
			} else {
				echo("'$board_info[alias]' 게시판타이틀이 설정되지 않았습니다.");
			}
		break;
*/
		default :
			$component = trim($exp[0]);
			if ($component != "") {
				$cpn++;
				$component_view = make_edit_link($exp[0], $read_line, $index, $cpn, "<font size=2>[{$component}]</font>", "");
				$component_view = insert_blank($component_view, $exp[12], $exp[13], $exp[14]);
				echo($component_view);
			}
		break;
	}
	
	if (($i_class_review >= $import_lines[$import_files_size-1]) && ($import_files_size > 0)) {
		array_pop($import_files);
		array_pop($import_lines);
		$import_files_size = sizeof($import_files);	// 임포트된 회수를 기록
	}
	if ($import_files_size == 0 && $is_repeat == "N") $read_line++;						// 임포트 페이지가 아닐때, 반복라인이 아닐때만 증가하여 실제페이지의 라인수를 기억한다.(수정작업할때 필수)
}
echo($close_body_tag . $body_out_tag . $close_html_tag);
ob_end_flush();

function make_member_info($user_info, $site_info, $exp) {
	global $root, $lib_insiter;
	$article_item = $exp[1];

	$exp_prt_type = explode($GLOBALS[DV][ct4], $exp[2]);	// 출력속성 불러옴
	$prt_type = $exp_prt_type[0];
	
	$exp_pp_item = explode($GLOBALS[DV][ct4], $exp[3]);	// 필드값 전용 속성 불러옴
	$item_index = $exp_pp_item[0];

	if ($item_index != '' && $article_item != "user_file") $article_item_index = $article_item . "_{$item_index}";
	else $article_item_index = $article_item;
	
	// 출력될 값 설정
	switch ($name) {
		case "user_level" :
			$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
			$T_value = $user_level_list[$user_info[user_level]];
		break;
		case "visit_num" :
			$T_value = "1000";
		break;
		default :
			$T_value = "[$article_item_index]";
		break;
	}

	// 출력될 값에 출력 형태별(텍스트, 숫자, 코드값 등등) 전용 속성을 적용한다.
	switch ($prt_type) {				
		case 'T' :									// 텍스트
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			if ($article_value[is_html] != 'Y' || strlen($T_value) == strlen(strip_tags($T_value))) {	 // 글쓴이가 html 체크를 안했거나, 태그 입력이 없으면 자동 줄바꿈등 수행
				$T_value = htmlspecialchars($T_value);
				$T_value = nl2br($T_value);
			}
			$pp_font = $exp_prt_type[2];
			if ($pp_font != '') $T_value = "<font $pp_font>$T_value</font>";	// 폰트 속성 적용
		break;
		case 'H' :								// HTML 태그 (태그입력이 전혀 없는 경우는 nl2br 함)
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			if (strlen($T_value) == strlen(strip_tags($T_value))) $T_value = nl2br($T_value);
		break;
		case 'F' :								// 파일
			$prt_type_file = $exp_prt_type[1];
			if ($prt_type_file != 'F') {	// 이미지나 아이콘인경우				
				$define_property = array("width", "height", "border", "align");	 // 이미지 속성 불러옴
				$pp_img = $GLOBALS[lib_common]->parse_property($exp_prt_type[2], ' ', '=', $define_property);
				$size_method = $exp_prt_type[3];
				$pp_file = array($pp_img, $size_method);
				$T_exp = explode('/', $T_value);
				if (sizeof($T_exp) > 1) {	// 디렉토리 경로까지 지정된 경우
					$T_file_name = $T_exp[sizeof($T_exp)-1];
					array_pop($T_exp);
					$file_dir = $root . implode('/', $T_exp) . '/';
				} else {
					$T_file_name = $T_value;
					$file_dir = "{$DIRS[designer_root]}images/";
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
		case 'U' :								// 사용자정의
			$T_value_ud = '';
			if ($exp_prt_type[2] != '') $T_value_ud = "<img src='$exp_prt_type[2]' border=0 align=absmiddle>";
			if ($exp_prt_type[1] != '') $T_value_ud .= $exp_prt_type[1];
			if ($T_value_ud != '') $T_value = $T_value_ud;
		break;
	}
	return $T_value;
}

function make_edit_link($item, $line_number, $index, $cpn, $tag, $title) {
	global $DIRS, $design_file, $import_files_size, $is_repeat;
	if ($import_files_size == 0 && $is_repeat == "N") {
		return $GLOBALS[lib_common]->make_link($tag, "{$DIRS[designer_root]}table_designer.php?design_file=$design_file&$index&current_line=$line_number&cpn=$cpn", "_nw", "table_designer,100,100,837,550,1,1,1", "title='{$item}($title)'", "#");
	} else {
		return $tag;
	}
}

// 로그인 입력상자 생성 함수
function make_login_box($exp_design_line) {
	global $lib_insiter;
	$name = $exp_design_line[1];
	$type = $exp_design_line[2];
	$default_pp = $exp_design_line[3];
	$item_define = $exp_design_line[4];
	if ($exp_design_line[5] != '') $divider = $exp_design_line[5];
	else $divider = "&nbsp;";
	if ($exp_design_line[6] != '') $name = $name . "_{$exp_design_line[6]}";

	// 입력상자 형태별 설정
	if ($item_define != '') {		// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
		$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $default_value, $divider);
	} else {															// 기타.
		$value = $GLOBALS[lib_common]->make_input_box($default_value, $name, $type, $default_pp, '');
	}
	return $value;
}

function make_article_value($page_type, $exp) {
	global $root, $lib_insiter, $design_file, $article_num, $site_info, $search_item, $search_value, $page, $user_info, $DB_TABLES, $board_info, $total_record, $total_page, $table_per_block, $list_view_mode, $query_type, $DIRS;
	$article_item = $exp[1];

	$exp_prt_type = explode($GLOBALS[DV][ct4], $exp[2]);	// 출력속성 불러옴
	$prt_type = $exp_prt_type[0];
	
	$exp_pp_item = explode($GLOBALS[DV][ct4], $exp[3]);	// 필드값 전용 속성 불러옴
	$item_index = $exp_pp_item[0];

	if ($item_index != '' && $article_item != "user_file") $article_item_index = $article_item . "_{$item_index}";
	else $article_item_index = $article_item;
	
	// 출력될 값 설정
	switch ($article_item_index) {
		case 'asc_num' :
			$T_value = "12345";
		break;
		case 'desc_num' :
			$T_value = "54321";
		break;
		case 'serial_num' :
			$T_value = "75341";
		break;
		case 'writer_name' :
			$T_value = "홍길동";
		break;
		case 'email' :
			$T_value = "E-mail";
		break;
		case 'homepage' :
			$T_value = "홈페이지";
		break;
		case 'subject' :
			$T_value = "이곳은 게시물 제목이 들어갑니다.";
		break;
		case 'sign_date' :
			$T_value = time();
		break;
		case 'user_file' :
			$T_value = "designer/images/sample_image.jpg";
		break;
		case 'file_size' :
			$T_value = "232300";
		break;
		case 'type' :
			$T_value = "[유형]";
		break;
		case 'page_block' :
			//array_shift($exp_pp_item);
			$T_value = page_block($exp_pp_item, $exp_prt_type);
		break;
		case 'count' :
			$T_value = "321";
		break;
		case 'total_article' :
			$T_value = "1000";
		break;
		case 'total_comment' :
			$T_value = "5";
		break;
		default :
			if ($article_item == "comment") $T_value = "게시물 내용({$article_item_index})";
			else $T_value = $article_item_index;
		break;
	}

	// 출력될 값에 출력 형태별(텍스트, 숫자, 코드값 등등) 전용 속성을 적용한다.
	switch ($prt_type) {				
		case 'T' :									// 텍스트
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			if ($article_value[is_html] != 'Y' || strlen($T_value) == strlen(strip_tags($T_value))) {	 // 글쓴이가 html 체크를 안했거나, 태그 입력이 없으면 자동 줄바꿈등 수행
				$T_value = htmlspecialchars($T_value);
				$T_value = nl2br($T_value);
			}
			$pp_font = $exp_prt_type[2];
			if ($pp_font != '') $T_value = "<font $pp_font>$T_value</font>";	// 폰트 속성 적용
		break;
		case 'H' :								// HTML 태그 (태그입력이 전혀 없는 경우는 nl2br 함)
			$max_string = $exp_prt_type[1];
			if ($max_string != '') $T_value = $GLOBALS[lib_common]->str_cutstring($T_value, $max_string, "..");
			else $T_value = $T_value;
			if (strlen($T_value) == strlen(strip_tags($T_value))) $T_value = nl2br($T_value);
		break;
		case 'F' :								// 파일
			$prt_type_file = $exp_prt_type[1];
			if ($prt_type_file != 'F') {	// 이미지나 아이콘인경우				
				$define_property = array("width", "height", "border", "align");	 // 이미지 속성 불러옴
				$pp_img = $GLOBALS[lib_common]->parse_property($exp_prt_type[2], ' ', '=', $define_property);
				$size_method = $exp_prt_type[3];
				$pp_file = array($pp_img, $size_method);
				$T_exp = explode('/', $T_value);
				if (sizeof($T_exp) > 1) {	// 디렉토리 경로까지 지정된 경우
					$T_file_name = $T_exp[sizeof($T_exp)-1];
					array_pop($T_exp);
					$file_dir = $root . implode('/', $T_exp) . '/';
				} else {
					$T_file_name = $T_value;
					$file_dir = "{$DIRS[designer_root]}images/";
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
		case 'U' :								// 사용자정의
			$T_value_ud = '';
			if ($exp_prt_type[2] != '') $T_value_ud = "<img src='$exp_prt_type[2]' border=0 align=absmiddle>";
			if ($user_define_text != '') $T_value_ud .= $user_define_text;
			if ($T_value_ud != '') $T_value = $T_value_ud;
		break;
	}
	return $T_value;
}

function make_join_box($exp_design_line, $member_field_defines) {
	global $lib_insiter, $site_info, $user_info, $DIRS;
	$name = $exp_design_line[1];
	//if ($exp_design_line[6] != '') $name .= "_{$exp_design_line[6]}";
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

	if ($type == "hidden") return array("[HD]", $name);
	
	// 필드별 기본값 재설정등 개별 설정
	if ($user_info[serial_num] != '') {
		switch ($name) {
			case "passwd" :
				$saved_value = '';
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
			case 'jumin_number_1' :
				$jumin_number = explode($GLOBALS[DV][ct6], $user_info[jumin_number]);
				$saved_value = $jumin_number[0];
			break;
			case 'jumin_number_2' :
				$jumin_number = explode($GLOBALS[DV][ct6], $user_info[jumin_number]);
				$saved_value = $jumin_number[1];
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
	}
	// 입력상자 형태별 설정
	if ($item_define != '') {									// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
		$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $saved_value, $divider);
	} else {
		$value = $GLOBALS[lib_common]->make_input_box($saved_value, $name, $type, $default_pp, '') . $etc_tag;
	}
	return array($value, $name);
}

// 게시물입력상자 생성 함수
function make_board_input_box($exp_design_line) {
	global $lib_insiter, $search_item, $search_value, $board_info, $page_type, $user_info;
	$name = $exp_design_line[1];
	$type = $exp_design_line[2];
	if ($type == "hidden") return array("[HD]", $name);
	$default_pp = $exp_design_line[3];
	$item_define = $exp_design_line[4];
	if ($exp_design_line[5] != '') $divider = $exp_design_line[5];
	else $divider = "&nbsp;";
	if ($exp_design_line[6] != '') $name = $name . "_{$exp_design_line[6]}";

	// 필드별 기본값 재설정등 개별 설정
	if (substr($name, 0, 9) == "category_") {		// 카테고리 입력 상자인 경우
		if (substr($name, 9, 2) == "go") $T_mode = "이동";
		else $T_mode = "선택";
		$item_define = "1;분류{$T_mode}상자_{$exp_design_line[6]}-1\n2;분류{$T_mode}상자_{$exp_design_line[6]}-2\n3;분류{$T_mode}상자_{$exp_design_line[6]}-3";
	} else if ($name == "type") {								// 글 유형인경우
		$item_define = "1;글유형-1\n2;글유형-2";
	} else if ($name == "search_item") {
		$item_define = $GLOBALS[VI][DD_search_field];
	}

	// 입력상자 형태별 설정
	if ($item_define != '') {		// 선택항목이 정의 되어 있는 경우 선택상자, 라디오버튼, 다중체크상자 로 간주하고 처리함
		$value = $lib_insiter->make_multi_input_box($type, $name, $item_define, $default_value, $divider);
	} else {															// 기타.
		$value = $GLOBALS[lib_common]->make_input_box($default_value, $name, $type, $default_pp, '');
	}
	return array($value, $name);
}

// 공백을 넣는 함수
function insert_blank($tag, $tag_both, $blanks, $perm) {
	global $lib_insiter, $design, $i_class_review, $skip_info;
	if ($perm != '' && $_SESSION[view_all] != 'Y') {
		if ($lib_insiter->is_skip($design, $perm, $_SESSION[view_level], $i_class_review, '', $skip_info) != "VIEW") return '';
	}
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

function page_block($exp, $pp_font) {
	global $DIRS, $table_per_block;
	$link_list = array();
	if ($exp[3] == '') $style_2_src = "{$DIRS[designer_root]}images/list_first.gif'";
	else $style_2_src = $exp[3];
	if ($exp[4] == '') $style_3_src = "{$DIRS[designer_root]}images/list_prev.gif";
	else $style_3_src = $exp[4];
	if ($exp[5] == '') $style_4_src = "{$DIRS[designer_root]}images/list_next.gif'";
	else $style_4_src = $exp[5];
	if ($exp[6] == '') $style_5_src = "{$DIRS[designer_root]}images/list_last.gif";
	else $style_5_src = $exp[6];
	for ($i=1; $i<=$table_per_block; $i++) $link_list[] = "{$exp[1]}{$i}{$exp[2]}";
	$link_list = implode($exp[9], $link_list);
	$link_list = "<img src='$style_2_src' border=0 align='absmiddle'> <img src='$style_3_src' border=0 align='absmiddle'> {$link_list} <img src='$style_4_src' border=0 align='absmiddle'> <img src='$style_5_src' border=0 align='absmiddle'>";
	return $link_list;
}
?>