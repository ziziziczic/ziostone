<?
// ������ �������� �ش� �������� �Խ��� ������ �Ǿ� �־�� ��.
// �Խ��� ī�װ��� 1��, 2�� �ڵ���� ����ȭ �Ǿ� �־�� �� (1, 2���� �ش�)

$CSB_category_1 = $GLOBALS[lib_common]->parse_property($board_info[category_1], $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
$exp_category_2 = $GLOBALS[lib_common]->parse_property($board_info[category_2], $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
$CSB_category_2 = array();

while (list($key_1, $value_1) = each($CSB_category_1)) {
	$code_head_nums = strlen($key_1);
	$T_category_2 = array();
	while (list($key_2, $value_2) = each($exp_category_2)) {
		if ($key_1 == substr($key_2, 0, $code_head_nums)) {
			$real_key_2 = substr($key_2, $code_head_nums);
			$T_category_2[$key_2] = $value_2;
			unset($exp_category_2[$key_2]);
		}
	}
	$CSB_category_2[$key_1] = $T_category_2;
	reset($exp_category_2);
}

// ���� ���� ���û��� ����
$property = array(
	"name_1"=>"category_1",
	"property_1"=>"class=designer_select",
	"default_value_1"=>$article_value[category_1],
	"name_2"=>"category_2",
	"property_2"=>"class=designer_select",
	"default_value_2"=>$article_value[category_2],
	"default_title_1"=>":: 1���з� ::",
	"default_title_2"=>":: 2���з� ::"
);
$P_item_codes = $GLOBALS[lib_common]->get_item_select_box($CSB_category_1, $CSB_category_2, $property);
echo("{$P_item_codes[0]} {$P_item_codes[1]}{$P_item_codes[2]}");
?>