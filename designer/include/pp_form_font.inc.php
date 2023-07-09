<?
if ($FL_text_value == 'Y') {
	$form_text_value = "
	<tr>
		<td width=70>글자내용</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($text_value, "text_value", "text", "size='15' maxlength='100' class='designer_text'", "") . "</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	<tr>	
	<tr><td colspan=4><hr size=1></td></tr>
	";
}
$option_name = array("::: 선택 :::");
$option_value[] = '';
for ($i=1; $i<=7; $i++) $option_name[] = $option_value[] = $i;
$P_pp_form_font = "
<script language='javascript'>
	<!--
		c1 = '$pp_font_color';
	//-->
</script>
<table width=100% cellpadding=2 cellspacing=0 border=0>
	$form_text_value
	<tr>
		<td width=70>글자크기</td>
		<td>" . $GLOBALS[lib_common]->make_list_box("pp_font_size", $option_name, $option_value, '', $pp_font_size, "class=designer_select", "width=110") . "</td>
		<td width=70>글씨체</td>
		<td>" . $lib_fix->make_font_list("pp_font_face", $pp_font_face, "class='designer_select'", '') . "</td>
	<tr>
	<tr>
		<td>글자색</td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($pp_font_color, "pp_font_color", "text", "size='7' maxlength='7' class='designer_text'", '') . "
			<script language='javascript'>
				document.write('<input type=button name=b1_color value=click class=designer_button style=background-color:'+c1+'; border-color:white; height=18px onclick=\"callColorPicker(-50, -50, 1, event, \'frm.b1_color\', \'frm.pp_font_color\')\">');
			</script>
		</td>
		<td>기타속성</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($pp_font_etc, "pp_font_etc", "text", "size='48' maxlength='100' class='designer_text'", "") . "</td>
	<tr>
</table>
";
?>