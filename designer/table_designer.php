<!-- 기능 입력 메인 페이지 -->
<html>
<head>
<title>인사이트 테이블 디자이너</title>
</head>
<frameset cols="202,*" frameborder="0" framespacing="0" border="0" bordercolor="#FFFFFA" bordercolorlight="#FFFFFA" bordercolordark="#FFFFFA">
  <frame name="menuFrame" src="<?echo("table_designer_left.php?design_file={$_GET[design_file]}&index={$_GET[index]}&current_line={$_GET[current_line]}&cpn={$_GET[cpn]}")?>" marginheight=10 marginwidth=5 scrolling=auto noresize>
  <frame name="mainFrame" src="<?echo("table_designer_view.php?design_file={$_GET[design_file]}&index={$_GET[index]}&current_line={$_GET[current_line]}&cpn={$_GET[cpn]}")?>" marginheight=20 marginwidth=20 scrolling=auto target="_self" noresize>
 <noframes>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
<p>이 페이지를 보려면, 프레임을 볼 수 있는 브라우저가 필요합니다.</p>
</body>
</noframes>
</frameset>
</html>
