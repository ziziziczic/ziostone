<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	������ ������ �ҷ� ���پ� �迭�� �����Ѵ�.

$blank_check = trim($item_define);
$blank_check = str_replace(" ", '', $blank_check);
$blank_check = str_replace("\n", '', $blank_check);
$blank_check = str_replace("\r", '', $blank_check);
if (strlen($blank_check) == 0) {															// ����� �Է��� �����̸�
	$input_items = '';
} else {																											// �Է� ������ ������ �Ʒ��� ��ƾ�� �����Ѵ�.
	$input_items = stripslashes($item_define);
	$input_items = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv] ,$input_items);
	$input_items = str_replace("\r\n", chr(92).n, $input_items);
}

// �⺻�������κ�
$default_value_info = "{$input_box_default_value_mode}{$GLOBALS[DV][ct4]}{$input_box_default_value}{$GLOBALS[DV][ct4]}{$input_box_use_mode}";

// �¿��±�
$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";

// ���鼳��
$blanks = "{$blank_up}{$GLOBALS[DV][ct4]}{$blank_down}{$GLOBALS[DV][ct4]}{$blank_left}{$GLOBALS[DV][ct4]}{$blank_right}";

$value = "�Խ����Է»���{$GLOBALS[DV][dv]}{$article_item_user}{$GLOBALS[DV][dv]}{$input_box_type}{$GLOBALS[DV][dv]}{$default_pp}{$GLOBALS[DV][dv]}{$input_items}{$GLOBALS[DV][dv]}{$divider}{$GLOBALS[DV][dv]}{$item_index}{$GLOBALS[DV][dv]}{$default_value_info}";
$article_item_value = $lib_fix->make_design_line($value, '', $tag_both, $blanks);

$location = "index=" . $index;
$search = $lib_fix->search_index($design, "ĭ", $location);

if ($cpn == "0") array_splice($design, $search[1], 0, $article_item_value);		// �׸� �߰��ΰ��
else $design[$current_line] = $article_item_value;														// �׸� �����ΰ��

$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
?>