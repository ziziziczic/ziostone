<?
if ($root == '') $root = "./";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$query = "SELECT * FROM tb_member order by mb_idx";
$result = $GLOBALS[lib_common]->querying($query);

$divider = array("date_time"=>' ');
while ($value = mysql_fetch_array($result)) {
	$ca_id = $category_map[$value[ca_order]];
	$img_file_name = $GLOBALS[lib_common]->get_file_name($value[it_image]);
	$record_info = array();
	$record_info[id] = $value[mb_id];
	$record_info[name] = $value[mb_name];
	$record_info[passwd] = $value[mb_pw];
	$record_info[email] = $value[mb_email];
	$record_info[homepage] = $value[mb_homepage];
	$record_info[post] = $value[mb_zipcode];
	$record_info[address] = $value[mb_address1] . ' ' . $value[mb_address2];
	$record_info[phone] = $value[mb_phone];
	$record_info[phone_mobile] = $value[mb_mobile];
	$record_info[rec_date] = $GLOBALS[lib_common]->str_date_to_time_stamp($value[mb_last_login], $divider);
	$record_info[reg_date] = $GLOBALS[lib_common]->str_date_to_time_stamp($value[mb_regist_date], $divider);
	$record_info[last_ip] = $value[mb_last_ip];
	$record_info[mailing] = $img_file_name;
	$record_info[visit_num] = $value[];
	$record_info[recommender] = $value[mb_recommender];
	$record_info[biz_company] = $value[mb_company];
	$record_info[biz_number] = $value[mb_c_number];
	$record_info[biz_ceo] = $value[mb_c_chief];
	$record_info[biz_cond] = $value[mb_c_conditions];
	$record_info[biz_item] = $value[mb_c_category];
	$record_info[biz_address] = $value[mb_c_address];
	$GLOBALS[lib_common]->input_record($DB_TABLES[member], $record_info);
}
echo("등록 완료 하였습니다.");
?>

