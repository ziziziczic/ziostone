<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

echo("
<html>
<body>
<form name='TCSYSTEM_LOGIN_FORM' method='post' action='./login_process.php'>
<input type=hidden name='after_db_msg' value='N'>
<input type='hidden' name='flag' value='$_SERVER[HTTP_HOST]'>
<input type=text name=user_id size=20>
<input type=password name=user_passwd size=20>
<input type=submit value=·Î±×ÀÎ>
</form>
</body>
</html>
");
?>