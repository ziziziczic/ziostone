<?
$vg_cart_dir_site_root = "../../";
include "config.inc.php";

switch ($_GET[mode]) {
	case "modify" :
		$T_quantity = $vg_cart_var_name[quantity] . $_GET[cart_serial];
		$_SESSION[$T_quantity] = $_GET[qty];
	break;
	case "delete" :
		$T_board_name = $vg_cart_var_name[board_name] . $_GET[cart_serial];
		$T_serial_num = $vg_cart_var_name[serial_num] . $_GET[cart_serial];

		$_SESSION[$T_board_name] = '';
		$_SESSION[$T_serial_num] = '';

		$F_ok = "NO";
		for ($vg_cart_i=0; $vg_cart_i<$_SESSION[$vg_cart_var_name[total]]; $vg_cart_i++) {				// 장바구니 배열수만큼 루프 돌린다..
			// 현재 읽고 있는 인덱스
			$T_board_name = $vg_cart_var_name[board_name] . $vg_cart_i;
			$T_serial_num = $vg_cart_var_name[serial_num] . $vg_cart_i;
			$T_name = $vg_cart_var_name[name] . $vg_cart_i;
			$T_price = $vg_cart_var_name[price] . $vg_cart_i;
			$T_quantity = $vg_cart_var_name[quantity] . $vg_cart_i;
			$T_opt1 = $vg_cart_var_name[option1] . $vg_cart_i;
			$T_opt2 = $vg_cart_var_name[option2] . $vg_cart_i;
			$T_opt3 = $vg_cart_var_name[option3] . $vg_cart_i;
			if ($_SESSION[$T_board_name] == '' && $_SESSION[$T_serial_num] == '') $F_ok = "YES";	// 삭제된 항목을 만나면 플래그함.
			if ($F_ok == "NO") {		// 삭제된 항목이 나오기 전이면.
				continue;
			} else {
				$vg_cart_i_new = $vg_cart_i + 1;												// 삭제할 위치에서 인덱스를 1씩 줄임
				// 새로 저장될 인덱스
				$T_board_name_new = $vg_cart_var_name[board_name] . $vg_cart_i_new;
				$T_serial_num_new = $vg_cart_var_name[serial_num] . $vg_cart_i_new;
				$T_name_new = $vg_cart_var_name[name] . $vg_cart_i_new;
				$T_price_new = $vg_cart_var_name[price] . $vg_cart_i_new;
				$T_quantity_new = $vg_cart_var_name[quantity] . $vg_cart_i_new;
				$T_opt1_new = $vg_cart_var_name[option1] . $vg_cart_i_new;
				$T_opt2_new = $vg_cart_var_name[option2] . $vg_cart_i_new;
				$T_opt3_new = $vg_cart_var_name[option3] . $vg_cart_i_new;

				$_SESSION[$T_board_name] = $_SESSION[$T_board_name_new];
				$_SESSION[$T_serial_num] = $_SESSION[$T_serial_num_new];
				$_SESSION[$T_name] = $_SESSION[$T_name_new];
				$_SESSION[$T_price] = $_SESSION[$T_price_new];
				$_SESSION[$T_quantity] = $_SESSION[$T_quantity_new];
				$_SESSION[$T_opt1] = $_SESSION[$T_opt1_new];
				$_SESSION[$T_opt2] = $_SESSION[$T_opt2_new];
				$_SESSION[$T_opt3] = $_SESSION[$T_opt3_new];
			}
		}
		session_unregister($vg_cart_var_name[board_name] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[serial_num] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[name] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[price] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[quantity] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[opt1] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[opt2] . $_SESSION[$vg_cart_var_name[total]]);
		session_unregister($vg_cart_var_name[opt3] . $_SESSION[$vg_cart_var_name[total]]);
		$_SESSION[$vg_cart_var_name[total]]--;
	break;
	case "delete_all" :
		$lh_vg_cart->cart_delete_all();
	break;
}
$lh_common->meta_url($vg_cart_file['list']);
?>
