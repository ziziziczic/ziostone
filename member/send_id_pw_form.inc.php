<?
echo("
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		check_field(form.mb_name, '성명을 입력하세요.', '', '#FFFFFF');
		objs = new Array();
		objs[0] = [form.email_1, form.email_2];
		check_field_array(objs, '이메일주소를 정확히 입력하세요', '#FFFFFF', '#FFFFFF');
		if (errmsg != '') {
			alert(errmsg);
			errmsg = '';
			return false;
		}
	}
//-->
</script>
<form name=frm method=post action='{$DIRS[member_root]}send_id_pw.php' onsubmit='return verify_submit(this)'>
<input type=hidden name='flag' value='$_SERVER[HTTP_HOST]'>
<table width='400'>
	<tr>
		<td  class='rBline02'></td>
	</tr>
	<tr>
		<td  class='rBc02'>
			<table  width='100%' >
				<tr>
					<td  width='90'><img src='images/01_member/i20.gif'></td>
					<td><input name='mb_name' type='text' class='bbox' style='width:100px;'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td  class='rBline02'></td>
	</tr>
	<tr>
		<td  class='rBc02'>
			<table  width='100%' >
				<tr>
					<td  width='90'><img src='images/01_member/i19.gif'></td>
					<td  width='103'><input name='email_1' type='text' class='bbox' style='width:100px;'></td>
					<td  width='15' align='center'><img src='images/01_member/img03.gif'></td>
					<td><input name='email_2' type='text' class='bbox' style='width:150px;'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td  class='rBline02'></td>
	</tr>
	<tr>
		<td  height='20' align='center' class='rBc02' style='padding-top:5px;'>
			<table  width='300' >
				<tr>
					<td  width='15'><input name='recv_method' type='radio' value='H'></td>
					<td  class='11px'>핸드폰으로 받기</td>
					<td  width='15'><input name='recv_method' type='radio' value='E' checked></td>
					<td  class='11px'>이메일로 받기</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td  class='rBline02'></td>
	</tr>
</table><br>
<table>
	<tr>
		<td><a href='javascript:history.back();'><img src='images/btn/btn_cancle.gif' border=0></a></td>
		<td  width='5'>
		</td>
		<td><input type='image' src='images/btn/btn_ok.gif'></td>
	</tr>
</table>
</form>
");
?>