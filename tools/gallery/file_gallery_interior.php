<?
$root = "../../";
include "{$root}include/db.php";

$gallery_number_array = array("1"=>"complete", "2"=>"counter", "3"=>"wall", "4"=>"light", "5"=>"sign", "6"=>"daejeon", "7"=>"front");
$gallery_button_array = array("1"=>"매장전경", "2"=>"카운터/휴게실", "3"=>"벽면디자인", "4"=>"조명", "5"=>"간판/파티션", "6"=>"대전모드/PS2존", "7"=>"현관/기타");
if ($gallery_number == "") $gallery_number = 1;

if ($gallery_number > 1) $prev_gallery_number = $gallery_number - 1;
else $prev_gallery_number = "";

if ($gallery_number < 7) $next_gallery_number = $gallery_number + 1;
else $next_gallery_number = "";


$gallery_img_dir = "{$root}interior_gallery/$gallery_number_array[$gallery_number]";

// 상단 이동 버튼 설정부
$top_button;
for ($i=1; $i<=sizeof($gallery_button_array); $i++) {
	if ($gallery_number != $i) {
		$gallery_link = "<a href='$PHP_SELF?gallery_number=$i'>";
		$gallery_link_close = "</a>";
		$strong_tag = "";
		$strong_tag_close = "";
	} else {
		$gallery_link = "";
		$gallery_link_close = "";
		$strong_tag = "<strong>";
		$strong_tag_close = "</strong>";
	}
	if ($i == 6) $divide_tag = "<br>";
	else $divide_tag = " | ";
	$top_button .= $gallery_link . $strong_tag . $gallery_button_array[$i] . $strong_tag_close . $gallery_link_close . $divide_tag;
}
$top_button = substr($top_button, 0, -3);
// 처음, 이전, 다음 버튼 링크 설정부
$gallery_top_link = "$PHP_SELF?gallery_number=1";
if ($prev_gallery_number != "") {
	$gallery_prev_link = "<a href='$PHP_SELF?gallery_number=$prev_gallery_number'>";
	$gallery_prev_link_close = "</a>";
}
if ($next_gallery_number != "") {
	$gallery_next_link = "<a href='$PHP_SELF?gallery_number=$next_gallery_number'>";
	$gallery_next_link_close = "</a>";
}
?>

<html>
<head>
<title>가맹점 갤러리</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="style.css" rel="stylesheet" type="text/css">
<script src="javascript.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0">
<table width="633" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="633" height="701"><table width="633" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="105" valign="bottom" background="images/pup_interia_tit.jpg" style="padding-left:30;padding-bottom:5"><table width="75%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="512" height=38><?echo($top_button)?></td>
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
                      <td width="160" align="left">&nbsp;</td>
                      <td><table width="251" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><?echo($gallery_prev_link)?><img src="images/gall_pop_prev.gif" width="83" height="34" border="0"><?echo($gallery_prev_link_close)?></td>
                            <td><a href="<?echo($gallery_top_link)?>"><img src="images/gall_pop_top.gif" width="85" height="34" border="0"></a></td>
                            <td><?echo($gallery_next_link)?><img src="images/gall_pop_next.gif" width="83" height="34" border="0"></a><?echo($gallery_next_link_close)?></td>
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
