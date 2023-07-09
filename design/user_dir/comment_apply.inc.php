<?
$_POST[subject] = "빠른 주문서 접수";
$_POST[comment_1] = "
<table  width='737' border='0' cellpadding='4' cellspacing='1' bgcolor='D5D9E8'>
	<tr  bgcolor='#FFFFFF'>
		<td  width='110' bgcolor='#F4F5FB' class='small' align='center'><font color='47557C'>* 성명</font></td>
		<td  width='608'>$_POST[name]</td>
	</tr>
	<tr  bgcolor='#FFFFFF'>
		<td  bgcolor='#F4F5FB' class='small' align='center'><font color='47557C'>E-mail</font></td>
		<td>$_POST[email]</td>
	</tr>
	<tr  bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' class='small' align='center'><font color='47557C'>* 연락처(핸드폰)</font></td>
		<td>$_POST[phone_mobile]</td>
	</tr>
	<tr  bgcolor='#FFFFFF'>
		<td  bgcolor='#F4F5FB' class='small' align='center'><font color='47557C'>주소</font></td>
		<td>$_POST[address]</td>
	</tr>
	<tr  bgcolor='#FFFFFF'>
		<td  bgcolor='#F4F5FB' class='small' align='center'><font color='47557C'>* 주문내용</font></td>
		<td>" . nl2br($_POST[memo]) . "</td>
	</tr>
</table>
";
?>