<?
$P_pp_form_link = "
<script language='javascript1.2'>
<!--
function is_nw_check(form) {
	if (typeof(form.pp_link_target) != 'undefined') {
		if (form.pp_link_target.value == '_nw' && form.pp_link_target.disabled == false) form.pp_link_nw.disabled = false;
		else form.pp_link_nw.disabled = true;
	}
}
//-->
</script>
<table width=100% cellpadding=2 cellspacing=0 border=0>
	<tr>
		<td width=80>대상프레임</td>
		<td>" . $lib_fix->make_target_list("pp_link_target", $pp_link_target, "onchange='is_nw_check(this.form)'", '') . ' ' . $GLOBALS[lib_common]->make_input_box($pp_link_nw, "pp_link_nw", "text", "size=50 maxlength=200 class='designer_text'{$nw_property_default}", '') . "</td>
	<tr>
	<tr>
		<td>A tag 속성</td>
		<td>" . $GLOBALS[lib_common]->make_input_box($pp_link_etc, "pp_link_etc", "text", "size='60' maxlength='255' class='designer_text'", "") . ' ' . $GLOBALS[lib_common]->make_input_box($pp_link_rollover, "pp_link_rollover", "checkbox", "size='70' maxlength='100' class='designer_text'", '', 'Y') . " (Rollover 버튼)</td>
	<tr>
</table>
";
?>