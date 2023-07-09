<?
include "header_sub.inc.php";

$design = $lib_fix->design_load($DIRS, $_GET[design_file], $site_page_info);
for($i=0; $i < sizeof($design); $i++) {
	if (!strcmp(trim($design[$i]),"")) continue;
	$design[$i] = str_replace(chr(92).r.chr(92).n, "\\r\\n", $design[$i]);
	$value .= $design[$i];
}

echo("
<form method='post' action='page_designer_manager.php?design_file={$_GET[design_file]}&mode=save_source'>
	<input type='hidden' name='allow_div' value='Y'>
  <table cellspacing='0' cellpadding='0' width='100%' height='700' border='0'>
    <tr> 
      <td valign='top'> 
			" . $GLOBALS[lib_common]->make_input_box($value, "design_file_edit", "textarea", "class='designer_textarea' wrap='off'", "width:100%;height:100%", "", "N") . "
      </td>
    </tr>
	 <tr height=30>
		<td>
			<input type='submit' value='저장'>
			<input type='reset' value='다시읽기'>
			<input type='button' value='창닫기' onclick='self.close()'>
		</td>
		</tr>
  </table>
</form>
");

include "footer_sub.inc.php";
?>