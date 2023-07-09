<?
$addr_code = explode("-", $_GET[code]);
$select_it = '';
if ($_GET[nm_post_two] != '') {
	$select_it .= "
		var post_one = eval('opener.document.all.' + nm_post_one);
		post_one.value = '$addr_code[0]';
		var post_two = eval('opener.document.all.' + nm_post_two);
		post_two.value = '$addr_code[1]';
	";
} else {
	$select_it .= "
		var post_one = eval('opener.document.all.' + nm_post_one);
		post_one.value = '$_GET[code]';
	";
}
if ($_GET[nm_sido] != '') {
	$select_it .= "
		var sido = eval('opener.document.all.' + nm_sido);
		sido.value = '$_GET[sido]';
	";
}
if ($_GET[nm_gugun] != '') {
	$select_it .= "
		var gugun = eval('opener.document.all.' + nm_gugun);
		gugun.value = '$_GET[gugun]';
	";
}
echo("
<script language='javascript'>
function select_it(nm_post_one, nm_post_two, nm_addr, nm_sido, nm_gugun) {
	$select_it	
	var addr = eval('opener.document.all.' + nm_addr);
	addr.value = '$_GET[address] $_GET[bunji]';
	self.close();
}
</script>
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
<tr>
   <td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
</tr>   
<tr>
   <td>
   <table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
   <tr bgcolor='#ECE9D8'>
      <td align='center'>우편번호</td>
      <td align='center'>주소</td>
   </tr>
   <tr bgcolor='#ffffff'>
      <td align='center'>$_GET[code]</td>
      <td>$_GET[address] $_GET[bunji]</td>
   </tr>
   <tr>
      <td bgColor='#ffffff' colspan='2' align='center'>
			<input type='button' value='위와같이 입력합니다.' onclick=\"select_it('$_GET[nm_post_one]', '$_GET[nm_post_two]', '$_GET[nm_addr]', '$_GET[nm_sido]', '$_GET[nm_gugun]')\">
      </td>
   </tr>
   </table>
   </td>
</tr>
</table>
");
?>