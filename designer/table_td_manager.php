<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	������ ������ �ҷ� ���پ� �迭�� �����Ѵ�.
if (!strcmp("modify", $mode)) {
	if($width != '') $width = " width={$width}";
	if($height != '') $height = " height={$height}";
	if($align != '') $align = " align={$align}";
	if($valign != '') $valign = " valign={$valign}";
	if($colspan > 1) $colspan = " colspan={$colspan}";
	else $colspan = '';
	if($rowspan > 1) $rowspan = " rowspan={$rowspan}";
	else $rowspan = '';
	if($bgcolor != '') $bgcolor = " bgcolor={$bgcolor}";
	if($etc != '') {
		$etc = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $etc);
		$etc = " $etc";
	}
	$bg_img_ext = array('gif', 'jpg');
	$bg_img = $GLOBALS[lib_common]->file_upload("background", $saved_background, $bg_img_ext, 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
	if ($bg_img != '') $bg_img = " background={$bg_img}";

	$td_property = "{$width}{$height}{$align}{$valign}{$colspan}{$rowspan}{$bgcolor}{$bg_img}{$etc}";

	$location = "index=" . $index;
	$line = $lib_fix->search_index($design, "ĭ", $location);
	$td_exp = explode($GLOBALS[DV][dv], trim($design[$line[0]]));
	$td_exp[2] = $td_property;
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";	 // �¿��±�
	$design[$line[0]] = $lib_fix->make_design_line(implode($GLOBALS[DV][dv], $td_exp), '', $tag_both, $blanks);
	
	if (!strcmp($select_modify_row, "tr")) {	// ������ ��ü ������ üũ������.
		$index_exp = explode("_", $index);
		$location = "index={$index_exp[0]}_{$index_exp[1]}";
		$line = $lib_fix->search_index($design, "��", $location);
		for ($i = $line[0]; $i<=$line[1]; $i++) {
			$td_exp = explode($GLOBALS[DV][dv], $design[$i]);
			if (!strcmp($td_exp[0], "ĭ����") && strcmp($td_exp[1], "index={$index}")) {	 
				$td_exp[2] = "{$width}{$height}{$align}{$valign}{$bgcolor}{$background}{$title} {$etc}";
				$design[$i] = implode($GLOBALS[DV][dv], $td_exp);
			}
		}
	}
	if (!strcmp($select_modify_col, "tr")) {	 // ���� �� ��ü ������ üũ������.
		$index_exp = explode("_", $index);
		$location = "index={$index_exp[0]}_{$index_exp[1]}";
		$line = $lib_fix->search_index($design, "��", $location);
		$num = $lib_fix->td_location($design, $line, $index_exp);
		$location = "index={$index_exp[0]}";
		$line = $lib_fix->search_index($design, "���̺�", $location);
		$counter = 0;
		for ($i = $line[0]; $i<=$line[1]; $i++) {
			$td_exp = explode($GLOBALS[DV][dv], $design[$i]);
			$index_exp_current = explode("_", $td_exp[1]);
			if ($td_exp[0] == "�ٽ���" && "index={$index_exp[0]}" == $index_exp_current[0]) {
				$counter = 0;
				continue;
			}
			if ($td_exp[0] == "ĭ����" && "index={$index_exp[0]}" == $index_exp_current[0]) {
				$counter++;
				if ($num == $counter) {
					$td_exp[2] = "{$width}{$height}{$align}{$valign}{$bgcolor}{$background}{$title} {$etc}";
					$design[$i] = implode($GLOBALS[DV][dv], $td_exp);
				}
			}
		}
	}
	if (!strcmp($select_modify_alltd, "td")) {		// ���ĭ ������ üũ������.
		$index_exp = explode("_", $index);
		$location = "index={$index_exp[0]}";
		$line = $lib_fix->search_index($design, "���̺�", $location);
		for ($i = $line[0]; $i<=$line[1]; $i++) {
			$td_exp = explode($GLOBALS[DV][dv], $design[$i]);
			$index_exp_current = explode("_", $td_exp[1]);
			if ($td_exp[0] == "ĭ����" && "index={$index_exp[0]}" == $index_exp_current[0]) {
				$td_exp[2] = "{$width}{$height}{$align}{$valign}{$bgcolor}{$background}{$title} {$etc}";
				$design[$i] = implode($GLOBALS[DV][dv], $td_exp);
			}
		}
	}
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
} else if ($mode == "make") {
	$bg_img_ext = array('gif', 'jpg');
	$bg_img = $GLOBALS[lib_common]->file_upload("background", $saved_background, $bg_img_ext, 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
	$line = $lib_fix->search_index($design, "��", $location);
	$new_td_index = $lib_fix->max_td_num($design, $line);
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";	 // �¿��±�
	$td_insert_value = $lib_fix->make_td($td_num, $width, $height, $align, $valign, $bgcolor, $bg_img, $etc, $style, $new_td_index, $index_exp[0], $index_exp[1], $tag_both);
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	if (!strcmp($insert_location, "left")) array_splice($design, $search[0], 0, $td_insert_value);
	else array_splice($design, $search[1]+1, 0, $td_insert_value);
	
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
} else if ($mode == "delete") {
	$location_td = "index=" . $index;
	$search_td_line = $lib_fix->search_index($design, "ĭ", $location_td);
	for ($start = $search_td_line[0]; $start <= $search_td_line[1]; $start++) {
		$design[$start] = "";
	}
	$new_design = $lib_fix->design_trim($design);	// �����ι迭�� ����� ���ְ� �� �ε����� ��´�.(���ڷ� �Ѿ�� �����ؾ��� ���̺� �ε��� ���� ������� �����ؼ� ����ؾ���)
	$design = $lib_fix->table_cleaner($new_design, $DIRS[design_root], $design_file, $index);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
} else if ($mode = "delete_value") {
	$design = $lib_fix->td_clear($index, $design, $DIRS[design_root], $design_file, $design_name, $code);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
}
?>