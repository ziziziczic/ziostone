<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $_GET[design_file], $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$current_line]);

$P_form = "
<table align='center' border='0' width='250' height='150'>
	<tr>
		<td width='100%' height='50' align='center' colspan='3' valign='middle'>
			<p style='line-height:200%;'><img src='{$DIRS[designer_root]}images/up.gif' width='10' height='10' border='0' alt='위쪽여백'><br>상 
			<input type='text' name='top_blank' size='3' maxlength='3' value='{$exp[10]}' style='text-align:right;'> 
			칸
		</td>
	</tr>
	<tr>
		<td width='75' height='50' align='center' valign='middle'>
			<img src='{$DIRS[designer_root]}images/left.gif' width='10' height='10' border='0' alt='왼쪽여백'><br>좌 <input type='text' name='left_blank' size='3' maxlength='3' value='<?echo($exp[12])?>' style='text-align:right;'> 
			칸
		</td>
		<td width='50' height='50' align='center' valign='middle'>
			<font color='blue'>현재<br>위치</font>
		</td>
		<td width='75' height='50' align='center' valign='middle'>
			<img src='<?echo($DIRS[designer_root])?>images/right.gif' width='10' height='10' border='0' alt='오른족여백'><br>우&nbsp;<input type='text' name='right_blank' size='3' maxlength='3' value='<?echo($exp[13])?>' style='text-align:right;'> 
			칸
		</td>
	</tr>
	<tr>
		<td width='100%' height='50' align='center' colspan='3' valign='middle'>
			하 <input type='text' name='bottom_blank' size='3' maxlength='3' value='<?echo($exp[11])?>' style='text-align:right;'> 
			칸<br><img src='<?echo($DIRS[designer_root])?>images/down.gif' width='10' height='10' border='0' alt='아래쪽여백'>
		</td>
	</tr>
</table>
";

echo("
<script language='javascript'>
<!--
function reload() {
	var form = eval(document.frm);
	form.reset();
}
function adjust_submit() {
	var form = eval(document.frm);
	form.action = form.action + '&adjust=y';
	form.submit();
}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form name='frm' method='post' action='table_designer_etc.php?design_file=$_GET[design_file]&index=$index&cpn=$cpn&current_line=$current_line&mode=blank'>
	<input type=hidden name=design_file value='$_GET[design_file]'>
	<input type=hidden name=index value='$index'>
	<input type=hidden name=current_line value='$current_line'>
	<input type=hidden name=cpn value='$cpn'>
	<tr>
		<td>
			$P_img_form
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
	<tr>
		<td>
			$P_form_blank
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>	
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>