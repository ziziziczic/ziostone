<?
######### �ּ� �����ͺ��̽����� ����ڰ� ������ �ּ��� �� �ʵ尪�� �����´�. ##########
$query = "SELECT *  from $DB_TABLES[post] WHERE id='$postNum'";
$result = $GLOBALS[lib_common]->querying($query, "������ �ּ� ���� ���� ������ ���� �߻�");
$addr_value = mysql_fetch_array($result);
$address = "$addr_value[si_do] $addr_value[gu_gun] $addr_value[dong]";
echo("
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
	<tr>
		<td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
	</tr>   
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
				<tr bgcolor='#ECE9D8'>
					<td align='center'>�����ȣ</td>
					<td align='center'>�ּ�</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
					<td align='center'>$addr_value[post_no]</td>
					<td>$address</td>
				</tr>   
				<tr bgcolor='#FFFFFF'>
					<td align='center'><font color=red>�󼼹��� �Է�</font></td>
					<td><input type='text' name='bunji'  size='30' class='designer_text'></td>
				</tr>
				<tr>
					<td bgColor='#ffffff' colspan='2' align='center'>
						<input type='hidden' name='code' value='$addr_value[post_no]'>
						<input type='hidden' name='address' value='$address' size='45'>
						<input type='hidden' name='sido' value='$addr_value[si_do]'>
						<input type='hidden' name='gugun' value='$addr_value[gu_gun_1]' size='45'>
						<input type='submit' value='���� �ܰ�� �̵�'>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
");
?>