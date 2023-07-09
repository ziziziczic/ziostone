<?
$jiib_memo = nl2br($jiib_memo);
$_POST[comment_1] = "
	<table border=1 cellpadding=5 cellspacing=0 width=100% bgcolor=cccccc bordercolor=ffffff bordercolorlight=cccccc bordercolordark=ffffff>
		<tr>
			<td bgcolor=f3f3f3 width=80><b><font color=#5A882D>차종/연식</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_car</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>품목</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_item</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>출근지</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_dest</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>배송지</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_dest</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>근무시간</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_work_time</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>휴무</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_holi</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>월급료</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_pay</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>제공사항</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_support</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>지입료</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_money</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>보험료</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_insur</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>할부금</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_divide</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>차량인수금</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_first</td>
		</tr>
		<tr>
			<td bgcolor=f3f3f3><b><font color=#5A882D>기타사항</font></b></td>
			<td bgcolor=ffffff>&nbsp;$jiib_memo</td>
		</tr>
	</table>
";
?>