<?
########## �ּ� �����ͺ��̽����� ����ڰ� �Է��� �ּҿ� ��ġ�ϴ� ���ڵ带 �˻��Ѵ�. ##########
$query = "select *  from TCSYSTEM_post_table where dong LIKE '%{$_GET[addr]}%' ORDER BY post_no";
$result = @mysql_query($query) or $libHandle->write_error($SESS_DBH, "�����ȣ �˻� ���������� �����߻�");

$rows = mysql_num_rows($result);

########## �˻������ �����ϸ� ����Ʈ�ڽ� ���·� ����Ѵ�. ########## 
if ($rows) {
echo("
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
	<tr>
		<td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
	</tr>   
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
				<tr bgcolor='#ECE9D8'>
					<td colspan='2'>�� <b>$rows</b>���� �ּҰ� �˻��Ǿ����ϴ�.</td>
				</tr>
");
while($addrValue = mysql_fetch_array($result)) {
	echo("<tr><td bgcolor='#ffffff' colspan='2'>\n");
	$address = "$addrValue[post_no] $addrValue[si_do] $addrValue[gu_gun] $addrValue[dong] $addrValue[bunji]";
	echo("<a href=\"javascript:selectAddress('$addrValue[id]')\">$address</a>");
	echo("</td></tr>\n");
}
echo("
						<input type='hidden' name='postNum' value=''>
					</td>      
				</tr>
			</table>
		</td>
	</tr>
</table>
");
########## �˻������ �ϳ��� �������� ������ ���Է��� �޴´�. ##########
} else {
	$GLOBALS[lib_common]->alert_url("�˻��� �ּҰ� �����ϴ�. �ٽ� �ѹ� Ȯ���� �ֽñ� �ٶ��ϴ�.");
	exit;
}
?>