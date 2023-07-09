<?php
//  smsWorld SMS 전송 PHP-API Test Sample
//
include "smsapicmd.php";

$userid = "smsid";
$passwd = "smspasswd";
$phone  = "01X-123-4567";
$message= "테스트 메시지...from SMS COMMAND API";

api_setreplyphone("01X-765-4321");
$rc = api_sendsms($userid, $passwd, $phone, $message);

echo "Return Code = [$rc]<br>\n";
echo "Return Mesg = [$api_retmsg]<br>\n";

if ($rc==0)
    echo "<font color=blue>메시지가 전송되었습니다.</font>";
else
    echo "<font color=red>메시지전송이 실패하였습니다.</font>";
exit;
?>
