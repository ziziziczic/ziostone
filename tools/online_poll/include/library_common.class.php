<?
class library_common {

/*
	공용 함수 클래스
*/

	function library_common() {
		// nothing
	}

	//	 일반공용 함수	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// \r 제거 함수
	function replace_cr($full_string, $replace_string) {
		$comment = explode("\n", $full_string);
		for ($i=0; $i<sizeof($comment); $i++) {
			$comment[$i] = trim($comment[$i]);
		}
		return implode($replace_string, $comment);
	}

	// 필터링 문자열 검색 함수
	function input_filter($filter_list, $input_value) {
		for ($i=0; $i<sizeof($filter_list); $i++) {
			if (trim($filter_list[$i]) == "") continue;
			if (eregi($filter_list[$i], $input_value)) die("입력하기에 부적절한 단어가 포함되어 있습니다. : <font color=red>$filter_list[$i]</font> <a href='javascript:history.back()'><b>[돌아가기]</b></a>");
		}
	}

	// 화폐단위로 출력
	function get_money_format($amount, $unit="원") {
		if ($amount == 0 || $amount == '') return "<font color=999999>0{$unit}</font>";
		$money = number_format($amount);
		return $money . $unit;
	}

	// 별 5개로 점수표현
	function get_stars($grade, $unit_half_star=1, $img_dir='') {
		$max_grade = $unit_half_star * 10;
		$stars = array();
		$direction = 'L';
		for ($i=1; $i<=$max_grade; $i++) {
			if (($i % $unit_half_star) == 0) {	// 별출력 조건
				if ($grade >= $i) {	// 색깔별출력
					if ($direction == 'L') {
						$stars[] = "TL";
						$direction = 'R';
					} else {
						$stars[] = "TR";
						$direction = 'L';
					}
				} else {						// 색깔없는별출력
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

	/* 권한처리 (상황에 따라 권한 부여 여부를 결정함 / 아래 예제참고)
		$value[0] : 기준값 , $value[1] : 현재값 , $value[2] : 모드
		$auth_method_array = array(array('L', 기준레벨, 사용자레벨, 'E'), array('L', 기준레벨, 사용자레벨, 'E'));
		if (!$lc_handle->auth_process($auth_method_array)) $lc_handle->die_msg("등록권한이 없습니다.", $SRE_file_info[die_msg_skin]);
	*/
	function auth_process($auth_method_array) {
		for ($i=0; $i<sizeof($auth_method_array); $i++) {
			switch ($auth_method_array[$i][0]) {
				case 'L' : // 레벨형 권한처리
					if ($auth_method_array[$i][3] == 'U') {				// 기준 권한 이상인경우
						if ($auth_method_array[$i][1] >= $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'L') {	// 기준 권한 이하인경우
						if ($auth_method_array[$i][1] <= $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'E') {
						if ($auth_method_array[$i][1] == $auth_method_array[$i][2]) return true;
					}
				break;
				case 'M' : // 매칭형 권한처리
					if ($auth_method_array[$i][3] == 'E') {
						if ($auth_method_array[$i][1] == $auth_method_array[$i][2]) return true;
					} else if ($auth_method_array[$i][3] == 'D') {
						if ($auth_method_array[$i][1] != $auth_method_array[$i][2]) return true;
					}
				break;
			}
		}
		return false;
	}

	// 메일 보내기 (파일 여러개 첨부 가능)
	function mailer($fname, $fmail, $to, $subject, $mail_contents, $type=0, $file='', $charset="EUC-KR", $cc='', $bcc='', $skin_file='', $log_info='', $auto_link='N', $to_name='', $is_logging='Y') {
		global $db_send_mail_log;
		// type : text=0, html=1, text+html=2
		$from_name = $fname;
		$fname   = "=?$charset?B?" . base64_encode($fname) . "?=";
		$subject_common = $subject;
		$subject = "=?$charset?B?" . base64_encode($subject) . "?=";
		$charset = ($charset != '') ? "charset=$charset" : '';
		
		$mail_contents = stripslashes($mail_contents);
		if ($auto_link == 'Y') $mail_contents = $this->auto_link($mail_contents);

		if ($skin_file != '') {
			$fp = fopen ($skin_file, "r");
			$skin_contents = fread($fp, 10000);
			fclose ($fp);
			$content = str_replace("%MAILTONAME%", $to_name, $skin_contents);
			$content = str_replace("%MAILSUBJECT%", $subject_common, $content);
			$content = str_replace("%MAILCONTENTS%", $mail_contents, $content);
		} else {
			$content =$mail_contents;
		}
		$header  = "Return-Path: <$fmail>\n";
		$header .= "From: $fname <$fmail>\n";
		$header .= "Reply-To: <$fmail>\n";
		if ($cc)  $header .= "Cc: $cc\n";
		if ($bcc) $header .= "Bcc: $bcc\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "X-Mailer: insiter mailer 0.9 (ohmysite.co.kr)\n";
		if ($file != '') {
			$boundary = uniqid("http://ohmysite.co.kr/");
			$header .= "Content-type: MULTIPART/MIXED; BOUNDARY=\"$boundary\"\n";
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
		$header .= chunk_split(base64_encode($content)) . "\n";
		if ($file != '') {
			foreach ($file as $f) {
				$header .= "\n--$boundary\n";
				$header .= "Content-Type: APPLICATION/OCTET-STREAM; name=\"$f[name]\"\n";
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
				// 메일전송 기록
				$sub_query = "from_name='$from_name', from_mail='$fmail', to_mail='$to', subject='$subject_common', contents='$content', type='$type', sign_date='$GLOBALS[w_time]', owner='$log_info[owner]', link='$log_info[link]', etc_msg='$log_info[etc_msg]'";
				$query = "insert VG_MAIL_LOG set $sub_query";
				$this->querying($query);
			}
			return $mail_ok;
		} else {
			return false;
		}
	}

	// 페이지 보안
	function page_lock() {
		echo("
			<script language='javascript1.2'>
			<!--
				function click_ie() { 
					if (event.button == 1) { 
						alert('마우스 왼쪽 버튼은 사용할 수 없습니다!');
						return false;
					}
					if (event.button == 2) { 
						alert('마우스 오른쪽 버튼은 사용할 수 없습니다!');
						return false;
					}
					if (event.ctrlKey == true ){
						alert('Ctrl키 사용불가능 합니다.');
						return false;
					}
					if (event.altKey == true ){
						alert('Alt키는 사용불가능 합니다.');
						return false;
					}
				}

				function check_ns(ev) { 
					if (ev.which == 2) { 
						alert('마우스 오른쪽 버튼은 사용할 수 없습니다!');
						return false; 
					} 
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
		");
	}

	// URL 상의 get 변수 변경함수
	function get_change_var_url($source, $change_vars) {
		parse_str($source, $get_vars);									// $QUERY_STRING 을 이름을 키로한 연관 배열로 만든다.
		$new_query_string = '';
		while (list($key, $value) = each($get_vars)) {	// 각 키값(GET 변수명) 중 
			if ($change_vars[$key] != '') {
				$value = $change_vars[$key];								// 새 값을 설정함
				$change_vars[$key] = '';
			}
			$new_query_string .= "{$key}={$value}&";
		}
		while (list($key, $value) = each($change_vars)) {	// 바뀌는 변수의 원소중 원본 $QUERY_STRING 에 없는 변수를 추가 한다.
			if ($value != '') $new_query_string .= "{$key}={$value}&";
		}
		$new_query_string = substr($new_query_string, 0, -1);
		return $new_query_string;
	}

	// 날짜 출력함수
	function get_input_date($date, $date_format='') {
		if ($date_format == '') $date_format = "y-m-d";
		if ($date != '' && $date != 0) return date($date_format, $date);
		else return '-';
	}

	function get_page_block($query, $ppa, $ppb, $page, $style, $font, $img_dir='', $link_file='', $unlink_view=N, $var_name_page='page', $total_type='C') {
		global $QUERY_STRING;
		if ($_GET[$var_name_page] <= 0) $T_page = 1;
		else $T_page = $_GET[$var_name_page];
		$result = $this->querying($query);
		$ppb_value = array();
		if ($total_type == 'C') $ppb_value = mysql_fetch_row($result);
		else $ppb_value[] = mysql_num_rows($result);
		$total = $ppb_value[0];
		$total_page = ceil($total / $ppa);
		if ($total_page == 0) return '';
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

		$current_page_block = floor($T_page / $ppb);	// 현재페이지블럭
		if (is_int($T_page/$ppb)) $current_page_block = $current_page_block - 1;	// 딱걸리는 페이지는 이전블록으로.
		$page_link_list = '';
		for($i = 1; $i<=$ppb; $i++) {
			$page_link = $current_page_block * $ppb + $i;	// 현재 블럭에서 표시될 페이지를 계산한다.
			$change_vars = array("$var_name_page"=>$page_link);
			$link = $link_file . "?" . $this->get_change_var_url($QUERY_STRING, $change_vars) . "#{$var_name_page}_top";
			if ($page_link == $T_page) $page_link_list .= "<font color='red'><b>{$style[0]}{$page_link}{$style[1]}</b></font>";
			else $page_link_list .= "<a href=\"{$link}\">{$open_font}{$style[0]}{$page_link}{$style[1]}{$close_font}</a>";	// <a name=''> 태그를 이용하여 시작 위치를 표시할 경우 페이지 이동시 특정 위치를 지킬 수 있도록 한다.
			$page_link_list .= " ";
			if($page_link == $total_page) break;		// 현재 페이지가 전체 페이지보다 커지면 루프를 빠져나간다.
		}
		if ($T_page > 1) {
			$temp = $T_page - 1;
			$change_vars = array("$var_name_page"=>$temp);
			$link = $link_file . "?" . $this->get_change_var_url($QUERY_STRING, $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_3_src' border='0' align='absmiddle'></a> " . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_3_src' border='0' align='absmiddle'>" . $page_link_list;
		}
		$pre_block = $current_page_block * $ppb;	// 이전 블럭에 표시될 페이지를 계산한다.
		if ($current_page_block > 0) {		// 이전 블럭이 존재 하면 이전블럭으로 이동할 수 있는 링크를 출력한다.
			$change_vars = array("$var_name_page"=>$pre_block);
			$link = $link_file . "?" . $this->get_change_var_url($QUERY_STRING, $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_2_src' border='0' align='absmiddle'></a>&nbsp;" . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_2_src' border='0' align='absmiddle'>&nbsp;{$page_link_list} ";
		}
		if ($T_page < $total_page) {
			$temp = $T_page + 1;
			$change_vars = array("$var_name_page"=>$temp);
			$link = $link_file . "?" . $this->get_change_var_url($QUERY_STRING, $change_vars);
			$page_link_list = $page_link_list . "<a href=\"{$link}\"><img src='$style_4_src' border='0' align='absmiddle'> </a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = $page_link_list . "<img src='$style_4_src' border='0' align='absmiddle'>";
		}
		$next_block = ($current_page_block+1) * $ppb+ 1; // 다음 블럭의 첫 페이지를 계산한다.
		if ($next_block <= $total_page) {
			$change_vars = array("$var_name_page"=>$next_block);
			$link = $link_file . "?" . $this->get_change_var_url($QUERY_STRING, $change_vars);
			$page_link_list = $page_link_list . "&nbsp;<a href='{$link}'><img src='$style_5_src' border='0' align='absmiddle'></a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = " {$page_link_list}&nbsp;<img src='$style_5_src' border='0' align='absmiddle'>";
		}
		$return_value = array($page_link_list, $ppb_value);
		return $return_value;
	}

	// 속성값을 분석해서 연관배열로 넘겨주는 함수
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
	
	// 하이퍼링크 함수
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

	// 문자열 자르기함수
	function str_cutstring($str, $num, $tail="...") { 
		$strip_tag_str = strip_tags($str);	// html 태그제거
		if (strlen($strip_tag_str) < $num) return $str; //자를 길이보다 문자열이 작으면 그냥 리턴 
		for ($i=0; $i<$num-1; $i++) if (ord($strip_tag_str[$i])>127) $i++; //한글일 경우 2byte 옮김 
		if (ord($strip_tag_str[$num-1])<127) $i++; //마지막 글자가 한바이트 문자일 때 
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

	// 오류 메시지 출력후 실행 정지
	function die_msg($msg, $skin_file="design/skin/die.html") {
		if ($skin_file == '') die($msg);
		$fp = fopen ($skin_file, "r");
		$skin_contents = fread($fp, 10000);
		fclose ($fp); 
		$content = str_replace("%MESSAGE%", $msg, $skin_contents);
		echo($content);
		die();
	}

	function auto_link($str) {
		global $agent,$rmail;

		$regex['file'] = "gz|tgz|tar|gzip|zip|rar|mpeg|mpg|exe|rpm|dep|rm|ram|asf|ace|viv|avi|mid|gif|jpg|png|bmp|eps|mov";
		$regex['file'] = "(\.({$regex['file']})\") TARGET=\"_blank\"";
		$regex['http'] = "(http|https|ftp|telnet|news|mms):\/\/(([\xA1-\xFEa-z0-9:_\-]+\.[\xA1-\xFEa-z0-9,:;&#=_~%\[\]?\/.,+\-]+)([.]*[\/a-z0-9\[\]]|=[\xA1-\xFE]+))";
		$regex['mail'] = "([\xA1-\xFEa-z0-9_.-]+)@([\xA1-\xFEa-z0-9_-]+\.[\xA1-\xFEa-z0-9._-]*[a-z]{2,3}(\?[\xA1-\xFEa-z0-9=&\?]+)*)";

		# &lt; 로 시작해서 3줄뒤에 &gt; 가 나올 경우와
		# IMG tag 와 A tag 의 경우 링크가 여러줄에 걸쳐 이루어져 있을 경우
		# 이를 한줄로 합침 (합치면서 부가 옵션들은 모두 삭제함)
		$src[] = "/<([^<>\n]*)\n([^<>\n]+)\n([^<>\n]*)>/i";
		$tar[] = "<\\1\\2\\3>";
		$src[] = "/<([^<>\n]*)\n([^\n<>]*)>/i";
		$tar[] = "<\\1\\2>";
		$src[] = "/<(A|IMG)[^>]*(HREF|SRC)[^=]*=[ '\"\n]*({$regex['http']}|mailto:{$regex['mail']})[^>]*>/i";
		$tar[] = "<\\1 \\2=\"\\3\">";

		# email 형식이나 URL 에 포함될 경우 URL 보호를 위해 @ 을 치환
		$src[] = "/(http|https|ftp|telnet|news|mms):\/\/([^ \n@]+)@/i";
		$tar[] = "\\1://\\2_HTTPAT_\\3";

		# 특수 문자를 치환 및 html사용시 link 보호
		$src[] = "/&(quot|gt|lt)/i";
		$tar[] = "!\\1";
		$src[] = "/<a([^>]*)href=[\"' ]*({$regex['http']})[\"']*[^>]*>/i";
		$tar[] = "<A\\1HREF=\"\\3_orig://\\4\" TARGET=\"_blank\">";
		$src[] = "/href=[\"' ]*mailto:({$regex['mail']})[\"']*>/i";
		$tar[] = "HREF=\"mailto:\\2#-#\\3\">";
		$src[] = "/<([^>]*)(background|codebase|src)[ \n]*=[\n\"' ]*({$regex['http']})[\"']*/i";
		$tar[] = "<\\1\\2=\"\\4_orig://\\5\"";

		# 링크가 안된 url및 email address 자동링크
		$src[] = "/((SRC|HREF|BASE|GROUND)[ ]*=[ ]*|[^=]|^)({$regex['http']})/i";
		$tar[] = "\\1<A HREF=\"\\3\" TARGET=\"_blank\">\\3</a>";
		$src[] = "/({$regex['mail']})/i";
		$tar[] = "<A HREF=\"mailto:\\1\">\\1</a>";
		$src[] = "/<A HREF=[^>]+>(<A HREF=[^>]+>)/i";
		$tar[] = "\\1";
		$src[] = "/<\/A><\/A>/i";
		$tar[] = "</A>";

		# 보호를 위해 치환한 것들을 복구
		$src[] = "/!(quot|gt|lt)/i";
		$tar[] = "&\\1";
		$src[] = "/(http|https|ftp|telnet|news|mms)_orig/i";
		$tar[] = "\\1";
		$src[] = "'#-#'";
		$tar[] = "@";
		$src[] = "/{$regex['file']}/i";
		$tar[] = "\\1";

		# email 주소를 변형시킴
		$src[] = "/{$regex['mail']}/i";
		$tar[] = "\\1@\\2";
		$src[] = "/<A HREF=\"mailto:([^ ]+) @ ([^\">]+)/i";
		$tar[] = "<A HREF=\"act.php?o[at]=ma&target=\\1{$rmail['chars']}\\2";

		# email 주소를 변형한 뒤 URL 속의 @ 을 복구
		$src[] = "/_HTTPAT_/";
		$tar[] = "@";

		# 이미지에 보더값 0 을 삽입
		$src[] = "/<(IMG SRC=\"[^\"]+\")>/i";
		$tar[] = "<\\1 BORDER=0>";

		# IE 가 아닌 경우 embed tag 를 삭제함
		if($agent['br'] != "MSIE") {
			$src[] = "/<embed/i";
			$tar[] = "&lt;embed";
		}

		$str = preg_replace($src,$tar,$str);
		return $str;
	}

	// 날짜를 타임스탬프로 변환하는 함수
	function str_date_to_time_stamp($date_str) {
		$wgsm_exp = explode(",", $date_str);
		$wgsm_ymd = explode("-", $wgsm_exp[0]);
		$wgsm_his = explode(":", $wgsm_exp[1]);
		$time_stamp = mktime($wgsm_his[0], $wgsm_his[1], $wgsm_his[2], $wgsm_ymd[1], $wgsm_ymd[2], $wgsm_ymd[0]);
		return $time_stamp;
	}

//	 인터페이스 관련	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// 파일내용을 바로 보여주는 함수
	function view_files($file_name, $dir='', $pp) {
		$exp = explode('.', $file_name);
		$extention = strtolower($exp[sizeof($exp)-1]);
		switch (strtolower($extention)) {
			case "png" :
			case "gif" :
			case "jpg" :
			case "jpeg" :
				$img_src = $dir . $file_name;
				$img_size = @getimagesize($img_src);
				$size_method = $pp[1];
				$input_width = $pp[0][width];
				$input_height = $pp[0][height];
				if ($size_method == 'A') {	// 상대 크기모드인경우
					if ($input_width != '') {		// 입력값이 있는경우만
						if ($input_width > $img_size[0]) $width = "width='$img_size[0]' ";		// 이미지 크기가 입력 크기보다 작은경우 이미지 크기대로 설정
						else $width = "width='$input_width' ";																// 그렇지 않은 경우 상한 입력값으로 설정
					}
					if ($input_height != '') {
						if ($input_height > $img_size[1]) $height = "height='$img_size[1]' ";
						else $height = "height='$input_height' ";
					}
				} else {	// 절대크기 모드인경우
					if ($input_width != "") $width = "width='$input_width' ";
					if ($input_height != "") $height = "height='$input_height' ";
				}
				if ($pp[0][border] != '') $border = "border='{$pp[0][border]}' ";
				if ($pp[0][align] != '') $align = "align='{$pp[0][align]}' ";
				if ($pp[0][etc] != '') $etc = $pp[0][etc];
				$property = "{$width}{$height}{$border}{$align}{$etc}";
				$value = "<img src='{$img_src}' $property>";
			break;
			case "swf" :
			break;
			default :
				$value = $file_name;
			break;
		}
		return $value;
	}
	
	// 파일 확장자에 따른 아이콘을 생성하는 함수
	function make_file_ext_icon($file_name, $img_dir='') {
		$exp = explode('.', $file_name);
		$extention = strtolower($exp[sizeof($exp)-1]);
		$icon_src = "{$img_dir}{$extention}.gif";
		if (file_exists($icon_src)) $value = "<img src='$icon_src' border=0 align='absmiddle'>";
		else $value = "<img src='{$img_dir}default.gif' border=0 align='absmiddle'>";
		return $value;
	}

	// 해당 년월에 속한 총 날짜 계산 함수
	function get_month_days($year, $month) {
		$day = 1;
		while (checkdate($month, $day, $year)) $day++;
		$day--;
		return $day;
	}

	// 년/월 선택시 페이지 이동
	function get_year_month_move($move_page='$PHP_SELF', $tails=array("년", "월")) {
		global $QUERY_STRING;
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

		// 보여줄 월을 설정함(설정되지 않았으면 오늘에 해당되는 달을 설정)
		$CD_today = getdate(time());
		if (!$_GET[CD_year]) $CD_year = $CD_today[year];
		else $CD_year = $_GET[CD_year];
		if (!$_GET[CD_month]) $CD_month = $CD_today[mon];
		else $CD_month = $_GET[CD_month];
		if (!$_GET[CD_day]) $CD_day = $CD_today[mday];
		else $CD_day = $_GET[CD_day];

		$CD_select_tag_year = "<select name='CD_year' onchange=\"change_year(this, '$move_page?$QUERY_STRING')\">";
		for ($CD_i=$CD_start_year; $CD_i<=$CD_end_year; $CD_i++) {
			if ($CD_i == $CD_year) $is_selected = " selected";
			else $is_selected = '';
			$CD_select_tag_year .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
		}
		$CD_select_tag_year .= "</select>{$tails[0]}";

		$QUERY_STRING = ereg_replace("&CD_year=[0-9]*", '', $QUERY_STRING);
		$QUERY_STRING = ereg_replace("&CD_month=[0-9]*", '', $QUERY_STRING);
		$CD_select_tag_month = "<select name='CD_month' onchange=\"change_month(this, '$move_page?$QUERY_STRING')\">";
		for ($CD_i=1; $CD_i<=12; $CD_i++) {
			if ($CD_i == $CD_month) $is_selected = " selected";
			else $is_selected = '';
			$CD_select_tag_month .= "<option value='$CD_i'{$is_selected}>$CD_i</option>";
		}
		$CD_select_tag_month .= "</select>{$tails[1]}";
		return $tag . $CD_select_tag_year . $CD_select_tag_month;
	}

	// 파일업로드 상자
	function get_file_upload_box($name, $number, $default_value, $property='') {
		$user_file_serial = $number;
		$name .= "_" . $user_file_serial;
		$file_upload_box = $this->make_input_box('', $name, "file", $property, '');
		$saved_user_file_value = explode(";", $default_value);
		if ($saved_user_file_value[$user_file_serial] != '') {				
			$etc_tag = "<br>" . $this->make_input_box($saved_user_file_value[$user_file_serial], "saved_{$name}", "text", "size=20 readonly class='input_text'", '');
			$etc_tag .= " <input type='button' value='삭제' class='input_button' onclick=\"this.form.saved_{$name}.value=''\">";
			$GLOBALS[JS_CODE][DELETE_ITEM] = "Y";
		}
		return $file_upload_box . $etc_tag;
	}

	// 각종 선택상자 만드는 함수(연관배열 제공)
	function get_list_boxs_array($list_value, $name, $default_value, $exist_null='Y', $property='', $default_num_msg=":: 선택 ::") {
		$T_option = $list_value;
		$option_name = $option_value = array();
		if ($exist_null == 'Y') {
			$option_name[] = $default_num_msg;
			$option_value[] = '';
		}
		while(list($key, $value) = each($T_option)) {
			$option_name[] = $value;
			$option_value[] = $key;
		}
		return $this->make_list_box($name, $option_name, $option_value, '', $default_value, $property, '');
	}

	// 각종 선택상자 만드는 함수(쿼리제공)
	function get_list_boxs_query($query_info, $name, $default_value, $not_null="N", $only_print="N", $property="class='designer_select'", $style='', $default_num_msg=":: 선택 ::") {
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
		return $this->make_list_box($name, $option_name, $option_value, '', $default_value, $property, $style);
	}

	// 선택상자를 만드는 함수 <select>
	function make_list_box($name, $option_name, $option_value, $selected_name, $selected_value, $property='', $style='') {
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
					if ($trimed_name == trim($selected_name)) $T_isSelected = " selected";
					else $T_isSelected = '';
				} else {
					if (array_search($trimed_name, $selected_name)) $T_isSelected = " selected";
					else $T_isSelected = '';
				}
				$input_type .= "<option value=\"$trimed_value\"{$T_isSelected}>$trimed_name</option>\n";
			}
		} else {
			for ($i=0; $i<sizeof($option_value); $i++) {
				$trimed_name = trim($option_name[$i]);
				$trimed_value = trim($option_value[$i]);
				if ($trimed_name== '') continue;
				if (!is_array($selected_value)) {
					if ($trimed_value == trim($selected_value)) $T_isSelected = " selected";
					else $T_isSelected = '';
				} else {
					if ($trimed_value != '' && is_int(array_search($trimed_value, $selected_value))) $T_isSelected = " selected";
					else $T_isSelected = '';
				}
				$input_type .= "<option value=\"$trimed_value\"{$T_isSelected}>$trimed_name</option>\n";
			}
		}
		$input_type .= "</select>";
		return $input_type;
	}

	// 입력상자를 만드는 함수 :  text, textarea, checkbox, radio
	function make_input_box($value, $name, $type, $property, $style, $default_value='Y', $is_strip_slashes='Y') {
		if ($style != '') $style = " style='$style'";
		if ($property != '') $property = " " . $property;
		if ($is_strip_slashes == "Y") $value = stripslashes($value);
		$value = htmlspecialchars($value);
		switch ($type) {
			case 'text' :
				$input_box = "<input type=\"text\" name='$name' value=\"$value\"{$property}{$style}>";
			break;
			case 'password' :
				$input_box = "<input type=\"password\" name=\"$name\"{$property}{$style}>";
			break;
			case 'textarea' :
				$input_box = "<textarea name=\"$name\"{$property}{$style}>$value</textarea>";
			break;
			case 'checkbox' :
				if ($value == $default_value) $property .= " checked";
				$input_box = "<input type=\"checkbox\" name=\"$name\" value=\"$default_value\"{$property}{$style}>";
			break;
			case 'radio' :
				if ($value == $default_value && $value != '') $property .= " checked";
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
		}
		return $input_box;
	}
	
	/* 날짜 선택 상자
	$today = getdate(time());
	$property = array("class=input_select", "class=input_select", "class=input_select");
	$print_info = array('Y'=>array("2005", "2008", $today[year], "년 "), 'M'=>array("1", "12", $today[mon], "월 "), 'D'=>array("1", "31", $today[mday], "일 "), 'H'=>array("1", "24", $today[hours], "시 "));
	*/
	function get_date_select_box($name, $print_info, $property) {
		$select_boxs = '';
		while (list($key, $value) = each($print_info)) {
			$option_name = $option_value = array();		
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

	// 날짜 입력 상자
	function make_date_input_box($check_box_name, $input_box_name, $default_value, $date_term=0, $date_point=" 현재", $date_format='', $input_box_property="size=12 class='designer_text' maxlength=20") {
		global $default_date_input_format;
		if ($date_format == '') $date_format = $default_date_input_format;
		if ($default_value != '' && $default_value != 0) $default_value = date($date_format, $default_value);
		else $default_value = '';
		if ($check_box_name != '') $check_box = $this->make_input_box('', $check_box_name, "checkbox", "onclick='if (this.checked == true) this.form.{$input_box_name}.value=this.form.{$check_box_name}.value; else this.form.{$input_box_name}.value = this.form.{$input_box_name}.defaultValue;' class='designer_checkbox'", '', date($date_format, $GLOBALS[w_time] + ($date_term*60*60*24))) . $date_point;
		$input_box = $this->make_input_box($default_value, $input_box_name, "text", $input_box_property, '', '');
		return $input_box . $check_box;
	}
	

	//	 DB 관련	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// 쿼리 수행함수
	function querying($query, $msg = "에러쿼리보고", $db_conn='') { 
		if ($DB_CONN != '') $result = mysql_query($query, $db_conn);
		else $result = mysql_query($query);
		if (!$result) {
			echo("$msg : $query<br>" . mysql_error() . "<br>");
			exit;
		}
		return $result;
	}

	// 레코드 입력 함수
	function input_record($table, $input_data) {
		$sub_query = '';
		while (list($key, $value) = each($input_data)) {
			if ($value == '') continue;
			$sub_query .= "$key='$value', ";
		}
		$sub_query = substr($sub_query, 0, -2);
		$query = "insert $table set $sub_query";
		$result = $this->querying($query);
	}

	// 특정 레코드 정보 추출
	function get_data($table, $key_field, $key_value) {
		global $SRE_file_info;
		if ($key_value == '') $this->die_msg("키 값 오류!!", $SRE_file_info[die_msg_skin]);
		$query = "select * from $table where $key_field='$key_value'";
		$result = $this->querying($query);
		return mysql_fetch_array($result);
	}

	// 특정 레코드 필드 값을 수정하는 함수
	function db_set_field_value($table, $field, $value, $serial_field, $serial_value) {
		$query = "update $table set $field='$value' where $serial_field='$serial_value'";
		$this->querying($query);
		return true;
	}

	// 특정 레코드 삭제 함수
	function db_record_delete($table, $serial_field, $serial_value) {
		if ($serial_value == '') $this->die_msg("삭제할 레코드의 일련번호가 없습니다. 삭제할 수 없습니다.");
		$query = "delete from $table where $serial_field='$serial_value'";
		$this->querying($query);
		return true;
	}

//	 FILE & DIRECTORY 관련	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// 디렉토리 복사 함수(하위 디렉토리포함)
	function copy_dir($from_path, $to_path, $isCreate, $permission) {
		$from_path .= "/";
		$to_path .= "/";
		if (!$permission) $permission = 0777;
		if (!file_exists($to_path)) {
			if ($isCreate == 1) {
				if (!mkdir($to_path, $permission)) {	// 퍼미션 설정 문제 있는가?
					echo("대상 디렉토리 생성중 에러발생");
					return false;
				} else {
					chmod ($to_path.$file, $permission);	// 한번더 확인설정
				}
			}
		}
		if (!is_dir($to_path)) {
			echo("대상 디렉토리 입력이 잘못되었습니다.");
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

	// 디렉토리(내부파일, 디렉토리포함)를 삭제하는 함수
	function delete_dir($dir_name) {
		if ($dir_name == "") {
			echo("디렉토리 삭제 오류!!");
			exit;
		}
		$dirhandle = opendir($dir_name);	// 인자로 넘겨 받은 디렉토리의 핸들을 얻는다.
		while ($filename = readdir($dirhandle)) {	// 디렉토리 안의 서브디렉토리와 파일들을 모두 탐색하여
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' 과 '../'는 무시한다.
			else {
				$filename = $dir_name . "/" . $filename;	 // 파일이름에 경로를 붙인다(디렉토리도 파일로 취급되므로 이름만으로는 확인 불가)
				if (is_dir($filename)) $this->delete_dir($filename);	// 디렉토리일 경우 현재 함수를 재귀적으로 호출
				else unlink($filename);	// 파일일 경우 삭제한다.
			}
		}
		closedir($dirhandle);	// 현재의 디렉토리 핸들을 닫고
		rmdir($dir_name);		// 현재 디렉토리를 삭제한다.
	}

	// 디렉토리(내부파일, 디렉토리포함)의 퍼미션을 변경하는 함수
	function change_permission($dir_name, $perm) {
		$dirhandle = opendir($dir_name);	// 인자로 넘겨 받은 디렉토리의 핸들을 얻는다.
		while ($filename = readdir($dirhandle)) {	// 디렉토리 안의 서브디렉토리와 파일들을 모두 탐색하여
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' 과 '../'는 무시한다.
			else {
				$filename = $dir_name . "/" . $filename;	 // 파일이름에 경로를 붙인다(디렉토리도 파일로 취급되므로 이름만으로는 확인 불가)
				if (is_dir($filename)) $this->change_permission($filename, $perm);	// 디렉토리일 경우 현재 함수를 재귀적으로 호출
				else chmod($filename, $perm);	// 파일일 경우 퍼미션 변경
			}
		}
		closedir($dirhandle);	// 현재의 디렉토리 핸들을 닫고
		chmod($dir_name, $perm);		// 현재 디렉토리 퍼미션 변경
	}

	// 디렉토리 내부의 파일만 삭제하는 함수
	function delete_inner_file($dir_name) {
		$dirhandle = opendir($dir_name);	// 인자로 넘겨 받은 디렉토리의 핸들을 얻는다.
		while ($filename = readdir($dirhandle)) {	// 디렉토리 안의 서브디렉토리와 파일들을 모두 탐색하여
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' 과 '../'는 무시한다.
			else {
				$filename = $dir_name . "/" . $filename;	 // 파일이름에 경로를 붙인다(디렉토리도 파일로 취급되므로 이름만으로는 확인 불가)
				if (is_dir($filename)) $this->delete_inner_file($filename);	// 디렉토리일 경우 현재 함수를 재귀적으로 호출
				else {
					unlink($filename);	// 파일일 경우 삭제한다.
				}
			}
		}
		closedir($dirhandle);	// 현재의 디렉토리 핸들을 닫고
	}

	// 하나의 파일을 특정디렉토리의 모든 하위 디렉토리에 복사하는 함수 ####
	function copy_sub_dir($source_file_dir, $one_file_name, $target_dir) {
		$dirhandle = opendir($target_dir);	// 인자로 넘겨 받은 디렉토리의 핸들을 얻는다.
		while ($file_name = readdir($dirhandle)) {	// 디렉토리 안의 서브디렉토리와 파일들을 모두 탐색하여
			if (!strcmp($file_name, ".") || !strcmp($file_name, "..")) {
				continue;	// './ ' 과 '../'는 무시한다.
			} else {
				$abs_file_name = $target_dir . "/" . $file_name;	 // 파일이름에 경로를 붙인다(디렉토리도 파일로 취급되므로 이름만으로는 확인 불가)
				if (is_dir($abs_file_name)) {
					$source_file = $source_file_dir . "/" . $one_file_name;
					$target_file = $abs_file_name . "/" . $one_file_name;
					echo("$source_file , $target_file <br>");
					copy($source_file, $target_file);
					chmod($target_file, 0777);
				}
			}
		}
		closedir($dirhandle);	// 현재의 디렉토리 핸들을 닫는다.
	}

	// 디렉토리 용량을 확인하는 함수(하위디렉토리 포함)
	function check_designspace($dir_name) {
		$designSize = 0;
		$dirhandle = opendir($dir_name);	// 인자로 넘겨 받은 디렉토리의 핸들을 얻는다.
		while ($filename = readdir($dirhandle)) {	// 디렉토리 안의 서브디렉토리와 파일들을 모두 탐색하여
			if (!strcmp($filename, ".") || !strcmp($filename, "..")) continue;	// './ ' 과 '../'는 무시한다.
			else {
				$filename = $dir_name . "/" . $filename;	 // 파일이름에 경로를 붙인다(디렉토리도 파일로 취급되므로 이름만으로는 확인 불가)
				if (is_dir($filename)) $designSize += $this->check_designspace($filename);	// 디렉토리일 경우 현재 함수를 재귀적으로 호출
				else $designSize += filesize($filename);
			}
		}
		closedir($dirhandle);	// 현재의 디렉토리 핸들을 닫고
		return $designSize;
	}

	// 파일 업로드 함수
	// 대상경로는 루트기준 상대경로로만 입력, 루트는 함수 내에서 설정(본 함수를 실행하는 경로는 바뀔수 있으므로, 해당 경로의 루트를 기준으로 업로드함)
	// return_dir 속성은 table 의 background 속성 처럼 이미지 경로까지 포함된 값을 리턴 받아야 할 경우 사용.
	function file_upload($upload_file_name, $saved_file_name='', $ext_array, $ext_method, $target_dir, $new_file_name='', $return_dir='') {
		global $site_info, $site_page_info, $root;
		$user_file = $_FILES[$upload_file_name][tmp_name];
		$user_file_name = $_FILES[$upload_file_name][name];
		if (substr($target_dir, -1) == '/') $target_dir = substr($target_dir, 0, -1);	// 끝에 / 가 있으면 제거한다.
		$real_target_dir = "{$root}{$target_dir}";
		if (($user_file != '') && strcmp($user_file, "none")) {
			$full_filename = explode("."  , $user_file_name);
			$extension = strtolower($full_filename[sizeof($full_filename)-1]);
			if ($ext_method == 'T') {
				if (!is_int(array_search($extension, $ext_array))) $this->alert_url("선택하신 파일은 업로드 할 수 없는 파일 입니다.");
			} else {
				if (is_int(array_search($extension, $ext_array))) $this->alert_url("선택하신 파일은 업로드 할 수 없는 파일 입니다.");
			}
			if (!file_exists($real_target_dir)) $this->alert_url("업로드할 디렉토리가 없습니다. \\n\\n{$target_dir}");
			if ($new_file_name == '') $new_file_name = $user_file_name;
			else $new_file_name = $new_file_name . '.' . $extension;
			if (file_exists("{$real_target_dir}/$new_file_name")) {
				rename("{$real_target_dir}/$new_file_name", "$target_dir/BAK_{$new_file_name}_" . time());	// 같은 이름의 파일이 있는 경우 백업한다.
				$this->alert_url("기존 같은 이름의 파일은 백업되었습니다.", 'N', '', '', '');
			}
			if(!copy($user_file, "{$real_target_dir}/$new_file_name")) $this->alert_url("업로드파일 복사실패!", 'N', '', '', '');
			if (!chmod("{$real_target_dir}/$new_file_name", 0777)) $this->alert_url("업로드 파일 권한 변경 실패", 'N', '', '', '');
			if(!unlink($user_file)) $this->alert_url("임시파일 삭제 실패!", 'N', '', '', '');
			if ($return_dir == 'Y') $new_file_name = "{$target_dir}/{$new_file_name}";
			return $new_file_name;
		} else if ($saved_file_name != '') {
			return $saved_file_name;
		} else {
			return false;
		}
	}
}
?>