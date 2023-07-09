<?
if (INSITER_INCLUDE != "YES") $GLOBALS[lib_common]->die_msg("잘못된접근입니다.");
include_once "{$root}service/config.inc.php";

$BIF_P_option_script_name = array();
$BIF_P_googs = '';
for ($i=0; $i<sizeof($BIF_serial_service_item); $i++) {
	$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $BIF_serial_service_item[$i]);
	$money_price = $lib_insiter->get_price_member($service_item_info, $user_info);	// 최소 구매 단위수 만큼계산
	$option_name = $option_value = array();
	for ($T_i=$service_item_info[ea_min]; $T_i<=$service_item_info[ea_max]; $T_i+=$service_item_info[ea_pack]) $option_name[] = $option_value[] = $T_i;
	if ($service_item_info[code_field_name] != "banner" && $service_item_info[item_option] != '') {
		$T_exp = explode(';', $service_item_info[item_option]);
		$T_option_array = $GLOBALS[lib_common]->parse_property($T_exp[1], ',', ':', $define_property);
		$BIF_P_option = "
			<tr bgcolor=ffffff>
				<td>{$IS_icon[form_title]}옵션</td>
				<td>" . $GLOBALS[lib_common]->get_list_boxs_array($T_option_array, $T_exp[0], '', 'N', "class=designer_select") . "</td>
			</tr>
		";
		$BIF_P_option_script_name[] = "'{$T_exp[0]}'";
	} else {
		$BIF_P_option = '';
		$BIF_P_option_script_name[] = "''";
	}
	$BIF_P_googs .= "
				<tr>
					<td width=40% style='border:1px dotted #9900FF;border-right:0px'>
						<table width=100% cellpadding=5 cellspacing=0 border=0>
							<tr bgcolor=ffffff>
								<td width=70>{$IS_icon[form_title]}서비스명</td>
								<td>
									<input type=checkbox name='BIF_item_select[]' value='{$service_item_info[serial_num]}' onclick=\"set_amount('$BIF_form_name')\">
									<font color='#FF9900'><b>$service_item_info[name]</b></font>
									<input type='hidden' name='item_name_{$service_item_info[serial_num]}' value='$service_item_info[name]'>
								</td>
							</tr>
							<tr bgcolor=ffffff>
								<td>{$IS_icon[form_title]}가격</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("ea_{$service_item_info[serial_num]}", $option_name, $option_value, '', '', "onchange=\"set_amount('$BIF_form_name')\" class=designer_select", '') . " {$SI_unit_code[$service_item_info[unit_code]]}
									<input type=hidden name='ea_unit_{$service_item_info[serial_num]}' value='$service_item_info[unit_code]'>
									" . $GLOBALS[lib_common]->make_input_box(number_format($money_price * $service_item_info[ea_min]), "money_price_{$service_item_info[serial_num]}", "text", "size=7  style='height:17px;border:0px' class=designer_text readonly", "text-align:right", $style) . " 원
									<input type=hidden name='price_unit_{$service_item_info[serial_num]}' value='$money_price'>
								</td>
							</tr>
							$BIF_P_option
						</table>
					</td>
					<td width=60% height=100% style='border:1px dotted #9900FF; border-left:0px;'>
						<table width=100% height=100% cellpadding=5 cellspacing=0 border=0>
							<tr bgcolor=ffffff>
								<td valign=top>$service_item_info[comment]</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr bgcolor='#FFFFFF'><td height=5 colspan=2></td></tr>
				<input type='hidden' name='service_table_{$service_item_info[serial_num]}' value='$service_item_info[code_table_name]'>
				<input type='hidden' name='service_field_{$service_item_info[serial_num]}' value='$service_item_info[code_field_name]'>
	";
}
$T_option_name_script_array = implode(',', $BIF_P_option_script_name);
$P_input_form = "
<table border='0' width='100%' cellspacing='1' cellpadding='0'>
	<tr>
		<td>
			<table width=100% cellpadding=0 cellspacing=0 border=0>
				$BIF_P_googs
			</table>
		</td>
	<tr>
	<tr>
		<td>
			<table width=100% cellpadding=5 cellspacing=1 border=0 class=input_form_table>
				<tr>
					<td width=20% class=input_form_title>{$IS_icon[form_title]} 총 결제금액</td>
					<td width=80% class=input_form_value>
						<input type=text name=BIF_total_amount value='' size=6 style='border:0px;text-align:right;height=21px;color:#FF6600;font-size:17px' class=designer_text readonly> 원
					</td>
				</tr>
				<tr>
					<td class=input_form_title>{$IS_icon[form_title]} 결제방식</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->get_list_boxs_array($SI_pay_method, "BIF_pay_method", $sell_info[pay_method], 'N', "onchange=\"chg_pay_method('TR-bank', this)\" class=designer_select") . "
					</td>
				</tr>
				<tr id='TR-bank' style='display:none'>
					<td class=input_form_title>{$IS_icon[form_title]} 무통장 입금정보</td>
					<td class=input_form_value>
						<table cellpadding=0 cellspacing=0 border=0 width=100%>
							<tr>
								<td>" . $GLOBALS[lib_common]->make_list_box("BIF_bank_account", $SI_bank_accounts, $SI_bank_accounts, '', '', "class=designer_select") . " / 입금자명 : " . $GLOBALS[lib_common]->make_input_box('', "BIF_bank_sender", "text", "size=10 class=designer_text", '') . "</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	<tr>
</table>
";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>구매정보입력</b>"));

if ($BIF_item_select == 'Y') {	// 상품선택이 필수인경우
	$BIF_P_script_verify_item_select = "
			if (submit_radio_check(form, 'BIF_item_select[]', 'checkbox') == 0) {
				alert('이용할 서비스를 선택해 주세요');
				return false;
			}
	";
}
echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td>
			$P_input_form
		</td>
	</tr>
</table>
<script language='javascript1.2'>
<!--
	function set_amount(form_name) {
		form = eval('document.' + form_name);
		form_els = form.elements;
		cnt = form_els.length ;
		new_name = 'BIF_item_select';
		nm_cnt = new_name.length;
		nm_option_array = [{$T_option_name_script_array}];
		select_flag = 0;
		sub_sum = total_sum = 0;
		j = 0;
		for (i=0; i<cnt; ++i) {																																									// 모든 엘리먼트만큼 반복
			if (form_els[i].type == 'checkbox' && form_els[i].name.substring(0, nm_cnt) == new_name) {			// 이름이 같은 엘리먼트 검색
				nm_ea = eval('form.ea_' + form_els[i].value);
				nm_money_price = eval('form.money_price_' + form_els[i].value);
				nm_price_unit = eval('form.price_unit_' + form_els[i].value);
				if (nm_option_array[j] != '') nm_item_option = eval('form.' + nm_option_array[j]);
				if (form_els[i].checked && form_els[i].value != '') {																								// 선택여부에 따른 작업수행
					nm_ea.disabled = false;
					nm_money_price.disabled = false;
					if (nm_option_array[j] != '') nm_item_option.disabled = false;
					sub_sum = nm_ea.value * parseInt(nm_price_unit.value);
					nm_money_price.value = number_format(sub_sum);
					total_sum += sub_sum;
				} else {
					nm_ea.disabled = true;
					nm_money_price.disabled = true;
					if (nm_option_array[j] != '') nm_item_option.disabled = true;
				}
				j++;
			}
		}
		form.BIF_total_amount.value = number_format(total_sum);
	}
	function verify_submit_buy(form) {
		$BIF_P_script_verify_item_select
		if (form.BIF_pay_method.value == 'B' && form.BIF_bank_sender.value == '') {
			alert('무통장 입금자명을 입력해 주세요.');
			form.BIF_bank_sender.focus();
			return false;
		}
	}
	function chg_pay_method(chk_prt_id, obj) {
		if (obj.value != 'B') chk_prt_id = '';
		excepts = ['UPLOADFILE', 'TITLE1', 'CONTENTS', 'LINKURL'];
		enable_child_id(chk_prt_id, document.getElementsByTagName('tr'), excepts);
	}
	set_amount('$BIF_form_name');
//-->
</script>
");
?>