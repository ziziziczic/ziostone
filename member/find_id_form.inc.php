<script language='javascript1.2'>
<!--
function verify_submit_find_id(form) {
	
	if ((form.jumin_number_1.value == '') || (form.jumin_number_1.value == '')) {
		alert('주민번호를 정확히 입력해 주세요');
		form.jumin_number_1.focus();
		return false;
	}
	if (form.name.value == '') {
		alert('성명을 입력해 주세요');
		form.name.focus();
		return false;
	}
	form.submit();
}
//-->
</script>

<link rel='stylesheet' href='<?echo($DIRS[designer_root])?>include/designer_style.css' type='text/css'>	
<table border=0 cellpadding=0 cellspacing=0 align=center width=100%>
	<form name='insiter' method=post action='<?echo($site_info[index_file])?>?design_file=find_manager.php' onsubmit='return verify_submit_find_id(this)'>
	<input type='hidden' name='find_item' value='id'>
	<input type='hidden' name='flag' value='<?echo($_SERVER[HTTP_HOST])?>'>
	<tr>
		<td width=80>주민등록번호</td>
		<td><input type="text" size=8 class="designer_text" name="jumin_number_1"> - <input type="text" size=8 class="designer_text" name="jumin_number_2"></td>
	</tr>
	<tr>
		<td width=80>성 명</td>
		<td><input type="text" size=23 class="designer_text" name="name"></td>
	</tr>
	<tr><td colspan=2 height=5></td></tr>
	<tr>
		<td></td>
		<td><input type='image' src="<?echo($DIRS[designer_root])?>images/btn_confirm.gif" border="0"></td>
	</tr>
	</form>
</table>