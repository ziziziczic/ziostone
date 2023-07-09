<?
$special_chars = "＠ § ※ ☆ ★ ○ ● ◎ ◇ ◆ ■ △ ▲ ▽ ▼ → ← ↑ ↓ ↔ 〓 ◁ ◀ ▷ ▶ ♤ ♠ ♡ ♥ ♧ ♣ ⊙ ◈ ▣ ◐ ◑ ▒ ▤ ▥ ▨ ▧ ▦ ▩ ♨ ☏ ☎ ☜ ☞ ↕ ↗ ↙ ↖ ↘ ㉿ ㈜ № ㏇ ™ ㏂ ㏘ ℡ ®";
$exp = explode(" ", $special_chars);
$td_tag = "";
for($i=1; $i<=sizeof($exp); $i++) {
	if (($i % 9) == 0) $is_br = "<br>";
	else $is_br = "";
	$click_tag .= "<a href=\"javascript:input_special_char('$exp[$i]', 'subject')\">$exp[$i]</a> {$is_br}";
}
$click_tag = trim($click_tag);
?>
<script language='javascript1.2'>
<!--
function input_special_char(special_char, form_item) {
	target_item = eval('document.all.' + form_item);
	target_item.value = target_item.value + special_char;
}
function open_sp_char_box() {
	obj_sp_box = MM_findObj("click_sp_char");
	obj_sp_box.style.top = 260;
	obj_sp_box.style.left = 760;
	MM_showHideLayers('click_sp_char','','show');
}
//-->
</script>
<table border=0 cellspacing=0 cellpadding=3>
	<tr>
		<td><a href="javascript:open_sp_char_box();">[특수문자]</a></td>
	</tr>
</table>
<DIV id=click_sp_char style="z-index:1; left:0px; top:0; position:absolute; visibility:hidden;">
<table border=0 cellspacing=1 cellpadding=3 bgcolor='blue'>
	<tr>
		<td bgcolor='white'><?echo($click_tag)?></td>
	</tr>
	<tr>
		<td align=right bgcolor='white'><a href="javascript:MM_showHideLayers('click_sp_char','','hide');">[닫기]</a></td>
	</tr>
</table>
</DIV>

<!--
function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->