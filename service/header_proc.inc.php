<?
if ($root == '') $root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[designer_root]}config.inc.php";

if ($_POST[proc_mode] == "add_user") $pass_level = 7;
else $pass_level = $GLOBALS[VI][admin_level_admin];
$auth_method_array = array(array('L', $pass_level, $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

include "{$DIRS[include_root]}form_input_filter.inc.php";
?>
