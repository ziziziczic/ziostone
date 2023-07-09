<?
echo("
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (submit_radio_check(form, 'withdrawal_question', 'radio') == 0) {
			alert('탈퇴사유를 선택해주세요');
			return false;
		}
	}
//-->
</script>
<table width=100% cellpadding=5 cellspacing=1 border=0>
	<form name='frm_withdrawal' method='post' action='member/member_manager.php' onsubmit='return verify_submit(this)'>
	<input type='hidden' name='proc_mode' value='withdrawal'>
	<input type='hidden' name='flag' value='{$_SERVER[HTTP_HOST]}'>
	<input type='hidden' name='Q_STRING' value='{$_SERVER[QUERY_STRING]}'>
	<input type='hidden' name='http_referer' value='/{$site_info[index_file]}?design_file=home.php'>
	<tr>
		<td>
			<table width=100% cellpadding=5 cellspacing=1 border=0 bgcolor=#CCCCCC>
				<tr>
					<td bgcolor='#F3F3F3'>
						<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>탈퇴사유 선택
					</td>
				</tr>
				<tr>
					<td bgcolor='#FFFFFF'>
						" . $GLOBALS[lib_common]->get_radio_array($IS_withdrawal_question, 'withdrawal_question', '', "class=designer_radio", "<br>") . "
					</td>
				</tr>
				<tr>
					<td bgcolor='#F3F3F3'>
						<img src='{$DIRS[designer_root]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>메모
					</td>
				</tr>
				<tr>
					<td bgcolor='#FFFFFF'>
						<textarea name='memo' rows=10 cols=50 style='width:100%'></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align=center>
			<input type=submit value='탈퇴신청하기' class=designer_button>
			<input type=button value='취소하기' onclick=\"document.location.href='{$site_info[index_file]}?design_file=home.php'\" class=designer_button>
		</td>
	</tr>
	</form>
</table>
");
?>