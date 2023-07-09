<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	������ ������ �ҷ� ���پ� �迭�� �����Ѵ�.

if (!strcmp("modify", $mode)) {
	if ($width != "") {
		$width = stripslashes($width);
		$width = " width={$width}";
	}
	if ($height != "") {
		$height = stripslashes($height);
		$height = " height={$height}";
	}
	if ($cellpadding != "") {
		$cellpadding = stripslashes($cellpadding);
		$cellpadding = " cellpadding={$cellpadding}";
	}
	if ($cellspacing != "") {
		$cellspacing = stripslashes($cellspacing);
		$cellspacing = " cellspacing={$cellspacing}";
	}
	if ($align != "") {
		$align = stripslashes($align);
		$align = " align={$align}";
	}
	if ($bgcolor != "") {
		$bgcolor = stripslashes($bgcolor);
		$bgcolor = " bgcolor={$bgcolor}";
	}
	if ($border != "") {
		$border = stripslashes($border);
		$border = " border={$border}";
	}
	if ($etc != "") {
		$etc = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $etc);
		$etc = stripslashes(trim($etc));
		$etc = " $etc";
	}
	$bg_img_ext = array('gif', 'jpg');
	$bg_img = $GLOBALS[lib_common]->file_upload("background", $saved_background, $bg_img_ext, 'T', "{$GLOBALS[VI][default_file_dir]}", '', 'Y');
	if ($bg_img != '') $bg_img = " background={$bg_img}";

	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0];
	$line = $lib_fix->search_index($design, "���̺�", $location);

	$table_exp = explode($GLOBALS[DV][dv], $design[$line[0]]);	 // �Ӽ��� �����ϱ� ���� ���̺��� �д´�.
	$table_property =  "{$width}{$height}{$cellpadding}{$cellspacing}{$align}{$bgcolor}{$bg_img}{$border}{$etc}{$style}";
	$table_property = trim($table_property);
	$table_exp[2] = $table_property;
	
	// �¿��±�
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";
	if (str_replace($GLOBALS[DV][ct4], '', $tag_both) != '') $table_exp[12] = $tag_both;
	else $table_exp[12] = '';

	// ��Ų
	$table_skin = "{$table_skin_dir}{$GLOBALS[DV][ct4]}{$table_skin_title}{$GLOBALS[DV][ct4]}{$table_skin_padding}";
	if (str_replace($GLOBALS[DV][ct4], '', $table_skin) != '') $table_exp[13] = $table_skin;
	else $table_exp[13] = '';

	$design[$line[0]] = implode($GLOBALS[DV][dv], $table_exp);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");

} else if (!strcmp("make", $mode)) {
	$bg_img_ext = array('gif', 'jpg');
	$bg_img = $GLOBALS[lib_common]->file_upload("background", $saved_background, $bg_img_ext, 'T', $GLOBALS[VI][default_file_dir], '', 'Y');

	// �¿��±�
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";
	$table_skin = "{$table_skin_dir}{$GLOBALS[DV][ct4]}{$table_skin_title}{$GLOBALS[DV][ct4]}{$table_skin_padding}";
	$table_tag = $lib_fix->make_table($design, $row, $col, $width, $height, $cellpadding, $cellspacing, $align, $bgcolor, $bg_img, $border, $etc, $style, $tag_both, $table_skin);

	if ($index != '') {	// ���̺� �ȿ� ���̺� �����̸�
		if ($current_line == '') die("��������� ã�� �� �����ϴ�");
		array_splice($design, $current_line+1, 0, $table_tag);
		$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
		$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
	} else {
		array_push($design, $table_tag);
		$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
		$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");
	}

} else if (!strcmp("delete", $mode)) {
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0];
	$search = $lib_fix->search_index($design, "���̺�", $location);
	array_splice($design, $search[0], $search[1] - $search[0] +1);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");

} else if (!strcmp("copy", $mode)) {
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0];
	$search = $lib_fix->search_index($design, "���̺�", $location);	// ���۰� �� ��ġ�� ��´�.
	for ($start = $search[0]; $start <= $search[1]; $start++) $cuted_table .= $design[$start];
	$fp = fopen("{$DIRS[design_root]}information/temp_table.php", "w");
	fwrite($fp, $cuted_table);
	fclose($fp);
	$GLOBALS[lib_common]->alert_url("������ ǥ�� Ŭ�����忡 �����Ͽ����ϴ�.", 'E');

} else if (!strcmp("cut", $mode)) {
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0];
	$search = $lib_fix->search_index($design, "���̺�", $location);	// ���۰� �� ��ġ�� ��´�.
	for ($start = $search[0]; $start <= $search[1]; $start++) $cuted_table .= $design[$start];
	$fp = fopen("{$DIRS[design_root]}information/temp_table.php", "w");
	fwrite($fp, $cuted_table);
	fclose($fp);
	array_splice($design, $search[0], $search[1] - $search[0] +1);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");

} else if (!strcmp("paste", $mode)) {
	$full_file_name = "{$DIRS[design_root]}information/temp_table.php";
	$cuted_table_value = $lib_fix->paste_table($full_file_name, $design);
	if ($current_line == '') die("��������� ã�� �� �����ϴ�");
	array_splice($design, $current_line+1, 0, $cuted_table_value);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	if ($current_line == -1) $GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");	// ������ �����̳� ����̸� �θ�â ���� ��ħ.
	else $GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");	// ���̺� �����̳� ����̸� â�� �ݴ´�.
}
?>