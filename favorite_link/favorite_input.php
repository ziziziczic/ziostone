<?
include "header_proc.inc.php";
if ($proc_mode != "add_ct" && $proc_mode != "config") {
	$where_array = array("serial_num"=>$serial_category, "serial_member"=>$user_info[serial_num]);
	$category_info = $GLOBALS[lib_common]->get_data($DB_TABLES[fav_category], $where_array, '');
	if ($category_info[serial_num] == '') $GLOBALS[lib_common]->die_msg("�з� ���������� �����ϴ�.");
}

$change_vars = array();
switch ($proc_mode) {
	case "config" :
		$input_data = array();
		$input_data[total_ct_nums] = $total_ct_nums;
		$input_data[ct_per_links] = $ct_per_links;
		$input_data[skin] = $skin;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[fav_config], "serial_member", $user_info[serial_num], $input_data);
	break;
	case "add_ct" :
		$input_data = array();
		$input_data[name] = $ct_name;
		// ���İ�����
		$query = "select max(sort) from $DB_TABLES[fav_category] where serial_member='$user_info[serial_num]'";
		$result = $GLOBALS[lib_common]->querying($query);
		$input_data[sort] = mysql_result($result, 0, 0) + 1;
		$input_data[date_sign] = $GLOBALS[w_time];
		$input_data[serial_member] = $user_info[serial_num];
		$GLOBALS[lib_common]->input_record($DB_TABLES[fav_category], $input_data);
	break;
	case "modify_ct" :
		$GLOBALS[lib_common]->db_set_field_value($DB_TABLES[fav_category], "name", $ct_name, $where_array, '');
		$sucess_msg = "�з����� �����Ǿ����ϴ�.";
		$return_page = "{$DIRS[favorite_link]}favorite_input_form.php";
	break;
	case "delete_ct" :
		$query = "delete from $DB_TABLES[fav_link] where serial_category='$category_info[serial_num]' and serial_member='$user_info[serial_num]'";
		$GLOBALS[lib_common]->querying($query);
		$GLOBALS[lib_common]->db_record_delete($DB_TABLES[fav_category], $where_array, '');
		$sucess_msg = "�ش� �з��� ���� ���ã�� ������ �����Ǿ����ϴ�.";
		$GLOBALS[lib_common]->alert_url($sucess_msg, 'E', '', '', "opener.location.reload();window.close()");
	break;
	case "add_urls" :
		// ��������� ��� ����
		$query = "delete from $DB_TABLES[fav_link] where serial_category='$category_info[serial_num]' and serial_member='$user_info[serial_num]'";
		$GLOBALS[lib_common]->querying($query);
		// �ű� ��� ���
		$j = 1;
		for ($i=0; $i<sizeof($_POST[link_name]); $i++) {
			if (trim($_POST[link_name][$i]) == '') continue;
			$input_data = array();
			$input_data[serial_link] = $j;
			$input_data[name] = $_POST[link_name][$i];
			$input_data[link_url] = $_POST[link_url][$i];
			$input_data[sort] = $j;
			$input_data[serial_category] = $category_info[serial_num];
			$input_data[serial_member] = $user_info[serial_num];
			$GLOBALS[lib_common]->input_record($DB_TABLES[fav_link], $input_data);
			$j++;
		}
		//$sucess_msg = "\'{$category_info[name]}\' �з��� ���ã�� ��ũ�� ��� �Ǿ����ϴ�.";
		$GLOBALS[lib_common]->alert_url($sucess_msg, 'E', '', '', "opener.location.reload();window.close()");
	break;
	case "sort_up_ct" :
		// �������İ� �ϰ� ������
		$GLOBALS[lib_common]->get_new_sort($DB_TABLES[fav_category], array("serial_member"=>$user_info[serial_num]), "sort", "asc", array("serial_num"));
		// ��ġ����
		$result_swap = $GLOBALS[lib_common]->record_swap($DB_TABLES[fav_category], 'U', array("serial_member"=>$user_info[serial_num]), array("serial_num"=>$serial_category), array("serial_num"), "sort");
		if ($result_swap == false) $sucess_msg = "���� ó�� �Դϴ�.";
	break;
	case "sort_down_ct" :
		// �������İ� �ϰ� ������
		$GLOBALS[lib_common]->get_new_sort($DB_TABLES[fav_category], array("serial_member"=>$user_info[serial_num]), "sort", "asc", array("serial_num"));
		// ��ġ����
		$result_swap = $GLOBALS[lib_common]->record_swap($DB_TABLES[fav_category], 'D', array("serial_member"=>$user_info[serial_num]), array("serial_num"=>$serial_category), array("serial_num"), "sort");
		if ($result_swap == false) $sucess_msg = "���� ������ �Դϴ�.";
	break;
	case "sort_up_link" :
		// �������İ� �ϰ� ������
		$GLOBALS[lib_common]->get_new_sort($DB_TABLES[fav_link], array("serial_member"=>$user_info[serial_num]), "sort", "asc", array("serial_link", "serial_category", "serial_member"));
		// ��ġ����
		$result_swap = $GLOBALS[lib_common]->record_swap($DB_TABLES[fav_link], 'U', array("serial_member"=>$user_info[serial_num], "serial_category"=>$serial_category), array("serial_link"=>$serial_link), array("serial_link"), "sort");
		if ($result_swap == false) $sucess_msg = "���� ó�� �Դϴ�.";
	break;
	case "sort_down_link" :
		// �������İ� �ϰ� ������
		$GLOBALS[lib_common]->get_new_sort($DB_TABLES[fav_link], array("serial_member"=>$user_info[serial_num]), "sort", "asc", array("serial_link", "serial_category", "serial_member"));
		// ��ġ����
		$result_swap = $GLOBALS[lib_common]->record_swap($DB_TABLES[fav_link], 'D', array("serial_member"=>$user_info[serial_num], "serial_category"=>$serial_category), array("serial_link"=>$serial_link), array("serial_link"), "sort");
		if ($result_swap == false) $sucess_msg = "���� ������ �Դϴ�.";
	break;
}
$link = $return_page . '?' . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);

$GLOBALS[lib_common]->alert_url($sucess_msg, 'E', $link);
?>