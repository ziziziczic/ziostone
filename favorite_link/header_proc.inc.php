<?
if ($root == '') $root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "config.inc.php";

$auth_method_array = array(array('L', '5', $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

include "{$DIRS[include_root]}form_input_filter.inc.php";
?>
