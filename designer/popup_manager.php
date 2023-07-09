<?
/*----------------------------------------------------------------------------------
 * 제목 : TCTools '인사이트' 게시판 생성 프로그램
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_proc.inc.php";

if ($mode == "add" || $mode == "modify") {
	$upload_file_name_array = array();
	$upload_file_size_array = array();
	for ($i=1; $i<=2; $i++) {																		// 개수만큼 반복
		$upload_file_name = $file_size = '';
		$user_files = "upload_files_" . $i;												// 임시파일
		$saved_user_files = "saved_upload_files_" . $i;				// 저장된파일
		$new_file_name = $GLOBALS[w_time] . '_' . $i;
		$upload_file_name = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, $GLOBALS[VI][img_ext], 'T', $DIRS[popup_img], $new_file_name, '', 'Y');
		$upload_file_name_array[$i] = $upload_file_name;
	}
	$upload_files = implode(';', $upload_file_name_array);
}

switch ($mode) {
	case "add" :
		$input_data = array();
		$input_data[skin_num] = $skin_num;
		$input_data[reg_date] = $GLOBALS[w_time];
		$input_data[subject] = $subject;
		$input_data[type] = $type;
		$input_data[begin_time] = $GLOBALS[lib_common]->str_date_to_time_stamp($begin_time);
		$input_data[end_time] = $GLOBALS[lib_common]->str_date_to_time_stamp($end_time);
		$input_data[disable_term] = $disable_term;
		$input_data[popup_left] = $popup_left;
		$input_data[popup_top] = $popup_top;
		$input_data[popup_width] = $popup_width;
		$input_data[popup_height] = $popup_height;
		$input_data[bg_color] = $bg_color;
		$input_data[font_color] = $font_color;
		$input_data[is_html] = $is_html;
		$input_data[contents] = $comment_1;
		$input_data['include'] = $include;
		$input_data[design_file] = $design_file;
		$input_data[upload_files] = $upload_files;
		$GLOBALS[lib_common]->input_record($DB_TABLES[popup], $input_data);
		$change_vars = array("page"=>'');
		$link = "./popup_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "modify" :
		$input_data = array();
		$input_data[skin_num] = $skin_num;
		$input_data[reg_date] = $GLOBALS[w_time];
		$input_data[subject] = $subject;
		$input_data[type] = $type;
		$input_data[begin_time] = $GLOBALS[lib_common]->str_date_to_time_stamp($begin_time);
		$input_data[end_time] = $GLOBALS[lib_common]->str_date_to_time_stamp($end_time);
		$input_data[disable_term] = $disable_term;
		$input_data[popup_left] = $popup_left;
		$input_data[popup_top] = $popup_top;
		$input_data[popup_width] = $popup_width;
		$input_data[popup_height] = $popup_height;
		$input_data[bg_color] = $bg_color;
		$input_data[font_color] = $font_color;
		$input_data[is_html] = $is_html;
		$input_data[contents] = $comment_1;
		$input_data['include'] = $include;
		$input_data[design_file] = $design_file;
		$input_data[upload_files] = $upload_files;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[popup], "serial_num", $serial_num, $input_data);
		$change_vars = array();
		$link = "./popup_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "delete" :
		$query = "delete from $DB_TABLES[popup] where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "팝업창 정보 삭제중 에러");
		$change_vars = array("serial_num"=>'', "page"=>'');
		$link = "./popup_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
}
$GLOBALS[lib_common]->alert_url('', 'E', $link);
?>
