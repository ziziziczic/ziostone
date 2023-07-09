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
		// 파일명 변경
		if ($file_name != '' && $site_page_info[file_name] != $file_name) {
			$src_file = "{$DIRS[design_root]}{$site_page_info[file_name]}";
			$T_target = "{$DIRS[design_root]}{$file_name}";
			if (is_file($T_target)) $GLOBALS[lib_common]->alert_url("대상 파일명이 이미 존재 합니다.");
			if (is_file($src_file)) {
				if (!rename($src_file, $T_target)) $GLOBALS[lib_common]->alert_url("파일명 변경오류");
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
		if ($design_file_copy != '') {																									// 복사 페이지를 선택한 경우
			if (!copy("{$DIRS[design_root]}{$design_file_copy}", $design_file_full)) die("디자인 파일 복사실패");
			$source_file_value = $GLOBALS[lib_common]->get_data($DB_TABLES[design_files], "file_name", $design_file_copy);
			$record_info[tag_header] = addslashes($source_file_value[tag_header]);
			$record_info[tag_body] = addslashes($source_file_value[tag_body]);
			$record_info[tag_body_in] = addslashes($source_file_value[tag_body_in]);
			$record_info[tag_body_out] = addslashes($source_file_value[tag_body_out]);
			$record_info[tag_contents_out] = addslashes($source_file_value[tag_contents_out]);
		} else if ($template_info != '') {																							// 템플릿을 선택한 경우
			$template_file_full = "{$DIRS[template]}{$template_info[template_name]}/{$template_info[template_file_name]}";
			if (!copy($template_file_full, $design_file_full)) die("디자인 파일 복사실패");
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
		if (!$replydelete) {								// 삭제하고자 하는 페이지 하위에 페이지가 존재하는 경우 삭제할 수 없다.
			$query = "select thread from $DB_TABLES[design_files] where fid='$site_page_info[fid]' and length(thread) = length('$site_page_info[thread]')+1 AND locate('$site_page_info[thread]',thread) = 1 order by thread desc limit 1";
			$result = $GLOBALS[lib_common]->querying($query, "답변글 존재 확인 쿼리 수행중 에러발생");
			$rows = mysql_num_rows($result);
			if($rows > 0) $GLOBALS[lib_common]->alert_url("하위 페이지가 있어 삭제할 수 없습니다.");
		}
		if (strcmp($design_file, "home.php") && strcmp($design_file, "member.php") && strcmp($design_file, "login.php")) {
			$lib_fix->delete_design_file($DIRS, $design_file);
			$change_vars = array("design_file"=>'');
			$link = "./page_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
			$GLOBALS[lib_common]->alert_url('', 'E', $link);
		} else {
			$GLOBALS[lib_common]->alert_url("필수페이지는 삭제할 수 없습니다.");
		}
	break;
	case "default" :
		$query = "select * from $DB_TABLES[design_files] where type='U' or type='S' or type='I'";
		$result = $GLOBALS[lib_common]->querying($query, "디자인 파일 추출 쿼리중 에러");
		while ($value = mysql_fetch_array($result)) {
			$lib_fix->delete_design_file($DIRS, $value[file_name]);
		}
		$GLOBALS[lib_common]->alert_url('', 'E', "index.php?view_page_type=$page_type");
	break;
	case "make_template" :
		if (trim($template_name) == '' && trim($selected_template_name) == '') $GLOBALS[lib_common]->alert_url("템플릿 이름을 입력하거나 기존 템플릿을 선택해 주세요");
		if ($template_name != '') $template_dir = "{$DIRS[template]}{$template_name}/";
		else $template_dir = "{$DIRS[template]}{$selected_template_name}/";
		$etc_info = array("allow_dir_exist"=>'Y', "dub_method_resource"=>$dub_method_resource);
		$lib_fix->make_template($design_file_name, $template_dir, $template_file_name . ".php", $etc_info);
		$msg = "템플릿이 생성되었습니다.";
		$GLOBALS[lib_common]->alert_url($msg, 'E', '', '', "window.close()");
	break;
	case "move" :
		$lib_fix->change_parent($design_file, $design_file_parent);
		$GLOBALS[lib_common]->alert_url($msg, 'E', '', '', "opener.location.href='{$DIRS[designer_root]}page_list.php?menu=design';window.close()");
	break;
}
?>