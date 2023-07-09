<?
$P_button_tag_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='3'>
	<tr> 
		<td height='25' width='90'>버튼내용</td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($tag_value, "tag_value", "text", "size='15' maxlength='100' class='designer_text'", "") . "
		</td>
	</tr>
</table>
";
?>