<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	������ ������ �ҷ� ���پ� �迭�� �����Ѵ�.

$print_value = $GLOBALS[lib_common]->file_upload("userfile", $pp_flash_src, $GLOBALS[VI][flash_ext], 'T', $GLOBALS[VI][default_file_dir], '', 'Y');
if ($print_value == false) $GLOBALS[lib_common]->alert_url("������ ���õ��� �ʾҽ��ϴ�.");

$property = "{$pp_flash_width}{$GLOBALS[DV][ct4]}{$pp_flash_height}{$GLOBALS[DV][ct4]}{$pp_flash_align}{$GLOBALS[DV][ct4]}{$pp_flash_wmode}{$GLOBALS[DV][ct4]}{$pp_flash_etc}";
$value = "�÷���{$GLOBALS[DV][dv]}{$print_value}{$GLOBALS[DV][dv]}{$property}{$GLOBALS[DV][dv]}";
$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";
$blanks = "{$blank_up}{$GLOBALS[DV][ct4]}{$blank_down}{$GLOBALS[DV][ct4]}{$blank_left}{$GLOBALS[DV][ct4]}{$blank_right}";
$article_item_value = $lib_fix->make_design_line($value, '', $tag_both, $blanks);

$location = "index=" . $index;
$search = $lib_fix->search_index($design, "ĭ", $location);

if ($cpn == "0") array_splice($design, $search[1], 0, $article_item_value);		// �׸� �߰��ΰ��
else $design[$current_line] = $article_item_value;															// �׸� �����ΰ��

$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>