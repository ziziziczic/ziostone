<?
$query = "select * from $DB_TABLES[popup] where ($GLOBALS[w_time] between begin_time and end_time) and design_file='$design_file' order by serial_num asc ";
$result = $GLOBALS[lib_common]->querying($query, "팝업목록 추출 쿼리중 에러");
for ($i=0; $popup_value=@mysql_fetch_array($result); $i++) {
    // 이미 체크 되었다면 Continue
    if ($HTTP_COOKIE_VARS["popup_" . $popup_value[serial_num]] == "Y") continue;
    if ($popup_value[type] == "layer") {
		if ($popup_value[upload_files] != '') {
			$T_file_name = explode(';', $popup_value[upload_files]);
			$file_dir = $DIRS[popup_img];
			$contents_image = $GLOBALS[lib_common]->view_files($T_file_name[0], $file_dir, $pp_file);
			if ($T_file_name[1] != '') $background = " background='{$file_dir}{$T_file_name[1]}'";
		}
?>
        <!-- layer_<? echo $popup_value[serial_num] ?> ↓ -->
        <script language="JavaScript">
        <!--
				function div_close_<? echo $popup_value[serial_num] ?>() {
					if (chepopup_<? echo $popup_value[serial_num] ?>.checked == true) set_cookie("popup_<? echo $popup_value[serial_num] ?>", "Y" , <? echo $popup_value[disable_term] ?>);
					
				}

				function close_div_<?echo($popup_value[serial_num])?>() {
					document.all.div_notice_<? echo $popup_value[serial_num] ?>.style.display = "none";
				}
				
				function set_cookie(name, value, expirehours) {
					var today = new Date();
					today.setTime(today.getTime() + (60*60*1000*expirehours));
					document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
				}
        //-->
        </script>

        <div id="div_notice_<? echo $popup_value[serial_num] ?>" style="position:absolute; left:<? echo $popup_value[popup_left] ?>; top:<? echo $popup_value[popup_top] ?>;">
        
<? 
if ($popup_value['include'] == "" && $popup_value[skin_num] != "") {	 // 인클루드 아니고, 스킨이 지정된경우
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
						<td background='<?echo($DIRS[designer_root])?>images/popup/skin_img/<?echo($popup_value[skin_num])?>/popup_3_2.gif'>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td height=30 align=center>
										<input type=checkbox name=chepopup_<? echo $popup_value[serial_num] ?> value='Y' onclick="div_close_<? echo $popup_value[serial_num] ?>();"><?echo("다음 접속시 창 안열리게 함")?>
									</td>
									<td width=50><a href="#" onclick="close_div_<?echo($popup_value[serial_num])?>()"><b>[닫기]</b></a></td>
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
	if ($popup['include'] != "") {
		include "$popup_value[include]";
	} else {
?>
<table width="<? echo $popup_value[popup_width] ?>" cellpadding="0" cellspacing="0" align=center>
	 <tr>
        <td>
<? 
echo stripslashes($popup_value[contents]); 
?>
			</td>
    </tr>
	 <tr>
        <td>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td align=center>
							<input type=checkbox name=chepopup_<? echo $popup_value[serial_num] ?> value='Y' onclick="div_close_<? echo $popup_value[serial_num] ?>();"><?echo("다음 접속시 창 안열리게 함")?>
						</td>
						<td width=10></td>
						<td width=50><a href="#" onclick="close_div_<?echo($popup_value[serial_num])?>()"><b>[닫기]</b></a></td>
					</tr>	
				</table>
			</td>
    </tr>
</table>
<?
	}
}
?>
        </div>
        <!-- layer_<? echo $popup_value[serial_num] ?> ↑ -->

<? 
    } else {
?>

        <!-- WINDOW_<? echo $popup_value[serial_num] ?> ↓ -->
        <script language="JavaScript">
            var left = <? echo $popup_value[popup_left] ?>;
            var top = <? echo $popup_value[popup_top] ?>;
            var height = <? echo $popup_value[popup_height] ?> + 5;
            var width = <? echo $popup_value[popup_width] ?> + 20;
            var opt = "scrollbars=yes,resizable=yes,width="+width+",height="+height+",top="+top+",left="+left;
				// 새 창
           window.open("<?echo($DIRS[designer_root])?>include/popup_window.inc.php?serial_num=<? echo $popup_value[serial_num] ?>", "WINDOW_<? echo $popup_value[serial_num] ?>", opt);
        </script>
        <!-- WINDOW_<? echo $popup_value[serial_num] ?> ↑ -->

<?
    }
} 
@mysql_free_result($result);
?>
