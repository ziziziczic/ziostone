<?
// 주소로부터 넘어온 메뉴 변수를 세션에 저장
if ($_GET[menu] != '') $_SESSION[MU] = $_GET[menu];
else if ($_SESSION[MU] == '') $_SESSION[MU] = "main";

$T_border_color = "#A1C864";
$T_current_color = "#FFFFFF";
$menu_style = array(
	"table_bg_color"=>"#CBCBCB", 
	"border"=>"border-right:1px solid {$T_border_color}; border-top:1px solid {$T_border_color}; border-bottom:1px solid {$T_border_color};", 
	"font"=>" style='font-size:10pt;font-weight:bold;color:#FFFFFF;width:100%'", 
	"over_color"=>"#599015", 
	"current_color"=>" bgcolor='{$T_current_color}'", 
	"current_border"=>"border-top:1px solid {$T_border_color}; border-bottom:1px solid {$T_current_color}; border-left:1px solid {$T_border_color}; border-right:1px solid #333333;",
	"current_font"=>" style='font-family:돋움;font-size:11pt;font-weight:bold;color:#000000;width:100%'"
);

$menu_tag = "
			<table cellpadding=0 cellspacing=0 border=0 width=100%>
				<tr>
					<td>
						<table cellpadding=0 cellspacing=0 border=0 width=100%>
							<tr>
								<td height=40 style='font-size:12pt' valign=top><a href='{$DIRS[designer_root]}index.php?menu=main'><img src='{$DIRS[designer_root]}/images/logo.gif' border=0 align=absmiddle></a></td>
								<td align=right>
									<table cellpadding=0 cellspacing=0 border=0>
										<form name=sch_top method=get action='{$DIRS[designer_root]}member_list.php' onsubmit=\"return verify_submit_sch_total(this)\">
										<input type=hidden name=menu value=member>
										<input type=hidden name=search_item value=A>
										<tr>
											<td><b>* $user_info[name] 님 ($user_info[id], $user_info[serial_num])</b></td>
											<td width=5></td>
											<td><a href='{$root}index.html'><img src='{$DIRS[designer_root]}/images/wams_top_home.gif' border=0 align=absmiddle></td>
											<td width=3></td>
											<td><a href='{$DIRS[designer_root]}member_input_form.php?menu=member&serial_num={$user_info[serial_num]}'><img src='{$DIRS[designer_root]}/images/wams_top_modify.gif' border=0 align=absmiddle></td>
											<td width=3></td>
											<td><a href='{$DIRS[member_root]}logout_process.php'><img src='{$DIRS[designer_root]}/images/wams_top_logout.gif' border=0 align=absmiddle></td>
											<td width=3></td>
											<td><a href='{$DIRS[designer_root]}setup_form.php?menu=setup'><img src='{$DIRS[designer_root]}/images/wams_top_setup.gif' border=0 align=absmiddle></td>
											<td width=3></td>
											<td><input type=text name='sch_kw_top' size=20 value='$_GET[sch_kw_top]' class='designer_text' style='height:18px'> <input type=submit value='고객검색' class='designer_button' style='height:18px'></td>
										</tr>
										</form>
									</table>	
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<script language='javascript1.2'>
						<!--
						// TD 버튼 오버시 호출
						function td_mouseover(obj) {
							obj.style.backgroundColor = '$menu_style[over_color]';
						}
						function defaultStatus(obj){
							obj.style.backgroundColor = '';
						}
						function verify_submit_sch_total(form) {
							if (form.sch_kw_top.value == '') {
								alert('검색단어를 입력하세요, 다중검색은 콤마로 구분합니다');
								form.sch_kw_top.focus();
								return false;
							}
						}
						//-->
						</script>
						<table width='100%' height='42' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td $menu_style[current_color]} style='border-bottom:1px solid {$T_border_color};'>&nbsp;</td>
";
$T_CN_menu = $CN_menu;
$T_i = 0;
$T_sizeof_menu = sizeof($T_CN_menu);
while (list($key, $value) = each($T_CN_menu)) {
	if ((int)$CN_menu_perm[$key] < $user_info[user_level]) continue;
	if ($T_i == 0) $menu_style_border = $menu_style[border] . " border-left:1px solid {$T_border_color};";
	else $menu_style_border = $menu_style[border];
	if ($key == $_SESSION[MU]) {
		$btn_bg_color = $menu_style[current_color];
		$btn_border = $menu_style[current_border];
		$btn_font = $menu_style[current_font];
		$script_onmouseover = '';
		$height = '41';
	} else {
		$btn_bg_color = '';
		$btn_border = $menu_style_border;
		$btn_font = $menu_style[font];
		$script_onmouseover = " onmouseover='td_mouseover(this);' onmouseout='defaultStatus(this);'";
		$height = '37';
	}
	/*
	switch ($key) {
		case "design" :
			$link_tail = "&SCH_type=U";
		break;
		default :
			$link_tail = '';
		break;
	}
	if ($key == "xxx") $lnk_menu = "{$CN_menu_link[$key]}&menu=$key";
	else $lnk_menu = "{$CN_menu_link[$key]}?menu={$key}{$link_tail}";
	*/
	$T_exp = explode('?', $CN_menu_link[$key]);
	if ($T_exp[1] != '') $T_exp[1] = '&' . $T_exp[1];
	$lnk_menu = "{$T_exp[0]}?menu={$key}{$T_exp[1]}";
	
	$menu_tag .= "
								<td width=100 valign=bottom>
									<table width='100%' border='0' cellspacing='0' cellpadding='0' background='{$DIRS[designer_root]}/images/top_menu_bg.gif'>
										<tr>
											<a href='{$lnk_menu}'><td align=center height='$height' id='main_menu'{$btn_bg_color}style='$btn_border; cursor:hand;'{$script_onmouseover}><span{$btn_font}>$value</span></td></a>
										</tr>
									</table>
								</td>
	";
	$T_i++;
}
$menu_tag .= "
								<td width=5 $menu_style[current_color]} style='border-bottom:1px solid {$T_border_color};'>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
";
echo($menu_tag);
?>