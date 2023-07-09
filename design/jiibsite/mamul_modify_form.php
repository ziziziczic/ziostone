<script language=javascript1.2>
<!--
	function inverter(form) {
		if (form.input_method[0].checked == '1') {	// 개별입력일 경우
			detail_input.style.display='block';
			paste_input.style.display='none';
		} else {															// 붙여넣기일 경우
			detail_input.style.display='none';
			paste_input.style.display='block';
		}
	}
//-->
</script>
<table cellSpacing=1 cellPadding=3 border=0 width=100%>
	<tr>
		<td bgcolor=ffffff height=20>* 정보 수정</td>
	</tr>
</table>
<table cellSpacing=1 cellPadding=3 border=0 style="display:visible" id="paste_input" width=100% height=95%>
	<tr>
		<td bgColor=#ffffff>
<?
$default_text_value = htmlspecialchars(stripslashes($article_value[comment_1]));
include "{$DIRS[designer_root]}include/paste_input_box.inc.php";
?>			
		</td>
	</tr>
</table>
