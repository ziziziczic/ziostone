<?
// ������ ����
$T_page_type = "U;����ڿ�\nB;�Խ��� (���, ������..)\nS;��Ų (���̾ƿ�)\nI;����Ʈ (�ݺ�����)\nY;�ý��� (�ʼ�)\nT;�����ø�\nP;���θ�";
if ($site_info[page_types] != '') $T_page_type .= "\n{$site_info[page_types]}";
$GLOBALS[VI][page_type_array] = $GLOBALS[lib_common]->parse_property($T_page_type, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', '', 'Y');

$GLOBALS[VI][DD_search_field] = ";::: ��ü�˻� :::\nsubject;����\ncomment_1;����\nname;�ۼ���";
$GLOBALS[VI][DD_mailling] = "Y;��\\nN;�ƴϿ�";
$GLOBALS[VI][DD_gender] = "M;��\\nF;��";
$GLOBALS[VI][DD_phone_1] = ";����\\n02;����\\n031;���\\n032;��õ\\n033;����\\n041;�泲\\n042;����\\n043;���\\n051;�λ�\\n052;���\\n053;�뱸\\n054;���\\n055;�泲\\n061;����\\n062;����\\n063;����\\n064;����\\n0707;���ͳ�\\n0505;���(������)\\n0502;���(KT)";
$GLOBALS[VI][DD_phone_mobile_1] = ";����\\n010;010\\n011;011\\n016;016\\n017;017\\n018;018\\n019;019";
$GLOBALS[VI][DD_phone_fax_1] = ";����\\n02;����\\n031;���\\n032;��õ\\n033;����\\n041;�泲\\n042;����\\n043;���\\n051;�λ�\\n052;���\\n053;�뱸\\n054;���\\n055;�泲\\n061;����\\n062;����\\n063;����\\n064;����\\n0707;���ͳ�\\n0505;���(������)\\n0502;���(KT)";

$page_menu_etc = "%B1%;�Խ��Ǻз�1\n%B2%;�Խ��Ǻз�2\n%B3%;�Խ��Ǻз�3\n%B4%;�Խ��Ǻз�4\n%B5%;�Խ��Ǻз�5\n%B6%;�Խ��Ǻз�6";

$IS_btns[add] = "<img src='{$DIRS[designer_root]}images/wams_a.gif' border=0 style='margin-left:1px'>";
$IS_btns[login] = "<img src='{$DIRS[designer_root]}images/wams_l.gif' border=0 style='margin-left:1px'>";
$IS_btns[modify] = "<img src='{$DIRS[designer_root]}images/wams_m.gif' border=0 style='margin-left:1px'>";
$IS_btns[delete] = "<img src='{$DIRS[designer_root]}images/wams_d.gif' border=0 style='margin-left:1px'>";
$IS_btns[view] = "<img src='{$DIRS[designer_root]}images/wams_v.gif' border=0 style='margin-left:1px'>";
$IS_btns[edit] = "<img src='{$DIRS[designer_root]}images/wams_btn_edit.gif' border=0 style='margin-left:1px'>";
$IS_btns[header] = "<img src='{$DIRS[designer_root]}images/wams_btn_header.gif' border=0 style='margin-left:1px'>";
$IS_btns[template] = "<img src='{$DIRS[designer_root]}images/btn_wams_template.gif' border=0 style='margin-left:1px'>";
$IS_btns[move] = "<img src='{$DIRS[designer_root]}images/wams_mv.gif' border=0 style='margin-left:1px'>";
$IS_btns[property] = "<img src='{$DIRS[designer_root]}images/wams_btn_property.gif' border=0 style='margin-left:1px'>";
$IS_btns[sort_up] = "<img src='{$DIRS[designer_root]}images/sort_up.gif' border=0 style='margin-left:1px' width=7 height=9>";
$IS_btns[sort_down] = "<img src='{$DIRS[designer_root]}images/sort_down.gif' border=0 style='margin-left:1px' width=7 height=9>";
$IS_btns[sort_left] = "<img src='{$DIRS[designer_root]}images/sort_left.gif' border=0 style='margin-left:1px' width=9 height=7>";
$IS_btns[sort_right] = "<img src='{$DIRS[designer_root]}images/sort_right.gif' border=0 style='margin-left:1px' width=9 height=7>";
$IS_icon[form_title] = "<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[form_title_1] = "<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[icon_help] = "<img src='{$DIRS[designer_root]}images/icon_help.gif' width='11' height='11' border=0 align=absmiddle>";

$IS_input_box_padding = '1';
$IS_ppa = array("design"=>"100", "board"=>"30", "member"=>"30", "popup"=>"30");
$IS_ppb = '10';
$IS_sch_method = "or";
$IS_sch_divider = ',';
$IS_supply_site = "http://ohmysite.co.kr";
$IS_thema = "thin_skyblue_round_title";
$IS_thema_left = "halfsurface_skin_round_title";
$IS_thema_window = "halfsurface_darkblue_round_title";
$IS_thema_help = "heavy_blue_round";
$IS_help_url = "http://help.wams.kr";

$IS_filter_keyword = "����,�ʻ�,�û�,�ý�,�ù�,����";
$IS_upload_ext = "gif,jpg,jpeg,png,xls,pdf,doc,hwp,ppt,ai,psd";
$IS_level_mode = array('U'=>"�̻�", 'L'=>"����", 'E'=>"��");

$CN_menu = array(
	"main"=>"������Ȩ",
	"design"=>"�����ΰ���",
	"board"=>"�Խ��ǰ���",
	"member"=>"ȸ������",
	"popup"=>"�˾�â����",
	"visit"=>"�湮���
");
$CN_menu_link = array(
	"main"=>"{$DIRS[designer_root]}index.php",
	"design"=>"{$DIRS[designer_root]}page_list.php?SCH_type=U",
	"board"=>"{$DIRS[designer_root]}board_list.php",
	"member"=>"{$DIRS[designer_root]}member_list.php",
	"popup"=>"{$DIRS[designer_root]}popup_list.php",
	"visit"=>"{$DIRS[designer_root]}visit_search_form.php");
$CN_menu_perm = array("main"=>$GLOBALS[VI][admin_level_admin],
	"design"=>$GLOBALS[VI][admin_level_admin],
	"board"=>$GLOBALS[VI][admin_level_admin],
	"member"=>$GLOBALS[VI][admin_level_admin],
	"popup"=>$GLOBALS[VI][admin_level_admin],
	"visit"=>$GLOBALS[VI][admin_level_admin]
);
if ($DIRS[shop_root] != '') {
	$CN_menu[shop] = "���θ�";
	$CN_menu_link[shop] = "{$DIRS[shop_root]}_administrator/order_list.php";
	$CN_menu_perm[shop] = $GLOBALS[VI][admin_level_admin];
}

// �̹��� �Ⱓ����
$today_array = getdate($GLOBALS[w_time]);
$end_date = $GLOBALS[lib_common]->get_last_date_month($today_array[year], $today_array[mon]);
$today_array[mon] = str_pad($today_array[mon], 2, '0', STR_PAD_LEFT);
$set_term_this_month = array("{$today_array[year]}-{$today_array[mon]}-01", "{$today_array[year]}-{$today_array[mon]}-{$end_date}");
?>