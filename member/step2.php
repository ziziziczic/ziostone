<?
########## 주소 데이터베이스에서 사용자가 입력한 주소와 일치하는 레코드를 검색한다. ##########
$query = "select *  from TCSYSTEM_post_table where dong LIKE '%{$_GET[addr]}%' ORDER BY post_no";
$result = @mysql_query($query) or $libHandle->write_error($SESS_DBH, "우편번호 검색 쿼리수행중 에러발생");

$rows = mysql_num_rows($result);

########## 검색결과가 존재하면 리스트박스 형태로 출력한다. ########## 
if ($rows) {
echo("
<table width='100%' border='0' cellpadding='1' cellspacing='0' align='center'>
	<tr>
		<td colspan='2' align='right'>STEP [<b>$step</b> / <b>4</b>]</td>
	</tr>   
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='1' align='center' bgcolor='#999966'>
				<tr bgcolor='#ECE9D8'>
					<td colspan='2'>총 <b>$rows</b>개의 주소가 검색되었습니다.</td>
				</tr>
");
while($addrValue = mysql_fetch_array($result)) {
	echo("<tr><td bgcolor='#ffffff' colspan='2'>\n");
	$address = "$addrValue[post_no] $addrValue[si_do] $addrValue[gu_gun] $addrValue[dong] $addrValue[bunji]";
	echo("<a href=\"javascript:selectAddress('$addrValue[id]')\">$address</a>");
	echo("</td></tr>\n");
}
echo("
						<input type='hidden' name='postNum' value=''>
					</td>      
				</tr>
			</table>
		</td>
	</tr>
</table>
");
########## 검색결과가 하나도 존재하지 않으면 재입력을 받는다. ##########
} else {
	$GLOBALS[lib_common]->alert_url("검색된 주소가 없습니다. 다시 한번 확인해 주시기 바랍니다.");
	exit;
}
?>