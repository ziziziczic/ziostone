<?
$today  = date("Y-m-d", time());
// $HTTP_REFERER 가 $HTTP_HOST 를 포함하지 않는다면 (같은 도메인에서 오지 않았다면)
if (eregi($_SERVER[HTTP_HOST], $_SERVER[HTTP_REFERER]) == false) { // 방문자 자료 생성
	$query = "insert into $DB_TABLES[visit] values ('', CURDATE(), CURTIME(), '$_SERVER[REMOTE_ADDR]', '$_SERVER[HTTP_REFERER]', '$_SERVER[HTTP_USER_AGENT]') ";
	$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	// 오늘 방문자수를 구함
	$query = " select vi_remote_addr from $DB_TABLES[visit] where vi_date = '$today' group by vi_remote_addr ";
	$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	$count_today = mysql_num_rows($result);
	mysql_free_result($result);

	// 오늘날짜의 자료가 합계 테이블에 있는지?
	$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$today' ";
	$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	$total_count_today = @mysql_result($result, 0);
	mysql_free_result($result);
	// 있다면
	if ( $total_count_today > 0 ) { // 오늘 방문자수가 합계에 있는 방문자수 보다 크다면
		if ( $count_today > $total_count_today ) { // 합계 오늘 방문자수 1 증가
			$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = '$today' ";
			$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러"); // 합계 전체 방문자수 1 증가
			$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = 'TOTAL' ";
			$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
		}
	} else { // 합계 오늘 일자로 자료 생성
		$query = " insert into $DB_TABLES[visit_total] values ('$today', '$count_today') ";
		$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");

		// 합계 전체 방문자수 1 증가
		$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = 'TOTAL' ";
		$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	}

	// 최대 방문자수가 오늘 방문자수 보다 작다면 최대 방문자수를 오늘 방문자수로 변경
	$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'MAX' ";
	$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	$max_count = @mysql_result($result, 0);
	mysql_free_result($result);
	if ( $max_count < $count_today ) {
		$query = " update $DB_TABLES[visit_total] set vt_count = '$count_today' where vt_date = 'MAX' ";
		$GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
	}
}

// 오늘 --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$today' ";
$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
$count_today = @mysql_result($result, 0);
mysql_free_result($result);
// 오늘 ==

// 어제 --
$yesterday  = date("Y-m-d", time()-86400);
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday' ";
$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
$count_yesterday = @mysql_result($result, 0);
mysql_free_result($result);
// 어제 ==

// 그제 --
$yesterday2  = date("Y-m-d", time()-86400*2);
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday2' ";
$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
$count_yesterday2 = @mysql_result($result, 0);
mysql_free_result($result);
// 그제 ==

// 최대 --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'MAX' ";
$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
$count_max = @mysql_result($result, 0);
mysql_free_result($result);
// 최대 ==

// 전체 --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'TOTAL' ";
$result = $GLOBALS[lib_common]->querying($query, "카운터쿼리중에러");
$count_total = @mysql_result($result, 0);
mysql_free_result($result);
// 전체 ==

if ($visible == "Y")
{
?>
<!-- 방문자 -->
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td height=20 width=80>&nbsp;<b>·</b>&nbsp; 오 늘 : </td><td align=right><? echo number_format($count_today) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>·</b>&nbsp; 어 제 : </td><td align=right><? echo number_format($count_yesterday) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>·</b>&nbsp; 그 제 : </td><td align=right><? echo number_format($count_yesterday2) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>·</b>&nbsp; 최 대 : </td><td align=right><? echo number_format($count_max) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>·</b>&nbsp; 전 체 : </td><td align=right><? echo number_format($count_total) ?>&nbsp;&nbsp;</td></tr>
</table>
<?
}
?>