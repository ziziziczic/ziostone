<?
if ($root == '') $VG_FM_site_root = "../../";
else $VG_FM_site_root = $root;
include "{$VG_FM_site_root}tools/form_mail/config.inc.php";
?>
<html>
<head>
<title>메일 보내기</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="<?echo($DIRS[designer_root])?>include/designer_style.css" type="text/css">
</head>

<script langauge='javascript'>
	function form_check(f) {
		errmsg = "";
		errfld = "";
		if (f.subject.value == "") {
			alert("제목을 입력하세요");
			f.subject.focus();
			return false;
		}
		if (f.from_name.value == "") {
			alert("보내는분 성명을 입력하세요");
			f.from_name.focus();
			return false;
		}
		if (f.from_email.value == "") {
			alert("보내는분 이메일을 입력하세요");
			f.from_email.focus();
			return false;
		}
		if (f.to_name.value == "") {
			alert("받는분 성명을 입력하세요");
			f.to_name.focus();
			return false;
		}
		if (f.to_email.value == "") {
			alert("받는분 이메일을 입력하세요");
			f.to_email.focus();
			return false;
		}
		if (f.contents.value == "") {
			alert("내용을 입력하세요");
			f.contents.focus();
			return false;
		}
		f.submit();
	}
</script>

<body leftmargin=10 topmargin=10>
<form name=formmail method=post action="send_mail.php" enctype="multipart/form-data"  onsubmit='form_check(this); return false;'>
<input type='hidden' name='flag' value='<?echo($_SERVER[HTTP_HOST])?>'>
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" valign="middle">
    <tr>
        <td width=200><img src="<?echo($DIRS[designer_root])?>images/sub_title_sendmail.gif"></td>
		  <td align=right width=200>
<?
$pilsu_img = "<img src='{$DIRS[designer_root]}images/icon3.gif' border=0 align=absmiddle>";
$pil_msg = "$pilsu_img 필수 입력&nbsp;&nbsp;&nbsp;";
echo($pil_msg);
?>
		  </td>
    </tr>
    <tr>
        <td valign="top" colspan=2>
            <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center">
					<tr>
                    <td width="140" height=25><? echo $pilsu_img ?> 제목 &nbsp;</td>
                    <td>
								<?echo($GLOBALS[lib_common]->make_input_box("", "subject", "text", "size=50 class=designer_text autocomplete='off'", $style))?>
							</td>
                </tr>
                <tr>
                    <td width="140" height=25><? echo $pilsu_img ?> 보내는분 성명/이메일</td>
                    <td>
								<?echo($GLOBALS[lib_common]->make_input_box($user_info[name], "from_name", "text", "size=6 class=designer_text autocomplete='off'", $style))?>
								<?echo($GLOBALS[lib_common]->make_input_box($user_info[email], "from_email", "text", "size=45 class=designer_text autocomplete='off'", $style))?>
							</td>
                </tr>
<?
if ($user_info[user_level] == 1) {
	$is_read_only = "";
} else {
	$is_read_only = " readonly";
	$host_info = $lib_insiter->get_user_info($site_info[site_id]);
	if ($to_name == '') $to_name = $host_info[name];
	if ($to_email == '') $to_email = $host_info[email];
}
?>
					<tr>
                    <td height=25><? echo $pilsu_img ?> 받는분 성명/이메일 &nbsp;</td>
                    <td>
								<?echo($GLOBALS[lib_common]->make_input_box($to_name, "to_name", "text", "size=6 class=designer_text autocomplete='off'{$is_read_only}", $style))?>
								<?echo($GLOBALS[lib_common]->make_input_box($to_email, "to_email", "text", "size=45 class=designer_text autocomplete='off'{$is_read_only}", $style))?>
							</td>
                </tr>
                <tr align="center">
                    <td colspan="2" height=110><?echo($GLOBALS[lib_common]->make_input_box("", "contents", "textarea", "rows=13 cols=75 class=designer_textarea autocomplete='off'", $style))?></td>
                </tr>
<?
$attach = 1;
for ($i=1; $i<=$attach; $i++) {
	echo "<tr>";
	echo "<td height=25 align=center>첨부 파일 $i  &nbsp;</td>";
	echo "<td>" . $GLOBALS[lib_common]->make_input_box("", "file$i", "file", "size=28 class=designer_text", $style) . "</td>";
	echo "</tr>";
}
?>
                <tr align="center">
                    <td colspan="2" height="50">
                        <input type='image' name='btn_submit' src="<?echo($DIRS[designer_root])?>images/confirm03.gif" border=0 alt="메일 보내기">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<input type=hidden name=attach value='<? echo $attach ?>'>
<input type=hidden name=close  value='<? echo $close ?>'>
</form>
<script language="JavaScript">
<!--
    document.formmail.subject.focus();
//-->
</script>

</body>
</html>
