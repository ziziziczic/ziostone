<?
include "{$DIRS[include_root]}verify_input.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";
$jumin_number = $jumin_number_1 . "-" . $jumin_number_2;

if ($_POST[find_item] == "id") {
	$query="select id from $DB_TABLES[member] where name='$name' and jumin_number='$jumin_number'";
	$result = $GLOBALS[lib_common]->querying($query, "����� ���� ���� ���� ������ �����߻�");
	$total = mysql_num_rows($result);
	if($total == 0) {
		$result_msg = "��ġ�ϴ� ȸ�������� �����ϴ�.<br>��˻� �Ŀ��� �Ȱ��� ��Ȳ�� �߻��� ���<br>�����ڿ��� ������ �ּ���";
	} else if ($total > 1) {
		$result_msg = "��ġ�ϴ� ȸ�������� �θ� �̻��Դϴ�.<br>�����ڿ��� ������ �ּ���";
	} else {																																									// ��ġ�ϴ� ������ �ִ� ���
		$member_id = mysql_result($result,0,0);
		$result_msg = "$name ���� ���̵��<br><font color='#4B9DC5'><b>$member_id</b></font><br>�Դϴ�.";
	}
} else if ($_POST[find_item] == "password") {
	
	$query="select id, passwd, email from $DB_TABLES[member] where id='$id' and name='$name' and jumin_number='$jumin_number'";
	$result = $GLOBALS[lib_common]->querying($query, "����� ���� ���� ���� ������ �����߻�");
	$total = mysql_num_rows($result);
	if($total == 0) {
		$result_msg = "��ġ�ϴ� ȸ�������� �����ϴ�.<br>��˻� �Ŀ��� �Ȱ��� ��Ȳ�� �߻��� ���<br>�����ڿ��� ������ �ּ���";
	} else if ($total > 1) {
		$result_msg = "��ġ�ϴ� ȸ�������� �θ� �̻��Դϴ�.<br>�����ڿ��� ������ �ּ���";
	} else {																																									// ��ġ�ϴ� ������ �ִ� ���
		$member_id = mysql_result($result,0,0);
		$member_password = mysql_result($result,0,1);
		$member_email = mysql_result($result,0,2);
		$domain_name = getenv("SERVER_NAME");
		$subject = "<b>��û�Ͻ� ȸ������ ��й�ȣ�Դϴ�.</b>";
		$mail_contents = "
						<table align=center width=500 cellpadding=3 cellspacing=0 border=2 bordercolor='#FF9900'>
							<tr> 
								<td> 
									<div align='center'><font color='#E39C62'><b>������ ����Ͻô� ��й�ȣ �����Դϴ�. </b></font></div>
								</td>
							</tr>
							<tr> 
								<td bgcolor='#E39C62' height=1></td>
							</tr>
							<tr> 
								<td height=4></td>
							</tr>
							<tr> 
								<td height='47'>
									<div align='center'><b><font color='#02A1C9'>$member_password</font></b></div>
								</td>
							</tr>
						</table>
						<p>&nbsp;</p>
		";
		$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $member_email, $subject, $mail_contents, 1, "", "EUC-KR", "", "", $GLOBALS[VI][mail_form]);

		$result_msg = "
			$id ������ ���� ��� �����ϼ̴� �̸����ּ�
			<font color='#4B9DC5'><b>$member_email</b></font>
			(��)�� ��й�ȣ�� �ȳ��� ��Ƚ��ϴ�.
			�̸��Ϸ� ��й�ȣ�� Ȯ���Ͽ� �ֽñ� �ٶ��ϴ�.
			�׻� ���� ���� ��Ź�帮�ڽ��ϴ�. 
		";
	}
}
?>

<table border=0 align=center>
	<tr>
		<td colspan=3>���̵� �� ��й�ȣ�� �ؾ������ ��, ���� �帳�ϴ�.</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td valign=top>
			<table border=0 cellpadding=20 cellspacing=1 bgcolor="#E6E6E6">
				<tr>
					<td bgcolor=white>
						<table width=400 border=0 cellpadding=0 cellspacing=0 align=center>
							<tr>
								<td align=center style="line-height:20px;">
									<?echo($result_msg)?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td align=center><a href="/"><img src="<?echo($DIRS[designer_root])?>images/btn_confirm.gif" border="0" alt=""></a></td>
	</tr>
</table>