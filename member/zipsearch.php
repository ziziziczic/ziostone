<?
/*----------------------------------------------------------------------------------
 * ���� : TCTools �����ȣ �˻�ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "./include/header_member.inc.php";
if (!$step) $step = 1;			// ù ������ ����
$next_step = $step + 1;
echo("
<html>
<head>
<title>�����ȣ �˻� Step $step</title>
$html_header
</head>
<script language='javascript1.2'>
<!--
	function selectAddress(post) {
		document.zipsearch.postNum.value = post;
		document.zipsearch.submit();
	}	
//-->
</script>
<body bgColor='#ffffff'>
<table align=center border=0 cellpadding=0 cellspacing=0 width=100%>	
	<tr> 
		<td align=left><img src=./images/title_sch_addr.gif></td>
	</tr>
	<tr>
		<td height=1 bgcolor=#c6bfb6></td>
	</tr>
	<tr>
		<td height=3 bgcolor=#e1dcd5></td>
	</tr>
</table>
<form name='zipsearch' method='get' action='{$PHP_SELF}?step=$next_step'> 
<input type=hidden name='step' value='$next_step'>
<input type=hidden name='nm_post_one' value='$_GET[nm_post_one]'>
<input type=hidden name='nm_post_two' value='$_GET[nm_post_two]'>
<input type=hidden name='nm_addr' value='$_GET[nm_addr]'>
<input type=hidden name='nm_sido' value='$_GET[nm_sido]'>
<input type=hidden name='nm_gugun' value='$_GET[nm_gugun]'>
");
if($step == 1) {
echo("
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
<tr>
   <td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
</tr>   
<tr>
   <td>
   <table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
   <tr bgcolor='#ECE9D8'>
      <td align='center'><input type='text' name='addr' size='15'></td>
      <td align='center'><font size=2><input type='submit' value='�ּ� �ڵ��˻�' class=designer_button></font></td>
   </tr>
   <tr bgcolor='#ffffff'>
      <td colspan='2' align='center'>�ڽ��� �ּ��߿��� [���鵿]�� �Է��Ͻʽÿ�!</td>
   </tr>
   </table>
   </td>
</tr>
</table>
");
} else if ($step == 2) {
   include "./step2.php";   
} else if ($step == 3) {
   include "./step3.php";
} else if ($step == 4) {   
   include "./step4.php";
}
echo("
</form>
</body>
</html>
");
?>