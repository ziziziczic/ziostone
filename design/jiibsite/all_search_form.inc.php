<script language="javascript1.2">
<!--
function user_verify_submit(form) {
	if (form.search_value2.value == '') {
		alert('검색어를 입력하세요.\n\n예 : 대전, 300, 택배, 냉동, 대기업...');
		form.search_value2.focus();
		return false;
	}
	form.submit();
}
//-->
</script>
<table border=0 cellpadding=2 cellspacing=0>
<form name='user_all_search' method=post action='insiter.php?design_file=513.php' onsubmit='user_verify_submit(this); return false;'>
	<tr>
		<td>
			<input type=text name=search_value2 size=20 class=inputbox value=<?echo($this->search_value)?>>
		</td>
		<td>
			<input type=image src='/design/images/bt_search.gif' align=absmiddle>
		</td>
	</tr>
</form>
</table>
