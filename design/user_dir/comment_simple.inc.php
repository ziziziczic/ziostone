<?
$_POST[subject] = $GLOBALS[lib_common]->str_cutstring("{$_POST[name]}, {$_POST[phone]}, {$_POST[sa_date]}", 50, "...");
$apply_date = date("Y년 m월 d일 h시 i분 s초");
$apply_domain = $_SERVER[HTTP_HOST];
$_POST[comment_1] = "
	<link rel=stylesheet type=text/css href=http://shared.ohmysite.co.kr/stylesheet/text.css>
	<table border=0 cellspacing=1 width=100% cellpadding=10 bgcolor=#C0C0C0>
		<tr>
			<td width=100% height=50 colspan=2 bgcolor=#EFEDDE>
			<p align=center><b><font color=darkblue>접수번호({$new_serial_num}) : 빠른 상담 접수 ({$apply_date})</font></b></td>
		</tr>
		<tr>
			<td width=120 bgcolor=#EFEDDE><b>접수홈페이지</b></td>
			<td width=400 bgcolor=#FFFFFF>{$apply_domain}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>신청자성명</b></td>
			<td bgcolor=#FFFFFF>{$_POST[name]}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>연락처</b></td>
			<td bgcolor=#FFFFFF>{$_POST[phone]}</td>
		</tr>
		<tr>
			<td bgcolor=#EFEDDE><b>상담가능시간</b></td>
			<td bgcolor=#FFFFFF>{$_POST[sa_date]}</td>
		</tr>
	</table>
";
?>