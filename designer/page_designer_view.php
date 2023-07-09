<?
if ($_GET[set_view_level] != '') {
	if ($_GET[set_view_level] == "DEFAULT") $_SESSION[view_level] = '';
	else $_SESSION[view_level] = $_GET[set_view_level];
	$_SESSION[view_all] = '';
}
if ($_GET[set_view_menu] != '') {
	if ($_GET[set_view_menu] == "DEFAULT") $_SESSION[view_menu] = '';
	else $_SESSION[view_menu] = $_GET[set_view_menu];
	$_SESSION[view_all] = '';
}
if ($_GET[set_view_design_file] != '') {
	if ($_GET[set_view_design_file] == "DEFAULT") $_SESSION[view_design_file] = '';
	else $_SESSION[view_design_file] = $_GET[set_view_design_file];
	$_SESSION[view_all] = '';
}
if ($_GET[set_view_group] != '') {
	if ($_GET[set_view_group] == "DEFAULT") $_SESSION[view_group] = '';
	else $_SESSION[view_group] = $_GET[set_view_group];
	$_SESSION[view_all] = '';
}
if ($_GET[set_view_page_type] != '') {
	if ($_GET[set_view_page_type] == "DEFAULT") $_SESSION[view_page_type] = '';
	else $_SESSION[view_page_type] = $_GET[set_view_page_type];
	$_SESSION[view_all] = '';
}
if ($_GET[set_view_mode] != '') $_SESSION[view_mode] = $_GET[set_view_mode];
if ($_GET[set_link_mode] != '') $_SESSION[link_mode] = $_GET[set_link_mode];
if ($_GET[set_view_all] != '') $_SESSION[view_all] = $_GET[set_view_all];
require "{$DIRS[designer_root]}include/class_review.php";
?>