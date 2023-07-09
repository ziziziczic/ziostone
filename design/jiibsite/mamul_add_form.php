<script language=javascript1.2>
<!--
	function inverter(form) {
		if (form.input_method[0].checked == '1') {	// 개별입력일 경우
			detail_input.style.display='block';
			paste_input.style.display='none';
		} else {															// 붙여넣기일 경우
			detail_input.style.display='none';
			paste_input.style.display='block';
		}
	}
//-->
</script>

<table cellSpacing=1 cellPadding=3 border=0 width=100% style="display:visible" id="detail_input" bgcolor=AEC2DA>
	<tr>
		<td colspan=10 bgcolor=#EAF2FD>
			<table cellSpacing=1 cellPadding=3 border=0 width=100%>
				<tr>
					<td><font color=#333399><b>개별입력<input type=radio value=1 name=input_method checked onclick="inverter(this.form)">, 붙여넣기<input type=radio value=2 name=input_method onclick="inverter(this.form)"></font></td>
					<td align=right><font color=#333399><b>* 지입사이트 매물 입력 프로그램</b></font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33 width=80>
		* 차종/연식</td>
		<td bgColor=#ffffff width=180><input type=text name=jiib_car size=20 class=design_text></td>
		<td bgColor=#ffffff height=33 width=80>
		* 운송품목</td>
		<td bgColor=#ffffff><input type=text name=jiib_item size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 출근지</td>
		<td bgColor=#ffffff><input type=text name=jiib_start size=20 class=design_text></td>
		<td bgColor=#ffffff height=33>
		* 배송지</td>
		<td bgColor=#ffffff><input type=text name=jiib_dest size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 근무시간</td>
		<td bgColor=#ffffff><input type=text name=jiib_work_time size=20 class=design_text></td>
		<td bgColor=#ffffff height=33>
		* 휴무</td>
		<td bgColor=#ffffff><input type=text name=jiib_holi size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 월급(운송)료</td>
		<td bgColor=#ffffff><input type=text name=jiib_pay size=20 class=design_text></td>
		<td bgColor=#ffffff height=33>
		* 제공사항</td>
		<td bgColor=#ffffff><input type=text name=jiib_support size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 지입료</td>
		<td bgColor=#ffffff><input type=text name=jiib_money size=20 class=design_text></td>
		<td bgColor=#ffffff height=33>
		* 보험료</td>
		<td bgColor=#ffffff><input type=text name=jiib_insur size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 할부금</td>
		<td bgColor=#ffffff><input type=text name=jiib_divide size=20 class=design_text></td>
		<td bgColor=#ffffff height=33>
		* 인수금</td>
		<td bgColor=#ffffff><input type=text name=jiib_first size=20 class=design_text></td>
	</tr>
	<tr>
		<td bgColor=#ffffff height=33>
		* 연령/기타사항</td>
		<td bgColor=#ffffff colspan=3><textarea name=jiib_memo cols=58 rows=7 class=design_textarea></textarea></td>
	</tr>
</table>
<table cellSpacing=1 cellPadding=3 border=0 style="display:none" id="paste_input" width=100% height=100%>
	<tr>
		<td bgColor=#ffffff>
<?
$default_text_value = stripslashes($article_value[comment_1]);
$default_text_value = htmlspecialchars($default_text_value);
include "{$designer_root}include/paste_input_box.inc.php";
?>			
		</td>
	</tr>
</table>
