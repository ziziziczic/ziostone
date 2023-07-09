<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	디자인 파일을 불러 한줄씩 배열에 저장한다.

if ($button_type == "그림") {
	$print_value = $GLOBALS[lib_common]->file_upload("userfile", $pp_img_src, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
	if ($print_value == false) $GLOBALS[lib_common]->alert_url("그림파일이 선택되지 않았습니다.");
	if ($pp_img_width != '') $pp_img_width = "width=$pp_img_width ";
	if ($pp_img_height != '') $pp_img_height = "height=$pp_img_height ";
	if ($pp_img_align != '') $pp_img_align = "align=$pp_img_align ";
	if ($pp_img_border != '') $pp_img_border = "border=$pp_img_border ";
	$default_property = trim("{$pp_img_width}{$pp_img_height}{$pp_img_border}{$pp_img_align}{$pp_img_etc}");
} else if ($button_type == "글자") {
	$print_value = $text_value;
	if ($pp_font_size != '') $pp_font_size = "size=$pp_font_size ";
	if ($pp_font_face != '') $pp_font_face = "face=$pp_font_face ";
	if ($pp_font_color != '') $pp_font_color = "color=$pp_font_color ";	
	$default_property = trim("{$pp_font_size}{$pp_font_face}{$pp_font_color}{$pp_font_etc}");
} else {
	$print_value = $tag_value;
	$default_property = trim($pp_tag_etc);
}
if ($user_link_page == '') $user_link_page = $user_link_board;
$link_url = "{$user_link_page}{$GLOBALS[DV][ct4]}{$user_link_url}";
$link_info = "{$pp_link_target}{$GLOBALS[DV][ct4]}{$pp_link_nw}{$GLOBALS[DV][ct4]}{$pp_link_etc}{$GLOBALS[DV][ct4]}{$pp_link_rollover}";

switch ($button_item) {
	case "sort" :
		$btn_etc = "{$sort_fld_name}{$GLOBALS[DV][ct4]}{$sort_sequence}{$GLOBALS[DV][ct4]}{$sort_is_multi}{$GLOBALS[DV][ct4]}{$sort_design_file}{$GLOBALS[DV][ct4]}{$sort_link_file}";
	break;
	case "multi_submit" :
		$btn_etc = "{$multi_submit_action}{$GLOBALS[DV][ct4]}{$multi_submit_target}{$GLOBALS[DV][ct4]}{$multi_submit_fnc}";
	break;
}

$value = "버튼{$GLOBALS[DV][dv]}{$button_item}{$GLOBALS[DV][dv]}{$button_type}{$GLOBALS[DV][dv]}{$print_value}{$GLOBALS[DV][dv]}{$default_property}{$GLOBALS[DV][dv]}{$link_info}{$GLOBALS[DV][dv]}{$btn_etc}{$GLOBALS[DV][dv]}{$link_url}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}";
$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";
$blanks = "{$blank_up}{$GLOBALS[DV][ct4]}{$blank_down}{$GLOBALS[DV][ct4]}{$blank_left}{$GLOBALS[DV][ct4]}{$blank_right}";
$article_item_value = $lib_fix->make_design_line($value, '', $tag_both, $blanks);

$location = "index=" . $index;
$search = $lib_fix->search_index($design, "칸", $location);

if ($cpn == "0") array_splice($design, $search[1], 0, $article_item_value);		// 항목 추가인경우
else $design[$current_line] = $article_item_value;														// 항목 수정인경우

$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>