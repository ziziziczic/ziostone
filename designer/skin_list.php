<?
// ����ڽ����� html ������� ����

include "header.inc.php";
$target_dir = $_GET[src];
if (substr($target_dir, 0, 1) == '.') $real_target_dir = $target_dir;	// ��� ����ΰ�� �״��
else $real_target_dir = "{$root}{$target_dir}";										// �׷��� ���� ��� ��Ʈ�� ����
if (substr($real_target_dir, -1) != '/') $real_target_dir .= '/';

$tag = $tag_title = array();
$dirhandle = opendir($real_target_dir);
while ($file = readdir($dirhandle)) {
	if (($file != ".") && ($file != "..")) {
		if (is_dir($real_target_dir . $file)) {
			$skin_info = array("img_dir"=>$real_target_dir . $file . '/', "title"=>"Ÿ��Ʋ TAG", "padding"=>'0', "contents"=>"���� TAG");
			$file_name = $real_target_dir . $file . "/index.html";
			$tag[] = $lib_insiter->get_skin_file($file_name, $skin_info);
			$tag_title[] = $file;
		}
	}
}
$skin_nums = sizeof($tag);
$list = '';
$line_per_skin = 5;
$width = " width='" . 100 / $line_per_skin . "%'";
for ($i=0; $i<$skin_nums; $i++) {
	$count = $i + 1;
	$left_value = $count % $line_per_skin;
	if ($left_value == 1) $list .= "
		<tr>
	";
	if ($count == $skin_nums && $left_value != 0) {
		$tail_td_nums = $line_per_skin - ($count % $line_per_skin);
		$td_tail = "<td colspan='$tail_td_nums' bgcolor=ffffff></td>";
	}
	$list .= "
			<td valign='top' bgcolor=ffffff{$width}>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td align=center>&lt;{$tag_title[$i]}&gt;</td>
					</tr>
					<tr>
						<td align=center>{$tag[$i]}</td>
					</tr>
				</table>
			</td>
			$td_tail
	";
	if ($count % $line_per_skin == 0) {
		$list .= "
		</tr>
		";
	}
}
closedir($dirhandle); 
$P_contents = "
<table width=100% cellpadding=5 cellspacing=1 border=0 bgcolor=f3f3f3>
	$list
	<tr>
		<td colspan='$line_per_skin' bgcolor=fafafa>* ��Ų ���丮 ���ε� ��� : /designer/images/box/</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"<b>���̺�Ų ���</b>"));
echo($P_contents);

include "footer.inc.php";
?>