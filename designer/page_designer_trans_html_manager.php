<?
//////////////////////////////////////////////////////////
// HTML -> DESIGN FILE �� ��ȯ�ϴ� ���α׷�   //
/////////////////////////////////////////////////////////

if ($root == '') $root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "config.inc.php";

$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_admin], $user_info[user_level], 'U'));
$auth_result = $GLOBALS[lib_common]->auth_process($auth_method_array);
if ($auth_result == false) $GLOBALS[lib_common]->die_msg($GLOBALS[VI][default_err_msg_admin]);

// �Ѿ���� _POST �� ó�� ($key : ������, $value : �Է°�)
while(list($key, $value) = each($_POST)) {
	if ($key == 'x' || $key == 'y') continue;
	//	 ����������, ���������ϱ����� ��ȯ, ���±� ����
	else $trans_value = $value;
	$form_tag_pattern = "<form[^>]*>";	// ���±� �� �����Ѵ�.
	$trans_value = eregi_replace($form_tag_pattern, '', $trans_value);
	$trans_value = eregi_replace("</form>", '', $trans_value);
	if ($_POST[is_stripslashes] != 'N') $trans_value = stripslashes($trans_value);
	$$key = $trans_value;
}

setcookie("VG_save_source_image_dir", $source_image_dir, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
setcookie("VG_save_target_image_dir", $target_image_dir, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
setcookie("VG_is_title_body", $is_title_body, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
setcookie("VG_is_del_link", $is_del_link, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");


$input_source = stripslashes($_POST[html_source]);	// �Ѿ�� html �ҽ��� �޴´�.

// <html> �±�����
$input_source = eregi_replace("<html>", '', $input_source);
$input_source = eregi_replace("</html>", '', $input_source);

// �ּ� ����
$tag_pattern = "<!--[^.]*-->";
$input_source = eregi_replace($tag_pattern, '', $input_source);

// �� div �±� ����
$tag_pattern = "<div[^>]*>([[:space:]]*)</div>";
$input_source = eregi_replace($tag_pattern, '', $input_source);

// ���±� ����
$tag_pattern = "<form[^>]*>";
$input_source = eregi_replace($tag_pattern, '', $input_source);
$input_source = eregi_replace("</form>", "", $input_source);


// �±׺и��ϴ� �κ�
$extract_tag_array = array("head", "map", "script", "style");
for ($i=0; $i<sizeof($extract_tag_array); $i++) {
	$var_name_tag = $extract_tag_array[$i] . "_tag_auto_name";
	$len_close_tag = strlen($extract_tag_array[$i]) + 3;
	$T_input_source = '';
	for ($j=0; $j<strlen($input_source); $j++) {
		$T_input_source .= $input_source[$j];
		if (strtolower(substr($T_input_source, $len_close_tag*-1)) == "</{$extract_tag_array[$i]}>") {
			if (eregi("<{$extract_tag_array[$i]}[^>]*>(.*)</{$extract_tag_array[$i]}>", $T_input_source, $T_tag)) {
				$$var_name_tag .= $T_tag[0] . "\r\n";
				$T_input_source = eregi_replace("<{$extract_tag_array[$i]}[^>]*>(.*)</{$extract_tag_array[$i]}>", '', $T_input_source);
			}
		}
	}
	$input_source = $T_input_source;
}

// ��ũ�� �����Ѵ�.
if ($is_del_link == "Y") {
	$a_tag_pattern = "<a[^>]*>";
	$input_source = eregi_replace($a_tag_pattern, "", $input_source);
	$input_source = eregi_replace("</a>", "", $input_source);
}

$input_source = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $input_source);
$input_source = str_replace("\r\n", "", $input_source);	// �ٹٲ��� ���ش�.
$input_source = str_replace("<", "\n<", $input_source);	// �±��� �յڷ� �ٹٲ��� ���ش�.
$input_source = str_replace(">", ">\n", $input_source);
if (substr($source_image_dir, -1) == "/") $source_image_dir = substr($source_image_dir, 0, -1);
if (substr($target_image_dir, -1) == "/") $target_image_dir = substr($target_image_dir, 0, -1);

if ($source_image_dir != "" && $target_image_dir != "") $input_source = str_replace("{$source_image_dir}/", "{$target_image_dir}/", $input_source);
$input_source_per_line = explode("\n", $input_source);	// ���پ��� ���� �迭�� �����Ѵ�.

$table_index = 0;
$tr_index = 0;
$td_index = 0;

$table_index_array = array("0");
$tr_index_array = array("0");
$td_index_array = array("0");

$text_value = "";
$make_design_file = "";
$pre_th_tag = ""; // �Ѵܰ����� ��ȯ�� �±׸� �����ϴ� ����
$javascript = $T_javascript = "";

for ($i=0; $i<sizeof($input_source_per_line); $i++) {
	$T_value = trim($input_source_per_line[$i]);
	if ($T_value == "") continue;
	$th_value = strtolower(substr($T_value, 0, 3));
	switch ($th_value) {
		case "<bo" :	// �ٵ��±�
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			if ($body_tag == '') $body_tag = $T_value;
		break;
		case "<ta" :
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			$table_index++;	// table �ε����� ������ �����Ѵ�.
			$table_start_index = $table_index;
			$table_index_array[] = $table_start_index;
			$tr_index = 0;	// table �� ���۵Ǹ� �������� tr, td �� 0���� ī��Ʈ.
			$td_index = 0;
			$T_value = eregi_replace("<table", "", $T_value);
			$T_value = str_replace(">", "", $T_value);
			$make_design_file .= "���̺����{$GLOBALS[DV][dv]}index={$table_start_index}{$GLOBALS[DV][dv]}{$T_value}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
		break;
		case "<tr" :
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			$table_start_index = $table_index_array[sizeof($table_index_array)-1];
			$tr_start_index = ++$tr_index;	// tr �ε����� table �±װ� ���۵� ��� 1 ���� �����ϰ� �׷��� �������� ���� tr �±׿� 1 ������ ������ �����ȴ�.
			$tr_index_array[] = $tr_start_index;
			$td_index = 0;	// tr �� ���۵Ǹ� �������� td �� 0 ���� ī��Ʈ.
			$T_value = eregi_replace("<tr", "", $T_value);
			$T_value = str_replace(">", "", $T_value);
			$make_design_file .= "�ٽ���{$GLOBALS[DV][dv]}index={$table_start_index}_{$tr_start_index}{$GLOBALS[DV][dv]}{$T_value}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
		break;
		case "<td" :
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			$table_start_index = $table_index_array[sizeof($table_index_array)-1];
			$tr_start_index = $tr_index_array[sizeof($tr_index_array)-1];
			$td_start_index = ++$td_index;
			$td_index_array[] = $td_start_index;
			$T_value = eregi_replace("<td", "", $T_value);
			$T_value = str_replace(">", "", $T_value);
			$make_design_file .= "ĭ����{$GLOBALS[DV][dv]}index={$table_start_index}_{$tr_start_index}_{$td_start_index}{$GLOBALS[DV][dv]}{$T_value}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
		break;
		case "<im" :
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			$T_value = eregi_replace("<img", "", $T_value);
			$T_value = str_replace(">", "", $T_value);
			$define_property = array("src");
			$img_property = $GLOBALS[lib_common]->parse_property($T_value, " ", "=", $define_property);
			$src = str_replace("'", "", $img_property[src]);
			$src = str_replace("\"", "", $src);
			$etc = $img_property[etc];
			$line_value = "�׸�{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$src}{$GLOBALS[DV][dv]}{$etc}";
			$make_design_file .= $lib_fix->make_design_line($line_value, "");
		break;
		case "</t" :
			$make_design_file .= make_text_value($text_value);
			$text_value = '';
			if (strtolower($T_value) == "</table>") {
				$make_design_file .= make_text_value($text_value);
				$table_end_index = array_pop($table_index_array);
				if ($table_end_index != "") $make_design_file .= "���̺�{$GLOBALS[DV][dv]}index={$table_end_index}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
			} else if (strtolower($T_value) == "</tr>") {
				$make_design_file .= make_text_value($text_value);
				$table_end_index = $table_index_array[sizeof($table_index_array)-1];
				$tr_end_index = array_pop($tr_index_array);
				if ($tr_end_index != "") 	$make_design_file .= "�ٳ�{$GLOBALS[DV][dv]}index={$table_end_index}_{$tr_end_index}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
				$tr_index = $tr_end_index;	 // tr �±װ� ������ ���� tr �� �ε����� ������ �д�. ���� tr �ε��� ������ �����Ѵ�.
			} else if (strtolower($T_value) == "</td>") {
				$make_design_file .= make_text_value($text_value);
				$table_end_index = $table_index_array[sizeof($table_index_array)-1];
				$tr_end_index = $tr_index_array[sizeof($tr_index_array)-1];
				$td_end_index = array_pop($td_index_array);
				if ($td_end_index != "") $make_design_file .= "ĭ��{$GLOBALS[DV][dv]}index={$table_end_index}_{$tr_end_index}_{$td_end_index}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}{$GLOBALS[DV][dv]}\n";
				$td_index = $td_end_index;	// td �±װ� ������ ���� td �� �ε����� ������ �д�. ���� td �ε��� ������ �����Ѵ�.
			} else {
				$text_value .= $T_value;
			}
		break;
		default :
			//if (($th_value == "<ht") || ($th_value == "<sc") || ($th_value == "<st") || ($th_value == "<he") || ($th_value == "</h") || ($th_value == "</s") || ($th_value == "<sp") || ($th_value == "<p ") || ($th_value == "</p")) continue;
 			$text_value .= $input_source_per_line[$i];
		break;
	}
}

$msg_alert = array();
$cnt_table_index_array = sizeof($table_index_array);
$cnt_tr_index_array = sizeof($tr_index_array);
$cnt_td_index_array = sizeof($td_index_array);
if ($cnt_table_index_array != 1 || $table_index_array[0] != '0') $msg_alert[] = "<TABLE> �±��� ����ȸ���� ����ȸ���� �ٸ��ϴ�. : {$cnt_table_index_array} , {$table_index_array[0]}";
if ($cnt_tr_index_array != 1 || $tr_index_array[0] != '0') $msg_alert[] = "<TR> �±��� ����ȸ���� ����ȸ���� �ٸ��ϴ�.  : {$cnt_table_index_array} , {$tr_index_array[0]}";
if ($cnt_td_index_array != 1 || $td_index_array[0] != '0') $msg_alert[] = "<TD> �±��� ����ȸ���� ����ȸ���� �ٸ��ϴ�. : {$cnt_table_index_array} , {$td_index_array[0]}";

if (sizeof($msg_alert) > 0) {
	$msg_alert[] = "html ������ Ȯ�� �� ���ñ� �ٶ��ϴ�.";
	$msg = implode("\\n\\n", $msg_alert);
	echo("
		<script language='javascript1.2'>
			alert('$msg');
		</script>
	");
}

$phpStartTag = chr(60) . chr(63);	// php ���� ������ �����.
$phpEndTag = chr(63) . chr(62);		// php ���� ������ �����.
$make_design_file = "{$phpStartTag}\n{$make_design_file}\n{$phpEndTag}";

// ����
$body_tag = addslashes($body_tag);
$head_tag = addslashes($head_tag_auto_name);
$map_tag = addslashes($map_tag_auto_name);
if (trim($script_tag_auto_name) != '') $script_tag = "\n" . addslashes($script_tag_auto_name);
if ($is_title_body != 'Y') $title_tag = $body_tag = $head_tag = $script_tag = '';

$query = "update $DB_TABLES[design_files] set tag_body='$body_tag', tag_header='{$head_tag}{$script_tag}', tag_body_in='$map_tag' where file_name='$design_file'";
$GLOBALS[lib_common]->querying($query, "Ÿ��Ʋ, �ٵ��±� ���� ������ ����");

$fp = fopen($DIRS[design_root] . $design_file, "w");
fwrite($fp, $make_design_file);
fclose($fp);
$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.parent.designer_view.location.reload();window.close();");

function make_text_value($value) {		// ����� ���ڿ��� ������ �������Ŀ� �°� �����ִ� �Լ�
	global $lib_insiter, $lib_fix;
	$value = str_replace("\r\n", chr(92).r.chr(92).n, trim($value));
	if (trim($value) != '') {
		$line_value = "���ڿ�{$GLOBALS[DV][dv]}$value";
		$return_value = $lib_fix->make_design_line($line_value, "");
		return $return_value;
	}
}

function explode_file_name($full_file_name) {
	$exp = explode("/", $full_file_name);
	return $exp[sizeof($exp)-1];
}

function delete_quot($property) {
	global $lib_handle;
	$define_property = array("style");
	$parse_property = $GLOBALS[lib_common]->parse_property($property, " ", "=", $define_property);
	$etc = str_replace("'", "", $parse_property[etc]);
	$etc = str_replace("\"", "", $etc);
	if (trim($parse_property[style]) != "") $style = " style='{$parse_property[style]}'";
	else $style = "";
	$return_property = $etc . $style;
	return $return_property;
}