<?
	// �Ѿ���� _POST �� ó�� ($key : ������, $value : �Է°�)
	while(list($key, $value) = each($_POST)) {
		if ($key == 'x' || $key == 'y') continue;
		//	 ������ ����, ���±� ����
		$trans_value = addslashes($value);
		$form_tag_pattern = "<form[^>]*>";	// ���±� �� �����Ѵ�.
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