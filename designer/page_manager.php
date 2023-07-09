<?
include "header_proc.inc.php";
switch ($mode) {
	case "add" :
		$record_info = array();
		$record_info[name] = $design_name;
		$record_info[create_date] = $GLOBALS[w_time];
		$record_info[view_level] = $pageViewLevel;
		$record_info[view_level_mode] = $page_view_level_mode;
		$record_info[type] = $page_type;
		$record_info[skin_file] = $skin_file;
		$record_info[design_file_group] = $_SESSION[dfg];
		$record_info[menu] = $page_menu;
		$record_info[navi_property] = $navi_property;
		$record_info[navi_mode] = $navi_mode;
		$record_info[udf_group] = $udf_group;
		$record_info[memo] = $memo;
		$record_info[perm_err_msg] = $perm_err_msg;
		$record_info[default_file_dir] = $default_file_dir;
		$record_info[view_err_page] = $view_err_page;
		$record_info[page_lock] = $page_lock;
		if ($template_name != '' && $template_file_name != '') $template_info = array("template_name"=>$template_name, "template_file_name"=>$template_file_name);
		$lib_fix->make_design_file($record_info, $design_file_parent, $design_file_copy, $template_info);
		$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.location.reload();window.close();");
	break;
	case "modify" :
		$site_page_info = $lib_fix->get_site_page_info($design_file);
		if ($page_type == 'S' || $page_type == 'I') $skin_file = '';
		$record_info = array();
		// ���ϸ� ����
		if ($file_name != '' && $site_page_info[file_name] != $file_name) {
			$src_file = "{$DIRS[design_root]}{$site_page_info[file_name]}";
			$T_target = "{$DIRS[design_root]}{$file_name}";
			if (is_file($T_target)) $GLOBALS[lib_common]->alert_url("��� ���ϸ��� �̹� ���� �մϴ�.");
			if (is_file($src_file)) {
				if (!rename($src_file, $T_target)) $GLOBALS[lib_common]->alert_url("���ϸ� �������");
			} else {
				$GLOBALS[lib_common]->str_to_file($T_target, 'w', '', "php");
			}
			$record_info[file_name] = $file_name;
		}
		$record_info[name] = $design_name;
		$record_info[last_modify_date] = $GLOBALS[w_time];
		$record_info[view_level] = $pageViewLevel;
		$record_info[view_level_mode] = $page_view_level_mode;
		$record_info[type] = $page_type;
		$record_info[skin_file] = $skin_file;
		$record_info[design_file_group] = $_SESSION[dfg];
		$record_info[menu] = $page_menu;
		$record_info[navi_property] = $navi_property;
		$record_info[navi_mode] = $navi_mode;
		$record_info[udf_group] = $udf_group;
		$record_info[memo] = $memo;
		$record_info[perm_err_msg] = $perm_err_msg;
		$record_info[default_file_dir] = $default_file_dir;
		$record_info[view_err_page] = $view_err_page;
		$record_info[page_lock] = $page_lock;
		$design_file_full = "{$DIRS[design_root]}{$design_file}";
		if ($template_name != '' && $template_file_name != '') $template_info = array("template_name"=>$template_name, "template_file_name"=>$template_file_name);
		if ($design_file_copy != '') {																									// ���� �������� ������ ���
			if (!copy("{$DIRS[design_root]}{$design_file_copy}", $design_file_full)) die("������ ���� �������");
			$source_file_value = $GLOBALS[lib_common]->get_data($DB_TABLES[design_files], "file_name", $design_file_copy);
			$record_info[tag_header] = addslashes($source_file_value[tag_header]);
			$record_info[tag_body] = addslashes($source_file_value[tag_body]);
			$record_info[tag_body_in] = addslashes($source_file_value[tag_body_in]);
			$record_info[tag_body_out] = addslashes($source_file_value[tag_body_out]);
			$record_info[tag_contents_out] = addslashes($source_file_value[tag_contents_out]);
		} else if ($template_info != '') {																							// ���ø��� ������ ���
			$template_file_full = "{$DIRS[template]}{$template_info[template_name]}/{$template_info[template_file_name]}";
			if (!copy($template_file_full, $design_file_full)) die("������ ���� �������");
			$tag_arrays = array("tag_header", "tag_body", "tag_body_in", "tag_body_out", "tag_contents_out");
			for ($i=0,$cnt=sizeof($tag_arrays); $i<$cnt; $i++) {
				$target_file = "{$template_file_full}_{$tag_arrays[$i]}";
				if (file_exists($target_file)) {
					$fp = fopen($target_file, 'r');
					$file_value = '';
					while (!feof($fp)) $file_value .= fgets($fp, 2048);
					$record_info[$tag_arrays[$i]] = addslashes($file_value);
				}
			}
		}
		$GLOBALS[lib_common]->modify_record($DB_TABLES[design_files], "file_name", $design_file, $record_info);
		if ($where == "page_designer") $GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");
		else $GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.location.reload();window.close();");
	break;
	case "delete" :
		$replydelete = false;
		if (!$replydelete) {								// �����ϰ��� �ϴ� ������ ������ �������� �����ϴ� ��� ������ �� ����.
			$query = "select thread from $DB_TABLES[design_files] where fid='$site_page_info[fid]' and length(thread) = length('$site_page_info[thread]')+1 AND locate('$site_page_info[thread]',thread) = 1 order by thread desc limit 1";
			$result = $GLOBALS[lib_common]->querying($query, "�亯�� ���� Ȯ�� ���� ������ �����߻�");
			$rows = mysql_num_rows($result);
			if($rows > 0) $GLOBALS[lib_common]->alert_url("���� �������� �־� ������ �� �����ϴ�.");
		}
		if (strcmp($design_file, "home.php") && strcmp($design_file, "member.php") && strcmp($design_file, "login.php")) {
			$lib_fix->delete_design_file($DIRS, $design_file);
			$change_vars = array("design_file"=>'');
			$link = "./page_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
			$GLOBALS[lib_common]->alert_url('', 'E', $link);
		} else {
			$GLOBALS[lib_common]->alert_url("�ʼ��������� ������ �� �����ϴ�.");
		}
	break;
	case "default" :
		$query = "select * from $DB_TABLES[design_files] where type='U' or type='S' or type='I'";
		$result = $GLOBALS[lib_common]->querying($query, "������ ���� ���� ������ ����");
		while ($value = mysql_fetch_array($result)) {
			$lib_fix->delete_design_file($DIRS, $value[file_name]);
		}
		$GLOBALS[lib_common]->alert_url('', 'E', "index.php?view_page_type=$page_type");
	break;
	case "make_template" :
		if (trim($template_name) == '' && trim($selected_template_name) == '') $GLOBALS[lib_common]->alert_url("���ø� �̸��� �Է��ϰų� ���� ���ø��� ������ �ּ���");
		if ($template_name != '') $template_dir = "{$DIRS[template]}{$template_name}/";
		else $template_dir = "{$DIRS[template]}{$selected_template_name}/";
		$etc_info = array("allow_dir_exist"=>'Y', "dub_method_resource"=>$dub_method_resource);
		$lib_fix->make_template($design_file_name, $template_dir, $template_file_name . ".php", $etc_info);
		$msg = "���ø��� �����Ǿ����ϴ�.";
		$GLOBALS[lib_common]->alert_url($msg, 'E', '', '', "window.close()");
	break;
	case "move" :
		$lib_fix->change_parent($design_file, $design_file_parent);
		$GLOBALS[lib_common]->alert_url($msg, 'E', '', '', "opener.location.href='{$DIRS[designer_root]}page_list.php?menu=design';window.close()");
	break;
}
?>