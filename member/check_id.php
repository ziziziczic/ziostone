<?
/*----------------------------------------------------------------------------------
 * ���� : TCTools �ߺ� ���̵� �˻� ������
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "./include/header_member.inc.php";
echo("
<html>
<head>
<title> ���̵� �ߺ� üũ</title>
$html_header
<script language='javascript'>
<!--
function replace_id(new_id) {
   opener.document.all.id.value = opener.document.all.id_hidden.value = new_id;
	//opener.document.all.id.focus();
   self.close();
}
function verify_id(form) {
	reg_express = new RegExp('^[a-z0-9]{6,15}$');
	if (!reg_express.test(form.id.value)) {
		alert('6~15�ڸ��� ���� �Ǵ� ���ڷ� �̷���� ���̵� ��� �����մϴ�.');
		form.id.value = '';
		return false;
	}
}
//-->
</script>
<body>
<table align=center border=0 cellpadding=0 cellspacing=0 width=95%>	
	<tr> 
		<td align=left><img src=./images/title_id_check.gif></td>
	</tr>
	<tr>
		<td height=1 bgcolor='#c6bfb6'></td>
	</tr>
	<tr>
		<td height=3 bgcolor='#e1dcd5'></td>
	</tr>
	<tr>
		<td height=15></td>
	</tr>
</table>
<table width=90% border=0 cellspacing=0 cellpadding=0 align=center>
	<tr> 
		<td align=center>
		<form name=form method=get action='$PHP_SELF'>
");
$query = "select count(id) from $DB_TABLES[member] where id ='$_GET[id]'";
$result = $GLOBALS[lib_common]->querying($query, "ȸ�� ���̵� �˻� ���������� �����߻�");
$rows = mysql_result($result,0,0);
if ($rows > 0) {
	echo("		
			<table width=100% border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td align=center><font color=#219AD6>
						<b>$_GET[id]</b> �� <br>
						������̰ų� ������ �� ���� ID �Դϴ�.</b></font>
					</td>
				</tr>
				<tr>
					<td style=padding:5 0 5 0>
						<table width=100% border=0 cellspacing=0 cellpadding=5 bgcolor=#e4dfd7>	
							<tr>
								<td width=42% align=right><font color=#666666><b>���ο� id �Է� : </b></font></td>
								<td><input type=text name=id size=13 maxlength=10 onblur='verify_id(this.form)'></td>
								<td width=30%><input type=submit value='�˻�' class=input_button> <input type=button value='�ݱ�' onclick=\"replace_id('')\" class=input_button></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	");
} else {
	echo("		
			<table width=320 border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td align=center><font color=#219AD6>
						<b>$_GET[id]</b> �� <br>��밡���� ���̵��Դϴ�.</b></font>
					</td>
				</tr>
				<tr>
					<td style=padding:5 0 5 0>
						<table width=100% border=0 cellspacing=0 cellpadding=5 bgcolor=#e4dfd7>	
							<tr>
								<td align=center><input type='button' onclick=\"replace_id('$_GET[id]')\" value='��û�մϴ�'></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	");
}
echo("
		</td>
	</tr>
	<tr>
		<td height=5></td>
	</tr>
	<tr>
	  <td>
			<table width=350 border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td>
						<font color=#666666>
						<ul>
						<li>ID(���̵�)�� �����ҹ��ڰ� ������ ��������<br>4~10�� �̳��� �ۼ��ϼž� �մϴ�.
						<li>�����빮�ڳ� Ư����ȣ(%, &, ��)�� ����� �� �����ϴ�.
						</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</FORM>
</table>
</body>
</html>
");
?>