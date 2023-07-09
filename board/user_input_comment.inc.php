<?
function get_checked_img($is_checked) {
	if ($is_checked == 'Y') $img_tag = "<img src=/images/img_check.gif border=0 align=absmiddle>";
	else $img_tag = "<img src=/images/img_check_no.gif border=0 align=absmiddle>";
	return $img_tag;
}

if ($input_method == '1') {	// 입력방법 이 다른 경우
	include "{$DIRS[design_root]}jiibsite/comment_add.inc.php";
} else {
	if ($board == "2474") {
		switch ($category_1) {
			case "O" :
				include "../design/user_dir/comment_apply.inc.php";
			break;
		}
	}
}
?>
