<?
include "header_proc.inc.php";

if ($user_level_alias_1 == '') $user_level_alias_1 = "7;일반회원\n6;우수회원\n5;특별회원";
if ($index_file == '') $index_file = $GLOBALS[VI][default_index_file];
if ($default_file_dir == "") $default_file_dir = "design/images";
if ($site_id == '') $GLOBALS[lib_common]->alert_url("관리자아이디를 입력하세요");

$input_data = array();
$input_data[site_name] = $site_name;
$input_data[site_email] = $site_email;
$input_data[site_id] = $site_id;
$input_data[join_next_page] = $join_next_page;
$input_data[member_modify_next_page] = $member_modify_next_page;
$input_data[access_denied_page] = $access_denied_page;
$input_data[login_next_page] = $login_next_page;
$input_data[logout_next_page] = $logout_next_page;
$input_data[login_error_page] = $login_error_page;
$input_data[skin_file] = $skin_file;
$input_data[default_file_dir] = $default_file_dir;
$input_data[is_frame] = $is_frame;
$input_data[frame_header] = $frame_header;
$input_data[index_file] = $index_file;
$input_data[user_level_alias] = $user_level_alias_1;
$input_data[member_field_define] = $member_field_define;
$input_data[member_field_define_2] = $member_field_define_2;
$input_data[member_field_define_3] = $member_field_define_3;
$input_data[member_field_define_4] = $member_field_define_4;
$input_data[member_field_define_5] = $member_field_define_5;
$input_data[member_field_define_6] = $member_field_define_6;
$input_data[member_field_define_7] = $member_field_define_7;
$input_data[counter] = $counter;
$input_data[design_file_group] = $design_file_group;
$input_data[design_file_menu] = $design_file_menu;
$input_data[ip_block] = $ip_block;
$input_data[perm_err_msg] = $perm_err_msg;
$input_data[referer_sites] = $referer_sites;
$input_data[page_types] = $page_types;
$input_data[auth_method] = $auth_method;
$GLOBALS[lib_common]->modify_record($DB_TABLES[site_info], "serial_num", '1', $input_data);
$GLOBALS[lib_common]->alert_url('', 'E', "setup_form.php");
?>