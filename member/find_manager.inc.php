<?
include "{$DIRS[include_root]}verify_input.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";
$jumin_number = $jumin_number_1 . "-" . $jumin_number_2;

if ($_POST[find_item] == "id") {
	$query="select id from $DB_TABLES[member] where name='$name' and jumin_number='$jumin_number'";
	$result = $GLOBALS[lib_common]->querying($query, "사용자 정보 추출 쿼리 수행중 에러발생");
	$total = mysql_num_rows($result);
	if($total == 0) {
		$result_msg = "일치하는 회원정보가 없습니다.<br>재검색 후에도 똑같은 상황이 발생될 경우<br>관리자에게 문의해 주세요";
	} else if ($total > 1) {
		$result_msg = "일치하는 회원정보가 두명 이상입니다.<br>관리자에게 문의해 주세요";
	} else {																																									// 일치하는 정보가 있는 경우
		$member_id = mysql_result($result,0,0);
		$result_msg = "$name 님의 아이디는<br><font color='#4B9DC5'><b>$member_id</b></font><br>입니다.";
	}
} else if ($_POST[find_item] == "password") {
	
	$query="select id, passwd, email from $DB_TABLES[member] where id='$id' and name='$name' and jumin_number='$jumin_number'";
	$result = $GLOBALS[lib_common]->querying($query, "사용자 정보 추출 쿼리 수행중 에러발생");
	$total = mysql_num_rows($result);
	if($total == 0) {
		$result_msg = "일치하는 회원정보가 없습니다.<br>재검색 후에도 똑같은 상황이 발생될 경우<br>관리자에게 문의해 주세요";
	} else if ($total > 1) {
		$result_msg = "일치하는 회원정보가 두명 이상입니다.<br>관리자에게 문의해 주세요";
	} else {																																									// 일치하는 정보가 있는 경우
		$member_id = mysql_result($result,0,0);
		$member_password = mysql_result($result,0,1);
		$member_email = mysql_result($result,0,2);
		$domain_name = getenv("SERVER_NAME");
		$subject = "<b>요청하신 회원님의 비밀번호입니다.</b>";
		$mail_contents = "
						<table align=center width=500 cellpadding=3 cellspacing=0 border=2 bordercolor='#FF9900'>
							<tr> 
								<td> 
									<div align='center'><font color='#E39C62'><b>고객님이 사용하시던 비밀번호 정보입니다. </b></font></div>
								</td>
							</tr>
							<tr> 
								<td bgcolor='#E39C62' height=1></td>
							</tr>
							<tr> 
								<td height=4></td>
							</tr>
							<tr> 
								<td height='47'>
									<div align='center'><b><font color='#02A1C9'>$member_password</font></b></div>
								</td>
							</tr>
						</table>
						<p>&nbsp;</p>
		";
		$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $member_email, $subject, $mail_contents, 1, "", "EUC-KR", "", "", $GLOBALS[VI][mail_form]);

		$result_msg = "
			$id 고객님이 가입 당시 기재하셨던 이메일주소
			<font color='#4B9DC5'><b>$member_email</b></font>
			(으)로 비밀번호를 안내해 드렸습니다.
			이메일로 비밀번호를 확인하여 주시기 바랍니다.
			항상 많은 관심 부탁드리겠습니다. 
		";
	}
}
?>

<table border=0 align=center>
	<tr>
		<td colspan=3>아이디 및 비밀번호를 잊어버리신 분, 도와 드립니다.</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td valign=top>
			<table border=0 cellpadding=20 cellspacing=1 bgcolor="#E6E6E6">
				<tr>
					<td bgcolor=white>
						<table width=400 border=0 cellpadding=0 cellspacing=0 align=center>
							<tr>
								<td align=center style="line-height:20px;">
									<?echo($result_msg)?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td align=center><a href="/"><img src="<?echo($DIRS[designer_root])?>images/btn_confirm.gif" border="0" alt=""></a></td>
	</tr>
</table>