<?
/****************************************************
	 DB 연동형, 1차 분류 선택에 따른 2차 분류 선택상자 출력 프로그램 (3차까지)
****************************************************/
/* 외부 환경변수 정의 (인클루드 하는 곳에서 정의 해야 하는 변수임)
$SMC = array();
$SMC[name] = "";													// 분류 타이틀 (예 : employ)
$SMC[form_name] = "";										// 폼 이름
$SMC[title_ct_1] = "";											// 1차 선택상자 타이틀
$SMC[title_ct_2] = "";											// 2차 선택상자 타이틀
$SMC[title_ct_3] = "";											// 3차 선택상자 타이틀
$SMC[table_ct_1] = "";										// 1차 분류 테이블 명
$SMC[table_ct_2] = "";										// 2차 분류 테이블 명
$SMC[table_ct_3] = "";										// 3차 분류 테이블 명
$SMC[sub_query_ct_1] = "";							// 1차 분류 서브쿼리  where is_private<>'Y' order by seq asc
$SMC[sub_query_ct_2] = "";							// 2차 분류 서브쿼리
$SMC[sub_query_ct_3] = "";							// 3차 분류 서브쿼리
$SMC[fld_code_ct_1] = "";									// 1차 분류 테이블 필드명 - 코드 (001 ...)
$SMC[fld_name_ct_1] = "";								// 1차 분류 테이블 필드명 - 이름 (전문직 ... )
$SMC[saved_value_ct_1] = "";						// 1차 분류 저장값
$SMC[fld_code_ct_2] = "";									// 2차 분류 테이블 필드명 - 코드 (00001 ...)
$SMC[fld_name_ct_2] = "";								// 2차 분류 테이블 필드명 - 이름 (운전직 ...)
$SMC[fld_select_code_ct_2] = "";					// 2차 분류 테이블 필드명 - 선택값 (003 ...)
$SMC[saved_value_ct_2] = "";						// 2차 분류 저장값
$SMC[fld_code_ct_3] = "";									// 3차 분류 테이블 필드명 - 코드 (00001 ...)
$SMC[fld_name_ct_3] = "";								// 3차 분류 테이블 필드명 - 이름 (운전직 ...)
$SMC[fld_select_code_ct_3] = "";					// 3차 분류 테이블 필드명 - 선택값 (003 ...)
$SMC[saved_value_ct_3] = "";						// 3차 분류 저장값
$SMC[input_name_ct_1] = "";							// 1차 분류 select name
$SMC[input_name_ct_2] = "";							// 2차 분류 select name
$SMC[input_name_ct_3] = "";							// 3차 분류 select name
$SMC[fixed_value_ct_1] = "";							// 1차 분류 고정값 (설정된 경우 선택상자 없이 hidden 태그로 출력)
$SMC[fixed_value_ct_2] = "";							// 2차 분류 고정값
$SMC[call_file_name] = "";								// 2차 분류 호출파일
$SMC[root] = "";
*/

function select_multi_category($SMC) {
	$TAG_ct = array();
	if ($SMC[saved_value_ct_1] != '') $smc_selected_ct_1 = $SMC[saved_value_ct_1];			// 저장된 값 이 있는 경우
	else $smc_selected_ct_1 = $SMC[fixed_value_ct_1];																			// 없는 경우 고정값 부여
	if ($SMC[saved_value_ct_2] != '') $smc_selected_ct_2 = $SMC[saved_value_ct_2];
	else $smc_selected_ct_2 = $SMC[fixed_value_ct_2];
	if ($SMC[saved_value_ct_3] != '') $smc_selected_ct_3 = $SMC[saved_value_ct_3];

	if ($SMC[input_name_ct_3] == '') $SMC[input_name_ct_3] = "none";										// 에러방지를 위한 방편

	// 1차 출력(고정이면 hidden tag 로)
	if ($SMC[fixed_value_ct_1] == '') {				// 1차 분류코드가 고정되지 않은 경우만 선택상자 출력
		$query = "select * from $SMC[table_ct_1]{$SMC[sub_query_ct_1]}";
		$result = $GLOBALS[lib_common]->querying($query);
		$smc_categorys = array();
		while ($value = mysql_fetch_array($result)) {
			$smc_categorys[$value[$SMC[fld_code_ct_1]]] = $value[$SMC[fld_name_ct_1]];
		}
		if ($SMC[table_ct_2] != '') $js_function_chg = " onChange=\"reset_next_select_{$SMC[name]}(this, '$SMC[input_name_ct_2]', '$SMC[form_name]', '$SMC[table_ct_2]', '$SMC[fld_select_code_ct_2]', '$SMC[fld_code_ct_2]', '$SMC[fld_name_ct_2]', '$SMC[call_file_name]', '" . urlencode($SMC[sub_query_ct_2]) . "', '$SMC[title_ct_2]');if (typeof(this.form.$SMC[input_name_ct_3]) != 'undefined') this.form.$SMC[input_name_ct_3].disabled=true\"";
		else $js_function_chg = '';
		$TAG_ct_1 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_1], $smc_selected_ct_1, 'Y', "class=designer_select{$js_function_chg}", ":: {$SMC[title_ct_1]} ::");
	} else {
		$TAG_ct_1 = "<input type=hidden name='$SMC[input_name_ct_1]' value='$smc_selected_ct_1'>";
	}
	$TAG_ct[] = $TAG_ct_1;

	// 2차 출력 (2차 분류 테이블 이름이 설정된 경우만)
	if ($SMC[table_ct_2] != '') {
		if ($SMC[fixed_value_ct_2] == '') {		// 2차 분류 코드가 고정되지 않은 경우만 선택상자 출력
			$smc_categorys = array();
			$query = "select * from $SMC[table_ct_2] where {$SMC[fld_select_code_ct_2]}='{$smc_selected_ct_1}'{$SMC[sub_query_ct_2]}";
			$result = mysql_query($query);
			$total_cnt = mysql_num_rows($result);
			if ($total_cnt > 0) {
				while ($value = mysql_fetch_array($result)) {
					$smc_categorys[$value[$SMC[fld_code_ct_2]]] = $value[$SMC[fld_name_ct_2]];
				}
				$is_disabled = '';
			} else {
				$is_disabled = " disabled";
			}
			if ($SMC[table_ct_3] != '') $js_function_chg = " onChange=\"reset_next_select_{$SMC[name]}(this, '$SMC[input_name_ct_3]', '$SMC[form_name]', '$SMC[table_ct_3]', 'serial_ct_2', 'serial_num', 'name', '$SMC[call_file_name]', '" . urlencode($SMC[sub_query_ct_3]) . "', '$SMC[title_ct_3]')\"";
			else $js_function_chg = '';
			$TAG_ct_2 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_2], $smc_selected_ct_2, 'Y', "class=designer_select{$js_function_chg}{$is_disabled}", ":: {$SMC[title_ct_2]} ::");
		} else {
			$TAG_ct_2 = "<input type=hidden name='$SMC[input_name_ct_2]' value='$smc_selected_ct_2'>";
		}
	}
	$TAG_ct[] = $TAG_ct_2;

	// 3차 출력 (3차 분류 테이블 이름이 설정된 경우만)
	if ($SMC[table_ct_3] != '') {
		$smc_categorys = array();
		$query = "select * from $SMC[table_ct_3] where {$SMC[fld_select_code_ct_3]}='{$smc_selected_ct_2}'{$SMC[sub_query_ct_3]}";
		$result = mysql_query($query);
		$total_cnt = mysql_num_rows($result);
		if ($total_cnt > 0) {
			while ($value = mysql_fetch_array($result)) {
				$smc_categorys[$value[$SMC[fld_code_ct_3]]] = $value[$SMC[fld_name_ct_3]];
			}
			$is_disabled = '';
		} else {
			$is_disabled = " disabled";
		}
		$TAG_ct_3 = $GLOBALS[lib_common]->get_list_boxs_array($smc_categorys, $SMC[input_name_ct_3], $smc_selected_ct_3, 'Y', "class=designer_select{$is_disabled}", ":: {$SMC[title_ct_3]} ::");
	}
	$TAG_ct[] = $TAG_ct_3;

	$TAG_smc_script = "
	<script id='{$SMC[name]}_DS'></script>
	<script language='javascript1.2'>
	<!--
		function reset_next_select_{$SMC[name]}(obj, reset_obj_name, form_name, table_name, selected_fld_name, fld_code, fld_name, select_file_name, sub_query, box_title) {
			var selected_value = obj.value;		// 선택된 값
			//alert(\"{$SMC[root]}\" + select_file_name + \"?selected_value=\" + selected_value + \"&selected_fld_name=\" + selected_fld_name + \"&reset_obj_name=\" + reset_obj_name + \"&form_name=\" + form_name + \"&table_name=\" + table_name + \"&fld_code=\" + fld_code + \"&fld_name=\" + fld_name + \"&sub_query=\" + sub_query);
			{$SMC[name]}_DS.src = \"{$SMC[root]}\" + select_file_name + \"?selected_value=\" + selected_value + \"&selected_fld_name=\" + selected_fld_name + \"&reset_obj_name=\" + reset_obj_name + \"&form_name=\" + form_name + \"&table_name=\" + table_name + \"&fld_code=\" + fld_code + \"&fld_name=\" + fld_name + \"&sub_query=\" + sub_query + \"&box_title=\" + box_title;	
		}
	//-->
	</script>
	";
	$TAG_ct[] = $TAG_smc_script;
	return $TAG_ct;
}
?>