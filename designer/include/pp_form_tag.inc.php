<?
$P_pp_form_tag = "
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
	<tr> 
		<td height='25' width='80'>버튼내용</td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($tag_value, "tag_value", "text", "size='30' maxlength='100' class='designer_text'", "") . "
		</td>
	</tr>
	<tr> 
		<td height='25' width='80'>태그속성</td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($pp_tag_etc, "pp_tag_etc", "text", "size='60' maxlength='100' class='designer_text'", "") . "
		</td>
	</tr>
</table>
";
?>