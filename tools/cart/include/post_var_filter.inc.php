<?
	// 넘어오는 _POST 값 처리 ($key : 변수명, $value : 입력값)
	while(list($key, $value) = each($_POST)) {
		if ($key == 'x' || $key == 'y') continue;
		//	 슬래시 삽입, 폼태그 제거
		$trans_value = addslashes($value);
		$form_tag_pattern = "<form[^>]*>";	// 폼태그 를 제거한다.
		$trans_value = eregi_replace($form_tag_pattern, "", $trans_value);
		$trans_value = eregi_replace("</form>", "", $trans_value);
		$$key = $trans_value;
		if (substr($key, -5) == "_date") {
			$pvf_exp = explode(",", $trans_value);
			$pvf_ymd = explode("-", $pvf_exp[0]);
			$pvf_his = explode(":", $pvf_exp[1]);
			$$key = mktime($pvf_his[0], $pvf_his[1], $pvf_his[2], $pvf_ymd[1], $pvf_ymd[2], $pvf_ymd[0]);
		}
	}
?>