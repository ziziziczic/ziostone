<?
include "lock_direct_conn.inc.php";
/*
$W_DB_HOST = "localhost";
$W_DB_NAME = "allerxmall";
$W_DB_USER = "allerxmall";
$W_DB_PASSWD = "dkffprtmmall";

if (!$W_DB_CONN = mysql_connect($W_DB_HOST, $W_DB_USER, $W_DB_PASSWD)) {
	echo "<li>Can't connect to $W_DB_HOST as $W_DB_USER";
	echo "<li>MySQL Error: ", mysql_error();
	die;
}
if (!mysql_select_db($W_DB_NAME, $W_DB_CONN)) {
	echo "<li>Unable to select database $W_DB_NAME";
	die;
}
*/
include "{$root}/db.inc.php";

// 각종 DB 테이블명 정의
$VG_OP_db_table = array();
$VG_OP_db_table[title_list] = "VG_OP_title_list";
$VG_OP_db_table[que_list] = "VG_OP_que_list";
?>