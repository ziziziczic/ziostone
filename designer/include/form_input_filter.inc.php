<?
	// �Ѿ���� _POST �� ó�� ($key : ������, $value : �Է°�)
	while(list($key, $value) = each($_POST)) {
		if ($key == 'x' || $key == 'y') continue;
		//	 ����������, ���������ϱ����� ��ȯ, ���±� ����
		if ($_POST[allow_div] != 'Y') $trans_value = str_replace($GLOBALS[DV][dv], $GLOBALS[DV][tdv], $value);
		else $trans_value = $value;
		$form_tag_pattern = "<form[^>]*>";	// ���±� �� �����Ѵ�.
		$trans_value = eregi_replace($form_tag_pattern, '', $trans_value);
		$trans_value = eregi_replace("</form>", '', $trans_value);
		if ($_POST[is_stripslashes] != 'N') $trans_value = stripslashes($trans_value);
		$$key = $trans_value;
	}
?>