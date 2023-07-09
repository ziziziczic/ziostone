<?
/*----------------------------------------------------------------------------------
 * 제목 : TCTools 중복 아이디 검색 페이지
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "./include/header_member.inc.php";
echo("
<html>
<head>
<title> 아이디 중복 체크</title>
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
		alert('6~15자리의 영문 또는 숫자로 이루어진 아이디만 사용 가능합니다.');
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
$result = $GLOBALS[lib_common]->querying($query, "회원 아이디 검색 쿼리수행중 에러발생");
$rows = mysql_result($result,0,0);
if ($rows > 0) {
	echo("		
			<table width=100% border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td align=center><font color=#219AD6>
						<b>$_GET[id]</b> 는 <br>
						사용중이거나 가입할 수 없는 ID 입니다.</b></font>
					</td>
				</tr>
				<tr>
					<td style=padding:5 0 5 0>
						<table width=100% border=0 cellspacing=0 cellpadding=5 bgcolor=#e4dfd7>	
							<tr>
								<td width=42% align=right><font color=#666666><b>새로운 id 입력 : </b></font></td>
								<td><input type=text name=id size=13 maxlength=10 onblur='verify_id(this.form)'></td>
								<td width=30%><input type=submit value='검색' class=input_button> <input type=button value='닫기' onclick=\"replace_id('')\" class=input_button></td>
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
						<b>$_GET[id]</b> 는 <br>사용가능한 아이디입니다.</b></font>
					</td>
				</tr>
				<tr>
					<td style=padding:5 0 5 0>
						<table width=100% border=0 cellspacing=0 cellpadding=5 bgcolor=#e4dfd7>	
							<tr>
								<td align=center><input type='button' onclick=\"replace_id('$_GET[id]')\" value='신청합니다'></td>
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
						<li>ID(아이디)는 영문소문자과 숫자의 조합으로<br>4~10자 이내로 작성하셔야 합니다.
						<li>영문대문자나 특수기호(%, &, 등)는 사용할 수 없습니다.
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