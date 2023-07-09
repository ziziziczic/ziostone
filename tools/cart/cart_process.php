<?
$vg_cart_dir_site_root = "../../";
include "config.inc.php";
$vg_cart_select_serials = $$vg_cart_var_select_serials_name;	// 선택된 항목의 일련번호
$vg_cart_serials = $$vg_cart_match[serial_num];								// 폼을 통해 넘어온 모든 일련번호
$board_name = "TCBOARD_{$_GET[board]}";
for ($vg_cart_i=0; $vg_cart_i<sizeof($vg_cart_serials); $vg_cart_i++) {
	$F_is_selected = array_search($vg_cart_serials[$vg_cart_i], $vg_cart_select_serials);
	if (!is_int($F_is_selected)) continue;
	$vg_cart_price = 0;
	$query = "select * from $board_name where serial_num='{$vg_cart_serials[$vg_cart_i]}'";
	$vg_cart_result = $lh_common->querying($query);
	$vg_cart_value = mysql_fetch_array($vg_cart_result);

	$vg_cart_board_name = $_GET[board];
	$vg_cart_serial_num = $vg_cart_serials[$vg_cart_i];										// 일련번호
	$vg_cart_name = $vg_cart_value[$vg_cart_match[name]];						// 상품명 설정
	$vg_cart_price = $vg_cart_value[$vg_cart_match[price]];							// 상품가격 설정 (아래 옵션에 따라 변동가능)
	$T_vg_cart_quantity = $$vg_cart_match[quantity];											// 개수 설정
	$vg_cart_quantity = $T_vg_cart_quantity[$vg_cart_i];
	if ($vg_cart_quantity == '' || $vg_cart_quantity <= 0) $vg_cart_quantity = 1;
	// 옵션 설정부
	for ($T_i=1; $T_i<=3; $T_i++) {
		$T_vg_cart_option = $$vg_cart_match["option" . $T_i];	// 폼으로 넘어온 옵션값 받음
		if ($T_vg_cart_option[$vg_cart_i] != '') {
			$T_cart_option_name = "vg_cart_option" . $T_i;
			$T_value_exp = explode($vg_cart_match[option_div], $T_vg_cart_option[$vg_cart_i]);
			$$T_cart_option_name = $T_value_exp[0];
			if ($T_value_exp[1] > 0) $vg_cart_price += $T_value_exp[1];
		}
	}
	if(!$_SESSION[$vg_cart_var_name[total]]) {																										// 장바구니에 구입한 목록이 없으면..
		$_SESSION[$vg_cart_var_name[board_name] . '0'] = $vg_cart_board_name;
		$_SESSION[$vg_cart_var_name[serial_num] . '0'] = $vg_cart_serial_num;
		$_SESSION[$vg_cart_var_name[name] . '0'] = $vg_cart_name;
		$_SESSION[$vg_cart_var_name[price] . '0'] = $vg_cart_price;
		$_SESSION[$vg_cart_var_name[quantity] . '0'] = $vg_cart_quantity;
		$_SESSION[$vg_cart_var_name[option1] . '0'] = $vg_cart_option1;
		$_SESSION[$vg_cart_var_name[option2] . '0'] = $vg_cart_option2;
		$_SESSION[$vg_cart_var_name[option3] . '0'] = $vg_cart_option3;
		$_SESSION[$vg_cart_var_name[total]] = 1;

	} else {																																										// 기존의 장바구니에 구입 목록이 있으면..
		$isSave = "not";
		for($vg_cart_j=0; $vg_cart_j<$_SESSION[$vg_cart_var_name[total]]; $vg_cart_j++) {			// 장바구니 배열수만큼 루프 돌린다..
			$T_board_name = $vg_cart_var_name[board_name] . $vg_cart_j;
			$T_serial_num = $vg_cart_var_name[serial_num] . $vg_cart_j;
			//$T_name = $vg_cart_var_name[name] . $vg_cart_j;
			//$T_price = $vg_cart_var_name[price] . $vg_cart_j;
			$T_quantity = $vg_cart_var_name[quantity] . $vg_cart_j;
			$T_opt1 = $vg_cart_var_name[option1] . $vg_cart_j;
			$T_opt2 = $vg_cart_var_name[option2] . $vg_cart_j;
			$T_opt3 = $vg_cart_var_name[option3] . $vg_cart_j;
			
			// 기존의 구입목록과 품목이 같으면..
			// 기존의 구입품목에 구입한 수량을 더한후
			if($_SESSION[$T_board_name] == $vg_cart_board_name && $_SESSION[$T_serial_num] == $vg_cart_serial_num && $_SESSION[$T_opt1] == $vg_cart_option1 && $_SESSION[$T_opt2] == $vg_cart_option2 && $_SESSION[$T_opt3] == $vg_cart_option3) {
				$_SESSION[$T_quantity] += $vg_cart_quantity;
				$isSave = "yes";
				if ($vg_cart_j > 0) break;
			}
		}
		if ($isSave == "not") {																																		// 구입한 품목과 같은 품목이 없으면..
			$T_board_name = $vg_cart_var_name[board_name] . $_SESSION[$vg_cart_var_name[total]];
			$T_serial_num = $vg_cart_var_name[serial_num] . $_SESSION[$vg_cart_var_name[total]];
			$T_name = $vg_cart_var_name[name] . $_SESSION[$vg_cart_var_name[total]];
			$T_price = $vg_cart_var_name[price] . $_SESSION[$vg_cart_var_name[total]];
			$T_quantity = $vg_cart_var_name[quantity] . $_SESSION[$vg_cart_var_name[total]];
			$T_opt1 = $vg_cart_var_name[option1] . $_SESSION[$vg_cart_var_name[total]];
			$T_opt2 = $vg_cart_var_name[option2] . $_SESSION[$vg_cart_var_name[total]];
			$T_opt3 = $vg_cart_var_name[option3] . $_SESSION[$vg_cart_var_name[total]];
			
			$_SESSION[$T_board_name] = $vg_cart_board_name;
			$_SESSION[$T_serial_num] = $vg_cart_serial_num;
			$_SESSION[$T_name] = $vg_cart_name;
			$_SESSION[$T_price] = $vg_cart_price;
			$_SESSION[$T_quantity] = $vg_cart_quantity;
			$_SESSION[$T_opt1] = $vg_cart_option1;
			$_SESSION[$T_opt2] = $vg_cart_option2;
			$_SESSION[$T_opt3] = $vg_cart_option3;
			$_SESSION[$vg_cart_var_name[total]]++;
		}
	}
}
$lh_common->meta_url($vg_cart_file['list']);
?>
