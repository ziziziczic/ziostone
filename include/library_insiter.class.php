<?
class library_insiter {

/*
	�λ����� ���� ���̺귯��
*/
	function library_insiter() {
		//$GLOBALS[lib_common] = $obj;
	}

	// �˻����� �����Լ�
	function get_search_input_boxs($date_items, $items, $option_item_boxs, $hidden_tag='', $options=array()) {
		$T_sch_box = '';
		for ($i=0,$cnt=sizeof($option_item_boxs); $i<$cnt; $i++) $T_sch_box .= "<td>{$option_item_boxs[$i]}</td>";
		// �Ⱓ�Է»��� �̸�������
		if ($date_items != '') {
			$var_sch_date_1 = "SCH_{$_GET[search_item_date]}_1";
			$var_sch_date_2 = "SCH_{$_GET[search_item_date]}_2";
			$saved_date_term_box = array($_GET[$var_sch_date_1], $_GET[$var_sch_date_2]);
			if ($_GET[search_item_date] == '') {
				list($key, $value) = each($date_items);
				$_GET[search_item_date] = $key;
			}
			$P_sch_box_date_term = "
					<td>
						" . $GLOBALS[lib_common]->get_list_boxs_array($date_items, "search_item_date", $_GET[search_item_date], 'N', "class=designer_select onchange='set_search_item_date_name(this.form, this)'", ":: ���� ::") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->get_date_box_term($_GET[search_item_date], $saved_date_term_box) . "
					</td>
			";
		}
		$methods = array("or"=>"OR", "and"=>"AND");
		if ($options[action] == '') $action = $_SERVER[PHP_SELF];
		else $action = $options[action];
		$sch_box = "
			<table cellpadding=2 border=0 cellspacing=0>
				<form name=frm_sch action='$PHP_SELF' method='get'>
				$hidden_tag
				<tr>
					$T_sch_box
					<td>
						" . $GLOBALS[lib_common]->get_list_boxs_array($items, "search_item", $_GET[search_item], 'N', "class=designer_select") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($_GET[search_keyword], "search_keyword", "text", "size=10 class='designer_text'", "") . "
					</td>
					<td>
						" . $GLOBALS[lib_common]->get_list_boxs_array($methods, "search_method", $_GET[search_method], 'N', "class=designer_select style='width:40px'") . "
					</td>
					$P_sch_box_date_term
					<td>
						" . $GLOBALS[lib_common]->make_input_box($_GET[ppa], "ppa", "text", "size=1 class='designer_text'", "") . "
						<input type='submit' value='�˻�' class=designer_button>
					</td>
				</tr>
				</form>
			</table>
		";
		return $sch_box;
	}

	// ����(����ó��) ��ȣ �Լ�
	// $service_info (field_owner : �������ʵ�, field_cmp_user : ȸ����ȣ�ʵ�, field_viewer : �����ڹ�ȣ�ʵ�, char_bracket : ������ ������)
	function get_private_value($service_info, $saved_value, $user_info) {
		global $DB_TABLES, $site_info;
		if ($user_info[user_level] <= $GLOBALS[VI][admin_level_user]) return array('O', $saved_value);																																												// �������� ��� Owner ����
		if (($saved_value[$service_info[field_owner]] != '') && ($saved_value[$service_info[field_owner]] == $user_info[$service_info[field_cmp_user]])) return array('O', $saved_value);	// ������� ��� Owner ����
		if ($service_info[field_viewer] != '') {																																																																											// �����ڰ� �����Ȱ��
			$viewers = $saved_value[$service_info[field_viewer]];
			if (ereg($service_info[char_bracket] . $user_info[$service_info[field_cmp_user]] . $service_info[char_bracket], $saved_value[$service_info[field_viewer]])) return array('V', $saved_value);	// ������ ������
		}
		$sec_char = $GLOBALS[VI][sec_char];
		switch ($service_info[table]) {
			case "$DB_TABLES[jiib_sell]" :
			break;
			case "$DB_TABLES[request]" :
				$saved_value[name] = substr($saved_value[name], 0, 2) . $sec_char[name];	// �̸� ���ܰ� �ƴѰ�� �̸� ����.
				$exp = explode(' ', $saved_value[address]);
				$saved_value[address] = $exp[0] . ' ' . $exp[1] . " �ۡۡ�";
				$saved_value[phone] = $sec_char[phone];
				$saved_value[phone_mobile] = $sec_char[phone];
				$saved_value[phone_fax] = $sec_char[phone];
				$exp = explode('@', $saved_value[email]);
				$saved_value[email] = $sec_char[email] . '@' . $exp[1];
				$saved_value[homepage] = $sec_char[homepage];
			break;
			default :
				$GLOBALS[lib_common]->die_msg("���� ��Ī ���� : function get_private_value()");
			break;
		}
		return array('G', $saved_value);
	}
	
	// ȸ�� ������ ���� ���� ���� �Լ�
	function get_price_member($item_info, $user_info) {
		if ($user_info[user_level] == 1) $tail = 2;
		else $tail = $user_info[user_level];
		$field_user_price = "price_" . $tail;
		if ($item_info[$field_user_price] > 0) $price = $item_info[$field_user_price];
		else $price = $item_info[price];
		return $price;
	}
	
	// ���� ���ϳ��� ���� �Լ�
	// $skin_info = array("img_dir"=>'', "title"=>'', "padding"=>'', "contents"=>'');
	function get_skin_file($file_name, $skin_info) {
		if (!file_exists($file_name)) return '';
		$file_contents = '';
		$fd = fopen ($file_name, 'r');
		while (!feof($fd)) {
			$buffer = fgets($fd, 128);
			$file_contents .= $buffer;
		}
		fclose ($fd);
		$file_contents = str_replace("%IMG_DIR%", $skin_info[img_dir], $file_contents);
		$file_contents = str_replace("%TITLE%", $skin_info[title], $file_contents);		
		$file_contents = str_replace("%PADDING%", $skin_info[padding], $file_contents);
		if ($skin_info[contents] != '') $file_contents = str_replace("%CONTENTS%", $skin_info[contents], $file_contents);
		if ($skin_info[title] != '' && $skin_info[icon] != 'N') {
			$icon_file = "{$skin_info[img_dir]}icon.gif";
			if (file_exists($icon_file)) list($width, $height) = getimagesize($icon_file);
			$file_contents = str_replace("%ICON%", "<td width='$width'><img src='{$skin_info[img_dir]}icon.gif' width='$width' height='$height' border=0 align=top></td><td width=5></td>", $file_contents);
		} else {
			$file_contents = str_replace("%ICON%", '', $file_contents);
		}
		return $file_contents;
	}
		
	// ���� ���� �Լ�
	function w_get_img_box($style, $contents, $padding=5, $etc_info='') {
		global $DIRS;
		if ($style == '') $style = $GLOBALS[VI][thema];
		$box_dir = "{$DIRS[designer_root]}images/box/$style/";
		$skin_info = array("img_dir"=>$box_dir, "title"=>$etc_info[title], "icon"=>$etc_info[icon], "padding"=>$padding, "contents"=>$contents);
		$file_name = $box_dir . "/index.html";
		return $this->get_skin_file($file_name, $skin_info);
	}

	// ip block �Լ�
	function ip_block($ip_block_urls, $client_ip) {
		for ($i=0; $i<sizeof($ip_block_urls); $i++) {
			$ip_block_url = str_replace('*', '', trim($ip_block_urls[$i]));
			if (!strcmp(substr($client_ip, 0, strlen($ip_block_url)), $ip_block_url)) return "BLOCK";
		}
	}

	// ���̺� �� ������ Ȯ���ϴ� �Լ�
	function is_skip($design, $table_view_level, $user_info_level, $i, $table_index, $skip_info) {
		global $lib_fix;
		$close_ii = $lib_fix->search_first_index($design, $table_index, $i+1);
		$exp = explode($GLOBALS[DV][ct5], $table_view_level);

		// case 'O' ==> ������ ���� �ƴѰ��
		// case default ==> ������ ���� ������ ���
		
		// ������ �з��� ������ ������ �Ǿ� ������
		if ($exp[8] != '') {
			$exp_multi = array_filter(explode($GLOBALS[DV][ct2], $exp[8]));
			switch ($exp[9]) {
				case 'O' :
					if (!in_array($skip_info[page_type], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
				default :
					if (in_array($skip_info[page_type], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
			}
		}

		// ������ �׷캰 ������ ������ �Ǿ� ������
		if ($exp[6] != '') {
			$exp_multi = array_filter(explode($GLOBALS[DV][ct2], $exp[6]));
			switch ($exp[7]) {
				case 'O' :
					if (!in_array($skip_info[udf_group], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
				default :
					if (in_array($skip_info[udf_group], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
			}
		}

		// �������� ������ ������ �Ǿ� ������
		if ($exp[4] != '') {
			$exp_multi = array_filter(explode($GLOBALS[DV][ct2], $exp[4]));
			switch ($exp[5]) {
				case 'O' :
					if (!in_array($skip_info[design_file], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
				default :
					if (in_array($skip_info[design_file], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
			}
		}

		// �޴��� ������ ������ �Ǿ� ������
		if ($exp[2] != '') {
			if ($skip_info[page_menu] == "%B1%") $skip_info[page_menu] = $_GET[category_1];
			if ($skip_info[page_menu] == "%B2%") $skip_info[page_menu] = $_GET[category_2];
			if ($skip_info[page_menu] == "%B3%") $skip_info[page_menu] = $_GET[category_3];
			if ($skip_info[page_menu] == "%B4%") $skip_info[page_menu] = $_GET[category_4];
			if ($skip_info[page_menu] == "%B5%") $skip_info[page_menu] = $_GET[category_5];
			if ($skip_info[page_menu] == "%B6%") $skip_info[page_menu] = $_GET[category_6];
			$exp_multi = array_filter(explode($GLOBALS[DV][ct2], $exp[2]));
			switch ($exp[3]) {				
				case 'O' :
					if (!in_array($skip_info[page_menu], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
				default :
					if (in_array($skip_info[page_menu], $exp_multi)) $new_i = "VIEW";
					else return $close_ii;
				break;
			}
		}

		if ($exp[0] != '') {
			if (!$this->is_login()) $level = 8;
			else $level = $user_info_level;
			switch ($exp[1]) {
				case 'U' :
					if ($exp[0] >= $level) $new_i = "VIEW";								// �� �� �ִ� ����
					else return $close_ii;																	// �� �� ���� ����
				break;
				case 'L' :
					if ($exp[0] <= $level) $new_i = "VIEW";								// �� �� �ִ� ����
					else return $close_ii;																	// �� �� ���� ����
				break;
				default :
					if ($exp[0] == $level) $new_i = "VIEW";								// �� �� �ִ� ����
					else return $close_ii;																	// �� �� ���� ����
				break;
			}
		}
		return "VIEW";
	}

	// ��������� ȸ���ʵ� ���� �����Լ�
	function member_field_define($site_info, $user_info) {
		$field_define_name = "member_field_define_{$user_info[user_level]}";																	// ���Ѻ� �ʵ�� ����
		if ($site_info[$field_define_name] != '') $member_field_define = $site_info[$field_define_name];					// �ش� ���� �ʵ尡 ���ǵǾ� ������
		else if ($site_info[member_field_define] != '') $member_field_define = $site_info[member_field_define];	// ���� �ʵ尡 ���� �Ǿ� ������
		else return '';																																																// ��������� ������
		$membef_field_defines = array();
		$defined_fields = explode("\r\n\r\n", $member_field_define);						// ȸ�� �ʵ� ���� �ҷ���
		for ($i=0; $i<sizeof($defined_fields); $i++) {															// ���ǵ� �ʵ� �� ��ŭ �ݺ�
			$exp_1 = explode($GLOBALS[DV][ct1], $defined_fields[$i]);						// �� �ʵ庰 ���Ǹ� 1�پ� �ҷ���
			$H_define = array_shift($exp_1);																				// ù ��° ���� �ʵ��� ����, ���� �� ���� �Է»��� �����׸� ����
			$H_define_exp = explode($GLOBALS[DV][ct2], $H_define);							// ù ��° �� (�ʵ��, Ÿ��, Ÿ��Ʋ, �Ӽ�->�����ڸ�忡����)
			$member_field_defines[$H_define_exp[0]] = array($H_define_exp[1], implode($GLOBALS[DV][ct1], $exp_1), $H_define_exp[2], $H_define_exp[3], $H_define_exp[4]);
		}
		return $member_field_defines;
	}

	function make_multi_input_box($type, $name, $item_define, $default_value, $divider, $default_pp='', $file_dir='') {
		if ($type == "file") {
			$exp_idx = explode('_', $name);
			$idx = $exp_idx[sizeof($exp_idx)-1];
			unset($exp_idx[sizeof($exp_idx)-1]);
			$name = implode('_', $exp_idx);
			$value = $GLOBALS[lib_common]->get_file_upload_box($name, $idx, $default_value, $default_pp, $file_dir);
		} else if ($type == "select") {							// ���û����ΰ��
			$T_default_value = explode($GLOBALS[DV][ct2], $default_value);			// 2�� �̻� ���õ� ����
			if (sizeof($T_default_value) > 1) $default_value = $T_default_value;		// �迭 ���ڸ� �Ѱ���
			$T_items = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).n, "\n", $item_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
			$value = $GLOBALS[lib_common]->get_list_boxs_array($T_items, $name, $default_value, 'N', $default_pp);
		} else if ($type == "radio") {				// ������ư
			$T_items = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).n, "\n", $item_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
			$value = $GLOBALS[lib_common]->get_radio_array($T_items, $name, $default_value, $default_pp, $divider);
		} else if ($type == "checkbox") {		// üũ�����ΰ��
			$T_default_value = explode($GLOBALS[DV][ct2], $default_value);			// 2�� �̻� ���õ� ����
			if (sizeof($T_default_value) > 1) $default_value = $T_default_value;		// �迭 ���ڸ� �Ѱ���
			$T_items = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).n, "\n", $item_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
			$value = $GLOBALS[lib_common]->get_checkbox_array($T_items, $name, $default_value, $default_pp, $divider);
		} else {		// ��Ÿ�����ΰ��
			$value = $GLOBALS[lib_common]->make_input_box($default_value, $name, $type, $default_pp, '');
		}
		return $value;
	}

	function make_article_common_link($value, $user_files, $pp_link) {
		global $user_info, $board_info, $article_value, $site_info, $search_item, $search_value, $root;
		$upload_files = explode(';', $user_files);
		$link_file_name = $upload_files[$pp_link[5]-1];
		switch ($pp_link[6]) {
			case 'S' :		// ����(���뿭��) ��ũ
				$article_auth_info = $this->get_article_auth($board_info, $article_value, $user_info, "view", "link");
				if ($value == '-' && $article_auth_info != 'O' && $article_auth_info != 'P') return $value;
				if ($article_auth_info != 'X') {
					$move_page = $board_info[view_page];
					if ($article_auth_info == 'P') {															// ����� �Խù��ΰ��
						$change_vars = array("design_file"=>$move_page, "article_num"=>$article_value[serial_num]);
						$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
						$value = $GLOBALS[lib_common]->make_link($value, "#;", '', '', "onclick=\"SYSTEM_on_passwd_input('$link_url', '$target', event)\"");
						$GLOBALS[JS_CODE][PRIVATE_ARTICLE] = "Y";
						$GLOBALS[ETC_CODE][PRIVATE_LAYER] = "Y";
					} else {
						if ($GLOBALS[JS_CODE][SUBJECT_LAYER] == 'Y') {
							$value = $GLOBALS[lib_common]->make_link($value, "javascript:show_answer(document.all.Q{$article_value[serial_num]},document.all.A{$article_value[serial_num]})", '', '', "onFocus=this.blur();");
						} else {
							$w_change_vars = array("design_file"=>$move_page, "article_num"=>$article_value[serial_num]);
							$link = "{$root}{$site_info[index_file]}?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $w_change_vars);
							$value = $GLOBALS[lib_common]->make_link($value, $link, $pp_link[0], $pp_link[1], $pp_link[2]);
						}
					}
				}
			break;
			case 'L' :
				$value = $GLOBALS[lib_common]->make_link($value, "{$root}design/upload_file/$board_info[name]/$link_file_name", $pp_link[0], $pp_link[1], $pp_link[2]);
			break;
			case 'B' :
				$T_img_src = "design/upload_file/$board_info[name]/{$link_file_name}";
				$value = $GLOBALS[lib_common]->make_link($value, "{$root}tools/big_img_view.php?src={$T_img_src}", "_nw", "big_img_view, 0,0,500,500,1,0,1,0", "title='$article_value[subject]'");
			break;
			case 'R' :
				$value = $GLOBALS[lib_common]->make_link($value, '#', $pp_link[0], $pp_link[1], "onmouseover=\"mouseover_view('$pp_link[8]', 'IMG_{$article_value[serial_num]}_{$pp_link[5]}')\"");
				$T_img_src = "design/upload_file/$board_info[name]/{$link_file_name}";
				$GLOBALS[JS_CODE][MOUSEOVER_VIEW] = 'Y';
				$GLOBALS[JS][] = "
					IMG_{$article_value[serial_num]}_{$pp_link[5]} = new Image();
					IMG_{$article_value[serial_num]}_{$pp_link[5]}.src = \"$T_img_src\";
				";
			break;
			case 'D' :	 // �ٿ�ε�
			break;
			case 'G' :	 // ������
			break;
			case 'O' :	 // �ƿ���
				if ($article_value[email] != '') $value = $GLOBALS[lib_common]->make_link($value, "mailto:$article_value[email]", '', '');
			break;
			case 'F' :	 // ������
				if ($article_value[email] != '') $value = $GLOBALS[lib_common]->make_link($value, "{$root}tools/form_mail/send_mail_form.php?email_address=$article_value[email]", "_nw", "form_mail, 30,30,500,450,1,1,1");
			break;
		}
		return $value;
	}

	// �Խ��� ���
	function get_board_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='9') {
		global $DIRS, $IS_btns, $DB_TABLES, $root, $site_info;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$level_alias = $this->get_level_alias($site_info[user_level_alias]);
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		$list_tag = '';
		$i = 0;
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			if ($value[create_date] == 0) $create_date = "�˼� ����";
			else $create_date = date("Y-m-d", $value[create_date]);
			$query = "select count(serial_num) from {$DB_TABLES[board]}_{$value[name]}";
			$result1 = $GLOBALS[lib_common]->querying($query, "�Խù� ���� ���� ���� ������ �����߻�");
			$total_article = mysql_result($result1, 0, 0);
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			$list_tag .= "
				<tr align='center' bgcolor='$tr_color'> 
					<td>$virtual_num</a></td>
					<td align=left nowrap>
						<a href='board_input_form.php?board_name=$value[name]&mode=modify'>{$value[alias]}</a>
					</td>
					<td>{$value[name]}</td>
					<td>{$value[admin]}</td>
					<td><a href='#;' title='�б� : {$level_alias[$value[read_perm]]} �̻�'>$value[read_perm]</a>:<a href='#;' title='���� : {$level_alias[$value[write_perm]]} �̻�'>$value[write_perm]</a>:<a href='#;' title='�亯 : {$level_alias[$value[reply_perm]]} �̻�'>$value[reply_perm]</a></td>
					<td>$total_article ��</td>
					<td align='center' nowrap>$create_date</td>
					<td>
						<a href='{$DIRS[designer_root]}page_designer.php?design_file={$value[list_page]}&page_type=U' title='�Խ��ǵ����μ���'>$IS_btns[modify]</a><a href='{$root}{$site_info[index_file]}?design_file={$value[list_page]}' target=_blank title='�Խ��ǹ̸�����'>$IS_btns[view]</a><a href='#;' onclick=\"window.open('{$DIRS[designer_root]}template_input_form.php?board_name={$value[name]}', 'template_input', 'left=10,top=10,width=600,height=330, scrollbars=1').focus()\" title='���ø������'>{$IS_btns[template]}</a>
					</td>
					<td>
						<a href='board_input_form.php?board_name=$value[name]&mode=modify' title='�Խ��ǼӼ�����'>$IS_btns[property]</a><a href=\"javascript:verify_delete('$value[name]');\" title='�Խ��� ����'>$IS_btns[delete]</a>
					</td>
				</tr>
			";
			$i++;
		}
		if ($list_tag == '') {
			$list_tag = "
												<tr align='center'>
													<td colspan='colspan'>��ϵ� �Խ����� �����ϴ�.</td>
												</tr>
			";
		}
		return $list_tag;
	}
	
	// ������ ���
	function get_page_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='9') {
		global $DIRS, $IS_btns, $site_info, $page_menu_etc, $IS_level_mode, $user_level_alias;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		$list_tag = '';
		$i = 0;
		$design_file_menu_array = $GLOBALS[lib_common]->parse_property($site_info[design_file_menu] . "\n{$page_menu_etc}", $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
		while ($value = mysql_fetch_array($result)) {
			$spacer = '';
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			if ($value[type] != 'Y') $delete_link = "<a href=\"javascript:verify_delete('$value[file_name]')\">$IS_btns[delete]</a>";
			else $delete_link = "<a href=\"javascript:alert('�ý��������� ������ �� �����ϴ�.')\">$IS_btns[delete]</a>";
			for($j = 0; $j < strlen($value[thread])-1; $j++) $spacer .= "&nbsp;&nbsp;&nbsp;";
			if (strlen($value[thread]) > 1) {
				$spacer .= "<img src='{$DIRS[designer_root]}images/re.gif' border=0> "; 
			}
			$add_page_button = "<a href=\"javascript:openAddCateWin('$value[file_name]')\">$IS_btns[add]</a>";
			$change_vars = array("design_file"=>$value[file_name]);
			$link_modify = "{$DIRS[designer_root]}page_designer.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			switch ($print_type) {
				case "move" :
					$list_tag .= "
					<tr align=center bgcolor='$tr_color'>
						<td>$virtual_num</td>
						<td align='left' nowrap>{$spacer}{$value[name]}</td>
						<td nowrap><a href=\"javascript:verify_move('{$value[name]}', '{$value[file_name]}')\">{$IS_btns[move]}</a></td>	
						<td>$value[file_name]</td>
						<td>$value[skin_file]</td>
					</tr>
					";
				break;
				default :
					$list_tag .= "
					<tr align=center bgcolor='$tr_color'>
						<td>$virtual_num</td>
						<td align='left' nowrap>{$spacer}<a href='$link_modify'>$value[name]</a></td>
						<td>$value[file_name]</td>
						<td>$value[skin_file]</td>
						<td nowrap>{$design_file_menu_array[$value[menu]]}</td>
						<td><a href='#;' title='{$user_level_alias[$value[view_level]]}'>{$value[view_level]}</a>:<a href='#;' title='{$IS_level_mode[$value[view_level_mode]]}'>{$value[view_level_mode]}</a></td>
						<td align='center'>$value[hit_count]</td>
						<td align='center'><a href='$link_modify'>{$IS_btns[edit]}</a><a href='#;' onclick=\"javascript:window.open('page_designer_tag_form.php?design_file={$value[file_name]}','main_input', 'top=0,left=0,width=710,height=700,resizable=1,status=1,scrollbars=1,menubar=0').focus()\">{$IS_btns[header]}</a></td>
						<td align='center'>$add_page_button</td>
						<td align='center'><a href=\"javascript:openModifyCateWin('$value[file_name]')\">$IS_btns[property]</a><a href='#;' onclick=\"window.open('{$DIRS[designer_root]}page_move_form.php?design_file={$value[file_name]}', 'page_move', 'left=0,top=0,width=600,height=700, scrollbars=1').focus()\" title='�������̵�'>{$IS_btns[move]}</a><a href='#;' onclick=\"window.open('{$DIRS[designer_root]}template_input_form.php?design_file_name={$value[file_name]}', 'template_input', 'left=10,top=10,width=600,height=330, scrollbars=1').focus()\" title='���ø������'>{$IS_btns[template]}</a>{$delete_link}</td>
					</tr>
					";
				break;
			}
			$i++;
		}

		if ($list_tag == '') {
			$list_tag = "
												<tr align='center'>
													<td colspan='9'>��ϵ� �������� �����ϴ�.</td>
												</tr>
			";
		}
		return $list_tag;
	}

	// ȸ�� ��� ��� �Լ�
	function get_member_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='9', $etc_info='') {
		global $site_info, $user_level_alias, $DIRS, $IS_btns;
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			$reg_date = date("Y-m-d", $value[reg_date]);
			$rec_date = date("Y-m-d", $value[rec_date]);
			$btn_login = "<a href=\"javascript:login('$value[serial_num]')\">{$IS_btns[login]}</a>";
			$btn_modify_link = "<a href='{$DIRS[designer_root]}member_input_form.php?serial_num=$value[serial_num]'>";
			if ($value[user_level] != 1 && $site_info[site_id] != $value[id]) $btn_delete = "<a href=\"javascript:verify('$value[serial_num]')\">{$IS_btns[delete]}</a>";
			else $btn_delete = "<a href=\"javascript:alert('�����ڴ� ������ �� �����ϴ�.')\">{$IS_btns[delete]}</a>";
			if ($DIRS[shop_root] != '') {
				global $shop_admin_dir;
				$cyber_money = "<td align=right>" . $GLOBALS[lib_common]->make_link(number_format($this->get_mb_cyber_money($value[id])), "{$DIRS[designer_root]}member_cm_list.php?search_item=mb_id&search_keyword={$value[id]}") . "</td>";
			} else {
				$cyber_money = '';
			}
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			switch ($print_type) {
				case "sch_member" :
					$new_ele = array();
					for ($ele_i=0; $ele_i<sizeof($etc_info); $ele_i++) {
						$new_ele[] = "'{$value[$etc_info[$ele_i]]}'";
					}
					$P_new_ele = implode(',', $new_ele);
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td><input type=radio name='btn_select_member' value='$value[serial_num]' onclick=\"select_member($P_new_ele)\"></td>
								<td>" . number_format($value[serial_num]) . "</td>
								<td align=left>{$value[id]}</td>
								<td>{$value[name]}</td>
								<td align=left nowarp>{$value[email]}</td>
								<td align=left>{$value[phone_mobile]}</td>
								<td>{$user_level_alias[$value[user_level]]}</td>
							</tr>
					";
				break;
				default :
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td>$virtual_num</td>
								<td align=left>{$btn_modify_link}$value[id]</a></td>
								<td>{$btn_modify_link}{$value[name]}</td>
								<td align=left>{$btn_modify_link}{$value[email]}</td>
								<td>{$btn_modify_link}{$user_level_alias[$value[user_level]]}</td>
								$cyber_money
								<td>$rec_date</td>
								<td>$reg_date</td>
								<td>{$btn_login}{$btn_modify_link}{$IS_btns[modify]}</a>{$btn_delete}</td>
							</tr>
					";
				break;
			}
			$i++;
		}	// while end	
		if ($i == 0) {
			$list = "
											<tr bgcolor=ffffff>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		} else {
			$list .= "
			<form name=frm_dynamic method=post action='./member_manager.php'>
				<input type='hidden' name='mode' value='delete'>
				<input type='hidden' name='serial_num' value=''>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
			</form>
			<script language='javascript'>
				<!--
				function verify(serial_num) {
					if (confirm(\"������ ȸ�������� �����Ͻðڽ��ϱ�? ������ ������ ���� �� �� �����ϴ�.\")) {
						form = document.frm_dynamic;
						form.serial_num.value = serial_num;
						form.submit();
					}
				}
				function login(serial_num) {
					if (confirm(\"������ ȸ������ �α��� �Ͻðڽ��ϱ�?.\")) {
						form = document.frm_dynamic;
						form.serial_num.value = serial_num;
						form.action = '{$DIRS[designer_root]}member_login.php';
						form.submit();
					}
				}
				//-->
			</script>
			";
		}
		mysql_free_result($result);
		return $list;
	}

	// ȸ�� �α��� �α� ��� �Լ�
	function get_member_visit_log($query, $total, $ppa=0, $page=1, $print_type='', $colspan='9', $etc_info='') {
		global $site_info, $user_level_alias, $DIRS, $IS_btns;
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			$reg_date = date("Y-m-d H:i:s", $value[visit_date]);
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			$term_info = $GLOBALS[lib_common]->get_sec_to_other($value[visit_term]);
			$btn_modify_link = "<a href='{$DIRS[designer_root]}member_input_form.php?serial_num=$value[serial_num]'>";
			switch ($print_type) {
				case "ranking" :
					$ranking = $i + 1;
					$btn_log_link = "<a href='{$DIRS[designer_root]}member_visit_log.php?search_item=id&search_keyword=$value[id]'>";
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td>$ranking</td>
								<td>{$btn_modify_link}$value[id]</a></td>
								<td>{$btn_modify_link}$value[name]</td>
								<td>{$btn_modify_link}{$user_level_alias[$value[user_level]]}</td>	
								<td>{$btn_modify_link}$value[phone]</td>
								<td>{$btn_modify_link}$value[phone_mobile]</td>
								<td>{$btn_modify_link}$value[email]</td>
								<td>{$btn_log_link}$value[visit_total]</td>
							</tr>
					";
				break;
				default :
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td>$value[serial_log]</td>
								<td>{$btn_modify_link}$value[id]</a></td>
								<td>{$btn_modify_link}$value[name]</td>
								<td>{$btn_modify_link}$value[visit_ip]</td>
								<td>{$btn_modify_link}{$user_level_alias[$value[user_level]]}</td>
								<td>{$btn_modify_link}$reg_date</td>
								<td>{$btn_modify_link}$value[visit_total]</td>
								<td align=right>{$btn_modify_link}" . number_format($term_info[0]) . " $term_info[1]</td>
							</tr>
					";
				break;
			}
			$i++;
		}	// while end	
		if ($i == 0) {
			$list = "
											<tr bgcolor=ffffff>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		}
		mysql_free_result($result);
		return $list;
	}

	// ��� ��� �Լ�
	function get_stat_list($query, $total, $ppa=0, $page=1, $print_type, $colspan='9', $etc_info='') {
		global $root, $DIRS, $site_info, $IS_withdrawal_question;
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			switch ($print_type) {
				case "member_join" :
					if ($_GET[view_type] == 'Y') {
						$date_start = $value[ymd] . "-01-01";					
						$date_end = $value[ymd] . '-12-' . $GLOBALS[lib_common]->get_last_date_month($exp_date[0], 12);
						$change_vars = array("view_type"=>'M', $var_sch_date_1=>$date_start, $var_sch_date_2=>$date_end);
						$link_date = "{$DIRS[designer_root]}member_stat_join.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
						$link_date = "<a href='$link_date'>";
					} else if ($_GET[view_type] == 'M') {
						$date_start = $value[ymd] . "-01";
						$date_end = $value[ymd] . '-' . $GLOBALS[lib_common]->get_last_date_month($exp_date[0], $exp_date[1]);
						$change_vars = array("view_type"=>'D', $var_sch_date_1=>$date_start, $var_sch_date_2=>$date_end);
						$link_date = "{$DIRS[designer_root]}member_stat_join.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
						$link_date = "<a href='$link_date'>";
					} else {
						$link_date = '';
					}
					$width = (100*$value[cnt_join])/$etc_info[max];
					if ($T_value_ymd != $value[ymd]) $value_ymd = "{$link_date}{$value[ymd]}</a>";
					else $value_ymd = '';
					$T_value_ymd = $value[ymd];
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td>{$value_ymd}</td>
								<td>" . number_format($value[cnt_join]) . "</td>
								<td align=left>
									<table cellpadding=3 cellspacing=1 border=0 width='{$width}%' height=15>
										<tr>
											<td background='{$DIRS[designer_root]}images/bg_graph.gif'></td>
										</tr>
									</table>
								</td>
							</tr>
					";
				break;
				case "member_withdrawal" :
					if ($_GET[view_type] == 'Y') {
						$date_start = $value[ymd] . "-01-01";					
						$date_end = $value[ymd] . '-12-' . $GLOBALS[lib_common]->get_last_date_month($exp_date[0], 12);
						$change_vars = array("view_type"=>'M', $var_sch_date_1=>$date_start, $var_sch_date_2=>$date_end);
						$link_date = "{$DIRS[designer_root]}member_stat_withdrawal.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
						$link_date = "<a href='$link_date'>";
					} else if ($_GET[view_type] == 'M') {
						$date_start = $value[ymd] . "-01";
						$date_end = $value[ymd] . '-' . $GLOBALS[lib_common]->get_last_date_month($exp_date[0], $exp_date[1]);
						$change_vars = array("view_type"=>'D', $var_sch_date_1=>$date_start, $var_sch_date_2=>$date_end);
						$link_date = "{$DIRS[designer_root]}member_stat_withdrawal.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
						$link_date = "<a href='$link_date'>";
					} else {
						$link_date = '';
					}
					$width = (100*$value[cnt_withdrawal])/$etc_info[max];
					if ($T_value_ymd != $value[ymd]) $value_ymd = "{$link_date}{$value[ymd]}</a>";
					else $value_ymd = '';
					$T_value_ymd = $value[ymd];
					$list .= "
							<tr align=center bgcolor='$tr_color'>
								<td>{$value_ymd}</td>
								<td>" . number_format($value[cnt_withdrawal]) . "</td>
								<td align=left>
									<table cellpadding=3 cellspacing=1 border=0 width='{$width}%' height=15>
										<tr>
											<td background='{$DIRS[designer_root]}images/bg_graph.gif'></td>
										</tr>
									</table>
								</td>
								<td align=left>{$IS_withdrawal_question[$value[withdrawal_question]]}</td>
							</tr>
					";
				break;
			}
			$i++;
		}	// while end	
		if ($i == 0) {
			$list = "
											<tr bgcolor=ffffff>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		}
		mysql_free_result($result);
		return array($list);
	}


	// �˾� ��� ��� �Լ�
	function get_popup_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='7') {
		global $site_info, $user_level_alias, $DIRS, $IS_btns;
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			if ($value[end_time] > time()) $P_end_time = "<font color=red>";
			else $P_end_time = '';
			$btn_modify_link = "<a href='{$DIRS[designer_root]}popup_input_form.php?serial_num=$value[serial_num]'>";
			$btn_delete = "<a href=\"javascript:verify('$value[serial_num]')\">{$IS_btns[delete]}</a>";
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			$list .= "
					<tr bgcolor='$tr_color' align='center'> 
						<td align='center' width='40'>$virtual_num</a></td>
						<td nowrap align=left>
							{$btn_modify_link}{$value[subject]}</a>
						</td>
						<td>$value[design_file]</td>
						<td>$value[type]</td>
						<td>" . $GLOBALS[lib_common]->get_format("date", $value[begin_time], '', "Y-m-d, H:i:s") . "</td>
						<td>{$P_end_time}" . $GLOBALS[lib_common]->get_format("date", $value[end_time], '', "Y-m-d, H:i:s") . "</td>
						<td>{$btn_modify_link}{$IS_btns[modify]}</a>{$btn_delete}</td>
					</tr>
			";
			$i++;
		}	// while end	
		if ($i == 0) {
			$list = "
											<tr bgcolor=ffffff>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		} else {
			$list .= "
			<form name=frm_delete method=post action='./popup_manager.php'>
				<input type='hidden' name='mode' value='delete'>
				<input type='hidden' name='serial_num' value=''>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
			</form>
			<script language='javascript'>
				<!--
				function verify(serial_num) {
					if (confirm(\"������ �˾������� �����Ͻðڽ��ϱ�? ������ ������ ���� �� �� �����ϴ�.\")) {
						form = document.frm_delete;
						form.serial_num.value = serial_num;
						form.submit();
					}
				}
				//-->
			</script>
			";
		}
		mysql_free_result($result);
		return $list;
	}

	// ������ ��� ��� �Լ�
	function get_cm_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='9') {
		global $site_info, $user_level_alias, $DB_TABLES, $root, $IS_btns;
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			if (($i%2) == 0) $tr_color = "#FFFFFF";
			else $tr_color = "#F8F5F0";
			$btn_delete = "<a href=\"javascript:verify('$value[id]')\">[����]</a>";
			$mi_memo = stripslashes($value[mi_memo]);
			if ($value[od_id] > 0 && strlen($mi_memo) == 4) {	// ��õ�� ���� ������ �������� �ֹ���ȣ�� ������ �ȵ�
				$query = "select on_uid from $DB_TABLES[s_order] where od_id='$value[od_id]' ";
				$result1 = $GLOBALS[lib_common]->querying($query);
				$row1 = mysql_fetch_array($result1);
				$a = "<a href='#;' onclick=\"window.open('{$root}insiter.php?design_file=order_list_detail.php&od_id=$value[od_id]&on_uid=$row1[on_uid]', 'od_detail', 'left=0,top=0,width=700,height=650,resizable=1,scrollbars=1').focus()\">";
				$str = "�ֹ� $a{$value[od_id]}</a> ";
				if ($value[ct_id] > 0) $str .= "�� " . get_it_name($row1[it_id]);
				$str .= " �� ���� " . $mi_memo;
				$mi_memo = $str;
			}
			$milage = ($value[mi_milage] >= 0) ? "+" . number_format($value[mi_milage]) : number_format($value[mi_milage]);
			$state_cm = $GLOBALS[VI][state_cm];
			switch ($print_type) {
				case "admin" :
					$btn_modify = "<a href='{$DIRS[designer_root]}member_cm_list.php?mi_id=$value[mi_id]'>{$IS_btns[modify]}</a>";
					$btn_delete = "<a href=\"javascript:verify_delete('$value[mi_id]')\">{$IS_btns[delete]}</a>";
					$list .= "
							<tr bgcolor='#FFFFFF' align=center height='25'>
								<td>{$value[mi_id]}</td>
								<td>" . $GLOBALS[lib_common]->get_format("date", $value[mi_time], '', "Y-m-d H:i:s") . "</td>
								<td align=left>$mi_memo</a></td>
								<td>{$state_cm[$value[mi_state]]}</td>
								<td align=right>{$milage}</td>
								<td>{$btn_modify}{$btn_delete}</td>
							</tr>
					";
				break;
				default :
					$list .= "
							<tr bgcolor='#FFFFFF' align=center height='25'>
								<td>$virtual_num</td>
								<td>" . $GLOBALS[lib_common]->get_format("date", $value[mi_time], '', "Y-m-d H:i:s") . "</td>
								<td align=left>$mi_memo</a></td>
								<td>{$state_cm[$value[mi_state]]}</td>
								<td align=right>$milage</td>						
							</tr>
					";
				break;
			}
			$i++;
		}	// while end
		if ($i == 0) {
			$list = "
											<tr bgcolor='#FFFFFF'>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		}
		mysql_free_result($result);
		return $list;
	}

	// �湮��� ��� ��� �Լ�
	function get_visit_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='6') {
		$list = '';
		$i = 0;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $GLOBALS[lib_common]->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
				
		while ($row = mysql_fetch_array($result)) {
			$vi_referer='';
			if($row[vi_referer]) $vi_referer = "<a href='$row[vi_referer]' target=referer>$row[vi_referer]</a>";
			$vi_user_agent = strtolower($row[vi_user_agent]);

			if(ereg("msie 4.0", $vi_user_agent))            { $browser = "MSIE 4.0"; }
			elseif(ereg("msie 5.0", $vi_user_agent))        { $browser = "MSIE 5.0"; }
			elseif(ereg("msie 5.5", $vi_user_agent))        { $browser = "MSIE 5.5"; }
			elseif(ereg("msie 6.0", $vi_user_agent))        { $browser = "MSIE 6.0"; }
			elseif(ereg("x11", $vi_user_agent))             { $browser = "Netscape"; }
			else                                            { $browser = "��Ÿ"; }

			if(ereg("windows 95", $vi_user_agent))          { $os = "Windows 95"; }
			elseif(ereg("windows 98", $vi_user_agent))      { $os = "Windows 98"; }
			elseif(ereg("windows me", $vi_user_agent))      { $os = "Windows ME"; }
			elseif(ereg("windows 2k", $vi_user_agent))      { $os = "Windows 2000"; }
			elseif(ereg("windows nt 4.0", $vi_user_agent))  { $os = "Windows NT 4.0"; }
			elseif(ereg("windows nt 5.0", $vi_user_agent))  { $os = "Windows NT 5.0"; }
			elseif(ereg("linux", $vi_user_agent))           { $os = "Linux"; }
			elseif(ereg("unix", $vi_user_agent))            { $os = "Unix"; }
			else                                            { $os = "��Ÿ"; }
			$class = ($i % 2) ? "onmouseover" : "onmouseout";			
			$list .= "
				<tr align=center class=$class>
					<td>$row[vi_id]</td>
					<td>$row[vi_time]</td>
					<td align=left>&nbsp;$row[vi_remote_addr]</td>
					<td align=left>&nbsp;$vi_referer</td>
					<td>$browser</td>
					<td>$os</td>
				</tr>
			";
			$i++;
		}	// while end	
		if ($i == 0) {
			$list = "
											<tr bgcolor=ffffff>
												<td colspan='$colspan'>�˻��� ��� ����</td>
											</tr>
			";
		}
		mysql_free_result($result);
		return $list;
	}

	function design_file_list($name, $type, $type_view='Y', $design_file, $property='', $saved_design_file='', $is_print='Y', $type_mode='T', $self_view='N', $first_value='') {
		global $DB_TABLES;
		if (!is_array($type)) {
			if ($self_view != 'Y') $query = "select * from $DB_TABLES[design_files] where file_name<>'$design_file' order by type desc, fid desc, thread asc, name asc";
			else $query = "select * from $DB_TABLES[design_files] order by type desc, fid desc, thread asc, name asc";
		} else {
			if ($self_view != 'Y') $sub_query = " where file_name<>'$design_file' and (";
			else $sub_query = " where (";
			if ($type_mode == 'T') {
				for ($i=0; $i<sizeof($type); $i++) $sub_query .= " type='$type[$i]' or ";
				$sub_query = substr($sub_query, 0, -3) . ")";
			} else {
				for ($i=0; $i<sizeof($type); $i++) $sub_query .= " type<>'$type[$i]' and ";
				$sub_query = substr($sub_query, 0, -4) . ")";
			}
			$query = "select * from $DB_TABLES[design_files]{$sub_query} order by type desc, fid desc, thread asc, name asc";
		}
		$result = $GLOBALS[lib_common]->querying($query, "$name ���������ϸ���Ʈ ���� ���� ������ �����߻�");
		
		$option_name = array(":: ���������� ::");
		$option_value = array($first_value);

		while ($design_file_value = mysql_fetch_array($result)) {
			if ($type_view == 'Y') {
				switch ($design_file_value[type]) {
					case "I" :
						$page_type = " [I]";
					break;
					case "S" :
						$page_type = " [S]";
					break;
					case "B" :
						$page_type = " [B]";
					break;
					case "T" :
						$page_type = " [T]";
					break;
					case "U" :
						$page_type = " [U]";
					break;
					case "T" :
						$page_type = " [T]";
					break;
					case "Y" :
						$page_type = " [Y]";
					break;
					case "P" :
						$page_type = " [P]";
					break;
					case "J" :
						$page_type = " [J]";
					break;
					default :
						$page_type = '';
					break;
				}
			} else {
				$page_type = '';
			}
			// ���� ������ ǥ�� ����
			$spacer = "";
			for($j = 0; $j < strlen($design_file_value[thread])-1; $j++) $spacer .= "&nbsp;";
			if (strlen($design_file_value[thread]) > 1) {
				$spacer .= "�� "; 
			}
			$option_name[] = $spacer . $design_file_value[name] . $page_type;
			$option_value[] = $design_file_value[file_name];
		}
		if (eregi("multiple", $property)) {
			$multi_sep = ';';
			$new_name = $name . "_multi";
			$etc_tag = "<input type='hidden' name='$name' value='$saved_design_file'>";
			$property .= " onchange=\"multi_select(this.form, '$new_name', '$name', '$multi_sep')\"";
			$GLOBALS[JS_CODE][MULTI_SELECT] = "Y";
			$saved_design_file = explode($multi_sep, $saved_design_file);
		} else {
			$new_name = $name;
		}
		if ($is_print == 'Y') echo($GLOBALS[lib_common]->make_list_box($new_name, $option_name, $option_value, "", $saved_design_file, "class=designer_select $property", "") . $etc_tag);
		else return $GLOBALS[lib_common]->make_list_box($new_name, $option_name, $option_value, "", $saved_design_file, "class=designer_select $property", "") . $etc_tag;
	}

	function design_file_count($design_file) {
		global $DB_TABLES;
		$query = "update $DB_TABLES[design_files] set hit_count=hit_count+1 where file_name='$design_file'";
		$GLOBALS[lib_common]->querying($query);
	}

	function delete_board($board_name) {
		global $DIRS, $DB_TABLES, $lib_fix;
		// ���ε� ���丮 ����
		if ($board_name == "") die("������ �Խ����� �����ϴ�.");
		$GLOBALS[lib_common]->delete_dir("{$DIRS[design_root]}upload_file/{$board_name}/");

		$board_info = $lib_fix->get_board_info($board_name);
		$lib_fix->delete_design_file($DIRS, $board_info[list_page]);
		$lib_fix->delete_design_file($DIRS, $board_info[view_page]);
		$lib_fix->delete_design_file($DIRS, $board_info[write_page]);
		$lib_fix->delete_design_file($DIRS, $board_info[modify_page]);
		$lib_fix->delete_design_file($DIRS, $board_info[delete_page]);
		$lib_fix->delete_design_file($DIRS, $board_info[reply_page]);
		
		$query = "delete from $DB_TABLES[board_list] where name='$board_info[name]'";
		$result = $GLOBALS[lib_common]->querying($query, "�Խ��� ��ϻ����� ����");
		$query = "DROP TABLE {$DB_TABLES[board]}_{$board_info[name]}";
		$result = $GLOBALS[lib_common]->querying($query, "�Խ��� ���̺������ ����");
	}

	// �湮��
	function visit_count($visible='Y') {
		global  $DB_TABLES, $DIRS;
		include "{$DIRS[designer_root]}include/visit_count.inc.php";
		return $visit_simple_view;
	}

	function visit_count_view() {
		global $DB_TABLES;
		// ���� --
		$today  = date("Y-m-d", time());
		$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$today' ";
		$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
		$count_today = @mysql_result($result, 0);
		mysql_free_result($result);
		// ���� ==

		// ���� --
		$yesterday  = date("Y-m-d", time()-86400);
		$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday' ";
		$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
		$count_yesterday = @mysql_result($result, 0);
		mysql_free_result($result);
		// ���� ==

		// ���� --
		$yesterday2  = date("Y-m-d", time()-86400*2);
		$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = '$yesterday2' ";
		$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
		$count_yesterday2 = @mysql_result($result, 0);
		mysql_free_result($result);
		// ���� ==

		// �ִ� --
		$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'MAX' ";
		$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
		$count_max = @mysql_result($result, 0);
		mysql_free_result($result);
		// �ִ� ==

		// ��ü --
		$query = " select vt_count from $DB_TABLES[visit_total] where vt_date = 'TOTAL' ";
		$result = $GLOBALS[lib_common]->querying($query, "ī���������߿���");
		$count_total = @mysql_result($result, 0);
		mysql_free_result($result);
		// ��ü ==

		$visit_simple_view = "
			<table cellpadding=0 cellspacing=0 border=0 width=90% align=center>
				<tr><td height=20>&nbsp;<b>*</b> �� �� : </td><td align=right><b>" . number_format($count_today) . "</b> ��&nbsp;</td></tr>
				<tr><td height=20>&nbsp;<b>*</b> �� �� : </td><td align=right><b>" . number_format($count_yesterday) . "</b> ��&nbsp;</td></tr>
				<tr><td height=20>&nbsp;<b>*</b> �� �� : </td><td align=right><b>" . number_format($count_yesterday2) . "</b> ��&nbsp;</td></tr>
				<tr><td height=20>&nbsp;<b>*</b> �� �� : </td><td align=right><b>" . number_format($count_max) . "</b> ��&nbsp;</td></tr>
				<tr><td height=20>&nbsp;<b>*</b> �� ü : </td><td align=right><b>" . number_format($count_total) . "</b> ��&nbsp;</td></tr>
			</table>
		";
		return $visit_simple_view;
	}

	function strip_special_char_post_var() {
		while(list($key, $value) = each($_POST)) {
			if ($key == 'x' || $key == 'y') continue;
			$_POST[$key] = ereg_replace("[^[:alnum:]]", '', $value); 
		}
	}

	function make_sub_query($sub_query, $user_query, $category_disabled='N') {
		$categorys = $GLOBALS[categorys];																	// URL�� ���� ���� �з����� ����
		for ($i=1,$cnt=sizeof($categorys); $i<=$cnt; $i++) {
			$T_var_category = "category_{$i}";
			$$T_var_category = $categorys[$i-1];
		}
		if ($user_query != '') {																									// ����� ������ �ִ�  ���
			for ($i=1,$cnt=sizeof($categorys); $i<=$cnt; $i++) {
				$T_var_category = "category_{$i}";															// �ּҰ����� �Ѿ���� �з����� ������ ������ �ʿ䰡 ���� ��.
				$user_query = str_replace("\$QCT{$i}", $$T_var_category, $user_query);
			}
			$sub_query[] = $user_query;
		}
		if ($category_disabled != 'Y') {
			for ($i=1,$cnt=sizeof($categorys); $i<=$cnt; $i++) {
				$T_var_category = "category_{$i}";
				if ($$T_var_category != '') {
					$category_value_type = substr($$T_var_category, 0, 1);
					if ($category_value_type == $GLOBALS[DV][ct6]) {
						$$T_var_category = substr($$T_var_category, 1);
						$sub_query_category = "category_{$i}<>'{$$T_var_category}'";
					} else if ($category_value_type == $GLOBALS[DV][ct5]) {
						$$T_var_category = substr($$T_var_category, 1);
						$sub_query_category = "category_{$i} like '%{$GLOBALS[DV][ct2]}{$$T_var_category}{$GLOBALS[DV][ct2]}%'";
					} else {
						$sub_query_category = "category_{$i}='{$$T_var_category}'";
					}
					$sub_query[] = $sub_query_category;
				}
			}
		}
		return $GLOBALS[lib_common]->get_sub_query($sub_query);
	}

	function is_login() {
		if ($_SESSION[user_id] != '' && ($_SESSION[user_level] > 0 && $_SESSION[user_level] < 8)) return true;
		else return false;
	}
	
	// �Խù� ����, �б�, ���� ������ �ľ��ϴ� �Լ�
	// O : �����ڱ���, X : ���Ѿ���
	function get_article_auth($board_info, $article_info, $user_info, $work_type, $use_type='') {
		global $DB_TABLES;
		if ($work_type == "write") {						// �����û (�Խù������ʹ� ���þ��� ��å�̹Ƿ� �켱 �˻�)
			$auth_method_array = array(array('L', $board_info[write_perm], $user_info[user_level], $board_info[write_perm_mode]));
			if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) return 'O';
			else return 'X';
		} else if ($work_type == "reply") {		// �亯�����û
			$auth_method_array = array(array('L', $board_info[reply_perm], $user_info[user_level], $board_info[reply_perm_mode]));
			if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) return 'O';
		} else {																// ��Ÿ��û (����, ����, ���� ��)
			$auth_method_array = array(array('L', $GLOBALS[VI][admin_level_admin], $user_info[user_level], 'U'), array('M', $board_info[admin], $user_info[serial_num], 'E'), array('M', $article_info[writer_id], $user_info[id], 'E'));
			if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) return 'O';		// SITE �����ڷ���, �Խ��ǰ�����, �Խù�����ڴ� ������ 'O'
			switch ($work_type) {
				case "list" :																						// �б��û
				case "view" :																						// �б��û
					if ($board_info[read_perm] != 'S') {									// �������̸� �����˻�
						$auth_method_array = array(array('L', $board_info[read_perm], $user_info[user_level], $board_info[read_perm_mode]));
						if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) {
							if ($article_info[is_private] == 'Y') {							// �Խù��� �� �� �ִ� ���������� ��б۷� ������ ��� �ѹ� �� üũ
								if ($use_type == "link") return 'P';
								if ($_POST[submit_passwd] != '') $T_passwd = $_POST[submit_passwd];
								else $T_passwd = $_POST[passwd];
								$query = "select password('$T_passwd')";
								$result = mysql_query($query);
								$input_passwd = mysql_result($result, 0, 0);
								if ($input_passwd == $article_info[passwd]) return 'O';
							} else {
								return 'O';
							}
						} else {																						// �������� ����
							return 'X';
						}
					} else {																							// ���α۸� ���� �����̸� fid ���� ã�� ����. (������� �����Ƿ� ������� ���α��� �ƴ�)
						$query = "select count(serial_num) from {$DB_TABLES[board]}_{$board_info[name]} where fid='$article_info[fid]' and writer_id='$user_info[id]'";
						$result = $GLOBALS[lib_common]->querying($query);
						if (mysql_result($result, 0, 0) > 0) return 'O';
					}
				break;
				case "modify"	:																				// ������û
					if ($board_info[modify_perm] == 'A') {	 						// �����ڸ����� (������� ������ �̹� �����ڰ� �ƴϹǷ� ������ �Ұ�)
						return 'X'	;
					} else if ($board_info[modify_perm] == 'S') {				// ���θ�����
						$auth_method_array = array(array('L', $article_info[writer_id], $user_info[id], 'E'));										
						if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) return 'O';
					} else {																							// �н�����
						if ($use_type == "btn") return 'P';
						if ($_POST[submit_passwd] != '') $T_passwd = $_POST[submit_passwd];
						else $T_passwd = $_POST[passwd];
						$query = "select password('$T_passwd')";	// ���Ȼ� ������ �������� �н����� Ȯ�� (������ ����)
						$result = mysql_query($query);
						$input_passwd = mysql_result($result, 0, 0);
						if ($input_passwd == $article_info[passwd]) return 'O';
					}
				break;
				case "delete"	:																				// ������û
					if ($board_info[delete_perm] == 'A') {	 							// �����ڸ����� (������� ������ �̹� �����ڰ� �ƴϹǷ� ������ �Ұ�)
						return 'X'	;
					} else if ($board_info[delete_perm] == 'S') {				// ���θ�����
						$auth_method_array = array(array('L', $article_info[writer_id], $user_info[id], 'E'));										
						if ($GLOBALS[lib_common]->auth_process($auth_method_array) == true) return 'O';
					} else {																							// �н�����
						if ($use_type == "btn") return 'P';
						if ($_POST[submit_passwd] != '') $T_passwd = $_POST[submit_passwd];
						else $T_passwd = $_POST[passwd];
						$query = "select password('$T_passwd')";	// ���Ȼ� ������ �������� �н����� Ȯ�� (������ ����)
						$result = mysql_query($query);
						$input_passwd = mysql_result($result, 0, 0);
						if ($input_passwd == $article_info[passwd]) return 'O';
					}
				break;
			}
			return 'X';
		}
	}

	########## ȸ�� ������ ��Ī�� ������ �Լ�.
	function get_level_alias($saved_level_alias, $etc_info=array()) {
		$exp = explode($GLOBALS[DV][ct1], $saved_level_alias);
		$return_value = array();
		if ($etc_info[0] != 'N') $return_value['8'] = "�湮��";
		for ($i=0; $i<sizeof($exp); $i++) {
			$exp_1 = explode($GLOBALS[DV][ct2], $exp[$i]);
			$return_value[$exp_1[0]] = trim($exp_1[1]);
		}
		if ($etc_info[1] != 'N') $return_value['1'] = "������";
		return $return_value;
	}

	function print_script_window() {
		$msg = "<script language=\"JavaScript\">
			<!--
			function na_open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable) {
				toolbar_str = toolbar ? 'yes' : 'no';
				menubar_str = menubar ? 'yes' : 'no';
				statusbar_str = statusbar ? 'yes' : 'no';
				scrollbar_str = scrollbar ? 'yes' : 'no';
				resizable_str = resizable ? 'yes' : 'no';
				window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
			}
			//-->
		</script>";
		return $msg;
	}

	// ��밡���� ���ϸ����� ����
	function get_mb_cyber_money($mb_id, $od_id='', $is_add='') {
		global $DB_TABLES;
		switch ($is_add) {
			case "+" :
				$sub_query = "and mi_milage > 0";
			break;
			case "-" :
				$sub_query = "and mi_milage < 0";
			break;
		}
		if ($od_id != '') {
			$sql = " select sum(mi_milage) from $DB_TABLES[cyber_money] where od_id = '$od_id' $sub_query and mi_state<>'R'";
		} else {
			$sql = " select sum(mi_milage) from $DB_TABLES[cyber_money] where mb_id = '$mb_id' $sub_query and mi_state<>'R'";
		}
		$result = $GLOBALS[lib_common]->querying($sql);
		 $row = mysql_fetch_row($result);
		 mysql_free_result($result);
		 return (float)$row[0];
	}

	// ���ϸ��� ������ ���̺� �Է�
	function insert_milage($mb_id, $milage, $memo, $od_id="", $ct_id="", $mi_state='R') {
		global $now, $DB_TABLES;
		$query = " insert $DB_TABLES[cyber_money] set mb_id = '$mb_id', mi_milage = '$milage', mi_memo = '$memo', od_id = '$od_id', ct_id = '$ct_id', mi_time = '{$GLOBALS[w_time]}', mi_ip = '{$_SERVER[REMOTE_ADDR]}', mi_state='$mi_state'";
		$GLOBALS[lib_common]->querying($query);
	}

	// ���ϸ��� ���� ���º���
	function update_milage($od_id, $state) {
		global $DB_TABLES;
		$query = "update $DB_TABLES[cyber_money] set mi_state='$state' where od_id='$od_id'";
		$GLOBALS[lib_common]->querying($query);
	}

	// ��Ų���� ����� ����� �Լ�
	function make_skin_file_liist() {
		global $DB_TABLES, $site_page_info;
		$option_name = $option_value = array();
		$query = "select name, file_name from $DB_TABLES[design_files] where type='S'";
		$result = $GLOBALS[lib_common]->querying($query, "��Ų ���� ���� ���� ������ �����߻�");
		$option_name[] = " :: ��Ų���� ";
		$option_value[] = '';
		while ($value = mysql_fetch_array($result)) {
			$option_name[] = $value[name];
			$option_value[] = $value[file_name];
		}
		$option_name[] = "[���ǽ�Ų]";
		$option_value[] = "session";
		return $GLOBALS[lib_common]->make_list_box("skin_file", $option_name, $option_value, "", $site_page_info[skin_file], "class=designer_select", "");
	}

	// ������ �޴������ ����� �Լ�
	function make_page_menu_list($default_value, $property, $name="page_menu", $etc_item='') {
		global $site_info;
		if ($etc_item != '') $etc_item = "\n{$etc_item}";
		if ($site_info[design_file_menu] != '') {
			$design_file_menu_array = $GLOBALS[lib_common]->parse_property($site_info[design_file_menu] . $etc_item, $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N', 'Y');
			return $GLOBALS[lib_common]->get_list_boxs_array($design_file_menu_array, $name, $default_value, 'Y', $property, ":: �޴����� ::");
		}
	}

	// �׺���̼� ����� �Լ�
	function make_navigation($site_page_info, $divider, $is_link='Y', $board_info='') {
		global $DB_TABLES, $site_info;
		if ($divider == '') $divider = '>';
		$divider = htmlspecialchars($divider);
		if ($is_link == 'Y') $navigation = "<a href='/{$site_info[index_file]}'><span class='navi'>HOME</span></a> $divider ";
		else $navigation = "HOME $divider ";
		if ($site_page_info[file_name] != "home.php") {
			$sub_query_thread = array();
			for ($i=0,$cnt=strlen($site_page_info[thread]); $i<$cnt; $i++) $sub_query_thread[] = "thread='" . substr($site_page_info[thread], 0, $i+1) . "'";
			$sub_query_thread = implode(" or ", $sub_query_thread);
			$query = "select * from $DB_TABLES[design_files] where fid='$site_page_info[fid]' and ($sub_query_thread) order by thread asc";
			$result = $GLOBALS[lib_common]->querying($query);
			$total_record = mysql_num_rows($result);
			for ($i=0; $i<$total_record; $i++) {
				$value = mysql_fetch_array($result);
				if ($value[navi_mode] == 'D') continue;		// ������� �����ΰ�� 
				if ($i < $total_record-1) {									// ������ ���� �ƴϸ�
					if ($value[navi_mode] == 'B') {
						$navigation .= $value[navi_property] . " $divider ";
					} else {
						if ($is_link == 'Y' && $value[navi_mode] != 'C') {
							$navigation .= "<a href='/{$site_info[index_file]}?design_file=$value[file_name]'><span class='navi'>{$value[name]}</span></a> $divider ";
						} else {
							$navigation .= "<span class='navi'>{$value[name]}</span> $divider ";
						}
					}
				} else {																		// ������ ����� ���õ� �з��� ���
					if ($value[navi_mode] == 'B') {
						$navigation .= $value[navi_property];
					} else {
						$categorys = $GLOBALS[categorys];
						$last_page_name = '';
						for ($j=1; $j<=sizeof($categorys); $j++) {															// ī�װ� �� ��ŭ �ݺ�
							if ($board_info["category_{$j}"] != '' && $categorys[$j-1] != '') {		// �з����� �Ǿ��ְ�, �з����� ������ ������.
								$code_define = $board_info["category_{$j}"];											// �з����� �ҷ���
								$T_codes = $GLOBALS[lib_common]->parse_property(str_replace(chr(92).r.chr(92).n, "\r\n", $code_define), $GLOBALS[DV][ct1], $GLOBALS[DV][ct2], '', 'N');
								$T_value = trim($T_codes[$categorys[$j-1]]);											// �з� �̸� �ľ�
								$last_page_name .= ", $T_value";
							}
						}
						$last_page_name = substr($last_page_name, 2);
						if ($last_page_name == '') $navigation .= "<span class='navi_last'>$value[name]</span>";
						else $navigation .= "<span class='navi_last'>$last_page_name</span>";
					}					
				}
			}
		}
		return $navigation;
	}

	function send_sms($site_id, $sms_phone_to, $sms_phone_from, $comment, $is_test='N') {
		global $DIRS;
		$comment = urlencode($comment);
		if ($is_test != 'Y') {
			include "{$DIRS[include_root]}user_define/send_sms.inc.php";
			$T_info = array("pass_empty_file"=>'Y', "ptr_header"=>'N');
			$GLOBALS[lib_common]->get_remote_file_value($sms_request_url, 2, $T_info);
			return 1;
		} else {
			$GLOBALS[lib_common]->alert_url("���Ź�ȣ : $sms_phone_to, �߽Ź�ȣ : $sms_phone_from, �޽��� : $comment");
		}
	}

	function get_page_block($total, $ppa, $ppb, $page, $style, $font, $img_dir='', $link_file='', $unlink_view='N', $var_name_page='page', $total_type='C', $change_vars=array()) {
		if ($total <= 0 || $total == '') return;
		if ($_GET[$var_name_page] <= 0) $T_page = 1;
		else $T_page = $_GET[$var_name_page];
		$total_page = ceil($total / $ppa);
		if ($T_page > $total_page) $T_page = $total_page;			// ��ü ���������� �Էµ� �������� ū��� �������� ������ �������� �����.
		if ($total_page == 0) return '';
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
		$page_link_list = array();
		for($i = 1; $i<=$ppb; $i++) {
			$page_link = $current_page_block * $ppb + $i;	// ���� ������ ǥ�õ� �������� ����Ѵ�.
			$change_vars["$var_name_page"] = $page_link;
			$link = $link_file . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "#{$var_name_page}_top";
			if ($page_link == $T_page) $page_link_list[] = "<font color='red'><b>{$style[0]}{$page_link}{$style[1]}</b></font>";
			else $page_link_list[] = "<a href=\"{$link}\">{$open_font}{$style[0]}{$page_link}{$style[1]}{$close_font}</a>";	// <a name=''> �±׸� �̿��Ͽ� ���� ��ġ�� ǥ���� ��� ������ �̵��� Ư�� ��ġ�� ��ų �� �ֵ��� �Ѵ�.
			if ($page_link == $total_page) break;		// ���� �������� ��ü ���������� Ŀ���� ������ ����������.
		}
		$page_link_list = implode($style[9], $page_link_list);
		if ($T_page > 1) {
			$temp = $T_page - 1;
			$change_vars["$var_name_page"] = $temp;
			$link = $link_file . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_3_src' border='0' align='absmiddle'></a> " . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_3_src' border='0' align='absmiddle'>" . $page_link_list;
		}
		$pre_block = $current_page_block * $ppb;	// ���� ���� ǥ�õ� �������� ����Ѵ�.
		if ($current_page_block > 0) {		// ���� ���� ���� �ϸ� ���������� �̵��� �� �ִ� ��ũ�� ����Ѵ�.
			$change_vars["$var_name_page"] = $pre_block;
			$link = $link_file . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = "<a href=\"{$link}\"><img src='$style_2_src' border='0' align='absmiddle'></a>&nbsp;" . $page_link_list;
		} else {
			if ($un_link_view == "Y") $page_link_list = "<img src='$style_2_src' border='0' align='absmiddle'>&nbsp;{$page_link_list} ";
		}
		if ($T_page < $total_page) {
			$temp = $T_page + 1;
			$change_vars["$var_name_page"] = $temp;
			$link = $link_file . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = $page_link_list . "<a href=\"{$link}\"><img src='$style_4_src' border='0' align='absmiddle'> </a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = $page_link_list . "<img src='$style_4_src' border='0' align='absmiddle'>";
		}
		$next_block = ($current_page_block+1) * $ppb+ 1; // ���� ���� ù �������� ����Ѵ�.
		if ($next_block <= $total_page) {
			$change_vars["$var_name_page"] = $next_block;
			$link = $link_file . "?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			$page_link_list = $page_link_list . "&nbsp;<a href='{$link}'><img src='$style_5_src' border='0' align='absmiddle'></a>";
		} else {
			if ($un_link_view == "Y") $page_link_list = " {$page_link_list}&nbsp;<img src='$style_5_src' border='0' align='absmiddle'>";
		}
		$return_value = array($page_link_list, $ppb_value);
		return $return_value;
	}

	function make_button($exp) {
		global $DIRS, $user_info, $board_info, $site_info, $form_name, $article_value, $page, $search_item, $search_value, $i_viewer;
		$name = $exp[1];
		$type = $exp[2];
		$value = $exp[3];
		if ($exp[4] != '') $pp_default = ' ' . $exp[4];
		$link_info = explode($GLOBALS[DV][ct4], $exp[5]);
		$pp_link_target = $link_info[0];
		$pp_link_nw = $link_info[1];
		if (trim($link_info[2]) != '') $pp_link_etc = $link_info[2] . ' ';
		$pp_link_rollover = $link_info[3];
		$btn_etc = explode($GLOBALS[DV][ct4], $exp[6]);
		$link_urls = explode($GLOBALS[DV][ct4], $exp[7]);

		// ��ũ�� ������.
		switch ($name) {
			case "sort" :
				$change_vars = array();
				$sort_fld_name = "SI_F_" . $btn_etc[0];
				if ($btn_etc[1] == '') {
					if ($_GET[$sort_fld_name] == "asc") $sort_sequence = "desc";
					else $sort_sequence = "asc";
				} else {
					$sort_sequence = $btn_etc[1];
				}
				$sort_is_multi = $btn_etc[2];
				if ($sort_is_multi != 'Y') {				// ���� �ʵ� �����̸�, ��� ���� �������� ���ش�.
					$T_get = $_GET;
					while (list($key_sort, $value_sort) = each($T_get)) {
						$key_head = substr($key_sort, 0, 5);
						if ($key_head == "SI_F_") $change_vars[$key_sort] = '';
					}
				}
				$change_vars[$sort_fld_name] = $sort_sequence;
				if ($btn_etc[3] != '') $change_vars["design_file"] = $btn_etc[3];
				if ($btn_etc[4] != '') $link_file = $btn_etc[4];
				else $link_file = $site_info[index_file];
				$link_url = $link_file . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			break;
			case "search_id" :
				$GLOBALS[JS_CODE][SEARCH_ID] = "Y";
				$link_url = "javascript:open_search_id('{$DIRS[member_root]}check_id.php?form_name={$form_name}')";
			break;
			case "search_passwd" :
				$change_vars = array("design_file"=>"find_id_pw.php");
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
			break;
			case "search_post" :
				$GLOBALS[JS_CODE][SEARCH_POST] = "Y";
				$link_url = $link_urls[1];
			break;
			case "list" :
				$article_auth_info = $this->get_article_auth($board_info, $article_value, $user_info, "list");
				if ($article_auth_info != 'O') return;
				$change_vars = array("design_file"=>$board_info[list_page], "article_num"=>'');
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
			break;
			case "write" :
				$article_auth_info = $this->get_article_auth($board_info, $article_value, $user_info, "write");
				if ($article_auth_info != 'O') return;
				$change_vars = array("design_file"=>$board_info[write_page]);
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
			break;
			case "modify" :
				$article_auth_info = $this->get_article_auth($board_info, $article_value, $user_info, "modify", "btn");
				if ($article_auth_info == 'X') return;
				$change_vars = array("design_file"=>$board_info[modify_page], "article_num"=>$article_value[serial_num]);
				$T_link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
				if ($article_auth_info == 'P') {			// �����ڳ� ������ �ƴѰ�� �н����� Ȯ��
					$link_url = "#;";
					$link_pp = "onclick=\"SYSTEM_on_passwd_input('$T_link_url', '$target', event)\"";
					$GLOBALS[JS_CODE][PRIVATE_ARTICLE] = "Y";
					$GLOBALS[ETC_CODE][PRIVATE_LAYER] = "Y";
				} else {
					$link_url = $T_link_url;
				}
			break;
			case "delete" :
				$article_auth_info = $this->get_article_auth($board_info, $article_value, $user_info, "delete", "btn");
				if ($article_auth_info == 'X') return;
				$change_vars = array("design_file"=>$board_info[delete_page], "article_num"=>$article_value[serial_num]);
				$T_link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
				if ($article_auth_info == 'P') {			// �����ڳ� ������ �ƴѰ�� �н����� Ȯ��
					$link_url = "#;";
					$link_pp = "onclick=\"SYSTEM_on_passwd_input('$T_link_url', '$target', event)\"";
					$GLOBALS[JS_CODE][PRIVATE_ARTICLE] = "Y";
					$GLOBALS[ETC_CODE][PRIVATE_LAYER] = "Y";
				} else {
					$link_url = $T_link_url;
				}
			break;
			case "reply" :
				if ($this->get_article_auth($board_info, $article_value, $user_info, "reply") != 'O') return;
				$change_vars = array("design_file"=>$board_info[reply_page], "article_num"=>$article_value[serial_num]);
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
			break;
			case "prev" :
				$PREV_query = get_query($board_info, "LIST", '5', $article_value[serial_num], '', '', '');
				$PREV_result = $GLOBALS[lib_common]->querying($PREV_query);
				$PREV_value = mysql_fetch_array($PREV_result);
				if ($PREV_value[serial_num] == '') return '';
				$change_vars = array("design_file"=>$board_info[view_page], "article_num"=>$PREV_value[serial_num]);
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
			break;
			case "next" :
				$NEXT_query = get_query($board_info, "LIST", '6', $article_value[serial_num], '', '', '');
				$NEXT_result = $GLOBALS[lib_common]->querying($NEXT_query);
				$NEXT_value = mysql_fetch_array($NEXT_result);
				if ($NEXT_value[serial_num] == '') return '';
				$change_vars = array("design_file"=>$board_info[view_page], "article_num"=>$NEXT_value[serial_num]);
				$link_url = $site_info[index_file] . '?' . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . $link_urls[1];
			break;
			case "reset" :		// �׸�, ���� ����
				$link_url = "#";
				$link_pp = "onclick='reset()'";
			break;
			case "submit" :	// ���� ����
				$link_url = "#";
				$link_pp = "onclick=\"{$form_name}_submit('text')\"";
			break;
			case "user" :
				if ($link_urls[0] != '') $link_url = "{$site_info[index_file]}?design_file={$link_urls[0]}";
				if ($link_urls[1] != '') $link_url .= $link_urls[1];
			break;
			case "close" :
				$link_url = "javascript:window.close()";
			break;
			case "back" :
				$link_url = "javascript:history.back()";
			break;
			case "home" :
				$link_url = "$site_info[index_file]";
			break;
			case "login" :
				$prev_url_encode = $_SERVER[PHP_SELF] . "?" . urlencode($_SERVER[QUERY_STRING]);
				$link_url = "{$site_info[index_file]}?design_file=login.php&prev_url=$prev_url_encode";
			break;
			case "logout" :
				$link_url = "{$DIRS[member_root]}logout_process.php";
			break;
			case "member" :
				if ($user_info[user_level] < 8) $T_design_file = "member.php";
				else $T_design_file = "agreement.php";
				$link_url = "{$site_info[index_file]}?design_file={$T_design_file}";
			break;
			case "favor" :
				$domain_name = getenv("SERVER_NAME");
				$link_url = "#";
				$link_pp = "onClick=\"{window.external.addfavorite('http://{$domain_name}', '$site_info[site_name]')}\"";
				$tag_btn_flag = "Y";	 // �±׹�ư�� ������ ��ũ�� ������ �˸��� �÷���
			break;
			case "start" :
				$domain_name = getenv("SERVER_NAME");
				$link_url = "#";
				$link_pp = "style='cursor:hand' onClick=\"this.style.behavior='url(#default#homepage)';this.sethomepage('http://{$domain_name}');\"";
				$tag_btn_flag = "Y";
			break;
			case "print" :
				$link_url = "#";
				$link_pp = "style='cursor:hand' onClick=\"window.print()\"";
				$tag_btn_flag = "Y";
			break;
			case "admin" :
				$link_url = "{$DIRS[designer_root]}index.php";
			break;
			case "multi_submit" :
				$link_url = "#";
				$link_pp = "onClick=\"{$form_name}_multi_submit_{$board_info[name]}_{$i_viewer}()\"";
				if (sizeof(explode('?', $btn_etc[0])) > 1) $con_char = '&';
				else $con_char = '?';
				$GLOBALS[JS][] = "
					function {$form_name}_multi_submit_{$board_info[name]}_{$i_viewer}() {
						if (verify_multi_check(document.{$form_name}, 'list_select') == 0) {
							alert(\"�׸��� �����ϼ���\");
							return false;
						}
						$btn_etc[2];
						form = document.{$form_name};
						form.action = '$btn_etc[0]' + '{$con_char}board=$board_info[name]';
						form.target = '$btn_etc[1]';
						form.submit();
					}
				";
				$GLOBALS[JS_CODE][VERIFY_MULTI_CHECK] = 'Y';
			break;
		}
		$link_pp = trim($pp_link_etc . $link_pp);
		switch ($type) {
			case "�׸�" :
				if ($pp_link_rollover == 'Y') {
					$T_exp = explode('.', $value);
					$rollover_file_name = $T_exp[0] . "_over." . $T_exp[1];
					$rollover = " onMouseOver=\"this.src='$rollover_file_name'\"  onMouseOut=\"this.src='$value'\"";
				}
				if ($name == "submit") {
					$value_tag = "<input type='image' src='$value'{$pp_default}{$rollover}>";
				} else {
					$value_tag = "<img src='$value'{$pp_default}{$rollover}>";
					$value_tag = $GLOBALS[lib_common]->make_link($value_tag, $link_url, $pp_link_target, $pp_link_nw, $link_pp);
				}
			break;
			case "����" :
				if ($pp_default != '') {
					$open_font = "<font $pp_default>";
					$close_font = "</font>";
				}
				$value_tag = $open_font . $value . $close_font;
				$value_tag = $GLOBALS[lib_common]->make_link($value_tag, $link_url, $pp_link_target, $pp_link_nw, $link_pp);
			break;
			case "�±�" :
				if ($name == "submit") {
					$value_tag = $GLOBALS[lib_common]->make_input_box($value, $name, "submit", $pp_default, $style);
				} else if ($name == "reset") {
					$value_tag = $GLOBALS[lib_common]->make_input_box($value, $name, "reset", $pp_default, $style);
				} else {
					if ($pp_link_target != "_nw") {
						if ($pp_link_target != "" && $pp_link_target != "_blank") $pp_link_target = substr($pp_link_target, 1);
						else $pp_link_target = "document";
						if ($link_url == '#') $tag_btn_flag = 'Y';
						if ($tag_btn_flag != "Y") $value_tag = $GLOBALS[lib_common]->make_input_box($value, $name, "button", "onclick={$pp_link_target}.location.href=\"$link_url\" {$link_pp}{$pp_default}", $style);				
						else $value_tag = $GLOBALS[lib_common]->make_input_box($value, $name, "button", $link_pp . $pp_default, $style);				
					} else {
						$win_open_tag = $GLOBALS[lib_common]->make_nw_property($link_url, $pp_link_nw);
						$value_tag = $GLOBALS[lib_common]->make_input_box($value, $name, "button", "onclick=\"{$win_open_tag}.focus()\" {$link_pp}{$pp_default}", $style);				
					}
				}
			break;
		}
		return $value_tag;
	}

	function get_help_form($help_msg, $file_name, $title="<b>����</b>") {
		global $IS_icon;
		if ($help_msg == '') {
			global $IS_help_url;
			// ������ ���� �������� �κ��ڵ�			
		} else {
			$help_msg = str_replace("<br>", '', trim($help_msg));
			$help_msg = nl2br($help_msg);
		}
		$help_form = "
			<table cellpaddiing=0 cellspacing=0 border=0 width=100%>
				<tr>
					<td class=designer_help>
						{$IS_icon[icon_help]} $title
					</td>
				</tr>
				<tr>
					<td><hr size=1></td>
				</tr>
				<tr>
					<td class=designer_help>$help_msg</td>
				</tr>
			</table>
		";
		return $this->w_get_img_box("heavy_blue_round", $help_form, 5);
	}
}
?>
