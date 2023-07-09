<?
######### 주소 데이터베이스에서 사용자가 선택한 주소의 각 필드값을 가져온다. ##########
$query = "SELECT *  from $DB_TABLES[post] WHERE id='$postNum'";
$result = $GLOBALS[lib_common]->querying($query, "선택한 주소 추출 쿼리 수행중 에러 발생");
$addr_value = mysql_fetch_array($result);
$address = "$addr_value[si_do] $addr_value[gu_gun] $addr_value[dong]";
echo("
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
	<tr>
		<td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
	</tr>   
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
				<tr bgcolor='#ECE9D8'>
					<td align='center'>우편번호</td>
					<td align='center'>주소</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
					<td align='center'>$addr_value[post_no]</td>
					<td>$address</td>
				</tr>   
				<tr bgcolor='#FFFFFF'>
					<td align='center'><font color=red>상세번지 입력</font></td>
					<td><input type='text' name='bunji'  size='30' class='designer_text'></td>
				</tr>
				<tr>
					<td bgColor='#ffffff' colspan='2' align='center'>
						<input type='hidden' name='code' value='$addr_value[post_no]'>
						<input type='hidden' name='address' value='$address' size='45'>
						<input type='hidden' name='sido' value='$addr_value[si_do]'>
						<input type='hidden' name='gugun' value='$addr_value[gu_gun_1]' size='45'>
						<input type='submit' value='다음 단계로 이동'>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
");
?>