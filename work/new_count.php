<?
// �Խù� ��¥ ���� ���α׷�

$root = "../";
require_once "{$root}include/db.php";
require_once "{$root}include/library.class.php";

$lib_handle = new library();


$table_name = "TCBOARD_513";


$query = "select serial_num from $table_name where count>100 ORDER BY serial_num desc";
$result = mysql_query($query) or die("����");

$i = 0;
while ($value = mysql_fetch_array($result)) {
	if ($i < 200) $new_count = mt_rand(30, 60);
	else $new_count = mt_rand(60, 90);
	$query = "update $table_name set count=$new_count where serial_num=$value[serial_num]";
	$lib_handle->querying($query);
	$i++;
}
echo("�Ϸ�Ǿ����ϴ�.");
?>