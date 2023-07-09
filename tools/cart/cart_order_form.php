<?
if ($_SESSION[$vg_cart_var_name[total]] <= 0) $lh_common->alert_url("구매할 품목을 먼저 담으세요");

include "{$vg_cart_dir_info['include']}lock_direct_conn.inc.php";
include "{$vg_cart_dir_info[root]}cart_list.inc.php";

$sell_amount_total = $vg_cart_amount;

$sell_delivery_total = $vg_cart_amount_delivery;
if ($sell_delivery_total == '') $sell_delivery_total = 0;

$sell_cyber_money_total = $vg_cart_amount_cyber_money;
if ($sell_cyber_money_total == '') $sell_cyber_money_total = 0;

$tot_amount = $sell_amount_total + $sell_delivery_total;

echo("
<form name=frm method=post action='{$vg_cart_dir_info[root]}cart_order.php' onsubmit='return verify_submit();'>
<input type=hidden name=od_amount value='$sell_amount_total'>
<input type=hidden name=od_send_cost value='$sell_delivery_total'>
<input type=hidden name=od_cyber_money value='$sell_cyber_money_total'>
<input type=hidden name=credit_pay_amount value='0'>
<table width=95% border=0 align=center>
	<tr>
		<td><img src='{$vg_cart_dir_info[images]}tle_03.gif' width='101' height='20' border='0'></td>
	</tr>
	<tr>
		<td height=2 bgcolor='#D0C2B4'></td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td valign=top>
			<table width=520 border=0 cellpadding=0 cellspacing=0 align=center>
				<tr>
					<td width=75>성 명</td>
					<td><input type=text name=od_name value='$vg_cart_user_info[name]' size=20 maxlength=20 autocomplete='off' class=input></td>
				</tr>
");
if ($vg_cart_user_info[user_level] == 8) { // 회원이 아니면
	echo("
				<tr>
					<td width=75>패스워드</td>
					<td><input type=password name=od_pwd class=input maxlength=20> 영,숫자 3~20자 (주문서 조회시 필요)</td>
				</tr>
	");
}
echo("
				<tr>
					<td width=75>이메일</td>
					<td><input type='text' size=50 class='text' name='od_email' value='$vg_cart_user_info[email]' autocomplete='off'></td>
				</tr>
				<tr>
					<td width=75>주 소</td>
					<td>						
						<input type=text name=od_zip1 size=3 maxlength=3 value='" . substr($vg_cart_user_info[post],0,3) . "' autocomplete='off' class=input> - <input type=text name=od_zip2 size=3 maxlength=3 value='" . substr($vg_cart_user_info[post],4,3) . "' autocomplete='off' class=input>
						<a href=\"javascript:open_search_post('{$vg_cart_file[search_addr]}?nm_post_one=od_zip1&nm_post_two=od_zip2&nm_addr=od_addr')\"><img src='{$vg_cart_dir_info[images]}btn_szip.gif' width='53' height='20' border='0' align='absmiddle'></a></td>
				</tr>
				<tr>
					<td width=75></td>
					<td><input type='text' size=60 class='input' name='od_addr' value='$vg_cart_user_info[address]' autocomplete='off' ></td>
				</tr>
				<tr>
					<td width=75>전화번호</td>
					<td><input type='text' size=20 class='input' name='od_tel' value='$vg_cart_user_info[phone]'maxlength=20 autocomplete='off'></td>
				</tr>
				<tr>
					<td width=75>휴대전화</td>
					<td><input type=text name=od_hp value='$vg_cart_user_info[mobile_phone]' maxlength=20 autocomplete='off' class=input></td>
				</tr>
");
if ($vg_cart_setup[use_fix_date] == 'Y') { // 배송희망일 사용
	$vg_cart_fix_date = date("Y-m-d", time()+86400*3);
	echo("
				<tr>
					<td width=75>희망배송일</td>
					<td><input type=text name=od_hope_date size=10 maxlength=10 value='$vg_cart_fix_date' autocomplete='off' class=input> (예 : $vg_cart_fix_date)</td>
				</tr>
	");
}
echo("
				<tr>
					<td width=75>남기실 말씀</td>
					<td><textarea name=od_memo rows=5 cols=60 class='text' ></textarea></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td>
			<table border=0 cellpadding=0 cellspacing=0 width=100%>
				<tr>
					<td><img src='{$vg_cart_dir_info[images]}tle_04.gif' width='101' height='19' border='0'></td>
					<td align=right><input type='checkbox' name='same_check' onclick='javascript:gumae2baesong(this.form);'> 위의 주소로 배송을 원하실 경우는 체크하세요</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height=2 bgcolor='#D0C2B4'></td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td valign=top>
			<table width=520 border=0 cellpadding=0 cellspacing=0 align=center>
				<tr>
					<td width=75>성 명</td>
					<td><input type='text' size=20 class='input' name = 'od_b_name'></td>
				</tr>
				<tr>
					<td width=75>주 소</td>
					<td>
						<input type=text name=od_b_zip1 size=3 maxlength=3 autocomplete='off' class=input> - <input type=text name=od_b_zip2 size=3 maxlength=3 autocomplete='off' class=input>
						<a href=\"javascript:open_search_post('{$vg_cart_file[search_addr]}?nm_post_one=od_b_zip1&nm_post_two=od_b_zip2&nm_addr=od_b_addr');\"><img src='{$vg_cart_dir_info[images]}btn_szip.gif' width='53' height='20' border='0' align='absmiddle'></a>
					</td>
				</tr>
				<tr>
					<td width=75></td>
					<td><input type=text name=od_b_addr size=60 maxlength=200 autocomplete='off' class=input></td>
				</tr>
				<tr>
					<td width=75>전화번호</td>
					<td><input type='text' size=20 class='input' name = 'od_b_tel'></td>
				</tr>
				<tr>
					<td width=75>휴대전화</td>
					<td><input type='text' size=20 class='input' name = 'od_b_hp'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td><img src='{$vg_cart_dir_info[images]}tle_05.gif' width='101' height='20' border='0'></td>
	</tr>
	<tr>
		<td height=2 bgcolor='#D0C2B4'></td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td valign=top>
			<table width=520 border=0 cellpadding=0 cellspacing=0 align=center>
				<tr>
					<td width=130 valign=top>
");
$checked = " checked";
$bank_view = $card_view = $cyber_money_view = "none";
// 무통장입금 사용
if ($vg_cart_setup[use_bank] == 'Y') {
	echo("<input type='radio' name='od_settle_case' value='무통장' onclick=\"change_pay_form('bank')\"{$checked}>무통장입금<br>");
	$checked = '';
	$bank_view = "block";
}

// 신용카드 사용
if ($vg_cart_setup[use_card] == 'Y') {
	echo("<input type='radio' name='od_settle_case' value='신용카드' onclick=\"change_pay_form('card')\"{$checked}>신용카드<br>");
	$checked = '';
}

// 인터넷뱅킹 사용
if ($vg_cart_setup[use_internet_bank] == 'Y') {
	echo("<input type='radio' name='od_settle_case' value='인터넷' onclick=\"change_pay_form('internet')\"{$checked}>실시간계좌이체<br>");
	$checked = '';
}

// 무통장입금 + 신용카드 사용
if (($vg_cart_setup[use_bank] == 'Y') && ($vg_cart_setup[use_card] == 'Y')) {
	echo "<input type='radio' name='od_settle_case' value='무통장+신용카드' onclick=\"change_pay_form('both')\"{$checked}>무통장 + 신용카드<br>";
	$checked = '';
	$bank_view = "block";
}

// 회원이면
if ($vg_cart_user_info[user_level] < 8 && $vg_cart_setup[use_cyber_money] == 'Y') {
	// 회원 적립금 구함
	$mb_cyber_money = $vg_cart_user_info[cyber_money];
	// 회원의 누적적립금이 구매가능한 적립금보다 크고 결제할 금액이 구매가능한 적립금보다 클때 이용
	if ($mb_cyber_money >= (int)$vg_cart_user_info[usable_cyber_money] && $sell_amount_total >= (int)$vg_cart_user_info[usable_cyber_money]) {
		if ($mb_cyber_money > $sell_amount_total) $usable_cyber_money = $sell_amount_total;	// 적립금이 구매금액보다 크다면 구매금액 만큼만 사용
		else $usable_cyber_money = $mb_cyber_money;
		echo("<input type=checkbox name=od_settle_case_sm value='$mb_cyber_money' onclick=\"change_pay_form('cyber_money')\">적립금사용");
	}
} else {
	$mb_cyber_money = $usable_cyber_money = 0;
}
echo("
					</td>
					<td valign=top>
						<table width=100% cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td>
									<table width=100%>
										<tr>
											<td width=80>총 결제금액</td>
											<td>
												: <input name='od_settle_amount' value='" . number_format($tot_amount) . "' size='9' style='text-align:right; border-style:none;' class=input readonly>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id='cyber_money_form' style='display:$cyber_money_view'>
								<td>
									<table>
										<tr>
											<td width=80>사용할 적립금</td>
											<td>
												: <input type=text name='od_receipt_milage' value='0' size='9' style='text-align:right;' class=text onFocus='this.value = no_comma(this.value); this.select();' onBlur='compute_amount(this.form, this);' autocomplete='off'>
											</td>
											<td>(현재적립금 : " . number_format($mb_cyber_money) . ")</td>
										</tr>
									</table>									
								</td>
							</tr>
							<tr id='card_form' style='display:$card_view'>
								<td>
									<table width=100%>
										<td width=80>카드결제액</td>
										<td>
											: <input type=text name='od_receipt_card' value='0' size='9' style='text-align:right;' class=text onFocus='this.value = no_comma(this.value); this.select();' onBlur='compute_amount(this.form, this);' autocomplete='off' readonly>
										</td>
									</table>	
								</td>								
							</tr>			
							<tr id='bank_form' style='display:$bank_view'>
								<td>
									<table width=100%>
										<tr>
											<td width=80>입금금액</td>
											<td>
												<table cellpadding=0 cellspacing=0>
													<tr>
														<td>
															: <input type=text name=od_receipt_bank class=input size='9' maxlength=20 value='" . number_format($tot_amount) . "' autocomplete='off' style='text-align:right;' onFocus='this.value = no_comma(this.value); this.select();' onBlur='compute_amount(this.form, this);' readonly>&nbsp;
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr id='bank_account'>
											<td width=80>입금계좌</td>
											<td> : " . $lh_common->make_list_box("od_bank_account", $vg_cart_account, $vg_cart_account, '', '', '', '') . "
										</tr>
										<tr id='depositor'>
											<td width=80>입금자명</td>
											<td>
												: <input type=text name=od_deposit_name class=input size=6 maxlength=20 value='$vg_cart_user_info[name]' autocomplete='off'> (주문하신분과 입금자가 다를 경우 수정)
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	  	  
	<tr><td height=10></td></tr>
	<tr>
		<td height=2 bgcolor='#D0C2B4'></td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td align=center>
			<table id='submit_btn' style='display:block' >
				<tr>
					<td><input type=image src='{$vg_cart_dir_info[images]}btn_pay.gif' width='72' height='23' border='0'></td>
					<td><a href='javascript:history.back()'><img src='{$vg_cart_dir_info[images]}brn_cancel.gif' width='72' height='23' border='0'></a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
");
?>
<script src='<?echo($vg_cart_dir_info['include'])?>js.js'></script>
<script language='javascript1.2'>
<!--
	var form = document.frm;
	var settle_amount = parseFloat(form.od_amount.value) + parseFloat(form.od_send_cost.value);
	var checked_case = "무통장";
	
	// 입력값확인
	function verify_submit() {
		errmsg = '';
		errfld = '';
		var deffld = '';

		check_field(form.od_name, "주문하시는 분 이름을 입력하십시오.");
		if (typeof(form.od_pwd) != 'undefined') {
			clear_field(form.od_pwd);
			if( (form.od_pwd.value.length<3) || (form.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
			error_field(form.od_pwd, "패스워드를 3자리 이상 입력해 주십시오. 주문서 조회시 필요합니다.");
		}
		check_field(form.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
		check_field(form.od_addr, "우편번호 찾기를 이용하여 주문하시는 분 주소를 입력하십시오.");
		check_field(form.od_zip1, "");
		check_field(form.od_zip2, "");

		clear_field(form.od_email);

		check_field(form.od_b_name, "받으시는 분 이름을 입력하십시오.");
		check_field(form.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
		check_field(form.od_b_addr, "우편번호 찾기를 이용하여 받으시는 분 주소를 입력하십시오.");
		check_field(form.od_b_zip1, "");
		check_field(form.od_b_zip2, "");
	
		if (errmsg) {
			alert(errmsg);
			errfld.focus();
			return false;
		}

		// 입력값 검증후 카드 결제 창 띄움
		if ("ok" == verify_amount(form)) {
			if (form.credit_pay_amount.value != "0" && checked_case != "무통장") {	// 결제창이 뜨는 경우
				if (!pay(form)) {				// 결제창 에러시(창닫는경우등)
					document.all.submit_btn.style.display = 'block';
					return false;
				} else {													// submit 시
					document.all.submit_btn.style.display = 'none';
				}
			} else {														// 결제창 없이 넘어가는 경우(무통장선택시)
				document.all.submit_btn.style.display = 'none';
			}
		} else {
			document.all.submit_btn.style.display = 'block';
			return false;
		}
	}

	// 금액확인
	function verify_amount(f) {
		errmsg = "";
		errfld = "";

		od_receipt_bank = 0;
		od_receipt_card = 0;
		od_receipt_milage = 0;

		if (checked_case == '무통장' || checked_case == '인터넷') {
			od_receipt_bank = parseFloat(no_comma(form.od_receipt_bank.value));
			if (form.od_bank_account.value == "" && od_receipt_bank > 0) {
				alert("입금하실 은행 계좌번호를 선택해 주십시오.");
				form.od_bank_account.focus();
				return;
			}
			if (form.od_deposit_name.value.length < 2) {
				alert("입금자분 이름을 입력해 주십시오.");
				form.od_deposit_name.focus();
				return;
			}

		} else if (checked_case == '신용카드') {
			od_receipt_card = parseFloat(no_comma(form.od_receipt_card.value));
			if (od_receipt_card < <? echo (int)($vg_cart_setup[usable_card]) ?>) {
				alert("신용카드 결제액은 <? echo number_format($vg_cart_setup[usable_card]) ?> 이상 가능합니다.");
				form.od_receipt_card.focus();
				return;
			}
		} else {
			od_receipt_bank = parseFloat(no_comma(form.od_receipt_bank.value));
			if (form.od_bank_account.value == "" && od_receipt_bank > 0) {
				alert("무통장으로 입금하실 은행 계좌번호를 선택해 주십시오.");
				form.od_bank_account.focus();
				return;
			}

			if (form.od_deposit_name.value.length < 2) {
				alert("입금자분 이름을 입력해 주십시오.");
				form.od_deposit_name.focus();
				return;
			}

			od_receipt_card = parseFloat(no_comma(form.od_receipt_card.value));
			if (od_receipt_card < <? echo (int)($vg_cart_setup[usable_card]) ?>) {
				alert("신용카드 결제액은 <? echo number_format($vg_cart_setup[usable_card]) ?> 이상 가능합니다.");
				form.od_receipt_card.focus();
				return;
			}
		}

		od_receipt_milage = parseFloat(no_comma(form.od_receipt_milage.value));
		sum = od_receipt_bank + od_receipt_card + od_receipt_milage;
		if (settle_amount != sum) {
			alert(settle_amount + "입력하신 입금액 합계와 결제금액이 같지 않습니다." + sum);
			return;
		}

		// 음수일 경우 오류
		if (od_receipt_milage < 0 || od_receipt_card < 0 || od_receipt_bank < 0) {
			alert("금액은 음수로 입력하실 수 없습니다.");
			return;
		}

		str_card = str_internet_bank = "";
		str = "총 결제하실 금액 " + form.od_settle_amount.value + " 중에서\n\n";
		if (typeof(form.od_settle_case_sm) != 'undefined') if (form.od_settle_case_sm.checked == true) str += "적립금 : " + form.od_receipt_milage.value + "원\n\n";
		if (checked_case == '신용카드' || checked_case == '무통장+신용카드') {
			str += "신용카드 : " + form.od_receipt_card.value + "원\n\n";
			if (parseFloat(form.od_receipt_card.value) > 0) {
				str_card = "\n\n"+
				"-------------------------------------------------------------\n\n"+
				"신용카드 결제를 선택하셨습니다.\n\n"+
				"다음에 나오는 신용카드결제화면 에서\n\n"+
				"카드번호등을 입력하여 결제하셔야 주문이 완료됩니다.";
			}
		} else if (checked_case == '인터넷') {
			str += "실시간계좌이체 : " + form.od_receipt_bank.value + "원\n\n";
			str_internet_bank = "\n\n"+
			"-------------------------------------------------------------\n\n"+
			"실시간계좌이체 이용을 선택하셨습니다.\n\n"+
			"다음에 나오는 계좌이체결제화면 에서\n\n"+
			"결제하셔야 주문이 완료됩니다.";
		}
		if (checked_case == '무통장' || checked_case == '무통장+신용카드') str += "무통장입금 : " + form.od_receipt_bank.value + "원\n\n";
		str += "으로 결제 됩니다.\n\n입력하신 대로 주문하시려면 확인 버튼을 클릭해 주시기 바랍니다."+ str_card + str_internet_bank;

		sw_submit = confirm(str);
		if (sw_submit == true) return "ok";
	}

	function compute_amount(f, fld) {
		x = no_comma(fld.value);
		if (isNaN(x)) {
			alert("숫자가 아닙니다.");
			fld.value = fld.defaultValue;
			fld.focus();
			return;
		} else if (x == "") x = 0;
		x = parseFloat(x);

		// 10점 미만 버림
		if (fld.name == "od_receipt_milage") {
			x = parseInt(x / 10) * 10;
		}

		fld.value = number_format(String(x));

		od_receipt_bank = 0;
		od_receipt_card = 0;
		od_receipt_milage = 0;

		if (typeof(form.od_receipt_bank) != 'undefined') od_receipt_bank = od_receipt_bank_1 = parseFloat(no_comma(form.od_receipt_bank.value));	// _1 은 원위치를 위한 변수
		if (typeof(form.od_receipt_card) != 'undefined') od_receipt_card = od_receipt_card_1 = parseFloat(no_comma(form.od_receipt_card.value));
		if (typeof(form.od_receipt_milage) != 'undefined') od_receipt_milage = od_receipt_milage_1 = parseFloat(no_comma(form.od_receipt_milage.value));

		// 적립금 이용시 실 결제 금액을 저장변수(신용카드, 인터넷뱅킹시만)
		//od_real_amt = od_real_amt_1 = parseFloat(no_comma(form.approval_amt.value));
		
		sum = od_receipt_bank + od_receipt_card + od_receipt_milage;	 // 현재 입력된 금액

		// 입력합계금액이 결제금액과 같지 않다면
		if (sum != settle_amount) {
			if (fld.name == 'od_receipt_milage') {	// 적립금 수정인경우
				// 적립금 적합성검사
				if (od_receipt_milage > <?echo($mb_cyber_money)?>) {
					alert('보유하고 계신 적립금을 초과하였습니다.');
					form.od_receipt_milage.value = '<?echo($usable_cyber_money)?>';
					od_receipt_milage = parseFloat(no_comma(form.od_receipt_milage.value));
				}
				if (od_receipt_milage > 0 && od_receipt_milage < <?echo($vg_cart_setup[usable_cyber_money])?>) {
					alert('사용 가능한 적립금은 <?echo($vg_cart_setup[usable_cyber_money])?> 원 부터 입니다.');
					form.od_receipt_milage.value = 0;
					od_receipt_milage = parseFloat(no_comma(form.od_receipt_milage.value));
				}

				// 적립금 반영(무통장 또는 카드 금액에서 뺌)
				if (checked_case == '무통장' || checked_case == '인터넷') {
					od_receipt_bank = settle_amount - od_receipt_milage;
				} else if (checked_case == '신용카드') {
					od_receipt_card = settle_amount - od_receipt_milage;
				} else {	// 무통장 + 신용카드
					if (od_receipt_card >= od_receipt_milage) {	// 카드결제 금액이 큰 경우 (큰놈에서 적립금을 빼야함)
						od_receipt_card = settle_amount - (od_receipt_milage + od_receipt_bank);
					} else if (od_receipt_bank >= od_receipt_milage) {
						od_receipt_bank = settle_amount - (od_receipt_milage + od_receipt_card);
					} else {																				// 카드, 은행입금 모두 적립금보다 작다면 (은행입금에서 뺌)
						//od_receipt_milage_1 = od_receipt_milage - od_receipt_card;
						//od_receipt_bank = od_receipt_bank - od_receipt_milage_1;
						od_receipt_card = settle_amount - (od_receipt_milage + od_receipt_bank);
					}
				}
			} else if (fld.name == 'od_receipt_card') {
				od_receipt_bank = settle_amount - (od_receipt_milage + od_receipt_card);
			} else if (fld.name == 'od_receipt_bank') {
				od_receipt_card = settle_amount - (od_receipt_milage + od_receipt_bank);
			}

			// 계산 결과 확인
			if (od_receipt_bank < 0 || od_receipt_card < 0 || od_receipt_milage <0) {
				alert("결제금액을 확인해 주세요.");
				form.od_receipt_bank.value = number_format(String(od_receipt_bank_1));
				form.od_receipt_card.value = number_format(String(od_receipt_card_1));
				form.od_receipt_milage.value = number_format(String(od_receipt_milage_1));
				fld.value = number_format(String(0));
				compute_amount(f, fld);
				return;
			}
			form.od_receipt_milage.value = number_format(String(od_receipt_milage));
			form.od_receipt_bank.value = number_format(String(od_receipt_bank));
			form.od_receipt_card.value = number_format(String(od_receipt_card));
			if (typeof(form.credit_pay_amount) != 'undefined') {
				if (checked_case == "인터넷") form.credit_pay_amount.value = od_receipt_bank;
				else if (checked_case == "신용카드") form.credit_pay_amount.value = od_receipt_card;
			}
		}
	}

	function change_pay_form(where) {
		for (i=0; i<form.od_settle_case.length; i++) {
			if (form.od_settle_case[i].checked) checked_case = form.od_settle_case[i].value;
		}
		od_receipt_bank = parseFloat(no_comma(form.od_receipt_bank.value));
		od_receipt_card = parseFloat(no_comma(form.od_receipt_card.value));
		od_receipt_milage = parseFloat(no_comma(form.od_receipt_milage.value));

		if (where == "cyber_money") {
			if (document.all.od_settle_case_sm.checked == true) document.all.cyber_money_form.style.display = 'block';
			else document.all.cyber_money_form.style.display = 'none';
			form.od_receipt_milage.value = 0;
			compute_amount(form, form.od_receipt_milage);

		} else {
			if (where == 'bank' || where == 'internet') {
				document.all.bank_form.style.display = 'block';
				document.all.card_form.style.display = "none";
				form.od_receipt_bank.readOnly = true;
				form.od_receipt_bank.value = number_format(String(settle_amount - od_receipt_milage));
				form.od_receipt_card.value = 0;
				if (where == 'bank') {
					document.all.bank_account.style.display = 'block';
					document.all.depositor.style.display = "block";
				} else {
					document.all.bank_account.style.display = 'none';
					document.all.depositor.style.display = "block";
				}
			} else if (where == 'card') {
				document.all.bank_form.style.display = 'none';
				document.all.card_form.style.display = "block";
				form.od_receipt_card.readOnly = true;
				form.od_receipt_card.value = number_format(String(settle_amount - od_receipt_milage));
				form.od_receipt_bank.value = 0;
			} else if (where == 'both') {
				document.all.bank_form.style.display = 'block';
				document.all.card_form.style.display = "block";
				form.od_receipt_bank.readOnly = false;
				form.od_receipt_card.readOnly = false;
				form.od_receipt_bank.value = number_format(String(settle_amount - od_receipt_milage));
				form.od_receipt_card.value = 0;
			} 
		}
	}


	function popWin(gURL,pName,w,h,t,px,py) {
		var opt = "width=" + w + ",height=" + h;
		var pTop = (screen.availHeight - h) / 3;
		var pLeft = (screen.availWidth - w) / 2;

		if (px != null && py != null) {
			opt += ",top=" + px + ",left=" + py;
		} else {
			opt += ",top=" + pTop + ",left=" + pLeft;
		}

		switch (t) {
		case 1 :
			opt += ",scrollbars=yes";
		break;
		default :
			opt += ",scrollbars=no";
		}
		var pop = window.open(gURL,pName,opt);
		pop.focus();
	}

	function open_search_post(ref) {
		var window_left = (screen.width-640)/2;
		var window_top = (screen.height-480)/2;
		window.open(ref,"win_search_post",'width=500,height=200,status=yes,resizable=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '').focus();
	}
	
	// 구매자 정보와 동일합니다.
	function gumae2baesong(form) {
		if (form.same_check.checked == true) {
			form.od_b_name.value = form.od_name.value;
			form.od_b_tel.value  = form.od_tel.value;
			form.od_b_hp.value   = form.od_hp.value;
			form.od_b_zip1.value = form.od_zip1.value;
			form.od_b_zip2.value = form.od_zip2.value;
			form.od_b_addr.value = form.od_addr.value;
		} else {
			form.od_b_name.value = "";
			form.od_b_tel.value  = "";
			form.od_b_hp.value   = "";
			form.od_b_zip1.value = "";
			form.od_b_zip2.value = "";
			form.od_b_addr.value = "";
		}
	}
	
	form.od_name.focus();
	change_pay_form('bank');
//-->
</script>

