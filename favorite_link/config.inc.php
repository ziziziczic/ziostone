<?
$DIRS[favorite_link] = "{$root}favorite_link/";

// db 테이블 매핑
$DB_TABLES[fav_config] = "VG_FAV_config";									// 설정
$DB_TABLES[fav_category] = "VG_FAV_catagory";						// 분류
$DB_TABLES[fav_link] = "VG_FAV_links";											// 링크
$DB_TABLES[fav_log] = "VG_FAV_log";												// 배너로그

/*
// 관리버튼재정의
$IS_btns[add] = "<img src='{$DIRS[designer_root]}images/wams_a.gif' border=0 style='margin-left:1px'>";
$IS_btns[login] = "<img src='{$DIRS[designer_root]}images/wams_l.gif' border=0 style='margin-left:1px'>";
$IS_btns[modify] = "<img src='{$DIRS[designer_root]}images/wams_m.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[delete] = "<img src='{$DIRS[designer_root]}images/wams_d.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[sort_up] = "<img src='{$DIRS[favorite_link]}images/sort_up.gif' border=0 style='margin-left:1px' width=7 height=9>";
$IS_btns[sort_down] = "<img src='{$DIRS[favorite_link]}images/sort_down.gif' border=0 style='margin-left:1px' width=7 height=9>";
$IS_btns[sort_left] = "<img src='{$DIRS[favorite_link]}images/sort_left.gif' border=0 style='margin-left:1px' width=9 height=7>";
$IS_btns[sort_right] = "<img src='{$DIRS[favorite_link]}images/sort_right.gif' border=0 style='margin-left:1px' width=9 height=7>";
$IS_icon[form_title] = "<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[form_title_1] = "<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[icon_help] = "<img src='{$DIRS[designer_root]}images/icon_help.gif' width='11' height='11' border=0 align=absmiddle>";
*/

// 상단메뉴명
$CN_menu[favorite_link] = "즐겨찾기";
$CN_menu_link[favorite_link] = "{$DIRS[favorite_link]}index.php";
$CN_menu_perm[favorite_link] = $GLOBALS[VI][admin_level_admin];

// 시스템변수
$IS_ppa[favorite_link] = "20";
$IS_ppb = "10";
$IS_sch_divider = $GLOBALS[DV][ct3];

// 설정변수
$FL_default_ct_nums = 10;
$FL_default_ct_per_links = 10;
$FL_default_skin = "thin_skyblue_round_title";
$FL_default_skin_admin = "thin_skyblue_round_title";
$FL_default_fav = '6';

// 기본설정을 불러옴
if ($user_info[serial_num] != '') $fav_serial_num = $user_info[serial_num];
else $fav_serial_num = '1';
$fav_config = $GLOBALS[lib_common]->get_data($DB_TABLES[fav_config], "serial_member", $fav_serial_num);
if ($fav_config[serial_member] == '') {
	$input_record = array();
	$input_record[serial_member] = $fav_serial_num;
	$input_record[total_ct_nums] = $FL_default_ct_nums;
	$input_record[ct_per_links] = $FL_default_ct_per_links;
	$input_record[date_sign] = $GLOBALS[w_time];
	$GLOBALS[lib_common]->input_record($DB_TABLES[fav_config], $input_record, 'Y');
	$fav_config = $GLOBALS[lib_common]->get_data($DB_TABLES[fav_config], "serial_member", $fav_serial_num);
}

$FAV_link_view = "{$root}{$site_info[index_file]}?design_file=3247.php";
$FAV_link_setup = "{$root}{$site_info[index_file]}?design_file=3248.php";

/////////////////////// 함수정의 ///////////////////////////
?>