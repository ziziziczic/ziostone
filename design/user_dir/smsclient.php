<?php
//  smsWorld SMS ���� PHP-API Test Sample
//
include "smsapicmd.php";

$userid = "smsid";
$passwd = "smspasswd";
$phone  = "01X-123-4567";
$message= "�׽�Ʈ �޽���...from SMS COMMAND API";

api_setreplyphone("01X-765-4321");
$rc = api_sendsms($userid, $passwd, $phone, $message);

echo "Return Code = [$rc]<br>\n";
echo "Return Mesg = [$api_retmsg]<br>\n";

if ($rc==0)
    echo "<font color=blue>�޽����� ���۵Ǿ����ϴ�.</font>";
else
    echo "<font color=red>�޽��������� �����Ͽ����ϴ�.</font>";
exit;
?>
