<?
include "header_proc.inc.php";

function table_insert($date, $count) {
    global $DB_TABLES;
    $query = " insert into $DB_TABLES[visit_total] values ('$date', '$count') ";
    $result = mysql_query($query);
    if ($result) return "INSERT";
    $query = " update $DB_TABLES[visit_total] set vt_count = '$count' where vt_date = '$date' ";
    $result = mysql_query($query);
    if ($result) return "UPDATE";
    return "*ERROR";
}
echo "<p align=left>";

// �Ϻ� �湮�� ī��Ʈ --
$query = " select vi_date, vi_remote_addr from $DB_TABLES[visit] group by vi_date, vi_remote_addr order by vi_date ";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
$temp_vi_date = $row[vi_date];
$count = 0;

do {
    if ( $temp_vi_date != $row[vi_date] ) {
        if ( $temp_vi_date ) {
            $msg = table_insert($temp_vi_date, $count);
            echo "&nbsp; > $temp_vi_date ($msg) -> " . number_format($count) . " �� �湮<br> ";
            flush();
        }
        $temp_vi_date = $row[vi_date];
        $count = 0;
    }
    $count++;
} while ( $row = mysql_fetch_array($result) );

$msg = table_insert($temp_vi_date, $count);
echo "&nbsp; > $temp_vi_date ($msg) -> " . number_format($count) . " �� �湮<br> ";
flush();
// �Ϻ� �湮�� ī��Ʈ ==


// ��ü --
$query = " select sum(vt_count) from $DB_TABLES[visit_total] where vt_date not in ('TOTAL', 'MAX', '') ";
$result = mysql_query($query) or die(mysql_error());
$row   = mysql_fetch_array($result);
$msg = table_insert("TOTAL", $row[0]);
echo "&nbsp; > ��ü ($msg) -> " . number_format($row[0]) . " �� �湮<br> ";
// ��ü ==

// �ִ� --
$query = " select max(vt_count) from $DB_TABLES[visit_total] where vt_date not in ('TOTAL', 'MAX') ";
$result = mysql_query($query) or die(mysql_error());
$row   = mysql_fetch_array($result);
$msg = table_insert("MAX", $row[0]);
echo "&nbsp; > �ִ� ($msg) -> " . number_format($row[0]) . " �� �湮<br> ";
// �ִ� ==

// ����� --
$query = " select avg(vt_count) from $DB_TABLES[visit_total] where vt_date not in ('TOTAL', 'MAX') ";
$result = mysql_query($query) or die(mysql_error());
$row   = mysql_fetch_array($result);
echo "&nbsp; > ����� -> " . number_format($row[0]) . " �� �湮<br> ";
// ����� ==

echo "<p>";
echo "&nbsp; �۾��� �Ϸ� �Ͽ����ϴ�. &nbsp;&nbsp;&nbsp;<a href='visit_search_form.php'><<< �ڷ�</a>";

?>
