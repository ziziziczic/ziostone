<?
	// �Ѿ���� _POST �� ó�� ($key : ������, $value : �Է°�)
	while(list($key, $value) = each($_POST)) {
		if ($key == 'x' || $key == 'y' || $key == "flag" || $key == "email" || $key == "homepage") continue;
		//	 ������ ����, ���±� ����
		// �Խù����͸�(�����ڴ� ������)
		if (($user_info[user_level] != '1') && ($user_info[id] != $board_info[admin])) $GLOBALS[lib_common]->input_filter($filter_chars, $value);
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