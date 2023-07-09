<?php
//  smsWorld SMS 전송 API  (popen version)
//                written by smsworld.com
//
//    2002.07.16 ver 1.0 - initial written
//
$api_retmsg = "";
$api_replyphone = "";

function api_setreplyphone($reply)
{
    global $api_replyphone;

    $api_replyphone = $reply;
}

function api_getreturnstr()
{
    global $api_retmsg;

    return $api_retmsg;
}

function api_sendsms($id, $passwd, $rcvphone, $message)
{
    global $api_retmsg;
    global $api_replyphone;

    if (!$id || !passwd || !$rcvphone || !$message) {
        $api_retmsg = "API호출 인자 누락";
        return(21);
    }

    $exec  = "./smsrequest ";
    $exec .= "-u '" . $id       . "' ";
    $exec .= "-p '" . $passwd   . "' ";
    $exec .= "-t '" . $rcvphone . "' ";
    $exec .= "-m '" . $message  . "' ";
    if ($api_replyphone) $exec .= "-r '" . $api_replyphone  . "'";

    $fp = popen($exec, "r");
    while (!feof($fp)) {
        $line = fgets($fp,1024);
//	echo "$line<br>";
        if (strncmp($line, "RETURN:", 7)==0) break;
    }
    pclose ($fp);

    strtok($line, ": ");  /** skip "RETURN: "**/
    $rc     = strtok(": ");
    $api_retmsg = strtok("\n");

    return($rc);
}
?>
