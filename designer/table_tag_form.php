<?
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "문자열") $text = $exp[1];
	$text = str_replace(chr(92).r.chr(92).n, "", $text);
}


$help_msg = "
	텍스트 삽입화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
function submit_input_tag() {
	if (submit_editor('frm') != true) return false;
}
//-->
</script>
<table width=100%>
	<form name='frm' method='post' action='{$DIRS[designer_root]}table_designer_manager.php?design_file={$design_file}&index={$index}&cpn={$cpn}&current_line={$current_line}&mode=input_tag' onsubmit='return submit_input_tag()'>
	<tr>
		<td height=450>
");
$default_text_value = htmlspecialchars($text);
include "{$DIRS[designer_root]}include/paste_input_box.inc.php"; 
echo("
		</td>
	</tr>
	<tr>
		<td height=30><input type=image src='{$DIRS[designer_root]}images/bt_appli.gif'></td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "{$DIRS[designer_root]}footer_sub.inc.php";
?>