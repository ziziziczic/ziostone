<?
$contents = "
<html>
<head>
<meta http-equiv=Content-Language content=ko>
<meta name=GENERATOR content=Microsoft FrontPage 5.0>
<meta name=ProgId content=FrontPage.Editor.Document>
<link rel=stylesheet type=text/css href=http://shared.ohmysite.co.kr/stylesheet/text.css>
</head>
<body>
	<table cellSpacing=5 cellPadding=1 border=0 width=550>
		<tr>
			<td>
			<table cellSpacing=1 cellPadding=5 bgColor=#e0e0e0 border=0 width=100%>
				<tr>
					<td bgColor=#f3f3f3 height=33 width=100>
					<img src=http://{$HTTP_HOST}/design/fix_img/icon/nec_dot.gif width=13 height=13 border=0 align=absmiddle>의뢰인 성명</td>
					<td bgColor=#ffffff>$_POST[name]</td>
				</tr>
				<tr>
					<td bgColor=#f3f3f3 height=33>
					<img src=http://{$HTTP_HOST}/design/fix_img/icon/nec_dot.gif width=13 height=13 border=0 align=absmiddle>전화번호</td>
					<td bgColor=#ffffff>$_POST[phone]</td>
				</tr>
				<tr>
					<td bgColor=#f3f3f3 height=33>
					<img src=http://{$HTTP_HOST}/design/fix_img/icon/nec_dot.gif width=13 height=13 border=0 align=absmiddle>이메일 주소</td>
					<td bgColor=#ffffff>$_POST[email]</td>
				</tr>
				<tr>
					<td bgColor=#f3f3f3 height=33>
					<img src=http://{$HTTP_HOST}/design/fix_img/icon/nec_dot.gif width=13 height=13 border=0 align=absmiddle>상담내용</td>
					<td bgColor=#ffffff>$memo</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</body>
</html>
";
?>