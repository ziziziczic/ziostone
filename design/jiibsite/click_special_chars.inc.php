<?
//$special_chars = "�� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� ";
$special_chars = "�� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� �� ";

$exp = explode(" ", $special_chars);
$td_tag = "";
for($i=1; $i<=sizeof($exp); $i++) {
	if (($i % 27) == 0) $is_br = "<br>";
	else $is_br = "";
	$click_tag .= "<a href=\"javascript:input_special_char('$exp[$i]', 'subject')\">$exp[$i]</a> {$is_br}";
}
$click_tag = trim($click_tag);
?>
<script language='javascript1.2'>
<!--
function input_special_char(special_char, form_item) {
	document.all.subject.value = document.all.subject.value + special_char;
}
//-->
</script>
<table border=0 cellspacing=0 cellpadding=3>
	<tr>
		<td><?echo($click_tag)?></td>
	</tr>
</table>
