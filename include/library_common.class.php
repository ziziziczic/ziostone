<?
class library_common {

/*
	���� �Լ� Ŭ����
*/

	function library_common() {
		// nothing
	}

//	 �Ϲݰ��� �Լ�	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// ������ �̹��� �����
	// $real_src_file = "./src_dir/file_name.gif";
	// $target_info = array("rate"=>50, "width"=>100, "height"=>50, "dir"=>"./thumb_nail/");
	// $option = array("over_write"=>'N', "show"=>'Y');
	function get_thumb_nail($real_src_file, $target_info, $option, $root='') {
		$src_file_info = '';
		if (is_file($real_src_file) == false) return '';
		if (substr($real_src_file, 0, 1) == '.') $src_file = $real_src_file;	// ��� ����ΰ�� �״��
		else $src_file = "{$root}{$real_src_file}";											// �׷��� ���� ��� ��Ʈ�� ����
		if ($target_info[width] == '' || $target_info[height] == '') {			// ���� �Ǵ� ���� ����� ������ ��� �������缭 ����
			$src_file_info = getimagesize($src_file);												// ��������
			if ($target_info[height] == '' && $target_info[width] != '') {
				$target_info[height] = ($src_file_info[1] * $target_info[width]) / $src_file_info[0];
			} else if ($target_info[width] == '' && $target_info[height] != '') {
				$target_info[width] = ($src_file_info[0] * $target_info[height]) / $src_file_info[1];
			} else if ($target_info[rate] > 0) {
				$target_info[width] = $src_file_info[0] * ($target_info[rate] / 100);
				$target_info[height] = $src_file_info[1] * ($target_info[rate] / 100);
			} else {
				$GLOBALS[lib_common]->alert_url("����� �̹��� ���� ���� : ������, ������, �Ǵ� ������ �Ѱ����� �ԷµǾ�� �մϴ�.");
			}
		}
		$target_file = "{$target_info[dir]}THUMBNAIL_{$target_info[width]}_{$target_info[height]}_" . $this->get_file_name($src_file);
		$tag_img = "<image src='$target_file' border='0' width='{$target_info[width]}' height='{$target_info[height]}' hspace='1' vspace='1'>";
		if ($option[over_write] == 'N' &&  file_exists($target_file) == true)   {
			if ($option[show] == 'Y' ) echo($tag_img);
			return $tag_img;
		}
		if ($src_file_info == '') $src_file_info = getimagesize($src_file);													// �������� 
		switch ($src_file_info[2]) {
			case '1' :																									// GIF
				$src_img = @imagecreatefromgif($src_file);
			break;
			case '2' :																									// JPG
				$src_img = @imagecreatefromjpeg($src_file);
			break;
			case '3' :																									// PNG
				$src_img = @imagecreatefrompng($src_file);
			break;
			default :																									// �� �� ������ ����
				return '';
			break;
		}
		$temp_x = (double)$target_info[width] / (double)$src_file_info[0];
		$temp_y = (double)$target_info[height] / (double)$src_file_info[1];
		if ($temp_x == 1 && $temp__y == 1) {										// ����� ������ ���
			copy($src_file, $target_file);
			return;
		}
		if ($temp_x * $src_file_info[1] <= $target_info[height]) {
			$real_x = (int)($temp_x * $src_file_info[0]);
			$real_y = (int)($temp_x * $src_file_info[1]);
		} else {
			$real_x = (int)($temp_y * $src_file_info[0]);
			$real_y = (int)($temp_y * $src_file_info[1]);
		}
		$img = imageCreateTrueColor($real_x, $real_y);
		imagecopyresampled($img, $src_img, 0, 0, 0, 0, $real_x, $real_y, $src_file_info[0], $src_file_info[1]);
		imagejpeg($img, $target_file, 100);
		if ($option[show] == 'Y' ) echo($tag_img);
		return $tag_img;
	}

	function get_form_vars($mode) {  
		if ($_SERVER[REQUEST_METHOD] == "POST") $form_vars = $_POST;
		else $form_vars = $_GET;
		$return_vars = array();
		while(list($key, $value) = each($_POST)) {
			if ($key == 'x' || $key == 'y' || $key == "flag" || $key == "email" || $key == "homepage") continue;
			$trans_value = addslashes($value);	// ������ ����
			$form_tag_pattern = "<form[^>]*>";	// ���±� �� �����Ѵ�.
			$trans_value = eregi_replace($form_tag_pattern, "", $trans_value);
			$trans_value = eregi_replace("</form>", "", $trans_value);
			$return_vars[$key] = $trans_value;
			if (substr($key, -5) == "_date") {
				$pvf_exp = explode(",", $trans_value);
				$pvf_ymd = explode("-", $pvf_exp[0]);
				$pvf_his = explode(":", $pvf_exp[1]);
				$return_vars[$key] = mktime($pvf_his[0], $pvf_his[1], $pvf_his[2], $pvf_ymd[1], $pvf_ymd[2], $pvf_ymd[0]);
			}
		}
		return $return_vars;
	}

	// �ؽ�Ʈ ����(��Ų)�� �ڵ�ȭ �� �κ��� ���ε� ������ ������ �ҷ����̴� �Լ�
	function get_skin_file($file_name, $chg_info) {
		if (!file_exists($file_name)) return '';
		$file_contents = '';
		$fd = fopen ($file_name, 'r');
		while (!feof($fd)) {
			$buffer = fgets($fd, 128);
			$file_contents .= $buffer;
		}
		fclose ($fd);
		while (list($key, $value) = each($chg_info)) $file_contents = str_replace("%{$key}%", $value, $file_contents);
		return $file_contents;
	}

	// �ش� ����� ���� �� ��¥ ��� �Լ�
	function get_last_date_month($year, $month) {
		$day = 28;
		while (checkdate($month, $day, $year)) $day++;
		$day--;
		return $day;
	}

	// start_date �κ��� �����Ⱓ ������ timestamp ���� ����.
	function get_date_term($start_date, $mode, $term) {
		switch ($mode) {
			case "year" :
				$start_date[0] += $term;
				$start_date[2] -= 1;
			break;
			case "month" :
				$start_date[1] += ($term -1);
				$start_date[2] = $this->get_last_date_month($start_date[0], $start_date[1]);
			break;
			case "day" :
				$start_date[2] += $term;
			break;
		}
		return mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
	}

	// Ư�� �������� ���ڿ��� �ǵ�����
	function get_format($format, $string, $divider='', $etc_info='', $head_foot=array()) {
		if ($string == '') return;
		global $DIRS;
		switch ($format) {
			case "phone" :
				if (eregi("[^0-9]", $string)) return $string;	// �����̿��� ������ ������ �״�� ����
				$value = array();
				if (substr($string, 0, 2) == "02") {						// ���� (������ ���� �����ϰ� �����ɷ� �Ǵ�)
					$value[] = "02";
					$string = substr($string, 2);
					if (strlen($string) == 8) {									// 02-0000-0000
						$value[] = substr($string, 0, 4);
						$value[] = substr($string, 4, 4);
					} else if (strlen($string) == 7) {						// 02-000-0000
						$value[] = substr($string, 0, 3);
						$value[] = substr($string, 3, 4);
					}
				} else {																			// ��Ÿ (�� 4�ڸ� �����ϰ� �����ɷ� �Ǵ�)
					$T_value = substr($string, -4, 4);
					$string = substr($string, 0, -4);
					if (strlen($string) == 8) {									// 0000-0000-xxxx
						$value[] = substr($string, 0, 4);
						$value[] = substr($string, 4, 4);
					} else if (strlen($string) == 7) {						// 000-0000-xxxx
						$value[] = substr($string, 0, 3);
						$value[] = substr($string, 3, 4);
					} else if (strlen($string) == 6) {						// 000-0000-xxxx
						$value[] = substr($string, 0, 3);
						$value[] = substr($string, 3, 3);
					} else {
						$value[] = $string;
					}
					$value[] = $T_value;
				}
			break;
			case "post" :
				if (eregi("[^0-9]", $string)) return $string;
				$value = array();
				$value[] = substr($string, 0, 3);
				$value[] = substr($string, 3, 3);
			break;
			case "biz_number" :
				if (eregi("[^0-9]", $string)) return $string;
				$value = array();
				$value[] = substr($string, 0, 3);
				$value[] = substr($string, 3, 2);
				$value[] = substr($string, 5, 5);
			break;
			case "jumin_number" :
				if (eregi("[^0-9]", $string)) return $string;
				$value = array();
				$value[] = substr($string, 0, 6);
				$value[] = substr($string, 6, 7);
			break;
			case "email" :
				if ($etc_info != '') $string_1 = $etc_info;
				else $string_1 = $string;
				$value = "<a href='#;' onclick=\"window.open('{$DIRS[tools_root]}form_mail/send_mail_form.php?item=common&to_email=$string', 'mail_send', 'left=10,top=10,width=600,height=600,resizable=yes,scollbars=yes')\">$string_1</a>";
			break;
			case "homepage" :
				if (strtolower(substr($string, 0, 7)) != "http://") $string = "http://{$string}";
				if ($etc_info != '') $string_1 = $etc_info;
				else $string_1 = $string;
				$value = "<a href='/move_url.php?url=$string' target=_blank>$string_1</a>";
			break;
			case "money" :
				$value = $this->get_money_format($string);
			break;
			case "date" :
				if ($etc_info == '') $etc_info = "y-m-d";
				$value = $this->get_input_date($string, $etc_info);
			break;
		}

		$return_value = '';		
		if (is_array($value) && $divider != '') {
			if ($value[0] != '') $return_value = implode($divider, $value);
		} else {
			if ($value != '') $return_value = $value;
		}
		return $head_foot[0] . $return_value . $head_foot[1];
	}

	// \r ���� �Լ�
	function replace_cr($full_string, $replace_string, $strip_quote='N') {
		$comment = explode("\n", $full_string);
		for ($i=0; $i<sizeof($comment); $i++) {
			$comment[$i] = trim($comment[$i]);
		}
		$value = implode($replace_string, $comment);
		if ($strip_quote == 'Y') $value = $this->strip_quote($value, 'A');
		return $value;
	}

	function strip_quote($string, $mode) {
		switch ($mode) {
			case 'S' :	// ��������ǥ
				$value = str_replace('\'', '', $string);
			break;
			case 'B' :	// ū����ǥ
				$value = str_replace('\"', '', $string);
			break;
			case 'A' :	// ���
				$value = str_replace('\'', '', $string);
				$value = str_replace('\"', '', $value);
			break;
		}
		return $value;
	}

	// ���͸� ���ڿ� �˻� �Լ�
	function input_filter($filter_list, $input_value) {
		for ($i=0; $i<sizeof($filter_list); $i++) {
			if (trim($filter_list[$i]) == '') continue;
			if (eregi($filter_list[$i], $input_value)) die("�Է��ϱ⿡ �������� �ܾ ���ԵǾ� �ֽ��ϴ�. : <font color=red>$filter_list[$i]</font> <a href='javascript:history.back()'><b>[���ư���]</b></a>");
		}
	}

	// ȭ������� ���
	function get_money_format($amount, $comma='Y', $unit="��", $unit_loc='R', $sosu='0') {
		if($comma == 'Y')  {
			if ($unit_loc == "F") $amount = $unit . number_format($amount, $sosu);
			else $amount = number_format($amount, $sosu) . $unit;
		}
		return $amount;
	}

	// �� 5���� ����ǥ��
	function get_stars($grade, $unit_half_star=1, $img_dir='') {
		$max_grade = $unit_half_star * 10;
		$stars = array();
		$direction = 'L';
		for ($i=1; $i<=$max_grade; $i++) {
			if (($i % $unit_half_star) == 0) {	// ����� ����
				if ($grade >= $i) {	// �������
					if ($direction == 'L') {
						$stars[] = "TL";
						$direction = 'R';
					} else {
						$stars[] = "TR";
						$direction = 'L';
					}
				} else {						// ������º����
					if ($direction == 'L') {
						$stars[] = "FL";
						$direction = 'R';
					} else {
						$stars[] = "FR";
						$direction = 'L';
					}				
				}
			}
		}
		$stars_tag = "<img src='{$img_dir}/%STARS%' border=0 align=absmiddle>";
		$return_value = '';
		for ($i=0; $i<sizeof($stars); $i++) {
			switch ($stars[$i]) {
				case "TL" :
					$return_value .= str_replace("%STARS%", "star_true_left.gif", $stars_tag);
				break;
				case "TR" :
					$return_value .= str_replace("%STARS%", "star_true_right.gif", $stars_tag);
				break;
				case "FL" :
					$return_value .= str_replace("%STARS%", "star_false_left.gif", $stars_tag);
				break;
				case "FR" :
					$return_value .= str_replace("%STARS%", "star_false_right.gif", $stars_tag);
				break;
			}
		}
		return $return_value;
	}

	/* ����ó�� (��Ȳ�� ���� ���� �ο� ���θ� ������ / �Ʒ� ��������)
		$value[0] : ���ذ� , $value[1] : ���簪 , $value[2] : ���
		$auth_method_array = array(array('L', ���ط���, ����ڷ���, 'E'), array('L', ���ط���, ����ڷ���, 'E'));
		if (!$lc_handle->auth_process($auth_method_array)) $lc_handle->die_msg("��ϱ����� �����ϴ�.", $SRE_file_info[die_msg_skin]);
	*/
	function auth_process($auth_method_array) {
		for ($i=0,$cnt=sizeof($auth_method_array); $i<$cnt; $i++) {
			if ($auth_method_array[$i][1] == '' && $auth_method_array[$i][2] == '') return false;
			switch ($auth_method_array[$i][0]) {
				case 'L' : // ������ ����ó��
					if ($auth_method_array[$i][3] == 'U') {				// ���� ���� �̻��ΰ��
						if ($auth_method_array[$i][1] >= $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'L') {	// ���� ���� �����ΰ��
						if ($auth_method_array[$i][1] <= $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'E') {
						if ($auth_method_array[$i][1] == $auth_method_array[$i][2]) return true;
					}
				break;
				case 'M' : // ��Ī�� ����ó��					
					if ($auth_method_array[$i][3] == 'E') {					// �������
						if ($auth_method_array[$i][1] == $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'D') {	// �ٸ����
						if ($auth_method_array[$i][1] != $auth_method_array[$i][2]) return true;
					}
				break;
			}
		}
		return false;
	}

	// ���� ÷�ν�
	/*
	$fp = fopen(__FILE__, "r");
	$file[] = array(
	"name"=>basename(__FILE__),
	"data"=>fread($fp, filesize(__FILE__)));
	fclose($fp);
	*/

	// ������ ÷����
	function attach_file($filename, $file, $type='') {
		$fp = fopen($file, "r");
		$tmpfile = array("name" => $filename, "data" => fread($fp, filesize($file)), "type" => $type);
		fclose($fp);
		return $tmpfile;
	}

	// ���� ������ (���� ������ ÷�� ����)
	function mailer($fname, $fmail, $to, $subject, $mail_contents, $type=0, $file='', $charset="EUC-KR", $cc='', $bcc='', $skin_file='', $log_info='', $auto_link='N', $to_name='', $is_logging='Y', $etc_info='') {
		// type : text=0, html=1, text+html=2
		$from_name = $fname;
		$fname   = "=?$charset?B?" . base64_encode($fname) . "?=";
		$subject_common = $subject;
		$subject = "=?$charset?B?" . base64_encode($subject) . "?=";
		$charset = ($charset != "") ? "charset=$charset" : "";

		$mail_contents = stripslashes($mail_contents);
		if ($auto_link == 'Y') {
			$mail_contents = $this->auto_link($mail_contents, "common");
			$etc_info[contents_etc] = $this->auto_link($etc_info[contents_etc], "common");
			$etc_info[footer] = $this->auto_link($etc_info[footer], "common");
		}

		if ($skin_file != '' && is_file($skin_file)) {
			$fp = fopen ($skin_file, "r");
			$skin_contents = fread($fp, 10000);
			fclose ($fp);
			$content = str_replace("%MAILCONTENTS%", $mail_contents, $skin_contents);
			$content = str_replace("%MAILSUBJECT%", $subject_common, $content);
			$content = str_replace("%MAILTONAME%", $to_name, $content);
			$content = str_replace("%MAILDOMAIN%", "{$GLOBALS[VI][protocol]}://{$_SERVER[HTTP_HOST]}", $content);			
		} else {
			$content =$mail_contents;
		}

		// ��Ÿ ���� ����
		if ($etc_info[contents_etc] != '') $content = str_replace("%MAILCONTENTSETC%", $etc_info[contents_etc], $content);
		else $content = str_replace("%MAILCONTENTSETC%", '', $content);

		// Ǫ�ͻ���
		if ($etc_info[footer] != '') $content = str_replace("%MAILFOOTER%", $etc_info[footer], $content);
		else $content = str_replace("%MAILFOOTER%", '', $content);

		// ������ ������ ����
		if ($etc_info[default_adver_file] != '') {
			$T_info = array("pass_empty_file"=>'Y', "ptr_header"=>'N');
			$remote_value = $this->get_remote_file_value($etc_info[default_adver_file], 2, $T_info);
			$content = str_replace("%ADVERTISEMENT%", $remote_value, $content);
		} else {
			$content = str_replace("%ADVERTISEMENT%", '&nbsp;', $content);
		}

		$header  = "Return-Path: <$fmail>\n";
		$header .= "From: $fname <$fmail>\n";
		$header .= "Reply-To: <$fmail>\n";
		if ($cc)  $header .= "Cc: $cc\n";
		if ($bcc) $header .= "Bcc: $bcc\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "X-Mailer: insiter mailer 0.9 (wams.kr)\n";
		if ($file != '') {
			$boundary = uniqid("{$GLOBALS[VI][protocol]}://wams.kr/");
			$header .= "Content-type: MULTIPART/MIXED; BOUNDARY=\"$boundary\"\n\n";
			$header .= "--$boundary\n";
		}
		if ($type) {
			$header .= "Content-Type: TEXT/HTML; $charset\n";
			if ($type == 2) $content = nl2br($type);
		} else {
			$header .= "Content-Type: TEXT/PLAIN; $charset\n";
			//$content = stripslashes($content);
		}
		$header .= "Content-Transfer-Encoding: BASE64\n\n";
		$header .= chunk_split(base64_encode(trim($content))) . "\n";
		if ($file != '') {
			foreach ($file as $f) {
				if ($f[type] == '') $f[type] = "APPLICATION/OCTET-STREAM";
				$header .= "\n--$boundary\n";
				$header .= "Content-Type: {$f[type]}; name=\"$f[name]\"\n";
				$header .= "Content-Transfer-Encoding: BASE64\n";
				$header .= "Content-Disposition: inline; filename=\"$f[name]\"\n";
				$header .= "\n";
				$header .= chunk_split(base64_encode($f[data]));
				$header .= "\n";
			}
			$header .= "--$boundary--\n";
		}
		$mail_ok = mail($to, $subject, '', $header);
		if ($mail_ok) {
			if ($is_logging == 'Y') {
				$subject_common = addslashes($subject_common);
				$content = addslashes($content);
				// �������� ���
				$sub_query = "from_name='$from_name', from_mail='$fmail', to_mail='$to', subject='$subject_common', contents='$content', type='$type', sign_date='$GLOBALS[w_time]', owner='$log_info[owner]', link='$log_info[link]', etc_msg='$log_info[etc_msg]'";
				$query = "insert VG_MAIL_LOG set $sub_query";
				$this->querying($query);
			}
			return $mail_ok;
		} else {
			return false;
		}
	}
	
	// ������ ������ ������ �ؽ�Ʈ�� �ҷ���
	function get_remote_file_value($remote_file, $timeout=2, $etc_info='') {
		$url = parse_url($remote_file);
		if (!in_array($url[scheme], array('','http'))) return;
		$fp = fsockopen($url['host'], ($url['port'] > 0 ? $url['port'] : 80), $errno, $errstr, $timeout);
		if (!$fp) {
			return;
		} else {
			if ($etc_info[referer] == '') $referer = $_SERVER[HTTP_REFERER];
			else $referer = $etc_info[referer];
			fputs ($fp, "GET /".$url['path'].($url['query'] ? '?'.$url['query'] : '')." HTTP/1.0\r\nHost: ".$url['host']."\r\nReferer: {$referer}\r\n\r\n");
			$remote_value = '';
			while (!feof($fp)) $remote_value .= fgets($fp, 2048);
			fclose($fp);
			if ($etc_info[pass_empty_file] == 'Y') if (!ereg("200 OK", $remote_value)) return;
			if ($etc_info[ptr_header] != 'Y') {
				$exp_remote_value = explode("\r\n\r\n", $remote_value);
				$exp_remote_value[0] = '';
				$remote_value = implode("\r\n\r\n", $exp_remote_value);
			}
			return $remote_value;
		}
	}

	// �־��� ���ڿ��� �ؽ�Ʈ ���Ϸ� ����� �Լ�
	function str_to_file($target_file, $mode, $str, $file_type='') {
		if ($file_type == "php") {
			$phpStartTag = chr(60) . chr(63) . "\r\n";
			$phpEndTag = "\r\n" . chr(63) . chr(62);
			$str = $phpStartTag . $str. $phpEndTag;
		}
		$fp = fopen($target_file, $mode);
		fwrite($fp, $str);
		fclose($fp);			
	}


	// ������ ����
	function page_lock($mode) {
		if ($mode[btn_left] == 'Y') {
			$msg = "alert('���콺 ���� ��ư�� ����� �� �����ϴ�!');";
			$value_btn_left = "
				if (event.button == 1) { 
					$msg
					return false;
				}
			";
		}
		if ($mode[btn_right] == 'Y') {
			$msg = "alert('���콺 ������ ��ư�� ����� �� �����ϴ�!');";
			$value_btn_right = "
				if (event.button == 2) { 
					$msg
					return false;
				}
			";
		}
		if ($mode[key_ctrl] == 'Y') {
			$msg = "alert('CtrlŰ�� ����� �� �����ϴ�.');";
			$value_key_ctrl = "
				if (event.ctrlKey == true ){
					$msg
					return false;
				}
			";
		}
		if ($mode[key_alt] == 'Y') {
			$msg = "alert('AltŰ�� ����� �� �����ϴ�.');";
			$value_key_alt = "
				if (event.altKey == true ){
					$msg
					return false;
				}
			";
		}

		$value = "
			<script language='javascript1.2'>
			<!--
				function click_ie() { 
					$value_btn_left
					$value_btn_right
					$value_key_ctrl
					$value_key_alt
				}
				if (navigator.appName == 'Netscape') { 
					document.captureEvents(Event.MOUSEDOWN); 
					document.onmousedown = check_ns;
				} else {
					document.onmousedown = click_ie;
					document.onkeydown = click_ie;
				}
			//-->
			</script>
		";
		return $value;
	}

	// URL ���� get ���� �����Լ�
	function get_change_var_url($source, $change_vars) {
		parse_str($source, $get_vars);									// $_SERVER[QUERY_STRING] �� �̸��� Ű���� ���� �迭�� �����.
		$new_query_string = '';
		while (list($key, $value) = each($get_vars)) {	// �� Ű��(GET ������) ��ŭ �ݺ��ϸ� ���ڷ� �Ѿ�� ������ �� ������
			if (isset($change_vars[$key])) {								// url �����߿� ������ Ű ���� �ִ� ���
				if ($change_vars[$key] == '') continue;			// �ش� Ű ���� ���� ��� �ش� ������ ������Ŵ
				$value = $change_vars[$key];							// �� ���� ������
				$change_vars[$key] = '';
			}
			$new_query_string .= "{$key}={$value}&";
		}
		while (list($key, $value) = each($change_vars)) {	// �ٲ�� ������ ������ ���� $_SERVER[QUERY_STRING] �� ���� ������ �߰� �Ѵ�.
			if ($value != '') $new_query_string .= "{$key}={$value}&";
		}
		$new_query_string = substr($new_query_string, 0, -1);
		return $new_query_string;
	}

	// ��¥ ����Լ�
	function get_input_date($date, $date_format="y-m-d") {
		if ($date != '' && $date != 0) return date($date_format, $date);
		else return '-';
	}

	function get_page_block($query, $ppa, $ppb, $page, $style, $font, $img_dir='', $link_file='', $unlink_view='N', $var_name_page='page', $total_type='C', $change_vars=array()) {
		if ($page <= 0) $T_page = 1;
		else $T_page = $page;
		$result = $this->querying($query);
		$ppb_value = array();
		if ($total_type == 'C') $ppb_value = mysql_fetch_row($result);	// ����� ����(�� ���ڵ�� ���)�� ����
		else $ppb_value[] = mysql_num_rows($result);									// ����� ���ڵ� ���� �� ������ ����
		$total = $ppb_value[0];
		$total_page = ceil($total / $ppa);
		if ($total_page == 0) return '';
		if ($T_page > $total_page) $T_page = $total_page;
		if ($style[0] == '') $style[0] = "[";
		if ($style[1] == '') $style[1] = "]";
		if ($style[2] == '') $style_2_src = "{$img_dir}list_first.gif";
		else $style_2_src = $style[2];
		if ($style[3] == '') $style_3_src = "{$img_dir}list_prev.gif";
		else $style_3_src = $style[3];
		if ($style[4] == '') $style_4_src = "{$img_dir}list_next.gif";
		else $style_4_src = $style[4];
		if ($style[5] == '') $style_5_src = "{$img_dir}list_last.gif";
		else $style_5_src = $style[5];
		if ($font != '') {
			$open_font = "<font{$font}>";
			$close_font = "</font>";
		}
		if ($link_file == '') $link_file = $PHP_SELF;
		$current_page_block = floor($T_page / $ppb);	// ������������
		if (is_int($T_page/$ppb)) $current_page_block = $current_page_block - 1;	// ���ɸ��� �������� �����������.
		$page_link_list = '';
		for($i = 1; $i<=$ppb; $i++) {
			$page_link = $current_page_block * $ppb + $i;	// ���� ������ ǥ�õ� �������� ����Ѵ�.
			$change_vars["$var_name_page"] = $page_link;
			$link = $link_file . "?" . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "#{$var_name_page}_top";
			if ($page_link == $T_page) $page_link_list .= "<font color='red'><b><span class='page_block_current'>{$style[0]}{$page_link}{$style[1]}</span></b></font>";
			else $page_link_list .= "<a href=\"{$link}\">{$open_font}<span class='page_block'>{$style[0]}{$page_link}{$style[1]}</span>{$close_font}</a>";	// <a name=''> �±׸� �̿��Ͽ� ���� ��ġ�� ǥ���� ��� ������ �̵��� Ư�� ��ġ�� ��ų �� �ֵ��� �Ѵ�.
			$page_link_list .= " ";
			if($page_link == $total_page) break;		// ���� �������� ��ü ���������� Ŀ���� ������ ����������.
		}
		if ($T_page > 1) {
			$temp = $T_page - 1;
			$change_vars["$var_name_page"] = $temp;
			$link = $link_file . "?" . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_3_src' border='0' align='absmiddle'></a> " . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_3_src' border='0' align='absmiddle'>" . $page_link_list;
		}
		$pre_block = $current_page_block * $ppb;	// ���� ���� ǥ�õ� �������� ����Ѵ�.
		if ($current_page_block > 0) {		// ���� ���� ���� �ϸ� ���������� �̵��� �� �ִ� ��ũ�� ����Ѵ�.
			$change_vars["$var_name_page"] = $pre_block;
			$link = $link_file . "?" . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_2_src' border='0' align='absmiddle'></a>&nbsp;" . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_2_src' border='0' align='absmiddle'>&nbsp;{$page_link_list} ";
		}
		if ($T_page < $total_page) {
			$temp = $T_page + 1;
			$change_vars["$var_name_page"] = $temp;
			$link = $link_file . "?" . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = $page_link_list . "<a href=\"{$link}\"><img src='$style_4_src' border='0' align='absmiddle'> </a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = $page_link_list . "<img src='$style_4_src' border='0' align='absmiddle'>";
		}
		$next_block = ($current_page_block+1) * $ppb+ 1; // ���� ���� ù �������� ����Ѵ�.
		if ($next_block <= $total_page) {
			$change_vars["$var_name_page"] = $next_block;
			$link = $link_file . "?" . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = $page_link_list . "&nbsp;<a href='{$link}'><img src='$style_5_src' border='0' align='absmiddle'></a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = " {$page_link_list}&nbsp;<img src='$style_5_src' border='0' align='absmiddle'>";
		}
		$return_value = array($page_link_list, $ppb_value, $T_page, $total_page);
		return $return_value;
	}

	// �Ӽ����� �м��ؼ� �����迭�� �Ѱ��ִ� �Լ�
	function parse_property($property, $div_1, $div_2, $define_property, $str_lower_mode='Y', $str_trim_mode='N') {
		$return_value = array();
		$exp = explode($div_1, $property);
		for ($i=0; $i<sizeof($exp); $i++) {
			$exp_1 = explode($div_2, $exp[$i]);
			if ($str_lower_mode == 'Y') $exp_1[0] = strtolower($exp_1[0]);
			if ($str_trim_mode == 'Y') $exp_1[1] = trim($exp_1[1]);
			if ($define_property != '') {
				if (!is_int(array_search($exp_1[0], $define_property)))	$return_value[etc] .= ' ' . trim($exp[$i]);
				else $return_value[$exp_1[0]] = $exp_1[1];
			} else {
				$return_value[$exp_1[0]] = $exp_1[1];
			}
		}
		if ($return_value[etc] != '') $return_value[etc] = trim($return_value[etc]);
		return $return_value;
	}

	// �����ڿ� ���� ���е� ���� �ڵ尪�� �������� ������
	// $return_type : [0] => Ÿ��(T, A), [1] => [0]�� T �� ��� ������
	function codes_values($saved_values, $divider, $codes, $return_type) {
		$T_exp = explode($divider, $saved_values);
		$code_value = array();
		for ($i=0; $i<sizeof($T_exp); $i++) {
			if (trim($codes[$T_exp[$i]]) != '') $code_value[] = $codes[$T_exp[$i]];
		}
		if ($return_type[0] == 'A') return $code_value;
		else return implode($return_type[1], $code_value);
	}

	// �����迭�� Ű�� ���� �־��� �����ڷ� ����� ���ڿ��� ��ȯ
	function get_string_r_array($r_array, $div_key_value, $div_index, $option=array()) {
		$T_index = array();
		while (list($key, $value) = each($r_array)) {
			$T_index[] = "{$option[FR_key]}{$key}{$option[FR_key]}={$option[FR_value]}{$value}{$option[FR_value]}";
		}
		if (sizeof($T_index) == 0) return false;
		else return implode($div_index, $T_index);
	}

	function make_nw_property($url, $property) {
		$exp = explode(",", $property);
		$window_real_pp = '';
		for ($i=0; $i<sizeof($exp); $i++) $exp[$i] = trim($exp[$i]);
		if ($exp[1] != '') $window_real_pp .= "top=$exp[1],";
		if ($exp[2] != '') $window_real_pp .= "left=$exp[2],";
		if ($exp[3] != '') $window_real_pp .= "width=$exp[3],";
		if ($exp[4] != '') $window_real_pp .= "height=$exp[4],";
		if ($exp[5] != '') $window_real_pp .= "resizable=$exp[5],";
		if ($exp[6] != '') $window_real_pp .= "status=$exp[6],";
		if ($exp[7] != '') $window_real_pp .= "scrollbars=$exp[7],";
		if ($exp[8] != '') $window_real_pp .= "menubar=$exp[8],";
		if ($exp[9] != '') $window_real_pp .= "toolbar=$exp[9],";
		if ($exp[10] != '') $window_real_pp .= "location=$exp[10],";
		if ($exp[11] != '') $window_real_pp .= "directories=$exp[11],";
		$window_real_pp = substr($window_real_pp, 0, -1);
		$win_open_tag = "window.open('$url','$exp[0]', '$window_real_pp')";
		return $win_open_tag;
	}
	
	// �����۸�ũ �Լ�
	function make_link($value, $url, $target='', $nw_property='', $link_pp='', $link_type='') {
		if ($link_pp != '') $link_pp = " " . $link_pp;
		if ($target != "_nw") {
			if ($target != '') $target = " target=\"$target\"";
			else $target = '';
			$link_value = "<a href=\"$url\"{$target}{$link_pp}>$value</a>";
		} else {
			$win_open_tag = $this->make_nw_property($url, $nw_property);
			if ($link_type == "#") $link_value = "<a href='#;' onclick=\"javascript:{$win_open_tag}.focus()\"{$link_pp}>$value</a>";
			else $link_value = "<a href=\"javascript:{$win_open_tag}.focus()\"{$link_pp}>$value</a>";
		}
		return $link_value;
	}

	// ���ڿ� �ڸ����Լ�
	function str_cutstring($str, $num, $tail="...") { 
		$strip_tag_str = strip_tags($str);	// html �±�����
		if (strlen($strip_tag_str) < $num) return $str; //�ڸ� ���̺��� ���ڿ��� ������ �׳� ���� 
		for ($i=0; $i<$num-1; $i++) if (ord($strip_tag_str[$i])>127) $i++; //�ѱ��� ��� 2byte �ű� 
		if (ord($strip_tag_str[$num-1])<127) $i++; //������ ���ڰ� �ѹ���Ʈ ������ �� 
		return substr($strip_tag_str,0,$i).$tail; 
	}

	function alert_url($msg, $rtnc='E', $url='', $target="document", $etc_script='') {
		if ($target != '') {
			if ($url == '') {
				$url = "history.go(-1);\n";
			} else {
				$url = "$target.location.href = '$url';\n";
			}
		}
		if ($msg != '') $alert_msg = "alert('$msg');\n";
		echo ("<script language='javascript'>{$alert_msg}\n{$url}\n{$etc_script}</script>");
		if ($rtnc == "E") exit;
	}
	
	function meta_url($url, $delay_second=0, $msg='') {
		if ($msg != '') echo($msg);
		if ($url != '') echo("<meta http-equiv=\"refresh\" content=\"{$delay_second};url=$url\">");
		exit;
	}

	// ���� �޽��� ����� ���� ����
	function die_msg($msg) {
		if ($GLOBALS[VI][die_skin] != '' && is_file($GLOBALS[VI][die_skin])) {
			$fp = fopen ($GLOBALS[VI][die_skin], "r");
			$skin_contents = fread($fp, 10000);
			fclose ($fp); 
			$msg = str_replace("%MESSAGE%", $msg, $skin_contents);
		}
		die($msg);
	}

	// ��ó jboard.
	function auto_link($str, $opt='') {
		$regex['file'] = "gz|tgz|tar|gzip|zip|rar|mpeg|mpg|exe|rpm|dep|rm|ram|asf|ace|viv|avi|mid|gif|jpg|png|bmp|eps|mov";
		$regex['file'] = "(\.({$regex['file']})\") TARGET=\"_blank\"";
		$regex['http'] = "(http|https|ftp|telnet|news|mms):\/\/(([\xA1-\xFEa-z0-9:_\-]+\.[\xA1-\xFEa-z0-9,:;&#=_~%\[\]?\/.,+\-]+)([.]*[\/a-z0-9\[\]]|=[\xA1-\xFE]+))";
		$regex['mail'] = "([\xA1-\xFEa-z0-9_.-]+)@([\xA1-\xFEa-z0-9_-]+\.[\xA1-\xFEa-z0-9._-]*[a-z]{2,3}(\?[\xA1-\xFEa-z0-9=&\?]+)*)";

		# &lt; �� �����ؼ� 3�ٵڿ� &gt; �� ���� ����
		# IMG tag �� A tag �� ��� ��ũ�� �����ٿ� ���� �̷���� ���� ���
		# �̸� ���ٷ� ��ħ (��ġ�鼭 �ΰ� �ɼǵ��� ��� ������)
		$src[] = "/<([^<>\n]*)\n([^<>\n]+)\n([^<>\n]*)>/i";
		$tar[] = "<\\1\\2\\3>";
		$src[] = "/<([^<>\n]*)\n([^\n<>]*)>/i";
		$tar[] = "<\\1\\2>";
		$src[] = "/<(A|IMG)[^>]*(HREF|SRC)[^=]*=[ '\"\n]*({$regex['http']}|mailto:{$regex['mail']})[^>]*>/i";
		$tar[] = "<\\1 \\2=\"\\3\">";

		# email �����̳� URL �� ���Ե� ��� URL ��ȣ�� ���� @ �� ġȯ
		$src[] = "/(http|https|ftp|telnet|news|mms):\/\/([^ \n@]+)@/i";
		$tar[] = "\\1://\\2_HTTPAT_\\3";

		# Ư�� ���ڸ� ġȯ �� html���� link ��ȣ
		$src[] = "/&(quot|gt|lt)/i";
		$tar[] = "!\\1";
		$src[] = "/<a([^>]*)href=[\"' ]*({$regex['http']})[\"']*[^>]*>/i";
		$tar[] = "<A\\1HREF=\"\\3_orig://\\4\" TARGET=\"_blank\">";
		$src[] = "/href=[\"' ]*mailto:({$regex['mail']})[\"']*>/i";
		$tar[] = "HREF=\"mailto:\\2#-#\\3\">";
		$src[] = "/<([^>]*)(background|codebase|src)[ \n]*=[\n\"' ]*({$regex['http']})[\"']*/i";
		$tar[] = "<\\1\\2=\"\\4_orig://\\5\"";

		# ��ũ�� �ȵ� url�� email address �ڵ���ũ
		$src[] = "/((SRC|HREF|BASE|GROUND)[ ]*=[ ]*|[^=]|^)({$regex['http']})/i";
		if ($opt == '') $tar[] = "\\1<A HREF='#' ONCLICK=\"window.open('\\3', 'AUTO_LINK', 'left=0,top=0,width=1024,height=768,scrollbars=1,resizable=1')\">\\3</a>";
		else if ($opt == "common") $tar[] = "\\1<A HREF=\"\\3\" TARGET=\"_blank\">\\3</a>";
		$src[] = "/({$regex['mail']})/i";
		$tar[] = "<A HREF=\"mailto:\\1\">\\1</a>";
		$src[] = "/<A HREF=[^>]+>(<A HREF=[^>]+>)/i";
		$tar[] = "\\1";
		$src[] = "/<\/A><\/A>/i";
		$tar[] = "</A>";

		# ��ȣ�� ���� ġȯ�� �͵��� ����
		$src[] = "/!(quot|gt|lt)/i";
		$tar[] = "&\\1";
		$src[] = "/(http|https|ftp|telnet|news|mms)_orig/i";
		$tar[] = "\\1";
		$src[] = "'#-#'";
		$tar[] = "@";
		$src[] = "/{$regex['file']}/i";
		$tar[] = "\\1";

		# �̹����� ������ 0 �� ����
		$src[] = "/<(IMG SRC=\"[^\"]+\")>/i";
		$tar[] = "<\\1 BORDER=0>";

		$str = preg_replace($src, $tar, $str);
		return $str;
	}

	// �ؽ�Ʈ�� �Ѿ�� ��¥�� Ÿ�ӽ������� ��ȯ
	function str_date_to_time_stamp($str, $divider='') {
		if ($divider[date_time] == '') $divider[date_time] = ',';
		if ($divider[ymd] == '') $divider[ymd] = '-';
		if ($divider[his] == '') $divider[his] = ':';
		$pvf_exp = explode($divider[date_time], $str);
		$pvf_ymd = explode($divider[ymd], $pvf_exp[0]);
		$pvf_his = explode($divider[his], $pvf_exp[1]);
		return mktime($pvf_his[0], $pvf_his[1], $pvf_his[2], $pvf_ymd[1], $pvf_ymd[2], $pvf_ymd[0]);
	}

//	 �������̽� ����	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// ���ϳ����� �ٷ� �����ִ� �Լ�
	function view_files($file_name, $dir='', $pp) {
		$exp = explode('.', $file_name);
		$extention = strtolower($exp[sizeof($exp)-1]);
		switch (strtolower($extention)) {
			case "png" :
			case "gif" :
			case "jpg" :
			case "jpeg" :
				$img_src = $dir . urlencode($file_name);
				$size_method = $pp[1];
				$use_thumb = $pp[2];
				$input_width = $pp[0][width];
				$input_height = $pp[0][height];
				if ($size_method == 'A') {	// ��� ũ�����ΰ��
					$img_size = @getimagesize($img_src);
					if ($input_width != '') {		// �Է°��� �ִ°�츸
						if ($input_width > $img_size[0]) $width = $img_size[0];		// �̹��� ũ�Ⱑ �Է� ũ�⺸�� ������� �̹��� ũ���� ����
						else $width = $input_width;																	// �׷��� ���� ��� ���� �Է°����� ����
					}
					if ($input_height != '') {
						if ($input_height > $img_size[1]) $height = $img_size[1];
						else $height = $input_height;
					}
				} else {	// ����ũ�� ����ΰ��
					if ($input_width != "") $width = $input_width;
					if ($input_height != "") $height = $input_height;
				}
				$target_info[width] = $width;
				$target_info[height] = $height;
				if ($pp[0][border] != '') $border = $target_info[border] = $pp[0][border];
				if ($pp[0][align] != '') $align = $target_info[border] = $pp[0][align];
				if ($pp[0][etc] != '') $target_info[etc] = $pp[0][etc];
				if ($use_thumb != 'Y') {
					if ($width != '') $width = "width='$width' ";
					if ($height != '') $height = "height='$height' ";
					if ($border != '') $border = "border='$border' ";
					if ($align != '') $align = "align='$align' ";
					$property = "{$width}{$height}{$border}{$align}{$pp[0][etc]}";
					$value = "<img src='{$img_src}' $property>";
				} else {
					$target_info[dir] = $dir;
					$option = array("over_write"=>'N');
					$value = $this->get_thumb_nail($img_src, $target_info, $option);
				}
			break;
			case "swf" :
				$input_width = $pp[0][width];
				$input_height = $pp[0][height];
				$value = "<script src='/flash_viewer.js.php?file_name={$dir}{$file_name}&width=$input_width&height=$input_height&align={$pp[0][align]}&wmode={$pp[0][etc]}'></script>";
			break;
			default :
				$value = $file_name;
			break;
		}
		return $value;
	}
	
	// ���� Ȯ���ڿ� ���� �������� �����ϴ� �Լ�
	function make_file_ext_icon($file_name, $img_dir='') {
		$exp = explode('.', $file_name);
		$extention = strtolower($exp[sizeof($exp)-1]);
		$icon_src = "{$img_dir}{$extention}.gif";
		if (file_exists($icon_src)) $value = "<img src='$icon_src' border=0 align='absmiddle'>";
		else $value = "<img src='{$img_dir}default.gif' border=0 align='absmiddle'>";
		return $value;
	}

	// �ش� ����� ���� �� ��¥ ��� �Լ�
	function get_month_days($year, $month) {
		$day = 1;
		while (checkdate($month, $day, $year)) $day++;
		$day--;
		return $day;
	}

	// ��/�� ���ý� ������ �̵�
	function get_year_month_move($move_page='$PHP_SELF', $tails=array("��", "��")) {
		$CD_start_year = 2000;
		$CD_end_year = 2020;
		$tag = "
			<script language='javascript1.2'>
			<!--
				function change_month(selObj, url) {
					sel_CD_year = document.all.CD_year;
					select_year = sel_CD_year.options[sel_CD_year.selectedIndex].value;
					select_month = selObj.options[selObj.selectedIndex].value;
					document.location.href = url + '&CD_year=' + select_year + '&CD_month=' + select_month;
				}

				function change_year(selObj, url) {
					sel_CD_month = document.all.CD_month;
					select_month = sel_CD_month.options[sel_CD_month.selectedIndex].value;
					select_year = selObj.options[selObj.selectedIndex].value;
					document.location.href = url + '&CD_year=' + select_year + '&CD_month=' + select_month;
				}
			//-->
			</script>
		";

		// ������ ���� ������(�������� �ʾ����� ���ÿ� �ش�Ǵ� ���� ����)
		$CD_today = getdate(time());
		if (!$_GET[CD_year]) $CD_year = $CD_today[year];
		else $CD_year = $_GET[CD_year];
		if (!$_GET[CD_month]) $CD_month = $CD_today[mon];
		else $CD_month = $_GET[CD_month];
		if (!$_GET[CD_day]) $CD_day = $CD_today[mday];
		else $CD_day = $_GET[CD_day];

		$CD_select_tag_year = "<select name='CD_year' onchange=\"change_year(this, '$move_page?$_SERVER[QUERY_STRING]')\">";
		for ($CD_i=$CD_start_year; $CD_i<=$CD_end_year; $CD_i++) {
			if ($CD_i == $CD_year) $is_selected = " selected";
			else $is_selected = '';
			$CD_select_tag_year .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
		}
		$CD_select_tag_year .= "</select>{$tails[0]}";

		$_SERVER[QUERY_STRING] = ereg_replace("&CD_year=[0-9]*", '', $_SERVER[QUERY_STRING]);
		$_SERVER[QUERY_STRING] = ereg_replace("&CD_month=[0-9]*", '', $_SERVER[QUERY_STRING]);
		$CD_select_tag_month = "<select name='CD_month' onchange=\"change_month(this, '$move_page?$_SERVER[QUERY_STRING]')\">";
		for ($CD_i=1; $CD_i<=12; $CD_i++) {
			if ($CD_i == $CD_month) $is_selected = " selected";
			else $is_selected = '';
			$CD_select_tag_month .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
		}
		$CD_select_tag_month .= "</select>{$tails[1]}";
		return $tag . $CD_select_tag_year . $CD_select_tag_month;
	}

	// ���Ͼ��ε� ����
	function get_file_upload_box($name, $number, $default_value, $property='', $file_dir='') {
		$user_file_serial = $number;
		$name .= "_" . $user_file_serial;
		$file_upload_box = $this->make_input_box('', $name, "file", $property, '');
		$saved_user_file_value = explode(";", $default_value);
		if ($saved_user_file_value[$user_file_serial-1] != '') {				
			$etc_tag = "<br>" . $this->make_input_box($saved_user_file_value[$user_file_serial-1], "saved_{$name}", "text", "size=20 readonly class='designer_text'", '');
			$etc_tag .= "<input type='checkbox' name='delete_file_{$name}' value='Y' class='designer_button' onclick=\"if (this.checked == true) this.form.saved_{$name}.value=''; else this.form.saved_{$name}.value=this.form.saved_{$name}.defaultValue;\" id='chk_box_delete_{$name}'><label for='chk_box_delete_{$name}'>����</label>";
			if ($file_dir != '') {
				if (substr($file_dir, -1) == '/') $file_dir = substr($file_dir, 0, -1);		// ������ / ����
				if (substr($file_dir, 0, 1) == '.') $real_file_dir = $file_dir;						// ��� ����ΰ�� �״��
				else $real_file_dir = "{$root}{$file_dir}";													// �׷��� ���� ��� ��Ʈ�� ����		
				$link_preview_upload_file = "{$real_file_dir}/{$saved_user_file_value[$user_file_serial-1]}";
				$T_exp = explode('.', $saved_user_file_value[$user_file_serial-1]);
				$extention = $T_exp[sizeof($T_exp)-1];
				if (in_array($extention, $GLOBALS[VI][img_ext])) $etc_tag .= " <input type='button' value='�̸�����' class='designer_button' onclick=\"window.open('$link_preview_upload_file','preview_upload_file')\">";
				else $etc_tag .= " <input type='button' value='�ٿ�ε�' class='designer_button' onclick=\"window.open('$link_preview_upload_file','preview_upload_file')\">";
			}
			$GLOBALS[JS_CODE][DELETE_ITEM] = "Y";
		}
		return $file_upload_box . $etc_tag;
	}

	// ���� ������ư ����� �Լ�(�����迭 ����)
	function get_radio_array($list_value, $name, $default_value, $property='', $divider='') {
		$T_is_checked= '';
		$T_option = $list_value;
		$option_name = $option_value = array();
		while(list($key, $value) = each($T_option)) {
			if ($key == '') continue;
			$option_name[] = $value;
			$option_value[] = $key;
		}
		$checked_value = str_replace("'", '', $default_value);
		$checked_value = str_replace("\"", '', $checked_value);
		if ($property != '') $property = ' ' . $property;
		for ($i=0; $i<sizeof($option_value); $i++) {
			$trimed_name = trim($option_name[$i]);
			$trimed_value = trim($option_value[$i]);
			if ($trimed_name== '') continue;
			if ($trimed_value == trim($checked_value)) $T_is_checked = " checked";
			else $T_is_checked = '';
			$input_type .= "<input type='radio' name='$name' value='$trimed_value'{$property}{$T_is_checked}>{$trimed_name}{$divider}";
		}
		if ($divider != '') $input_type = substr($input_type, 0, -strlen($divider));
		return $input_type;
	}

	// üũ���� �̹��� ��ȯ
	function get_checked_img($is_checked) {
		if (!strcmp(trim($is_checked), "checked")) $is_checked = 'Y';
		if ($is_checked == 'Y') $img_tag = "<img src='{$GLOBALS[VI][protocol]}://{$_SERVER[HTTP_HOST]}/designer/images/img_check.gif' border='0' align='absmiddle'>";
		else $img_tag = "<img src='{$GLOBALS[VI][protocol]}://{$_SERVER[HTTP_HOST]}/designer/images/img_check_no.gif' border='0' align='absmiddle'>";
		return $img_tag;
	}

	// ���� üũ���ڸ� ����� �Լ� <checkbox>
	function get_checkbox_array($list_value, $name, $default_value, $property='', $divider='', $no_script='N', $option_pp='') {
		$multi_sep = $GLOBALS[DV][ct2];
		$T_is_checked = '';
		$T_option = $list_value;
		$new_name = $name . "_multi[]";
		$option_name = $option_value = array();
		while(list($key, $value) = each($T_option)) {
			if ($key == '') continue;
			$option_name[] = $value;
			$option_value[] = $key;
		}
		$checked_value = str_replace("'", '', $default_value);
		$checked_value = str_replace("\"", '', $checked_value);
		if ($property != '') $property = ' ' . $property;
		for ($i=0; $i<sizeof($option_value); $i++) {
			$trimed_name = trim($option_name[$i]);
			$trimed_value = trim($option_value[$i]);
			if ($trimed_name== '') continue;
			if (!is_array($default_value)) {
				if ($trimed_value == trim($checked_value)) $T_is_checked = " checked";
				else $T_is_checked = '';
			} else {
				if ($trimed_value != '' && is_int(array_search($trimed_value, $checked_value))) $T_is_checked = " checked";
				else $T_is_checked = '';
			}
			if ($no_script == 'N') {
				$script = " onclick=\"multi_check(this.form, '" . substr($new_name, 0, -2) . "', '$name', '$multi_sep')\"";
				$input_type .= "<input type='checkbox' name='$new_name' value='$trimed_value'{$script}{$property}{$T_is_checked}>{$trimed_name}{$divider}";
			} else {
				$script = '';
				$input_type .= $this->get_checked_img($T_is_checked) . " {$trimed_name}{$divider}";
			}
			
		}
		if ($divider != '') $input_type = substr($input_type, 0, -strlen($divider));
		if ($default_value != '' && is_array($default_value)) $O_default_value = implode($multi_sep, $default_value);
		else $O_default_value = $default_value;
		if ($no_script == 'N') $input_type .= "<input type='hidden' name='$name' value='$O_default_value'>";
		$GLOBALS[JS_CODE][MULTI_CHECK] = "Y";
		return $input_type;
	}

	// ���� ���û��� ����� �Լ�(�����迭 ����)
	function get_list_boxs_array($list_value, $name, $default_value, $exist_null='Y', $property='', $default_num_msg=":: ���� ::", $option_pp='', $multi_sep='') {
		$T_option = $list_value;
		$option_name = $option_value = array();
		if (eregi("multiple", $property)) {
			if ($multi_sep == '') $multi_sep = $GLOBALS[DV][ct2];
			$new_name = $name . "_multi";
			$etc_tag = "<input type='hidden' name='$name' value='$default_value'>";
			$property .= " onchange=\"multi_select(this.form, '$new_name', '$name', '$multi_sep')\"";
			$GLOBALS[JS_CODE][MULTI_SELECT] = "Y";
			$default_value = explode($multi_sep, $default_value);
		} else {
			$new_name = $name;
		}
		if ($exist_null == 'Y') {
			$option_name[] = $default_num_msg;
			$option_value[] = '';
		}
		while(list($key, $value) = each($T_option)) {
			$option_name[] = $value;
			$option_value[] = $key;
		}
		return $this->make_list_box($new_name, $option_name, $option_value, '', $default_value, $property, '', $option_pp) . $etc_tag;
	}

	// ���� ���û��� ����� �Լ�(������ ����)
	// $query_info = array($query, $option_value_field, $option_name_field, $option_name_tail_field)
	function get_list_boxs_query($query_info, $name, $default_value, $not_null="N", $only_print="N", $property="class='designer_select'", $style='', $default_num_msg=":: ���� ::", $option_pp='') {
		$option_name = $option_value = array();
		if ($not_null == "N") {
			$option_name[] = $default_num_msg;
			$option_value[] = '';
		}
		$query = $query_info[0];
		$serial_field = $query_info[1];
		$name_field = $query_info[2];
		$etc_field = $query_info[3];
		$result = $this->querying($query);
		while ($value = mysql_fetch_array($result)) {
			if ($value[$etc_field] != '') $etc_field_print = ", $value[$etc_field]";
			else $etc_field_print = '';
			$option_name[] = $value[$name_field] . $etc_field_print;
			$option_value[] = $value[$serial_field];
			if ($only_print == "Y") {
				if ($value[$serial_field] == $default_value) return $value[$name_field];
			}
		}
		return $this->make_list_box($name, $option_name, $option_value, '', $default_value, $property, $style, $option_pp);
	}

	// 2���з� �ڵ� ���û��� ����
	function get_item_select_box($category_1_array, $category_2_array, $property, $option_pp='') {
		$P_select_box_name = $P_select_box_value = array();
		while (list($key, $value) = each($category_1_array)) {
			$T_option_name = $T_option_value = array();
			while (list($key_1, $value_1) = each($category_2_array[$key])) {
				$T_option_name[] = "'{$value_1}'";
				$T_option_value[] = "'{$key_1}'";
			}
			$P_select_box_name[] = "option_name_{$property[form_name]}_{$key} = [" . implode(',', $T_option_name) . "];\n";
			$P_select_box_value[] = "option_value_{$property[form_name]}_{$key} = [" . implode(',', $T_option_value) . "];\n";
		}
		$select_box_1 = $GLOBALS[lib_common]->get_list_boxs_array($category_1_array, $property[name_1], $property[default_value_1], 'Y', $property[property_1] . " onchange=\"select_category_1(this.form, '{$property[name_2]}', this, '{$property[form_name]}', '{$property[default_title_2]}')\"", $property[default_title_1], $option_pp);
		if (is_array($category_2_array[$property[default_value_1]])) $category_2_array_selected = $category_2_array[$property[default_value_1]];
		else $category_2_array_selected = array();
		$select_box_2 = $GLOBALS[lib_common]->get_list_boxs_array($category_2_array_selected, $property[name_2], $property[default_value_2], 'Y', $property[property_2], $property[default_title_2], $option_pp);
		$select_box_script = "
			<script>
				" . implode("\n", $P_select_box_name) . implode("\n", $P_select_box_value) . "
			</script>
		";
		return array($select_box_1, $select_box_2, $select_box_script);
	}

	// ���û��ڸ� ����� �Լ� <select>
	function make_list_box($name, $option_name, $option_value, $selected_name, $selected_value, $property='', $style='', $option_pp='') {
		$T_isSelected = '';
		$selected_name = str_replace("'", '', $selected_name);
		$selected_name = str_replace("\"", '', $selected_name);
		
		$selected_value = str_replace("'", '', $selected_value);
		$selected_value = str_replace("\"", '', $selected_value);

		if ($property != '') $property = " " . $property;
		if ($style != '') $style = " style='" . $style . "'";
		$input_type = "<select name='$name'{$property}{$style}>\n";
		if ($selected_name != '') {	 // 
			for ($i=0; $i<sizeof($option_name); $i++) {
				$trimed_name = trim($option_name[$i]);
				$trimed_value = trim($option_value[$i]);
				if ($trimed_name == '') continue;
				if (!is_array($selected_name)) {
					if ($trimed_value != '' && $trimed_name == trim($selected_name)) $T_isSelected = " selected";
					else $T_isSelected = '';
				} else {
					if ($trimed_value != '' && array_search($trimed_name, $selected_name)) $T_isSelected = " selected";
					else $T_isSelected = '';
				}
				$input_type .= "<option value=\"$trimed_value\"{$T_isSelected} {$option_pp[$i]}>$trimed_name</option>\n";
			}
		} else {
			for ($i=0; $i<sizeof($option_value); $i++) {
				$trimed_name = trim($option_name[$i]);
				$trimed_value = trim($option_value[$i]);
				if ($trimed_name== '') continue;
				if (!is_array($selected_value)) {
					if ($trimed_value != '' && $trimed_value == trim($selected_value)) $T_isSelected = " selected";
					else $T_isSelected = '';
				} else {
					if ($trimed_value != '' && is_int(array_search($trimed_value, $selected_value))) $T_isSelected = " selected";
					else $T_isSelected = '';
				}
				$input_type .= "<option value=\"$trimed_value\"{$T_isSelected} {$option_pp[$i]}>$trimed_name</option>\n";
			}
		}
		$input_type .= "</select>";
		return $input_type;
	}

	// �Է»��ڸ� ����� �Լ� :  text, textarea, checkbox, radio
	function make_input_box($value, $name, $type, $property, $style='', $default_value='Y', $is_strip_slashes='Y') {
		if ($style != '') $style = " style='$style'";
		if ($property != '') $property = " " . $property;
		if ($is_strip_slashes == "Y") $value = stripslashes($value);
		$value = htmlspecialchars($value);
		switch ($type) {
			case 'text' :
				$input_box = "<input type=\"text\" name=\"$name\" value=\"$value\"{$property}{$style}>";
			break;
			case 'password' :
				$input_box = "<input type=\"password\" name=\"$name\" value=\"$value\"{$property}{$style}>";
			break;
			case 'textarea' :
				$input_box = "<textarea name=\"$name\"{$property}{$style}>$value</textarea>";
			break;
			case 'checkbox' :
				if ($default_value != '' && $value == $default_value) $property .= " checked";
				$input_box = "<input type=\"checkbox\" name=\"$name\" value=\"$default_value\"{$property}{$style}>";
			break;
			case 'radio' :
				if ($default_value != '' && $value == $default_value && $value != '' && !eregi("disabled", $property)) $property .= " checked";
				$input_box = "<input type='radio' name=\"$name\" value=\"$default_value\"{$property}{$style}>";
			break;
			case 'file' :
				$input_box = "<input type=\"file\" name=\"$name\"{$property}{$style}>";
			break;
			case 'button' :
				$input_box = "<input type=\"button\" name=\"$name\" value=\"$value\"{$property}{$style}>";
			break;
			case 'reset' :
				$input_box = "<input type=\"reset\" name=\"$name\" value=\"$value\"{$property}{$style}>";
				break;
			case 'submit' :
				$input_box = "<input type=\"submit\" name=\"$name\" value=\"$value\"{$property}{$style}>";
			break;
			case 'hidden' :
				$input_box = "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
			break;
			case "html" :
				global $DIRS;
				$default_text_value = $value;
				$field_name_input_box = $name;
				include "{$DIRS[designer_root]}include/paste_input_box.inc.php"; 
			break;
			case "calendar" :
				$input_box = $this->make_date_input_box($name . "_chk", $name, $value, 0, "����", '', $property, 'Y');
			break;
		}
		return $input_box;
	}
	
	/* ��¥ ���� ����
	$today = getdate(time());
	$property = array("class=input_select", "class=input_select", "class=input_select");
	$print_info = array('Y'=>array("2005", "2008", $today[year], "�� "), 'M'=>array("1", "12", $today[mon], "�� "), 'D'=>array("1", "31", $today[mday], "�� "), 'H'=>array("1", "24", $today[hours], "�� "));
	$option_null = array('Y'=>"---", 'M'=>"===");
	*/
	function get_date_select_box($name, $print_info, $property, $option_null=array()) {
		$select_boxs = '';
		while (list($key, $value) = each($print_info)) {
			if ($option_null[$key] != '') {
				$option_name = array($option_null[$key]);
				$option_value = array('');
			} else {
				$option_name = $option_value = array();
			}
			switch ($key) {
				case 'Y' :
					for ($SSE_i=$value[0]; $SSE_i<=$value[1]; $SSE_i++) {
						$option_name[] = $option_value[] = $SSE_i;
					}
					$select_boxs .= $this->make_list_box($name . "_year", $option_name, $option_value, '', $value[2], $property[0]) . $value[3];
				break;
				case 'M' :
					for ($SSE_i=$value[0]; $SSE_i<=$value[1]; $SSE_i++) {
						$option_name[] = $option_value[] = $SSE_i;
					}
					$select_boxs .= $this->make_list_box($name . "_month", $option_name, $option_value, '', $value[2], $property[1]) . $value[3];
				break;
				case 'D' :
					for ($SSE_i=$value[0]; $SSE_i<=$value[1]; $SSE_i++) {
						$option_name[] = $option_value[] = $SSE_i;
					}
					$select_boxs .= $this->make_list_box($name . "_day", $option_name, $option_value, '', $value[2], $property[0]) . $value[3];
				break;
				case 'H' :
					for ($SSE_i=$value[0]; $SSE_i<=$value[1]; $SSE_i++) {
						$option_name[] = $option_value[] = $SSE_i;
					}
					$select_boxs .= $this->make_list_box($name . "_hour", $option_name, $option_value, '', $value[2], $property[0]) . $value[3];
				break;
			}
		}
		return $select_boxs;
	}

	// ��¥ �Է� ����
	function make_date_input_box($check_box_name, $input_box_name, $default_value, $date_term=0, $date_point="����", $date_format="Y-m-d,H:i:s", $input_box_property="size=12 class='designer_text' maxlength=20", $calendar='N') {
		if ($default_value == 0) $default_value = '';
		if ($date_format == '') $date_format = "Y-m-d,H:i:s";
		if ($default_value != '' && eregi("([0-9]{10,11})", $default_value)) $default_value = date($date_format, $default_value);
		$set_date_value = date($date_format, $GLOBALS[w_time] + ($date_term*60*60*24));
		if ($check_box_name != '') $check_box = $this->make_input_box('', $check_box_name, "checkbox", "onclick='if (this.checked == true) this.form.{$input_box_name}.value=this.form.{$check_box_name}.value; else this.form.{$input_box_name}.value=this.form.{$input_box_name}.defaultValue;' class='designer_checkbox'", '', $set_date_value) . $date_point;
		$input_box = $this->make_input_box($default_value, $input_box_name, "text", $input_box_property, '', '');
		if ($calendar == 'Y') {
			$T_exp = explode(',', $set_date_value);
			if ($T_exp[1] != '') $calendar_tail = ",{$T_exp[1]}";
			$btn_calendar = $this->get_calendar_btn($input_box_name, "Y-M-D{$calendar_tail}") . ' ';
		}
		return $btn_calendar . $input_box . $check_box;
	}

	// �޷�ȣ���Լ�
	function get_calendar_btn($date_input_box_name, $format, $property=" class=designer_button") {
		global $DIRS;
		$tag_btn = '';
		if ($GLOBALS[form_type_calendar] != 'Y') {
			$tag_btn = "<div id='calendar' style='visibility:hidden; position:absolute; left:150; top:136; width:186 height:205; border:0pt;'><iframe src='' frameborder='0' name='calframe' width=175 height=200></iframe></div>
				<script language='javascript1.2'>
				<!--
					function open_calendar(form_name, date_input_box_name, format) {
						var targetElement = document.all('calendar');
						targetElement.style.display = '';
						var x = (event.pageX) ? event.pageX : document.body.scrollLeft+event.clientX;
						var y = (event.pageY) ? event.pageY : document.body.scrollTop+event.clientY;								
						document.frames['calframe'].document.location='{$DIRS[tools_root]}calendar/form_input_type/index.html?form_name=' + form_name + '&date_input_box_name=' + date_input_box_name + '&format=' + format;
						document.all['calendar'].style.visibility = 'visible';
						document.all['calendar'].style.left = x - 50;
						document.all['calendar'].style.top = y - 50;						
					}
				//-->
				</script>";
			$GLOBALS[form_type_calendar] = 'Y';
		}
		$tag_btn .= "<input type='button' value='  ' onclick=\"open_calendar(this.form.name, '$date_input_box_name', '$format')\"{$property} style=\"cursor:hand; border:0px; width: 20px; height: 20px; background-image: url('{$DIRS[tools_root]}calendar/form_input_type/cal.gif'); top: 0; padding: 0;font-size: 5px;\">";
		return $tag_btn;
	}
	

	//	 DB ����	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// ���� �����Լ�
	function querying($query, $msg = "������������", $db_conn='') { 
		if ($db_conn != '') $result = mysql_query($query, $db_conn);
		else $result = mysql_query($query);
		if (!$result) {
			echo("$msg : $query<br>" . mysql_error() . "<br>");
			exit;
		}
		return $result;
	}

	// ���ڵ� �Է� �Լ�
	function input_record($table, $input_data, $get_serial='N') {
		$T_sub_query = array();
		while (list($key, $value) = each($input_data)) {
			if ($value == '') continue;
			if (substr($value, 0, 7) == "[MYSQL]") $T_sub_query[] = "$key" . substr($value, 7);
			else $T_sub_query[] = "$key='$value'";
		}
		$sub_query = implode(", ", $T_sub_query);
		if ($get_serial == 'N') {
			$query = "insert $table set $sub_query";
			$result = $this->querying($query);
		} else {
			@mysql_query("LOCK TABLES $table READ, $table WRITE");
			$query = "insert $table set $sub_query";
			$result = $this->querying($query);
			$new_serial_num = mysql_insert_id();
			@mysql_query("UNLOCK TABLES");
			return $new_serial_num;
		}
	}

	// ���ڵ� ���� �Լ�
	function modify_record($table, $key_field, $key_value, $input_data, $empty_value='Y', $where_query='') {
		$sub_query = array();
		while (list($key, $value) = each($input_data)) {
			if ($value == '' && $empty_value == 'N') continue;
			if (substr($value, 0, 7) == "[MYSQL]") $sub_query[] = "$key" . substr($value, 7);
			else $sub_query[] = "$key='$value'";
		}
		$sub_query = implode(", ", $sub_query);
		if ($where_query == '') {
			if (!is_array($key_field)) {
				if (substr($key_value, 0, 7) == "[MYSQL]") $where_query = "$key_field" . substr($key_value, 7);
				else $where_query = "$key_field='$key_value'";
			} else {
				$where_query = array();
				while (list($key, $value) = each($key_field)) {
					if (substr($value, 0, 7) == "[MYSQL]") $where_query[] = "$key" . substr($value, 7);
					else $where_query[] = "$key='$value'";
				}
				$where_query = implode(" $where_method ", $where_query);
			}
		}
		$query = "update $table set $sub_query where $where_query";
		return $this->querying($query);
	}

	// Ư�� ���ڵ� ���� ����
	function get_data($table, $key_field, $key_value) {
		$where_query = array();
		if (!is_array($key_field)) {
			$where_query = "$key_field='$key_value'";
		} else {
			while (list($key, $value) = each($key_field)) {
				$where_query[] = "$key='$value'";
			}
			$where_query = implode(" and ", $where_query);
		}
		$query = "select * from $table where $where_query";
		$result = $this->querying($query);
		return mysql_fetch_array($result);
	}

	// Ư�� ���ڵ� �ʵ� ���� �����ϴ� �Լ�
	function db_set_field_value($table, $field, $modify_value, $serial_field, $serial_value) {
		$where_query = array();
		if (!is_array($serial_field)) {
			$where_query = "$serial_field='$serial_value'";
		} else {
			while (list($key, $value) = each($serial_field)) {
				$where_query[] = "$key='$value'";
			}
			$where_query = implode(" and ", $where_query);
		}
		if (substr($modify_value, 0, 7) == "[MYSQL]") $sub_query = "$field" . substr($modify_value, 7);
		else $sub_query = "$field='$modify_value'";
		$query = "update $table set $sub_query where $where_query";
		return $this->querying($query);
	}

	// Ư�� ���ڵ� ���� �Լ�
	function db_record_delete($table, $serial_field, $serial_value, $where_method='and') {
		$where_query = array();
		if (!is_array($serial_field)) {
			$where_query = "$serial_field='$serial_value'";
		} else {
			while (list($key, $value) = each($serial_field)) {
				$where_query[] = "$key='$value'";
			}
			$where_query = implode(" $where_method ", $where_query);
		}
		$query = "delete from $table where $where_query";
		return $this->querying($query);
	}
	
	// �������� ����(where ��)
	function get_sub_query($sub_querys, $head="where") {
		$cnt = sizeof($sub_querys);
		if ($cnt <= 0) return;
		$sub_query = array();
		for ($T_i=0,$cnt=sizeof($sub_querys); $T_i<$cnt; $T_i++) $sub_query[] = $sub_querys[$T_i];
		if (sizeof($sub_query) > 0) return " $head " . implode(" and ", $sub_query);
	}

	// �˻� �������� ���� (�� : SCH_T_fldname �Ǵ� SCH_P_fldname .. )
	function get_query_search($field_header, $field_tail_date, $T_method=" or ") {
		$sch_info = $T_sub_query = $sch_querys = array();
		$except_tail = array("_multi");																																					// �˻�����
		$head_len = strlen($field_header);
		$T_get = $_GET;
		while (list($key, $value) = each($T_get)) {																																// url �� �˻������� �Ѿ�°��
			$is_except = 'N';
			for ($i=0,$cnt=sizeof($except_tail); $i<$cnt; $i++) {																										// ����ó��
				$length = strlen($except_tail[$i]);
				if (substr($key, -$length) == $except_tail[$i]) $is_except = 'Y';
			}
			if ($is_except == 'Y') continue;
			$key_head = substr($key, 0, $head_len);
			if ($key_head == $field_header && $value != '') $sch_info[substr($key, $head_len)] = $value;				// ���� ������ �迭�� ����
		}
		if (sizeof($sch_info) > 0) {																																									// �˻��� �׸��� �����ϴ� ���
			$sub_query_2 = array();
			while (list($key, $value) = each($sch_info)) {																														// �� ���� �˻�
				$T_key_tail = substr($key, -6);
				if (($T_key_tail == "{$field_tail_date}_1" || $T_key_tail == "{$field_tail_date}_2") && $value != '') {
					$T_key = substr($key, 0, -2);
					if ($T_key_tail == "{$field_tail_date}_1" && $sch_info[$key] != '') {
						$ymd = explode('-', $sch_info[$key]);
						$sch_date = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
						$sub_query_2[] = "$T_key>=$sch_date";
					}
					if ($T_key_tail == "{$field_tail_date}_2" && $sch_info[$key] != '') {
						$ymd = explode('-', $sch_info[$key]);
						$sch_date = mktime(0, 0, 0, $ymd[1], $ymd[2]+1, $ymd[0]);
						$sub_query_2[] = "$T_key<$sch_date";
					}
				} else {
					$sub_query_1 = array();
					$T_exp = explode(' ', trim($value));																																		// ����Ű���� (���̶������ ����)
					for ($T_i=0,$cnt=sizeof($T_exp); $T_i<$cnt; $T_i++) {																								// Ű���� ������ŭ
						$sub_query_1[] = $this->get_query_operator($key, $T_exp[$T_i]);																// �� Ű���� ���� ���ڸ� ����ó��
					}
					$T_sub_query[] = '(' . implode(" {$T_method} ", $sub_query_1) . ')';
				}
			}
			if (sizeof($sub_query_2) > 0) $T_sub_query[] = '(' . implode(" and ", $sub_query_2) . ')';
			return $T_sub_query;
		}
	}

	// �˻��� ù���ڸ� �˻��ؼ� ���� �����ڿ� �´� ������ �����ִ� �Լ�
	function get_query_operator($key, $value) {
		$head_sch_item = substr($value, 0, 1);
		if ($head_sch_item == '!' || $head_sch_item == '+' || $head_sch_item == '-') $T_value = substr($value, 1);
		else $T_value = $value;
		switch ($head_sch_item) {
			case '!' :
				$query = "$key<>'$T_value'";
			break;
			case '+' :
				$query = "$key='$T_value'";
			break;				
			case '-' :
				$query = "$key unlike '%{$T_value}%'";
			break;
			default :
				$query = "$key like '%{$T_value}%'";
			break;
		}
		return $query;
	}

	// �˻����� ���� (�������� ������ �迭����)
	// $sch_info : method=$_GET[sch_method] , head=SCH_ , tail_date=date or time ... / $sch_keyword = $_GET[search_value] / $sch_item_selected = $_GET[search_item]
	function get_query_search_all($sch_info, $sch_item_selected, $sch_keyword, $search_items) {
		if ($sch_info[method] == '') $T_method = "or";																																									// ���� Ű���尣 (and, or ����)
		else $T_method = $sch_info[method];
		$sch_query = $this->get_query_search($sch_info[head], $sch_info[tail_date], $T_method);																	// GET���� �Ѿ���� ��� �˻��ʵ��� �������� ����
		if (sizeof($sch_query) > 0) $T_sub_query = $sch_query;																																				// �ʱ� �������� ����
		else $T_sub_query = array();
		if (trim($sch_keyword) != '') {																																																		// �˻� Ű���尡 �ִ� ���
			$exp_search_keyword = explode(' ', trim($sch_keyword));																																												// ����Ű���� (���̶������ ����)
			if ($sch_item_selected == '' || $sch_item_selected == 'A') {																																															// ���հ˻��ΰ��
				$sch_item_array = array();
				while (list($key, $value) = each($search_items)) {																																				// �˻� �ʵ� �� ��ŭ
					if ($key == 'A') continue;
					$exp_sch_item = explode(';', $key);																																								// ���߰˻��׸��ΰ�� (���հ˻���...)
					$sch_item_array = array_merge($sch_item_array, $exp_sch_item);
				}
			} else {
				$sch_item_array = explode(';', $sch_item_selected);																																				// �˻��׸� �и�(üũ�����ΰ�� ���������� ����)
			}
			for ($i=0,$cnt=sizeof($sch_item_array); $i<$cnt; $i++) {	// �˻��׸� ������ŭ(����, ����..)
				if (trim($sch_item_array[$i]) == '') continue;
				$sub_query_1 = $sub_query_3 = array();
				for ($j=0,$cnt_j=sizeof($exp_search_keyword); $j<$cnt_j; $j++) {																																		// Ű���� ������ŭ
					$sub_query_1[] = $this->get_query_operator($sch_item_array[$i], $exp_search_keyword[$j]);											// �� Ű���� ���� ���ڸ� ����ó��
				}
				$sub_query_2[] = '(' . implode(" {$T_method} ", $sub_query_1) . ')';
			}
			if (sizeof($sub_query_2) > 0) $T_sub_query[] = '(' . implode(" or ", $sub_query_2) . ')';																	// ���߼��õ� �˻��׸� ��������
		}
		return $T_sub_query;
	}

	function get_date_box_term($name, $value) {
		$obj_id_1 = "{$name}_id_1";
		$obj_id_2 = "{$name}_id_2";
		$date_box_1 = $this->make_date_input_box('', "SCH_" . $name . "_1", $value[0], 0, '', "Y-m-d", "class=designer_text size=10 readonly id='{$obj_id_1}' style='width:68px'", 'Y');
		$date_box_2 = $this->make_date_input_box('', "SCH_" . $name . "_2", $value[1], 0, '', "Y-m-d", "class=designer_text size=10 readonly id='{$obj_id_2}' style='width:68px'", 'Y');
		if ($GLOBALS[script_search_item_date_name] != 'Y') {
			$script = "
				<script language='javascript1.2'>
				<!--
					function set_search_item_date_name(form, obj) {
						obj_name_head = obj.value;
						obj_id_1 = document.getElementById('$obj_id_1');
						obj_id_2 = document.getElementById('$obj_id_2');
						obj_id_1.name = 'SCH_' + obj_name_head + '_1';
						obj_id_2.name = 'SCH_' + obj_name_head + '_2';
					}
				//-->
				</script>
			";
			$GLOBALS[script_search_item_date_name] = 'Y';
		}
		return $date_box_1 . ' ~ ' . $date_box_2 . $script;
	}

	// ���� �������� ���� (�� : SI_F_fldname , SI_S_fldname)
	function get_query_sort($field_header, $sort_field, $sort_sequence) {
		$sort_info = array();
		$sort_method_1 = array();
		$head_len = strlen($field_header);
		$T_get = $_GET;
		while (list($key, $value) = each($T_get)) {
			$key_head = substr($key, 0, $head_len);
			if ($key_head == $field_header) $sort_info[substr($key, $head_len)] = $value;
		}
		if (sizeof($sort_info) > 0) {	// url �� ���İ��� �Ѿ�� ���
			while (list($key, $value) = each($sort_info)) {
				$key = str_replace('-', '.', $key);
				$sort_method_1[] = "$key $value";
			}
		} else {
			if (!is_array($sort_field)) {
				$sort_method_1[] = "$sort_field $sort_sequence";
			} else {
				for ($i=0; $i<sizeof($sort_field); $i++) {
					$sort_method_1[] = "$sort_field[$i] $sort_sequence[$i]";
				}
			}
		}
		$sort_method = " order by " . implode(", ", $sort_method_1);
		return $sort_method;
	}

	// ���İ� �ϰ�����
	// $ar_where : where�� ���ǿ� �����迭, $field_nm_sort : ���������ʵ�, $sort_method : ���ļ���
	function get_new_sort($table, $ar_where, $field_nm_sort, $sort_method, $primary_key) {
		$where_query_select = $this->get_string_r_array($ar_where, "=", " and ", array("FR_value"=>"'"));
		if ($where_query_select != '') $where_query_select = "where $where_query_select";
		$query = "select " . implode(',', $primary_key) . " from $table $where_query_select order by $field_nm_sort $sort_method";
		$result = $GLOBALS[lib_common]->querying($query);
		$i = 1;
		while ($value_category = mysql_fetch_array($result)) {
			$T_up_array = array();
			for ($j=0; $j<sizeof($primary_key); $j++) $T_up_array[$primary_key[$j]] = $value_category[$primary_key[$j]];
			$where_query_update = "where " . $this->get_string_r_array($T_up_array, "=", " and ", array("FR_value"=>"'"));
			$query = "update $table set {$field_nm_sort}='$i' $where_query_update";
			$GLOBALS[lib_common]->querying($query);
			$i++;
		}
	}

	// �ΰ��� ������ ���ڵ带 �� �Ǵ� �Ʒ��� ��ȯ
	// $where_shared : ���� ������ ���� ���� �ʵ��, �� (�����迭)
	// $where_this : ���� ���ڵ带 �����ϱ� ���� �ʵ��, �� (�����迭)
	// $primary_key_swap : �ٲ� ���ڵ带 ã�� ���� �ʵ�� (1�����迭)
	function record_swap($table, $mode, $where_shared, $where_this, $primary_key_swap, $field_nm_sort) {
		$where_array = $where_this + $where_shared;
		$sub_query = $this->get_string_r_array($where_array, "=", " and ", array("FR_value"=>"'"));
		// ���� ������ ����		
		$query = "select * from $table where $sub_query";
		$result = $GLOBALS[lib_common]->querying($query);
		$info_this = mysql_fetch_array($result);
		// mode �� ���� �� �Ǵ� �� ���ڵ� ����
		$swap_query = $this->get_string_r_array($where_shared, "=", " and ", array("FR_value"=>"'"));
		if ($swap_query != '') $swap_query = "and $swap_query";
		switch ($mode) {
			case 'U' :
				$query = "select * from $table where {$field_nm_sort}<'{$info_this[$field_nm_sort]}' $swap_query order by $field_nm_sort desc limit 1";
			break;
			case 'D' :
				$query = "select * from $table where {$field_nm_sort}>'{$info_this[$field_nm_sort]}' $swap_query order by $field_nm_sort asc limit 1";
			break;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if (mysql_num_rows($result) > 0) {									// �ٲ� ���ڵ尡 �ִ� ���
			$value_swap = mysql_fetch_array($result);			// ��������
			$query = "update $table set {$field_nm_sort}={$value_swap[$field_nm_sort]} where $sub_query";							// ���� ���ڵ� ������ �ٲ� ���ڵ� ���������� ����
			$result = $GLOBALS[lib_common]->querying($query);
			// �ٲ� ���ڵ� ��������
			$T_up_array = array();
			for ($j=0; $j<sizeof($primary_key_swap); $j++) $T_up_array[$primary_key_swap[$j]] = $value_swap[$primary_key_swap[$j]];
			$up_array = $T_up_array + $where_shared;
			$where_query_update = "where " . $this->get_string_r_array($up_array, "=", " and ", array("FR_value"=>"'"));
			$query = "update $table set {$field_nm_sort}='{$info_this[$field_nm_sort]}' $where_query_update";						// �ٲ� ���ڵ� ������ ���� ���ڵ� ���������� ����
			$result = $GLOBALS[lib_common]->querying($query);
			return true;
		} else {
			return false;
		}
	}

	// ���� ��ũ ���� �Լ�
	function get_sort_link($field_header, $field_name, $sequence, $link_file='', $is_multi='N', $is_fix='N', $change_vars_1='') {
		if ($change_vars_1 != '') $change_vars = $change_vars_1;
		else $change_vars = array();
		$sort_fld_name = $field_header . $field_name;
		if ($_GET[$sort_fld_name] != '') {
			if ($is_fix != 'Y') {
				if ($_GET[$sort_fld_name] == "asc") $sort_sequence = "desc";
				else $sort_sequence = "asc";
			} else {
				$sort_sequence = $sequence;
			}
		} else {
			$sort_sequence = $sequence;
		}
		if ($is_multi != 'Y') {				// ���� �ʵ� �����̸�, ��� ���� �������� ���ش�.
			$T_get = $_GET;
			while (list($key_sort, $value_sort) = each($T_get)) {
				$key_head = substr($key_sort, 0, 5);
				if ($key_head == $field_header) $change_vars[$key_sort] = '';
			}
		}
		$change_vars[$sort_fld_name] = $sort_sequence;
		$link_url = $link_file . '?' . $this->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
		return $link_url;
	}

	// ���������� ���� ����
	function get_ppb_query($query, $replace_query_head) {
		$exp_query = explode(" from ", $query);
		$exp_query[0] = $replace_query_head;
		$query_ppb = implode(" from ", $exp_query);
		return $query_ppb;
	}

//	 FILE & DIRECTORY ����	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function get_dir_file_list($directory, $user_except=array()) {
		if ($handle = opendir($directory)) {
			$list = array();
			$default_except_list = array(".", "..");
			$except_list = array_merge($default_except_list, $user_except);
			while (false !== ($file = readdir($handle))) { 
				if (!in_array($file, $except_list)) $list[$file] = $file;
			}
			closedir($handle);
			return $list;
		} else {
			return false;
		}
	}

	// ���丮 ���� �Լ�(���� ���丮����)
	function copy_dir($from_path, $to_path, $isCreate, $permission) {
		global $site_info;
		$from_path .= "/";
		$to_path .= "/";
		if (!$permission) $permission = $site_info[directory_permission];
		if (!file_exists($to_path)) {
			if ($isCreate == 1) {
				if (!mkdir($to_path, $permission)) {	// �۹̼� ���� ���� �ִ°�?
					echo("��� ���丮 ������ �����߻�");
					return false;
				} else {
					chmod ($to_path.$file, $permission);	// �ѹ��� Ȯ�μ���
				}
			}
		}
		if (!is_dir($to_path)) {
			echo("��� ���丮 �Է��� �߸��Ǿ����ϴ�.");
			return false;
		}
		$dirhandle = opendir($from_path);
		while ($file = readdir($dirhandle)) {
			if (($file != ".") && ($file != "..")) {
				if (is_dir($from_path . $file)) $this->copy_dir($from_path.$file, $to_path.$file, $isCreate, $permission);
				else if (is_file($from_path . $file)) {
					copy($from_path.$file, $to_path.$file);
					chmod ($to_path.$file, $permission);
				}
			}
		}
		closedir($dirhandle); 
		return true;
	}

	// ���丮(��������, ���丮����)�� �����ϴ� �Լ�
	function delete_dir($dir_name) {
		if ($dir_name == "") {
			echo("���丮 ���� ����!!");
			exit;
		}
		$dirhandle = opendir($dir_name);	// ���ڷ� �Ѱ� ���� ���丮�� �ڵ��� ��´�.
		while ($filename = readdir($dirhandle)) {	// ���丮 ���� ������丮�� ���ϵ��� ��� Ž���Ͽ�
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' �� '../'�� �����Ѵ�.
			else {
				$filename = $dir_name . "/" . $filename;	 // �����̸��� ��θ� ���δ�(���丮�� ���Ϸ� ��޵ǹǷ� �̸������δ� Ȯ�� �Ұ�)
				if (is_dir($filename)) $this->delete_dir($filename);	// ���丮�� ��� ���� �Լ��� ��������� ȣ��
				else unlink($filename);	// ������ ��� �����Ѵ�.
			}
		}
		closedir($dirhandle);	// ������ ���丮 �ڵ��� �ݰ�
		rmdir($dir_name);		// ���� ���丮�� �����Ѵ�.
	}

	// ���丮(��������, ���丮����)�� �۹̼��� �����ϴ� �Լ�
	function change_permission($dir_name, $perm) {
		$dirhandle = opendir($dir_name);	// ���ڷ� �Ѱ� ���� ���丮�� �ڵ��� ��´�.
		while ($filename = readdir($dirhandle)) {	// ���丮 ���� ������丮�� ���ϵ��� ��� Ž���Ͽ�
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' �� '../'�� �����Ѵ�.
			else {
				$filename = $dir_name . "/" . $filename;	 // �����̸��� ��θ� ���δ�(���丮�� ���Ϸ� ��޵ǹǷ� �̸������δ� Ȯ�� �Ұ�)
				if (is_dir($filename)) $this->change_permission($filename, $perm);	// ���丮�� ��� ���� �Լ��� ��������� ȣ��
				else chmod($filename, $perm);	// ������ ��� �۹̼� ����
			}
		}
		closedir($dirhandle);	// ������ ���丮 �ڵ��� �ݰ�
		chmod($dir_name, $perm);		// ���� ���丮 �۹̼� ����
	}

	// ���丮 ������ ���ϸ� �����ϴ� �Լ�
	function delete_inner_file($dir_name) {
		$dirhandle = opendir($dir_name);	// ���ڷ� �Ѱ� ���� ���丮�� �ڵ��� ��´�.
		while ($filename = readdir($dirhandle)) {	// ���丮 ���� ������丮�� ���ϵ��� ��� Ž���Ͽ�
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' �� '../'�� �����Ѵ�.
			else {
				$filename = $dir_name . "/" . $filename;	 // �����̸��� ��θ� ���δ�(���丮�� ���Ϸ� ��޵ǹǷ� �̸������δ� Ȯ�� �Ұ�)
				if (is_dir($filename)) $this->delete_inner_file($filename);	// ���丮�� ��� ���� �Լ��� ��������� ȣ��
				else {
					unlink($filename);	// ������ ��� �����Ѵ�.
				}
			}
		}
		closedir($dirhandle);	// ������ ���丮 �ڵ��� �ݰ�
	}

	// �ϳ��� ������ Ư�����丮�� ��� ���� ���丮�� �����ϴ� �Լ� ####
	function copy_sub_dir($source_file_dir, $one_file_name, $target_dir) {
		global $site_info;
		$dirhandle = opendir($target_dir);	// ���ڷ� �Ѱ� ���� ���丮�� �ڵ��� ��´�.
		while ($file_name = readdir($dirhandle)) {	// ���丮 ���� ������丮�� ���ϵ��� ��� Ž���Ͽ�
			if (!strcmp($file_name, ".") || !strcmp($file_name, "..")) {
				continue;	// './ ' �� '../'�� �����Ѵ�.
			} else {
				$abs_file_name = $target_dir . "/" . $file_name;	 // �����̸��� ��θ� ���δ�(���丮�� ���Ϸ� ��޵ǹǷ� �̸������δ� Ȯ�� �Ұ�)
				if (is_dir($abs_file_name)) {
					$source_file = $source_file_dir . "/" . $one_file_name;
					$target_file = $abs_file_name . "/" . $one_file_name;
					echo("$source_file , $target_file <br>");
					copy($source_file, $target_file);
					chmod($target_file, $site_info[directory_permission]);
				}
			}
		}
		closedir($dirhandle);	// ������ ���丮 �ڵ��� �ݴ´�.
	}

	// ���丮 �뷮�� Ȯ���ϴ� �Լ�(�������丮 ����)
	function check_designspace($dir_name) {
		$designSize = 0;
		$dirhandle = opendir($dir_name);	// ���ڷ� �Ѱ� ���� ���丮�� �ڵ��� ��´�.
		while ($filename = readdir($dirhandle)) {	// ���丮 ���� ������丮�� ���ϵ��� ��� Ž���Ͽ�
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' �� '../'�� �����Ѵ�.
			else {
				$filename = $dir_name . "/" . $filename;	 // �����̸��� ��θ� ���δ�(���丮�� ���Ϸ� ��޵ǹǷ� �̸������δ� Ȯ�� �Ұ�)
				if (is_dir($filename)) $designSize += $this->check_designspace($filename);	// ���丮�� ��� ���� �Լ��� ��������� ȣ��
				else $designSize += filesize($filename);
			}
		}
		closedir($dirhandle);	// ������ ���丮 �ڵ��� �ݰ�
		return $designSize;
	}

	// ���� ���ε� �Լ�
	// ����δ� ��Ʈ���� ����ηθ� �Է�, ��Ʈ�� �Լ� ������ ����(�� �Լ��� �����ϴ� ��δ� �ٲ�� �����Ƿ�, �ش� ����� ��Ʈ�� �������� ���ε���)
	// return_dir �Ӽ��� table �� background �Ӽ� ó�� �̹��� ��α��� ���Ե� ���� ���� �޾ƾ� �� ��� ���.
	function file_upload($upload_file_name, $saved_file_name='', $ext_array, $ext_method, $target_dir, $new_file_name='', $return_dir='', $create_dir='N') {
		global $site_info, $root, $lib_fix;
		$user_file = $_FILES[$upload_file_name][tmp_name];
		$user_file_name = $_FILES[$upload_file_name][name];
		if (substr($target_dir, 0, 1) == '.') $real_target_dir = $target_dir;		// ��� ����ΰ�� �״��
		else $real_target_dir = "{$root}{$target_dir}";											// �׷��� ���� ��� ��Ʈ�� ����
		if (($user_file != '') && strcmp($user_file, "none")) {
			$full_filename = explode("."  , $user_file_name);
			$extension = strtolower($full_filename[sizeof($full_filename)-1]);
			if (is_int(array_search($extension, $GLOBALS[VI][deny_ext]))) {		// �������� �˻�
				$host_info = $lib_fix->get_user_info($site_info[site_id]);
				$mail_contents = "
					{$site_info[site_name]} Ȩ�������� �̿����� �ý��������� ���ε� �Ϸ��� �õ��� �־����ϴ�.<br>
					IP Address : {$_SERVER[REMOTE_ADDR]}<br>
					����� ID : {$user_info[id]} {$user_info[name]}<br>
					�ð� : " . date("Y-m-d H:i:s", $GLOBALS[w_time]) . "<br>
					���ε� �õ��� ���� : {$real_target_dir}/{$user_file_name}
				";
				$log_info = array("owner"=>"system");
				$this->mailer($site_info[site_name], $site_info[site_email], $host_info[email], "�ý������� ���ε� �õ� ����", $mail_contents, 1, '', "EUC-KR", '', '', $GLOBALS[VI][mail_form], $log_info, 'N', $host_info[name]);
				$this->alert_url("�ý��� �ʼ� ������ ���ε� �� �� �����ϴ�.\\n\\n������ �������ּ� $_SERVER[REMOTE_ADDR] �� ��� �Ǿ����� �����ڿ��� �뺸�Ǿ����ϴ�.");
			}
			if ($ext_method == 'T') {																																																	// ������ ���ϸ� ���ε� ������ ������ ���
				if (!is_int(array_search($extension, $ext_array))) $this->alert_url("�����Ͻ� ������ ���ε� �� �� ���� ���� �Դϴ�.");
			} else {																																																										// ���������� �̿ܿ��� ���ε� ������ ������ ���
				if (is_int(array_search($extension, $ext_array))) $this->alert_url("�����Ͻ� ������ ���ε� �� �� ���� ���� �Դϴ�.");
			}
			if (!file_exists($real_target_dir)) {
				if ($create_dir == 'N') $this->alert_url("���ε��� ���丮�� �����ϴ�. \\n\\n{$target_dir}");
				else mkdir($real_target_dir, $site_info[directory_permission]);
			}
			if ($new_file_name == '') $new_file_name = $user_file_name;
			else $new_file_name = $new_file_name . '.' . $extension;
			if (file_exists("{$real_target_dir}/$new_file_name")) {
				rename("{$real_target_dir}/{$new_file_name}", "{$real_target_dir}/BAK_{$new_file_name}_" . time());	// ���� �̸��� ������ �ִ� ��� ����Ѵ�.
				$this->alert_url("���� ���� �̸��� ������ ����Ǿ����ϴ�.", 'N', '', '', '');
			}
			if (!move_uploaded_file($user_file, "{$real_target_dir}/$new_file_name")) $this->alert_url("���ε����� �̵� ����!", 'N', '', '', '');
			if (!chmod("{$real_target_dir}/$new_file_name", $site_info[directory_permission])) $this->alert_url("���ε����� ���Ѻ��� ����", 'N', '', '', '');
			if ($return_dir == 'Y') $new_file_name = "{$target_dir}/{$new_file_name}";
			return $new_file_name;
		} else if ($saved_file_name != '') {
			return $saved_file_name;
		} else {
			return false;
		}
	}

	// ������ Ȯ���ڸ� ��� �Լ�	
	function get_file_extention($file_name) {
		$T_exp = explode('.', $file_name);
		return $T_exp[sizeof($T_exp)-1];
	}
	
	// ���丮���� ������ ������ ���ϸ� �����Լ�
	function get_file_name($full_file_name) {
		$array = explode('/', $full_file_name);
		if (sizeof($array) <= 1)  return $full_file_name;
		return $array[sizeof($array) -1];
	}

	// �� ���� ũ�⿡ ���� ��, ��, �ʷ� �����ִ� �Լ�
	function get_sec_to_other($second) {
		if ($second >= 60*60*24) {
			$chg_value = $second / (60*60*24);
			$unit = "��";
		} else if ($second >= 60*60) {
			$chg_value = $second / (60*60);
			$unit = "�ð�";
		} else if ($second >= 60) {
			$chg_value = $second / 60;
			$unit = "��";
		} else {
			$chg_value = $second;
			$unit = "��";
		}
		return array($chg_value, $unit);
	}

	// HTML Ư������ ��ȯ htmlspecialchars
	function htmlspecialchars2($str) {
		$trans = array("\"" => "&#034;", "'" => "&#039;", "<"=>"&#060;", ">"=>"&#062;");
		$str = strtr($str, $trans);
		return $str;
	}

	// htmlspecialchars2 �Լ� �ݴ�
	function htmlspecialchars3($str) {
		$trans = array("&quot;" => "\"", "&#039;" => "'", "&lt;"=>"<", "&gt;"=>">");
		$str = strtr($str, $trans);
		return $str;
	}
		
	// base64_encode �ι�
	function base64_encode2($str) {
		$str = base64_encode($str);
		$str = base64_encode($str);
		return $str;
	}

	// base64_decode �ι�
	function base64_decode2($str) {
		$str = base64_decode($str);
		$str = base64_decode($str);
		return $str;
	}
}
?>