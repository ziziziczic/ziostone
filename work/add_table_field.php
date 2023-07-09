<?

/* 기존 생성된 테이블에 컬럼을 추가하는 프로그램 */


$Root = "./";
$Design_Root = "./design/";
$Designer_Root = "./Designer/";

require_once "{$Root}Common/db.php";
require_once "{$Root}Common/class_library.php";

$libHandle = new library();

$source_table_name = array("TCBOARD_MAIN_2N", "TCBOARD_MAIN_N");

for ($i=0; $i < sizeof($source_table_name); $i++) {
	$query = "ALTER TABLE $source_table_name[$i] ADD comment2 CHAR(1);";
	$result = @mysql_query($query) or die("필드 추가 쿼리중 에러 comment2 <br>" . mysql_error());
	$query = "ALTER TABLE $source_table_name[$i] ADD etc1 CHAR(1);";
	$result = @mysql_query($query) or die("필드 추가 쿼리중 에러 etc1 <br>" . mysql_error());
	$query = "ALTER TABLE $source_table_name[$i] ADD relation_serial CHAR(1);";
	$result = @mysql_query($query) or die("필드 추가 쿼리중 에러 relation_serial <br>" . mysql_error());
	$query = "ALTER TABLE $source_table_name[$i] ADD etc2 CHAR(1);";
	$result = @mysql_query($query) or die("필드 추가 쿼리중 에러 etc2 <br>" . mysql_error());
	$query = "ALTER TABLE $source_table_name[$i] ADD etc3 CHAR(1);";
	$result = @mysql_query($query) or die("필드 추가 쿼리중 에러 etc3 <br>" . mysql_error());
}
echo("완료 되었습니다.");
?>