<?
$_POST[subject] = $GLOBALS[lib_common]->str_cutstring("{$_POST[name]}, {$_POST[phone]}, {$_POST[sa_date]}", 50, "...");
$apply_date = date("Y�� m�� d�� h�� i�� s��");
$apply_domain = $_SERVER[HTTP_HOST];
$_POST[comment_1] = "
	<link rel=stylesheet type=text/css href=http://shared.ohmysite.co.kr/stylesheet/text.css>
	<table border=0 cellspacing=1 width=100% cellpadding=10 bgcolor=#C0C0C0>
		<tr>
			<td width=100% height=50 colspan=2 bgcolor=#EFEDDE>
			<p align=center><b><font color=darkblue>������ȣ({$new_serial_num}) : ���� ��� ���� ({$apply_date})</font></b></td>
		</tr>
		<tr>
			<td width=120 bgcolor=#EFEDDE><b>����Ȩ������</b></td>
			<td width=400 bgcolor=#FFFFFF>{$apply_domain}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>��û�ڼ���</b></td>
			<td bgcolor=#FFFFFF>{$_POST[name]}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>����ó</b></td>
			<td bgcolor=#FFFFFF>{$_POST[phone]}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>��㰡�ɽð�</b></td>
			<td bgcolor=#FFFFFF>{$_POST[sa_date]}</td>
		</tr>
	</table>
";
?>