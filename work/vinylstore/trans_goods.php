<?
if ($root == '') $root = "./";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$query = "SELECT * FROM tb_item, tb_item_sale, tb_category WHERE ca_idx=is_ca_idx AND it_idx=is_it_idx";
$result = $GLOBALS[lib_common]->querying($query);

$category_map = array(
	"01"=>"1001000000000000000",
	"0101"=>"1001001000000000000",
	"0102"=>"1001002000000000000",
	"0103"=>"1001003000000000000",
	"0104"=>"1001004000000000000",
	"0105"=>"1001005000000000000",
	"02"=>"1002000000000000000",
	"0201"=>"1002001000000000000",
	"0202"=>"1002002000000000000",
	"03"=>"1003000000000000000",
	"04"=>"1004000000000000000",
	"06"=>"1005000000000000000",
	"0601"=>"1005001000000000000",
	"0603"=>"1005002000000000000",
	"0605"=>"1005003000000000000",
	"08"=>"1006000000000000000",
	"0801"=>"1006001000000000000",
	"0807"=>"1006002000000000000",
	"0811"=>"1006003000000000000",
	"0813"=>"1006004000000000000",
	"10"=>"1007000000000000000",
	"1001"=>"1007001000000000000",
	"1003"=>"1007002000000000000",
	"1005"=>"1007003000000000000",
	"1007"=>"1007004000000000000",
	"12"=>"1008000000000000000",
	"1201"=>"1008001000000000000",
	"1203"=>"1008002000000000000"
);

while ($value = mysql_fetch_array($result)) {
	$ca_id = $category_map[$value[ca_order]];
	$img_file_name = $GLOBALS[lib_common]->get_file_name($value[it_image]);
	$record_info = array();
	$record_info[ca_id] = $ca_id;
	$record_info[it_name] = $value[it_name];
	$record_info[it_code] = $value[it_code];
	$record_info[it_wonga] = $value[it_price_buy];
	$record_info[it_cust_amount] = $record_info[it_sell_amount_1] = $record_info[it_sell_amount_2] = $record_info[it_sell_amount_3] = $value[it_price_sell];
	$record_info[it_sell_unit] = $value[it_unit_saling];
	$record_info[it_send_cost] = $value[it_shipping_cost];
	$record_info[it_width] = $value[it_width];
	$record_info[it_length] = $value[it_length];
	$record_info[it_height] = $value[it_height];
	$record_info[it_color] = $value[it_color];
	$record_info[it_color_rgb] = $value[it_color_rgb];
	$record_info[it_meterial] = $value[it_meterial];
	$record_info[it_images] = $img_file_name;
	$record_info[it_basic] = '';
	$record_info[it_basic_html] = 'N';
	$record_info[it_basic_use] = 'N';
	$record_info[it_explan] = addslashes($value[it_info]);
	$record_info[it_explan_html] = 'Y';
	$record_info[it_explan_use] = 'Y';
	$record_info[it_sell_enabled] = 'Y';
	$record_info[it_stock_qty] = 9999999;
	$record_info[it_ea_subject] = "장";
	$record_info[it_pack_subject] = "묶음";
	$GLOBALS[lib_common]->input_record($DB_TABLES[s_goods], $record_info, $get_serial='N');
}

echo("등록 완료 하였습니다.");
?>