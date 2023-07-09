<?
/*
// 아래의 자바스크립트는 제품선택 화면(리스트)에 삽입함.
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
// 이 파일은 견적 세부 내용작성하는 페이지에 적당히 삽입(선택한 제품이 출력되도록 하는 부분임을 감안하여.)
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
	$select_products = "<br><b>☆ 선택한 제품 ☆</b><table width=100% border=0 cellpadding=5 cellspacing=1 bgcolor=cccccc><tr bgcolor=f3f3f3><td><b>제 품 명</b></td></tr>$select_products</table><br>";
	echo($select_products);
} else {
	//
}
echo("
 <input type=hidden name=comment_2 value=\"$select_products\">
 <input type='hidden' name='category_1' value='견적요청'>
 <input type='hidden' name='subject' value='견적 요청이 접수 되었습니다.'>
");
?>