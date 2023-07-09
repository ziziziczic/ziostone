<?
$root = "../../";
include "{$root}include/db.php";
$gallery_number = $article_num;
if ($gallery_number == "") $gallery_number = 1;

$gallery_img_dir = "{$root}store_gallery/{$gallery_number}";

$query = "select * from TCBOARD_1141 where etc_3='등록' order by serial_num desc";
$result = @mysql_query($query) or die(mysql_error());
$optino_name = $option_value = array();
while ($value = mysql_fetch_array($result)) {
	$option_name[] = $value[subject];
	$option_value[] = $value[serial_num];
	if ($top_flag != 'Y') {
		$top_article_num = $value[serial_num];
		$top_flag = 'Y';
	}
}
$gallery_dir_list = $lib_handle->make_list_box("change_gallery", $option_name, $option_value, "", $gallery_number, "onchange=\"MM_jumpMenu('self',this,0)\"", '');

// 처음, 이전, 다음 버튼 링크 설정부
$gallery_top_link = "$PHP_SELF?article_num=" . $top_article_num;

$query = "select serial_num from TCBOARD_1141 where etc_3='등록' and serial_num>$gallery_number order by serial_num asc  limit 1";
$result = @mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) > 0) {
	$prev_number = mysql_result($result, 0, 0);
	$gallery_prev_link = "<a href='$PHP_SELF?article_num=" . $prev_number . "'>";
	$gallery_prev_link_close = "</a>";
}

$query = "select serial_num from TCBOARD_1141 where etc_3='등록' and serial_num<$gallery_number order by serial_num desc limit 1";
$result = @mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) > 0) {
	$next_number = mysql_result($result, 0, 0);
	$gallery_next_link = "<a href='$PHP_SELF?article_num=" . $next_number . "'>";
	$gallery_next_link_close = "</a>";
}
?>
<html>
<head>
<title>가맹점 갤러리</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="javascript.js"></script>
<script language='javascript1.2'>
<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='<?echo($PHP_SELF)?>?article_num="+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0">
<table width="633" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="633" height="701" valign='top'><table width="633" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="105" valign="bottom" background="images/gall_pop_01.gif"><table width="633" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="154">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td align="left" valign="bottom">
						<?echo($gallery_dir_list)?>
					 </td>
              </tr>
              <tr> 
                <td height="12"></td>
                <td></td>
              </tr>
          </table></td>
        </tr>
        <tr> 
          <td align="center" background="images/gall_pop_bg.gif"><?include "list.inc.php"?></td>
        </tr>
        <tr>
          <td><img src="images/gall_pop_02.gif" width="633" height="8"></td>
        </tr>
        <tr> 
          <td height="104" background="images/gall_pop_03.gif"><table width="633" height="104" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="633" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="32">&nbsp;</td>
                      <td width="160" align="left"><a href="#"><img src="images/gall_pop_vod_up.gif" name="Image8" width="86" height="34" border="0" onMouseOver="MM_swapImage('Image8','','/images/join/gall_pop_vod_d.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
                      <td><table width="251" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><?echo($gallery_prev_link)?><img src="images/gall_pop_prev.gif" width="83" height="34" border="0"><?echo($gallery_prev_link_close)?></td>
                            <td><a href="<?echo($gallery_top_link)?>"><img src="images/gall_pop_top.gif" width="85" height="34" border="0"></a></td>
                            <td><?echo($gallery_next_link)?><img src="images/gall_pop_next.gif" width="83" height="34" border="0"><?echo($gallery_next_link_close)?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td height="30" align="center" valign="middle"><a href="javascript:close();"><img src="images/gall_pop_end.gif" width="53" height="17" border="0"></a></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td><img src="images/gall_pop_sho.gif" width="633" height="47"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
