<?
	// 넘어오는 _POST 값 처리 ($key : 변수명, $value : 입력값)
	while(list($key, $value) = each($_POST)) {
		if ($key == 'x' || $key == 'y') continue;
		//	 슬래시제거, 디자인파일구분자 변환, 폼태그 제거
		if ($_POST[allow_div] != 'Y') $trans_value = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $value);
		else $trans_value = $value;
		$form_tag_pattern = "<form[^>]*>";	// 폼태그 를 제거한다.
		$trans_value = eregi_replace($form_tag_pattern, '', $trans_value);
		$trans_value = eregi_replace("</form>", '', $trans_value);
		if ($_POST[is_stripslashes] != 'N') $trans_value = stripslashes($trans_value);
		$$key = $trans_value;
	}
?>