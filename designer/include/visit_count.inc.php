<?
$today  = date("Y-m-d", time());
// $HTTP_REFERER �� $HTTP_HOST �� �������� �ʴ´ٸ� (���� �����ο��� ���� �ʾҴٸ�)
if (eregi($_SERVER[HTTP_HOST], $_SERVER[HTTP_REFERER]) == false) { // �湮�� �ڷ� ����
	$query = "insert into $DB_TABLES[visit] values ('', CURDATE(), CURTIME(), '$_SERVER[REMOTE_ADDR]', '$_SERVER[HTTP_REFERER]', '$_SERVER[HTTP_USER_AGENT]') ";
	$GLOBALS[lib_common]->querying($query, "ī���������߿���");
	// ���� �湮�ڼ��� ����
	$query = " select vi_remote_addr from $DB_TABLES[visit] where vi_date = '$today' group by vi_remote_addr ";
	$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
	$count_today = mysql_num_rows($result);
	mysql_free_result($result);

	// ���ó�¥�� �ڷᰡ �հ� ���̺� �ִ���?
	$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$today' ";
	$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
	$total_count_today = @mysql_result($result, 0);
	mysql_free_result($result);
	// �ִٸ�
	if ( $total_count_today > 0 ) { // ���� �湮�ڼ��� �հ迡 �ִ� �湮�ڼ� ���� ũ�ٸ�
		if ( $count_today > $total_count_today ) { // �հ� ���� �湮�ڼ� 1 ����
			$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = '$today' ";
			$GLOBALS[lib_common]->querying($query, "ī���������߿���"); // �հ� ��ü �湮�ڼ� 1 ����
			$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = 'TOTAL' ";
			$GLOBALS[lib_common]->querying($query, "ī���������߿���");
		}
	} else { // �հ� ���� ���ڷ� �ڷ� ����
		$query = " insert into $DB_TABLES[visit_total] values ('$today', '$count_today') ";
		$GLOBALS[lib_common]->querying($query, "ī���������߿���");

		// �հ� ��ü �湮�ڼ� 1 ����
		$query = " update $DB_TABLES[visit_total] set vt_count = vt_count + 1 where vt_date = 'TOTAL' ";
		$GLOBALS[lib_common]->querying($query, "ī���������߿���");
	}

	// �ִ� �湮�ڼ��� ���� �湮�ڼ� ���� �۴ٸ� �ִ� �湮�ڼ��� ���� �湮�ڼ��� ����
	$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'MAX' ";
	$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
	$max_count = @mysql_result($result, 0);
	mysql_free_result($result);
	if ( $max_count < $count_today ) {
		$query = " update $DB_TABLES[visit_total] set vt_count = '$count_today' where vt_date = 'MAX' ";
		$GLOBALS[lib_common]->querying($query, "ī���������߿���");
	}
}

// ���� --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$today' ";
$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
$count_today = @mysql_result($result, 0);
mysql_free_result($result);
// ���� ==

// ���� --
$yesterday  = date("Y-m-d", time()-86400);
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday' ";
$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
$count_yesterday = @mysql_result($result, 0);
mysql_free_result($result);
// ���� ==

// ���� --
$yesterday2  = date("Y-m-d", time()-86400*2);
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday2' ";
$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
$count_yesterday2 = @mysql_result($result, 0);
mysql_free_result($result);
// ���� ==

// �ִ� --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'MAX' ";
$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
$count_max = @mysql_result($result, 0);
mysql_free_result($result);
// �ִ� ==

// ��ü --
$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'TOTAL' ";
$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
$count_total = @mysql_result($result, 0);
mysql_free_result($result);
// ��ü ==

if ($visible == "Y")
{
?>
<!-- �湮�� -->
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td height=20 width=80>&nbsp;<b>��</b>&nbsp; �� �� : </td><td align=right><? echo number_format($count_today) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>��</b>&nbsp; �� �� : </td><td align=right><? echo number_format($count_yesterday) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>��</b>&nbsp; �� �� : </td><td align=right><? echo number_format($count_yesterday2) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>��</b>&nbsp; �� �� : </td><td align=right><? echo number_format($count_max) ?>&nbsp;&nbsp;</td></tr>
<tr><td height=20 width=80>&nbsp;<b>��</b>&nbsp; �� ü : </td><td align=right><? echo number_format($count_total) ?>&nbsp;&nbsp;</td></tr>
</table>
<?
}
?>