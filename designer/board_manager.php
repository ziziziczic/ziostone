<?
/*----------------------------------------------------------------------------------
 * ���� : TCTools '�λ���Ʈ' �Խ��� ���� ���α׷�
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
include "header_proc.inc.php";

if ($clip_board_name != '') $clip_board_info = $lib_fix->get_board_info($clip_board_name);
else if ($template_name != '') $template_dir = $DIRS[template] . $template_name . '/';

if ($mode == "add" || $mode == "modify") {
	// ��������������
	$board_page_array = array("list"=>"���", "view"=>"����", "write"=>"����", "modify"=>"����", "delete"=>"����", "reply"=>"�亯");
	// ������������
	$perm_info_array = array("read_perm"=>$read_perm, "read_perm_mode"=>$read_perm_mode, "write_perm"=>$write_perm, "write_perm_mode"=>$write_perm_mode, "modify_perm"=>$modify_perm, "delete_perm"=>$delete_perm, "reply_perm"=>$reply_perm, "reply_perm_mode"=>$reply_perm_mode);
	// Ÿ��Ʋ �̹��� ���ε�	
	$input_title_img = $GLOBALS[lib_common]->file_upload("title_img", $saved_title_img, $GLOBALS[VI][img_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
	if ($read_perm == '') $read_perm = '8';
	if ($write_perm == '') $write_perm = '8';
	if ($reply_perm == '') $reply_perm = '8';
	if ($read_perm_mode == '') $read_perm_mode = 'U';
	if ($write_perm_mode == '') $write_perm_mode = 'U';
	if ($reply_perm_mode == '') $reply_perm_mode = 'U';
	if ($modify_perm == '') $modify_perm = 'P';
	if ($delete_perm == '') $delete_perm = 'P';
}
$page_type = 'B';																															// ������ Ÿ��
switch($mode) {
	case "add" :
		// �Խ��� ��Ī(������̸�) �ߺ� Ȯ��
		$query = "select serial_num from $DB_TABLES[board_list] where alias='$alias'";
		$result = $GLOBALS[lib_common]->querying($query, "�ߺ� �Խ��� �̸� ���� ���� ������ �����߻�"); 
		if (mysql_num_rows($result) > 0) $GLOBALS[lib_common]->alert_url("���� �̸��� �Խ����� �����մϴ�.\\n\\n�ٸ� �̸��� �Է��� �ּ���!!");
		$alias = stripslashes($alias);
		$view_page = "����";
		$write_page = "����";
		$modify_page = "����";
		$delete_page = "����";
		$reply_page = "�亯";

		// �Խ��� �ڵ�� ����
		$query = "select max(serial_num)+1 from $DB_TABLES[design_files]";
		$result = $GLOBALS[lib_common]->querying($query, "������ ���� �� ���� ���������� ����"); 
		$board_name = mysql_result($result, 0, 0);

		// ���������� �⺻����
		$record_info = array();
		$record_info[create_date] = $GLOBALS[w_time];
		$record_info[view_level] = $read_perm;
		$record_info[type] = $page_type;
		$record_info[skin_file] = $skin_file;
		$record_info[design_file_group] = $_SESSION[dfg];
		$record_info[menu] = $page_menu;
		$record_info[udf_group] = $udf_group;
		$record_info[memo] = $memo;		
		$record_info[tag_header] = $tag_header;
		$record_info[tag_body] = $tag_body;
		$record_info[tag_body_in] = $tag_body_in;
		$record_info[tag_body_out] = $tag_body_out;
		$record_info[tag_contents_out] = $tag_contents_out;

		// ���ø����� �Ǵ� �ٸ� �Խ��Ǻ���� : ���, ����, ����, ����, ����, �亯 ������ ������ƾ
		while (list($key, $value) = each($board_page_array)) {
			$design_file_copy = $template_info = $design = '';
			$var_name_tb_field = "{$key}_page";
			$var_name_board_file = "{$key}_file";
			if ($clip_board_name != '') {
				$design_file_copy = $clip_board_info[$var_name_tb_field];
				$design = $lib_fix->design_load($DIRS, $design_file_copy, '');
			} else if ($template_name != '') {
				$template_file_name = "board_{$key}.php";
				$template_info = array("template_name"=>$template_name, "template_file_name"=>$template_file_name);
				$design = $lib_fix->design_load($DIRS, $template_file_name, '', $template_dir);
			}
			$design = chg_board_name($board_name, $design);
			
			// �Խ��� ���ѿ� ���� ������ ���Ѽ���
			$page_perm_info = get_perm_code($perm_info_array, $var_name_tb_field);
			$record_info[view_level] = $page_perm_info[perm];
			$record_info[view_level_mode] = $page_perm_info[perm_mode];
			if ($key == "list") {
				$record_info[name] = $alias;
				if ($parent_design_file != '') $design_file_parent = $parent_design_file;
				else $design_file_parent = '';				
			} else {
				$record_info[name] = $value;
				$design_file_parent = $list_file;
			}
			$$var_name_board_file = $lib_fix->make_design_file($record_info, $design_file_parent, $design_file_copy, $template_info, $design);
		}
		$record_info = array();
		$record_info[name] = $board_name;
		$record_info[alias] = $alias;
		$record_info[create_date] = $GLOBALS[w_time];
		$record_info[list_page] = $list_file;
		$record_info[view_page] = $view_file;
		$record_info[write_page] = $write_file;
		$record_info[modify_page] = $modify_file;
		$record_info[delete_page] = $delete_file;
		$record_info[reply_page] = $reply_file;
		$record_info[type_define] = $type_define;
		$record_info[header] = $header;
		$record_info[footer] = $footer;
		$record_info[title_tag] = $title_tag;
		$record_info[title_type] = $title_type;
		$record_info[read_perm] = $read_perm;
		$record_info[write_perm] = $write_perm;
		$record_info[reply_perm] = $reply_perm;
		$record_info[read_perm_mode] = $read_perm_mode;
		$record_info[write_perm_mode] = $write_perm_mode;
		$record_info[reply_perm_mode] = $reply_perm_mode;
		$record_info[modify_perm] = $modify_perm;
		$record_info[delete_perm] = $delete_perm;
		$record_info[category_1] = $category_1;
		$record_info[category_2] = $category_2;
		$record_info[category_3] = $category_3;
		$record_info[category_4] = $category_4;
		$record_info[category_5] = $category_5;
		$record_info[category_6] = $category_6;
		$record_info[search_field] = $search_field;
		$record_info[file_name_method] = $file_name_method;
		$record_info[admin] = $admin;
		$record_info[title_img] = $input_title_img;
		$record_info['include'] = $include;
		$record_info[filter] = $filter;
		$record_info[member_info] = $member_info;
		$record_info[notice_email] = $notice_email;
		$record_info[notice_sms] = $notice_sms;
		$record_info[notice_user_email] = $notice_user_email;
		$record_info[notice_user_sms] = $notice_user_sms;
		$record_info[count_term] = $count_term;
		$record_info[extensions] = $extensions;
		$record_info[extensions_mode] = $extensions_mode;
		$record_info[design_file_group] = $_SESSION[dfg];
		$GLOBALS[lib_common]->input_record($DB_TABLES[board_list], $record_info);

		$query = "
			CREATE TABLE `{$DB_TABLES[board]}_{$board_name}` (
				`serial_num` mediumint(10) unsigned NOT NULL auto_increment,
				`fid` mediumint(10) unsigned NOT NULL default '0',
				`writer_name` varchar(150) NOT NULL default '',
				`email` varchar(150) default NULL,
				`phone` varchar( 14 ) NOT NULL,
				`homepage` varchar(150) default NULL,
				`subject` varchar(200) NOT NULL,
				`comment_1` text NOT NULL,
				`comment_2` varchar(255) NOT NULL default '',
				`passwd` varchar(30) NOT NULL default '',
				`sign_date` int(10) unsigned NOT NULL default '0',
				`modify_date` int(10) unsigned NOT NULL default '0',
				`count` mediumint(5) NOT NULL default '0',
				`thread` varchar(255) NOT NULL default '',
				`reply_answer` char(1) NOT NULL default 'N',
				`user_ip` varchar(16) default NULL,
				`user_file` varchar(255) default NULL,
				`file_size` int(10) unsigned default '0',
				`vote` int(5) unsigned default '0',
				`category_1` varchar(10) NOT NULL default '',
				`category_2` varchar(10) NOT NULL default '',
				`category_3` varchar(10) NOT NULL default '',
				`category_4` varchar(10) NOT NULL default '',
				`category_5` varchar(10) NOT NULL default '',
				`category_6` varchar(10) NOT NULL default '',
				`writer_id` varchar(20) default '',
				`type` varchar(200) NOT NULL default '',
				`is_view` char(1) NOT NULL default 'Y',
				`is_notice` char(1) NOT NULL default '',
				`is_html` char(1) NOT NULL default 'N',
				`is_private` char(1) default 'N',
				`relation_table` varchar(20) default '',
				`relation_serial` mediumint(7) NOT NULL default '0',
				`etc_1` varchar(20) NOT NULL default '',
				`etc_2` char(1) NOT NULL default '',
				`etc_3` char(1) NOT NULL default '',
				PRIMARY KEY  (`serial_num`)
			)
		";
		$result = $GLOBALS[lib_common]->querying($query, "�Խ��� ���̺��߰� ������ ����");

		// ���ε����� ���� ���丮 ����
		mkdir("{$DIRS[design_root]}/upload_file/{$board_name}/", $site_info[directory_permission]);
		chmod("{$DIRS[design_root]}/upload_file/{$board_name}/", $site_info[directory_permission]);

		$change_vars = array("page"=>'');
		$link = "./board_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
		$GLOBALS[lib_common]->alert_url('', 'E', $link);
	break;
	case "modify" :
		$board_info = $lib_fix->get_board_info($board_name);
		$T_where = array();
		// ���ø����� �Ǵ� �ٸ� �Խ��Ǻ���� : ���, ����, ����, ����, ����, �亯 ������ ������ƾ
		if ($clip_board_name != '' || $template_name != '') $board_page_array_modify = $board_page_array;
		else $board_page_array_modify = array();
		while (list($key, $value) = each($board_page_array_modify)) {
			$design_file_copy = $template_info = $design = '';
			$var_name_tb_field = "{$key}_page";
			if ($clip_board_name != '') {
				$design_file_copy = $clip_board_info[$var_name_tb_field];
				$design = $lib_fix->design_load($DIRS, $design_file_copy, '');
			} else if ($template_name != '') {
				$template_file_name = "board_{$key}.php";
				$template_info = array("template_name"=>$template_name, "template_file_name"=>$template_file_name);
				$design = $lib_fix->design_load($DIRS, $template_file_name, '', $template_dir);
			}
			$design = chg_board_name($board_name, $design);
			$lib_fix->design_save($design, $DIRS, $board_info[$var_name_tb_field], $site_page_info, "N");
		}

		if ($board_info[alias] != $alias) $GLOBALS[lib_common]->db_set_field_value($DB_TABLES[design_files], "name", $alias, "file_name", $board_info[list_page]);

		// ������ �Ӽ� �ϰ�����
		$record_info_page = array();
		if ($skin_file != '') $record_info_page[skin_file] = $skin_file;																	// ��Ų ������ �ִ°��
		if ($page_menu != '') $record_info_page[menu] = $page_menu;															// �޴� ������ �ִ°��
		if ($udf_group != '') $record_info_page[udf_group] = $udf_group;														// ��������� �׷� ������ �ִ°��
		if ($tag_header != '') $record_info_page[tag_header] = $tag_header;												// ��� ������ �ִ°��
		if ($tag_body_in != '') $record_info_page[tag_body_in] = $tag_body_in;										// �ٵ𳻺� ������ �ִ°��
		if ($tag_body_out != '') $record_info_page[tag_body_out] = $tag_body_out;								// �ٵ�ܺ� ������ �ִ°��
		if ($tag_contents_out != '') $record_info_page[tag_contents_out] = $tag_contents_out;		// �������ܺ� ������ �ִ°��

		if (sizeof($record_info_page) > 0) {
			$sub_query_board_file = "file_name='$board_info[list_page]' or file_name='$board_info[view_page]' or file_name='$board_info[write_page]' or file_name='$board_info[modify_page]' or file_name='$board_info[delete_page]' or file_name='$board_info[reply_page]'";
			$GLOBALS[lib_common]->modify_record($DB_TABLES[design_files], '', '', $record_info_page, 'Y', $sub_query_board_file);
		}

		// ���� ����
		while (list($key, $value) = each($board_page_array)) {
			$field_name = "{$key}_page";
			if ($key == "list") {
				$T_sub_query = " or file_name='{$board_info[$field_name]}'";
				continue;
			}
			$record_info = array();
			$page_perm_info = get_perm_code($perm_info_array, $field_name);
			$T_read_perm = $page_perm_info[perm];
			$T_read_perm_mode = $page_perm_info[perm_mode];
			$query = "update $DB_TABLES[design_files] set view_level='{$T_read_perm}', view_level_mode='{$T_read_perm_mode}' where file_name='{$board_info[$field_name]}'{$T_sub_query}";
			$result = $GLOBALS[lib_common]->querying($query, "������ $key ���� ������ ����");
			$T_sub_query = '';
		}
		
		$record_info = array();
		// �������� �����
		reset($board_page_array);
		while (list($key, $value) = each($board_page_array)) {
			$var_name_tb_field = "{$key}_page";
			$var_name_board_file = "{$key}_file";
			if ($$var_name_tb_field != '' && $board_info[$var_name_tb_field] != $$var_name_tb_field) {	// ������ �ִ� ���
				$design_file_list = "{$DIRS[design_root]}{$board_info[$var_name_tb_field]}";
				$T_target = "{$DIRS[design_root]}{$$var_name_tb_field}";
				if (is_file($T_target)) $GLOBALS[lib_common]->alert_url("��� ���ϸ��� �̹� ���� �մϴ�.");
				if (is_file($design_file_list)) {
					if (!rename($design_file_list, $T_target)) $GLOBALS[lib_common]->alert_url("���ϸ� �������");
				} else {
					$GLOBALS[lib_common]->str_to_file($T_target, 'w', '', "php");
				}
				$record_info[$var_name_tb_field] = $$var_name_tb_field;
				$query = "update $DB_TABLES[design_files] set file_name='{$$var_name_tb_field}' where file_name='$board_info[$var_name_tb_field]'";
				$result = $GLOBALS[lib_common]->querying($query, "���ϸ� ���� ������ ����");
			}
		}

		$change_vars = array("board_name"=>$board_name);

		// �Խ��� ���̺�� ����
		if ($name != '' && $board_info[name] != $name) {
			$T_source = "{$DIRS[upload_root]}{$board_info[name]}";
			$T_target = "{$DIRS[upload_root]}{$name}";
			if (is_file($T_target)) $GLOBALS[lib_common]->alert_url("���� �̸��� ���ε� ���丮�� ���� �մϴ�. : $T_target");
			if (!rename($T_source, $T_target)) $GLOBALS[lib_common]->alert_url("���ε����� ���丮�� ������� : $T_source, $T_target");
			$query = "ALTER TABLE `TCBOARD_{$board_info[name]}` RENAME `TCBOARD_{$name}`";
			$result = mysql_query($query);
			if (!$result) {
				if (!rename($T_target, $T_source)) $GLOBALS[lib_common]->alert_url("���ε����� ���丮�� �������� : $T_target, $T_source");
				$GLOBALS[lib_common]->alert_url("DB ���̺�� ���� ����");
			}
			reset($board_page_array);
			while (list($key, $value) = each($board_page_array)) {
				$var_name_tb_field = "{$key}_page";
				$design = $lib_fix->design_load($DIRS, $board_info[$var_name_tb_field]);
				$design = chg_board_name($name, $design);
				$lib_fix->design_save($design, $DIRS, $board_info[$var_name_tb_field], $site_page_info, "N");
			}
			$record_info[name] = $name;
			$change_vars = array("board_name"=>$name);
		}

		// �Խ��� ���� ����
		$record_info[alias] = $alias;
		$record_info[type_define] = $type_define;
		$record_info[header] = $header;
		$record_info[footer] = $footer;
		$record_info[title_tag] = $title_tag;
		$record_info[title_type] = $title_type;
		$record_info[read_perm] = $read_perm;
		$record_info[write_perm] = $write_perm;
		$record_info[reply_perm] = $reply_perm;
		$record_info[read_perm_mode] = $read_perm_mode;
		$record_info[write_perm_mode] = $write_perm_mode;
		$record_info[reply_perm_mode] = $reply_perm_mode;
		$record_info[modify_perm] = $modify_perm;
		$record_info[delete_perm] = $delete_perm;
		$record_info[category_1] = $category_1;
		$record_info[category_2] = $category_2;
		$record_info[category_3] = $category_3;
		$record_info[category_4] = $category_4;
		$record_info[category_5] = $category_5;
		$record_info[category_6] = $category_6;
		$record_info[search_field] = $search_field;
		$record_info[file_name_method] = $file_name_method;
		$record_info[admin] = $admin;
		$record_info[title_img] = $input_title_img;
		$record_info['include'] = $include;
		$record_info[filter] = $filter;
		$record_info[member_info] = $member_info;
		$record_info[notice_email] = $notice_email;
		$record_info[notice_sms] = $notice_sms;
		$record_info[notice_user_email] = $notice_user_email;
		$record_info[notice_user_sms] = $notice_user_sms;
		$record_info[count_term] = $count_term;
		$record_info[extensions] = $extensions;
		$record_info[extensions_mode] = $extensions_mode;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[board_list], "name", $board_name, $record_info);

		$link = "./board_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
		$GLOBALS[lib_common]->alert_url('', 'E', $link);
	break;
	case "delete" :
		if (trim($board_name) == '') $GLOBALS[lib_common]->alert_url("������ �Խ����� �����ϴ�.", 'E', '', "document");
		$lib_insiter->delete_board($board_name);
		$change_vars = array("board_name"=>'');
		$link = "./board_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
		$GLOBALS[lib_common]->alert_url('', 'E', $link);
	break;	
	case "make_template" :
		if (trim($template_name) == '') $GLOBALS[lib_common]->alert_url("���ø� �̸��� �Է��� �ּ���");
		$board_info = $lib_fix->get_board_info($board_name);
		$template_dir = "{$DIRS[template]}{$template_name}/";
		$etc_info = array("allow_dir_exist"=>'Y', "dub_method_resource"=>$dub_method_resource);
		$lib_fix->make_template($board_info[list_page], $template_dir, "board_list.php", $etc_info);
		$lib_fix->make_template($board_info[view_page], $template_dir, "board_view.php", $etc_info);
		$lib_fix->make_template($board_info[write_page], $template_dir, "board_write.php", $etc_info);
		$lib_fix->make_template($board_info[modify_page], $template_dir, "board_modify.php", $etc_info);
		$lib_fix->make_template($board_info[delete_page], $template_dir, "board_delete.php", $etc_info);
		$lib_fix->make_template($board_info[reply_page], $template_dir, "board_reply.php", $etc_info);
		$msg = "���ø��� �����Ǿ����ϴ�.";
		$GLOBALS[lib_common]->alert_url($msg, 'E', '', '', "window.close()");
	break;
}

// ������ ���Ͽ��� �Խ����ڵ���� ã�Ƽ� ������ �ִ� �Լ�
function chg_board_name($board_name, $design) {
	global $DB_TABLES;
	if ($design == '') return '';
	for ($i=0,$cnt=sizeof($design); $i<$cnt; $i++) {
		$exp = explode($GLOBALS[DV][dv], $design[$i]);
		if ($exp[4] == "TC_BOARD") {
			$board_property = explode($GLOBALS[DV][ct5], $exp[5]);
			if ($board_property[10] != '') {																										// �������̺��� ������ ��� �������̺�� ����
				$board_property[10] = "{$DB_TABLES[board]}_{$board_name}";
			} else {																																						// ���� ���̺� �����ȵȰ�� ���̺�� ����
				$board_property[0] = $board_name;
			}			
			$board_property = implode($GLOBALS[DV][ct5], $board_property);
			$exp[5] = $board_property;
			$design[$i] = implode($GLOBALS[DV][dv], $exp);
		}
	}
	return $design;
}

// �Խ��� ���� ������ ������ ���Ѽ����� �����ϴ� �Լ�
function get_perm_code($perm_info, $board_page) {
	$return_value = array();
	// ������ ���õ��� ���� ��� ��� �� �� �ֵ��� ����
	if ($perm_info[read_perm] == '') {
		$perm_info[read_perm] = '8';
		$perm_info[read_perm_mode] = 'U';
	}
	if ($perm_info[write_perm] == '') {
		$perm_info[write_perm] = '8';
		$perm_info[write_perm_mode] = 'U';
	}
	if ($perm_info[reply_perm] == '') {
		$perm_info[reply_perm] = '8';
		$perm_info[reply_perm_mode] = 'U';
	}
	if ($perm_info[modify_perm] == '') {
		$perm_info[modify_perm] = '8';
		$perm_info[modify_perm_mode] = 'U';
	}
	if ($perm_info[delete_perm] == '') {
		$perm_info[delete_perm] = '8';
		$perm_info[delete_perm_mode] = 'U';
	}
	switch ($board_page) {
		case "list_page" :
		case "view_page" :
			if ($perm_info[read_perm] == 'S') {
				$return_value[perm] = '7';
				$return_value[perm_mode] = 'U';
			} else {
				$return_value[perm] = $perm_info[read_perm];
				$return_value[perm_mode] = $perm_info[read_perm_mode];
			}
		break;
		case "write_page" :
			$return_value[perm] = $perm_info[write_perm];
			$return_value[perm_mode] = $perm_info[write_perm_mode];
		break;
		case "reply_page" :
			$return_value[perm] = $perm_info[reply_perm];
			$return_value[perm_mode] = $perm_info[reply_perm_mode];
		break;		
		case "modify_page" :
			if ($perm_info[modify_perm] == 'S') {
				$return_value[perm] = '7';
				$return_value[perm_mode] = 'U';
			} else if ($perm_info[modify_perm] == 'A') {
				$return_value[perm] = $GLOBALS[VI][admin_level_user];
				$return_value[perm_mode] = 'U';
			} else {
				$return_value[perm] = '8';
				$return_value[perm_mode] = 'U';
			}
		break;		
		case "delete_page" :
			if ($perm_info[delete_perm] == 'S') {
				$return_value[perm] = '7';
				$return_value[perm_mode] = 'U';
			} else if ($perm_info[delete_perm] == 'A') {
				$return_value[perm] = $GLOBALS[VI][admin_level_user];
				$return_value[perm_mode] = 'U';
			} else {
				$return_value[perm] = '8';
				$return_value[perm_mode] = 'U';
			}
		break;
	}
	return $return_value;
}

?>
