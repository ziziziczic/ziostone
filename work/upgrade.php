<?
//////////////////////////////////////////////////
//
// �λ����� DB ���׷��̵� ��ũ��Ʈ
//
// ���������� : 2005-01-19
//
//////////////////////////////////////////////////
$root = "./";
include_once "{$root}include/db.php";

$query = "ALTER TABLE `TCSYSTEM_board_list` CHANGE `resize_rate` `file_name_method` CHAR( 1 );";
$result = $lib_handle->querying($query);

$query = "delete from `TCSYSTEM_design_files` where name='���ú���';";
$result = $lib_handle->querying($query);

$query = "ALTER TABLE `TCSYSTEM_board_list` DROP `read_page`;";
$result = $lib_handle->querying($query);

echo("������Ʈ �Ϸ�");
mysql_close();
?>