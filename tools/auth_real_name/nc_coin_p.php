<?php 
// =============================================//
// version : 1.5 (2003.07.3)
// 사용방법 : 
// nc_coin_p.php Page에 Post 방식으로 a1=이름,a2=주민번호를 보낸다.
// =============================================//

// =============================================//
// 회원사 ID, 비밀번호 및 기타  설정
// =============================================//
// sURLnc의 값을 실제 이 페이지를 부르는 page로 설정해야 동작합니다.
// 외부 사용자가 이 URL을 스크래핑하여 불법으로 사용하는 것을 막기 위함.
$root = "../../";
include "{$root}include/verify_input.inc.php";

$sSiteID = "S220";  	// 사이트 id 
$sSitePW = "55956232";   // 비밀번호

$cb_encode_path = "/home/hosting_users/insiter1/www/tools/auth_real_name/cb_namecheck";			// cb_namecheck 모듈이 설치된 위치 

$strJumin= $jumin_number_1 . $jumin_number_2;		// 주민번호
$strName = $a1;		// 이름

$iReturnCode  = '';
//echo("$cb_encode_path $sSiteID $sSitePW $strJumin $strName");
//exit;
$iReturnCode = `$cb_encode_path $sSiteID $sSitePW $strJumin $strName`;

$iReturnCode = '1';
if ($iReturnCode == '1') {				// 실명인증된경우
	$real_input_name = $a1;
	$user_info_jumin_number = $jumin_number_1 . "-" . $jumin_number_2;
	$design_file = "member.php";
	include "{$root}db.inc.php";
	include "{$root}config.inc.php";
	include "{$root}include/viewer.inc.php";
	mysql_close();
} else {													// 안된경우
	$GLOBALS[lib_common]->alert_url("실명인증에 실패하였습니다. 성함과 주민등록번호를 확인해 주시기 바랍니다.");
}

/*
<P>
<P>
<HR>
<font color=red>이 이하 부분은 실제 서비스시 삭제하시기 바람니다.
</font>
<HR>
CREDITBANK와 통신후 발생한 RETURN CODE 설명<P>
<PRE>
코드	내용
------- ---------------------------------------------------------------------------------
0	기본값임. $HTTP_REFERER를 sURLnc와 비교하는 if문 값이 False일때. 
1	본인 맞음
2	본인 아님
3	자료없음
4	kis 시스템 장애.
5	주민번호 오류
7	선불제인데 일반실명확인 서비스로 들어온경우.
8	일반실명확인 서비스인데 선불제로 들어온경우.
9	request 데이타 오류.(주민번호, 비밀번호, 사이트아이디, 성명 중 한개의 데이터라도 빠지거나 오류가 있는 경우)
10	사이트코드 오류
11	사이트 정지상태임
12	사이트 패스워드 오류
13	사이트 인증시스템 장애
15	Decoding 오류(Data)
16	Decoding 시스템장애
18	선불제에서 코인이 소멸된경우.

</PRE>

<HR>
CREDITBANK와 통신전에 발생한 RETURN CODE 설명<P>
<PRE>
코드	내용
------- ---------------------------------------------------------------------------------
21	암호화 데이터 에러.(주민번호_비밀번호 자릿수가 21이 아닐경우)
24	암호화 연산중 에러
31	연결장애
32	결과값 이상…(result= ) 형식으로 데이터가 넘어오지 않은 경우…
34	통신중 장애발생
</PRE>
*/
?>
