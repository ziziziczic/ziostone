<?
if ($root == '') $root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "config.inc.php";

$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_admin], $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

include "{$DIRS[designer_root]}include/form_input_filter.inc.php";
?>
