<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$CN_gender = array('M'=>"남", 'F'=>"여");
$CN_birthday = array('S'=>"양", 'L'=>"음");

$query = "select * from Member_Info order by Num asc";
$result = $GLOBALS[lib_common]->querying($query);
while ($value = mysql_fetch_array($result)) {
	$member_info = array();
	$member_info[id] = $value[U_ID];
	$member_info[name] = $value[U_Name];
	$member_info[passwd] = $value[U_Pass];
	$member_info[email] = $value[Email];
	$member_info[gender] = $CN_gender[$value[Sex]];
	$member_info[birth_day] = $value[Birth];
	$member_info[birth_day_type] = $CN_birthday[$value[Birth_Ext]];; 
	$member_info[jumin_number] = $value[Reg_Num];
	$member_info[post] = $value[Zip];
	$member_info[address] = $value[Address] . ' ' . $value[Address_Ext];
	$member_info[phone] = $value[Phone];
	$member_info[mobile_phone] = $value[Mobile];
	$member_info[user_level] = '7';
	$pvf_exp = explode(" ", $value[Last_Login]);
	$pvf_ymd = explode("-", $pvf_exp[0]);
	$pvf_his = explode(":", $pvf_exp[1]);
	$date_1 = mktime($pvf_his[0], $pvf_his[1], $pvf_his[2], $pvf_ymd[1], $pvf_ymd[2], $pvf_ymd[0]);
	$member_info[rec_date] = $date_1;
	$pvf_exp = explode(" ", $value[Join_Date]);
	$pvf_ymd = explode("-", $pvf_exp[0]);
	$pvf_his = explode(":", $pvf_exp[1]);
	$date_1 = mktime($pvf_his[0], $pvf_his[1], $pvf_his[2], $pvf_ymd[1], $pvf_ymd[2], $pvf_ymd[0]);
	$member_info[reg_date] = $date_1;
	$member_info[mailing] = 'Y';
	$member_info[visit_num] = $value[Login_Num];
	$GLOBALS[lib_common]->input_record("TCMEMBER", $member_info);
}
?>