<?
$root = "./";
include_once "{$root}include/db.php";

$query = "select * from TEMP_member order by join_date asc";
$result = mysql_query($query);
while ($value = mysql_fetch_array($result)) {
	if ($value[mail_flag] == 1) $mailing = 'Y';
	else $mailing = 'N';
	if ($value[gender] == 1) $gender = "남";
	else $gender = "여";

	$exp = explode(" ", $value[join_date]);
	$exp_date = explode("-", $exp[0]);
	$exp_time = explode(":", $exp[1]);
	$reg_date = mktime($exp_time[0], $exp_time[1], $exp_time[2], $exp_date[1], $exp_date[2], $exp_date[0]);

	$exp = explode(" ", $value[last_login]);
	$exp_date = explode("-", $exp[0]);
	$exp_time = explode(":", $exp[1]);
	$rec_date = mktime($exp_time[0], $exp_time[1], $exp_time[2], $exp_date[1], $exp_date[2], $exp_date[0]);

	$query = "insert TCMEMBER set id='$value[user_id]', name='$value[name]', passwd='$value[user_pass]', email='$value[email]', gender='$gender', jumin_number='$value[recode]', post='$value[zipcode]', address='$value[addr1] $value[addr2]', phone='$value[tel]', mobile_phone='$value[mobile]', user_level='7', reg_date='$reg_date', mailing='$mailing', visit_num='$value[l_cnt]', rec_date=$rec_date";
	mysql_query($query);
}
echo("완료되었습니다");
mysql_close();
?>