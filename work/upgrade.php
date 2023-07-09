<?
//////////////////////////////////////////////////
//
// 인사이터 DB 업그레이드 스크립트
//
// 최종수정일 : 2005-01-19
//
//////////////////////////////////////////////////
$root = "./";
include_once "{$root}include/db.php";

$query = "ALTER TABLE `TCSYSTEM_board_list` CHANGE `resize_rate` `file_name_method` CHAR( 1 );";
$result = $lib_handle->querying($query);

$query = "delete from `TCSYSTEM_design_files` where name='선택보기';";
$result = $lib_handle->querying($query);

$query = "ALTER TABLE `TCSYSTEM_board_list` DROP `read_page`;";
$result = $lib_handle->querying($query);

echo("업데이트 완료");
mysql_close();
?>