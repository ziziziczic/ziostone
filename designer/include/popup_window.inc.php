<?
$root = "../../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$query = "select * from $DB_TABLES[popup] where serial_num = '$serial_num' ";
$result = $GLOBALS[lib_common]->querying($query, "팝업내용 추출 쿼리중 에러");
$popup_value = mysql_fetch_array($result);
mysql_free_result($result);

$popup_value[subject] = stripslashes($popup_value[subject]);
$popup_value[contents] = stripslashes($popup_value[contents]);

if ($popup_value['include'] != "") {
	include "$popup_value[include]";
} else {
	if ($popup_value[upload_files] != '') {
		$T_file_name = explode(';', $popup_value[upload_files]);
		$file_dir = $DIRS[popup_img];
		$contents_image = $GLOBALS[lib_common]->view_files($T_file_name[0], $file_dir, $pp_file);
		if ($T_file_name[1] != '') $background = " background='{$file_dir}{$T_file_name[1]}'";
	}
?>
<html>
<head>
<meta http-equiv='content-type' content='text/html; charset=euc-kr'>
<title><? echo $popup_value[subject] ?></title>
<link rel='stylesheet' href='<?echo($DIRS[designer_root])?>include/designer_style.css' type='text/css'>
<body leftmargin="0" topmargin="0">
<script language="JavaScript">
<!--
	function div_close_<? echo $popup_value[serial_num] ?>() {
		if (chepopup_<? echo $popup_value[serial_num] ?>.checked == true) set_cookie("popup_<? echo $popup_value[serial_num] ?>", "Y" , <? echo $popup_value[disable_term] ?>);
		//window.close();
	}
	function set_cookie(name, value, expirehours) {
		var today = new Date();
		today.setTime(today.getTime() + (60*60*1000*expirehours));
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
	}
	function go_event(link_page) {
		opener.location.href=link_page;
		window.close();
	}
//-->
</script>
<?
	if ($popup_value[skin_num] != '') {
?>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="<? echo $popup_value[bg_color] ?>" align=center>
    <tr>
        <td>
				<table width=100% cellpadding=0 cellspacing=0>
					<tr>
						<td width=74><img src='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_1_1.gif' border=0></td>
						<td background='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_1_2.gif'><font color="<? echo $popup_value[font_color] ?>"><b> <? echo $popup_value[subject] ?> </b></font></td>
						<td width=20><img src='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_1_3.gif' border=0></td>
					</tr>
				</table>
			</td>
    </tr>
	 <tr>
        <td>
				<table width=100% height=100% cellpadding=0 cellspacing=0>
					<tr>
						<td width=17 background='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_2_1.gif'>&nbsp;</td>
						<td<?echo($background)?>>
<? 
echo stripslashes($contents_image . $popup_value[contents]); 
?>
						</td>
						<td width=16 background='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_2_3.gif'>&nbsp;</td>
					</tr>
				</table>
			</td>
    </tr>
	 <tr>
        <td>
				<table width=100% height=40 cellpadding=0 cellspacing=0>
					<tr>
						<td width=30><img src='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_3_1.gif' border=0></td>
						<td background='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_3_2.gif' valign=bottom>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td height=40 align=center>
										<input type=checkbox name=chepopup_<? echo $popup_value[serial_num] ?> value='Y' onclick="div_close_<? echo $popup_value[serial_num] ?>();"><?echo("다음 접속시 창 안열리게 함")?>
									</td>
									<td width=50><a href="javascript:window.close()"><b>[닫기]</b></a></td>
								</tr>	
							</table>
						</td>
						<td width=22><img src='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_3_3.gif' border=0></td>
					</tr>
				</table>
			</td>
    </tr>
</table>
<?
	} else {
?> 
<table width="100%" cellpadding="0" cellspacing="0" align=center border=0>
	 <tr>
        <td<?echo($background)?>>				
<?
echo stripslashes($contents_image . $popup_value[contents]); 
?>
			</td>
    </tr>
	 <tr>
        <td>
				<table align=right cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td width=20>
<?
echo("
							<input type=checkbox name=chepopup_{$popup_value[serial_num]} value='Y' onclick='div_close_{$popup_value[serial_num]}();'>
							
")
?>
						</td>
						<td>다음 접속시 창 안열리게 함</td>
						<td width=10></td>
						<td width=60><a href="javascript:window.close()"><b>[창닫기]</b></a></td>
					</tr>	
				</table>
			</td>
    </tr>
</table>
<?
	}
}
?>
</body>
</html>
