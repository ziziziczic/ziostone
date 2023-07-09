<?
include "header_proc.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	디자인 파일을 불러 한줄씩 배열에 저장한다.
if (!strcmp("modify", $mode)) {
	if($width != "") {
		$width = stripslashes($width);
		$width = " width={$width}";
	}
	if($height != "") {
		$height = stripslashes($height);
		$height = " height={$height}";
	}
	if($align != "") {
		$align = stripslashes($align);
		$align = " align={$align}";
	}
	if($valign != "") {
		$valign = stripslashes($valign);
		$valign = " valign={$valign}";
	}
	if($bgcolor != "") {
		$bgcolor = stripslashes($bgcolor);
		$bgcolor = " bgcolor={$bgcolor}";
	}
	if($etc != "") {
		$etc = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $etc);
		$etc = stripslashes(trim($etc));
		$etc = " $etc";
	}

	$tr_property = "{$width}{$height}{$align}{$valign}{$bgcolor}{$title}{$etc}{$style}";
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
	$search_tr = $lib_fix->search_index($design, "줄", $location);
	$exp = explode($GLOBALS[DV][dv], trim($design[$search_tr[0]]));
	$exp[2] = $tr_property;
	$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";	 // 좌우태그
	$design[$search_tr[0]] = $lib_fix->make_design_line(implode($GLOBALS[DV][dv], $exp), '', $tag_both, $blanks);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");

} else if ($mode == "make") {
	if (!strcmp("row", $insert_line)) {				
		if($etc != "") {
			$etc = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $etc);
			$etc = " " . trim($etc);
		}
		$index_exp = explode("_", $index);
		$location = "index=" . $index_exp[0];
		$line = $lib_fix->search_index($design, "테이블", $location);
		for ($i = $line[0]; $i < $line[1]; $i++) {
			$exp = explode($GLOBALS[DV][dv], $design[$i]);
			if (!strcmp($exp[0],"줄끝")) {
				$exp = explode("=", $exp[1]);
				$exp = explode("_", $exp[1]);
				if ($exp[1] >= $max_tr_index) {
					$max_tr_index = $exp[1] + 1;
				}
			}
		}
		$location = "index=" . $index_exp[0] . "_" .$index_exp[1];
		$search = $lib_fix->search_index($design, "줄", $location);
		$col = 0;		// 현재 줄에 있는 칸의 개수를 담을 변수
		for ($i=$search[0]; $i<=$search[1]; $i++) {
			$exp = explode($GLOBALS[DV][dv], $design[$i]);
			if (!strcmp($exp[0], "칸시작")) {
				$exp[1] = str_replace("index=", "", $exp[1]);
				$td_exp = explode("_", $exp[1]);
				if (($td_exp[0] == $index_exp[0]) && ($td_exp[1] == $index_exp[1])) {
					$col++;
				}
			}
		}
		$tag_both = "{$tag_open}{$GLOBALS[DV][ct4]}{$tag_close}";	 // 좌우태그
		$tr_insert_value = $lib_fix->make_tr($row, $col, $width, $height, $align, $valign, $bgcolor, $etc, $style, $max_tr_index, $index, $tag_both);
		if (!strcmp($insert_location, "left")) array_splice($design, $search[0], 0, $tr_insert_value);
		else array_splice($design, $search[1]+1, 0, $tr_insert_value);

	} else if (!strcmp("col", $insert_line)) {
		for ($col_num=1; $col_num<=$row; $col_num++) {
			$index_exp = explode("_", $index);
			$location = "index={$index_exp[0]}_{$index_exp[1]}";
			$line = $lib_fix->search_index($design, "줄", $location);
			$num = $lib_fix->td_location($design, $line, $index_exp);	// 현재 줄의 몇번째 칸인지 파악한다.
			$location = "index={$index_exp[0]}";
			$line = $lib_fix->search_index($design, "테이블", $location);
			for ($i = $line[0]; $i<=$line[1]; $i++) {	// 테이블 시작부터 끝까지 반복함
				$td_exp = explode($GLOBALS[DV][dv], $design[$i]);
				$index_exp_current = explode("_", $td_exp[1]);
				if ($td_exp[0] == "줄시작" && "index={$index_exp[0]}" == $index_exp_current[0]) {	// 현재 테이블에 속한 줄시작인경우
					$location = "{$index_exp_current[0]}_{$index_exp_current[1]}";
					$tr_line = $lib_fix->search_index($design, "줄", $location);
					$new_td_index = $lib_fix->max_td_num($design, $tr_line) + $col_num;
					$td_insert_value = $lib_fix->make_td(1, $width, $height, $align, $valign, $bgcolor,'', $etc,'', $new_td_index,str_replace("index=", "", $index_exp_current[0]), $index_exp_current[1]);
					$counter = 0;
					continue;
				}
				if ($insert_location == "left") {
					if ($td_exp[0] == "칸시작" && "index={$index_exp[0]}" == $index_exp_current[0]) {
						$counter++;
						if ($num == $counter) {
							array_splice($design, $i, 0, $td_insert_value);
							$line[1] = $line[1] + 2;
							$i = $i + 2;
						}
					}
				} else {
					if ($td_exp[0] == "칸끝" && "index={$index_exp[0]}" == $index_exp_current[0]) {
						$counter++;
						if ($num == $counter) {
							array_splice($design, $i+1, 0, $td_insert_value);
							$line[1] = $line[1] + 2;
							$i = $i + 2;
						}
					}
				}
			}
		}
	}
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
} else if ($mode == "delete") {
	if (!strcmp($delete_line, "row")) {		// 행삭제 인경우
		$index_exp = explode("_", $index);
		$location_tr = "index=" . $index_exp[0] . "_" . $index_exp[1];
		$search_tr_line = $lib_fix->search_index($design, "줄", $location_tr);
		for ($start = $search_tr_line[0]; $start <= $search_tr_line[1]; $start++) {
			$design[$start] = "";
		}
	} else {															// 열삭제 인경우
		$index_exp = explode("_", $index);
		$location = "index={$index_exp[0]}_{$index_exp[1]}";
		$line = $lib_fix->search_index($design, "줄", $location);
		$num = $lib_fix->td_location($design, $line, $index_exp);
		$location = "index={$index_exp[0]}";
		$line = $lib_fix->search_index($design, "테이블", $location);
		$counter = 0;
		for ($i = $line[0]; $i<=$line[1]; $i++) {
			$td_exp = explode($GLOBALS[DV][dv], $design[$i]);
			$index_exp_current = explode("_", $td_exp[1]);
			if ($td_exp[0] == "줄시작" && "index={$index_exp[0]}" == $index_exp_current[0]) {
				$counter = 0;
				continue;
			}
			if ($td_exp[0] == "칸시작" && "index={$index_exp[0]}" == $index_exp_current[0]) {
				$counter++;
				if ($num == $counter) {
					$del_td = $lib_fix->search_index($design, "칸", $td_exp[1]);
					for ($del_line=$del_td[0]; $del_line<=$del_td[1]; $del_line++) $design[$del_line] = "";
				}
			}
		}
	}
	$new_design = $lib_fix->design_trim($design);	// 디자인배열의 빈공간 없애고 새 인덱스를 얻는다.(인자로 넘어온 참조해야할 테이블 인덱스 값이 사라짐에 주의해서 사용해야함)
	$design = $lib_fix->table_cleaner($new_design, $DIRS, $design_file, $index);
	$lib_fix->design_save($design, $DIRS, $design_file, $site_page_info);
	$GLOBALS[lib_common]->alert_url('', 'E', '', '', "parent.opener.location.reload();parent.window.close();");
}
?>