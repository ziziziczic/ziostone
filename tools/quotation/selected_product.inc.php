<?
/*
// �Ʒ��� �ڹٽ�ũ��Ʈ�� ��ǰ���� ȭ��(����Ʈ)�� ������.
<script>
<!--
function quotation_submit() {
 var form = document.TCBOARD_1042_LIST;
 form.action = 'insiter.php?design_file=737.php&where=quotation';
 form.submit();
}
//-->
</script>
*/
?>

<?
// �� ������ ���� ���� �����ۼ��ϴ� �������� ������ ����(������ ��ǰ�� ��µǵ��� �ϴ� �κ����� �����Ͽ�.)
$sub_query = "where ";
for ($i=0; $i<sizeof($is_selected); $i++) {
	$sub_query .= "serial_num=$is_selected[$i] or ";
}
if ($sub_query != "where ") {
	$sub_query = substr($sub_query, 0, -4);
	$quotation_query = "select * from TCBOARD_1087 $sub_query";
	$quotation_result = $lib_handle->querying($quotation_query);

	while ($quotation_value = mysql_fetch_array($quotation_result)) {
		$select_products .= "<tr><td bgcolor=ffffff>$quotation_value[subject]</td></tr>";
	}
	$select_products = "<br><b>�� ������ ��ǰ ��</b><table width=100% border=0 cellpadding=5 cellspacing=1 bgcolor=cccccc><tr bgcolor=f3f3f3><td><b>�� ǰ ��</b></td></tr>$select_products</table><br>";
	echo($select_products);
} else {
	//
}
echo("
 <input type=hidden name=comment_2 value=\"$select_products\">
 <input type='hidden' name='category_1' value='������û'>
 <input type='hidden' name='subject' value='���� ��û�� ���� �Ǿ����ϴ�.'>
");
?>