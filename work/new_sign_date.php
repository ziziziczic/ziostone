<?
// 게시물 날짜 변경 프로그램

$root = "../";
require_once "{$root}include/db.php";
require_once "{$root}include/library.class.php";

$lib_handle = new library();

$start_date = mktime(0, 0, 0, 2, 1, 2003);
$end_date = time();
$table_name = "TCBOARD_492";


$query = "select serial_num, thread from $table_name ORDER BY is_notice desc, fid desc, thread ASC";
$result = mysql_query($query) or die("에러");
$total_article = mysql_num_rows($result);

$term = floor(($end_date - $start_date) / $total_article);

$i = 0;
while ($value = mysql_fetch_array($result)) {
	$new_sign_date = $end_date - ($i * $term);
	if ($value[thread] == "A") $query = "update $table_name set sign_date='$new_sign_date', count='100' where serial_num='$value[serial_num]'";
	else $query = "update $table_name set sign_date='$T_new_sign_date' where serial_num='$value[serial_num]'";
	$lib_handle->querying($query);
	$i++;
	$T_new_sign_date = $new_sign_date;
}

echo("완료되었습니다.");
?>