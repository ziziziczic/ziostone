<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	디자인 파일을 불러 한줄씩 배열에 저장한다.
if ($article_item_user != '') $article_item = $article_item_user;
$pp_prt_type = "{$prt_type}{$GLOBALS[DV][ct4]}"; 
switch ($prt_type) {			// 출력형태별 전용속성
	case 'T' :								// 텍스트
		if ($pp_font_size != '') $pp_font_size = "size=$pp_font_size ";	 // 텍스트 속성
		if ($pp_font_face != '') $pp_font_face = "face=$pp_font_face ";
		if ($pp_font_color != '') $pp_font_color = "color=$pp_font_color ";	
		$pp_font = trim("{$pp_font_size}{$pp_font_face}{$pp_font_color}{$pp_font_etc}");
		$pp_prt_type .= "{$max_string}{$GLOBALS[DV][ct4]}{$pp_font}";
	break;
	case 'H' :								// HTML 태그
		$pp_prt_type .= "{$max_string}";
	break;
	case 'F' :								// 파일
		if ($prt_type_file != 'F') {
			if ($pp_img_width != '') $pp_img_width = "width=$pp_img_width ";	// 이미지속성
			if ($pp_img_height != '') $pp_img_height = "height=$pp_img_height ";
			if ($pp_img_align != '') $pp_img_align = "align=$pp_img_align ";
			if ($pp_img_border != '') $pp_img_border = "border=$pp_img_border ";
			$pp_img = trim("{$pp_img_width}{$pp_img_height}{$pp_img_border}{$pp_img_align}{$pp_img_etc}");
			$pp_prt_type .= "{$prt_type_file}{$GLOBALS[DV][ct4]}{$pp_img}{$GLOBALS[DV][ct4]}{$size_method}{$GLOBALS[DV][ct4]}{$use_thumb}";
		} else {
			$pp_prt_type .= "{$prt_type_file}{$GLOBALS[DV][ct4]}{$GLOBALS[DV][ct4]}{$GLOBALS[DV][ct4]}{$max_string}";
		}
	break;
	case 'N' :								// 숫자
		$pp_prt_type .= "{$sosujum}";
	break;
	case 'D' :								// 날짜
		$pp_prt_type .= "{$format_date}";
	break;
	case 'C' :								// 코드값
		$blank_check = trim($code_define);
		$blank_check = str_replace(" ", '', $blank_check);
		$blank_check = str_replace("\n", '', $blank_check);
		$blank_check = str_replace("\r", '', $blank_check);
		if (strlen($blank_check) == 0) {															// 사용자 입력이 공백이면
			$input_items = '';
		} else {																											// 입력 내용이 있으면 아래의 루틴을 수행한다.
			$input_items = stripslashes($code_define);
			$input_items = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv] ,$input_items);
			$input_items = str_replace("\r\n", chr(92).n, $input_items);
		}
		$pp_prt_type .= "{$input_items}";
	break;
	case 'U' :								// 사용자정의
		// 출력내용 속성
		$user_define_img_img = $GLOBALS[lib_common]->file_upload("user_define_img", $saved_user_define_img, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$pp_prt_type .= "{$user_define_text}{$GLOBALS[DV][ct4]}{$user_define_img_img}";
	break;
}

// 필드별 전용속성
switch ($article_item) {
	case "subject" :
		$recent_icon_img = $GLOBALS[lib_common]->file_upload("recent_icon_1", $saved_recent_icon_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$reply_icon_img = $GLOBALS[lib_common]->file_upload("reply_icon_1", $saved_reply_icon_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$notice_icon_img = $GLOBALS[lib_common]->file_upload("notice_icon_1", $saved_notice_icon_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$common_icon_img = $GLOBALS[lib_common]->file_upload("common_icon_1", $saved_common_icon_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$private_icon_img = $GLOBALS[lib_common]->file_upload("private_icon_1", $saved_private_icon_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$pp_fld = "{$recent_icon_img}{$GLOBALS[DV][ct4]}{$recent_icon_time}{$GLOBALS[DV][ct4]}{$reply_icon_img}{$GLOBALS[DV][ct4]}{$notice_icon_img}{$GLOBALS[DV][ct4]}{$private_icon_img}{$GLOBALS[DV][ct4]}{$common_icon_img}";
	break;
	case "page_block" :
		$page_block_pre_block_img = $GLOBALS[lib_common]->file_upload("page_block_pre_block_1", $saved_page_block_pre_block_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$page_block_pre_page_img = $GLOBALS[lib_common]->file_upload("page_block_pre_page_1", $saved_page_block_pre_page_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$page_block_next_page_img = $GLOBALS[lib_common]->file_upload("page_block_next_page_1", $saved_page_block_next_page_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$page_block_next_block_img = $GLOBALS[lib_common]->file_upload("page_block_next_block_1", $saved_page_block_next_block_1, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
		$pp_fld = "{$page_block_left}{$GLOBALS[DV][ct4]}{$page_block_right}{$GLOBALS[DV][ct4]}{$page_block_pre_block_img}{$GLOBALS[DV][ct4]}{$page_block_pre_page_img}{$GLOBALS[DV][ct4]}{$page_block_next_page_img}{$GLOBALS[DV][ct4]}{$page_block_next_block_img}{$GLOBALS[DV][ct4]}{$page_block_link_page}{$GLOBALS[DV][ct4]}{$page_block_page_var_name}{$GLOBALS[DV][ct4]}{$page_block_space}";
	break;
	case "total_comment" :
		$pp_fld = "{$comment_table}{$GLOBALS[DV][ct4]}{$relation_table}{$GLOBALS[DV][ct4]}{$relation_serial_get_name}";
	break;
}
$pp_fld = "{$item_index}{$GLOBALS[DV][ct4]}" . $pp_fld;

// 링크정보
$link_info = "{$pp_link_target}{$GLOBALS[DV][ct4]}{$pp_link_nw}{$GLOBALS[DV][ct4]}{$pp_link_etc}{$GLOBALS[DV][ct4]}{$pp_link_rollover}{$GLOBALS[DV][ct4]}{$link_field}{$GLOBALS[DV][ct4]}{$link_field_part}{$GLOBALS[DV][ct4]}{$link_method}{$GLOBALS[DV][ct4]}{$user_link}{$GLOBALS[DV][ct4]}{$origin_img_name}";


// 좌우태그
$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";

// 여백설정
$blanks = "{$blank_up}{$GLOBALS[DV][ct4]}{$blank_down}{$GLOBALS[DV][ct4]}{$blank_left}{$GLOBALS[DV][ct4]}{$blank_right}";

// 종합
$value = "게시물정보{$GLOBALS[DV][dv]}{$article_item}{$GLOBALS[DV][dv]}{$pp_prt_type}{$GLOBALS[DV][dv]}{$pp_fld}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$link_info}";

$article_item_value = $lib_fix->make_design_line($value, '', $tag_both, $blanks);
$location = "index=" . $index;
$search = $lib_fix->search_index($design, "칸", $location);

if ($cpn == "0") array_splice($design, $search[1], 0, $article_item_value);		// 항목 추가인경우
else $design[$current_line] = $article_item_value;															// 항목 수정인경우

$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>