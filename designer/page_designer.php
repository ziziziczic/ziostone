<?
echo("
<html>
<head>
<title>�����̳�</title>
<meta http-equiv=content-type content='text/html; charset=euc-kr'>
</head>
<frameset cols='171,*' frameborder='1' framespacing='0'>
  <frame name='designer_left' src='page_designer_left.php?design_file=$_GET[design_file]&page_type=$_GET[page_type]&url_referer=" . urlencode($_SERVER[HTTP_REFERER]) . "' marginheight=10 marginwidth=5 scrolling=auto>
  <frame name='designer_view' src='../page_designer_view.php?design_file=$_GET[design_file]' marginheight=20 marginwidth=20 scrolling=auto target='_self'>
<noframes>
<body bgcolor='#FFFFFF' text='#000000' link='#0000FF' vlink='#800080' alink='#FF0000'>
<p>�� �������� ������, �������� �� �� �ִ� �������� �ʿ��մϴ�.</p>
</body>
</noframes>
</frameset>
</html>
");
?>