<?
echo("
<script langauge='javascript'>
    function form_check(f) {
        errmsg = '';
        errfld = '';
		  if (f.subject.value == '') {
			  alert('������ �Է��ϼ���');
			  f.subject.focus();
			  return false;
		  }
		  if (f.from_name.value == '') {
			  alert('�����º� ������ �Է��ϼ���');
			  f.from_name.focus();
			  return false;
		  }
		  if (f.contents_file.selectedIndex == 0) {
			  alert('�������ϸ��� �����ϼ���');
			  f.contents_file.focus();
			  return false;
		  }
    }
	 function verify_submit_upload(form) {
		 if (form.mail_contents_file.value == '') {
			 alert('���ε��� ������ �����ϼ���.');
			 return false;
		 }
	 }
	 function verify_submit_delete(form) {
		 if (!confirm('������ ������ ������ �� �����ϴ�. �����Ͻðڽ��ϱ�?')) return false;
	 }
</script>
<table width='98%' border='0' cellspacing='0' cellpadding='5' align='center' valign='middle'>
	<tr>
		<td><b>[�뷮 �̸��� ������]</b>
");
$pilsu_img = "<font color=red>*</font>";
$pil_msg = "&nbsp;&nbsp;&nbsp; $pilsu_img �ʼ� �Է�&nbsp;&nbsp;&nbsp;";
echo("
			$pil_msg
		</td>
	</tr>
	<tr>
		<td valign='top'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
			<form name=formmail method=post action='send_mail.php' onsubmit='return form_check(this);'>
			<input type='hidden' name='flag' value='$_SERVER[HTTP_HOST]'>
			<input type='hidden' name='sch_query' value='" . urlencode(stripslashes($_GET[query])) . "'>
				<tr>
					<td width='150' height=25><b>$pilsu_img ���� </td>
					<td>
						" . $lh_common->make_input_box($_GET[subject], "subject", "text", "size=45 class=designer_text style='width:100%' autocomplete='off'", $style) . "
					</td>
				</tr>
				<tr>
					<td width='150' height=25><b>$pilsu_img �����º� �̸��� </td>
					<td>
						" . $lh_common->make_input_box($vg_mailing_setup[send_name], "from_name", "text", "size=10 class=designer_text style='width:25%' autocomplete='off'", $style) . "
						" . $lh_common->make_input_box($vg_mailing_setup[send_email], "from_mail", "text", "size=45 class=designer_text style='width:70%' autocomplete='off'", $style) . "
					</td>
				</tr>
				<tr>
					<td width='150' height=25><b>$pilsu_img �������� </td>
					<td>
");
$option_name = array(":: ���� ������ �����ϼ��� ::");
if ($handle = opendir($vg_mailing_dir_info[contents])) {
	while (false !== ($file = readdir($handle))) { 
		if ($file != '.' && $file != ".." && substr($file, -4) != ".bak") {
			$option_name[] = $file;
		}
	}
	closedir($handle);
}
echo("
						" . $lh_common->make_list_box("contents_file", $option_name, $option_name, '', '') . "
					</td>
				</tr>
				<tr>
					<td width='150' height=25><b>$pilsu_img �߼ۿ��� </td>
					<td>
						" . $lh_common->make_input_box('P', "is_preview", "radio", '', '', 'P') . "
						�̸�����, " . $lh_common->make_input_box('', "is_preview", "radio", '', '', 'T') . "
						�׽�Ʈ�߼�, " . $lh_common->make_input_box('', "is_preview", "radio", '', '', 'S') . "�����߼�
					</td>
				</tr>
				<tr align='center'>
					<td colspan='2' height='40'>
						<input type='submit' value='���Ϲ߼�'> <input type='button' value='�ݱ�' onclick='javascript:window.close()'> <input type='button' value='�߼۱��' onclick=\"location.href='{$vg_mailing_file[history_list]}'\">
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
	<tr>
		<td><br>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td><font color=#CC3300><b>+ �߼۴�� ���� ���� Ȯ�� +</b></font></td>
				</tr>
				<tr>
					<td><u>" . stripslashes($_GET[query]) . "</u></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><br>
			<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
				<form name=frm_upload method=post action='file_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit_upload(this)'>
				<input type='hidden' name='flag' value='$_SERVER[HTTP_HOST]'>
				<input type='hidden' name='mode' value='upload'>
				<tr>
					<td width='120' height=25><b>+ �������� ���ε� </td>
					<td>
						" . $lh_common->make_input_box('', "mail_contents_file", "file", "size=40 class=designer_text style='autocomplete='off'", $style) . "
						<input type=submit value='���ε�'>
					</td>
				</tr>
				</form>
				<tr>
					<td colspan=2><b>+ �������� ���</b> (���ϸ��� Ŭ���Ͻø� ������ �����ϴ�.)
						<table width=100% cellpadding=5 cellspacing=1 border=0 bgcolor=#f3f3f3>
");
for ($i=1; $i<sizeof($option_name); $i++) {
	echo("
							<form name=frm_delete_{$i} method=post action='file_manager.php' onsubmit='return verify_submit_delete(this)'>
							<input type='hidden' name='flag' value='$_SERVER[HTTP_HOST]'>
							<input type='hidden' name='mode' value='delete'>
							<input type='hidden' name='delete_file_name' value='{$option_name[$i]}'>
							<tr bgcolor=#ffffff>
								<td>
									<a href='{$vg_mailing_dir_info[contents]}{$option_name[$i]}' target=_blank><font color=blue><b>{$i}. {$option_name[$i]}</b></font></a>
								</td>
								<td width=80>
									<input type=submit value='���ϻ���'>
								</td>
							</tr>
							</form>
	");
}
echo("
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script language='JavaScript'>
<!--
    document.formmail.subject.focus();
//-->
</script>
");
?>