<?
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);

if ($depth2 != "") {
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	$components = $lib_insiter->search_all_commands($design, $search[0]+1, $search[1]);	// ���� ĭ�� ��� ������Ʈ�� �ҷ��´�.
	$component_num = sizeof($components);		// ������Ʈ�� �� ������ ���Ѵ�.
	if ($component_num <= 1) {		// ������Ʈ�� ���ų� �Ѱ��� ��ġ�� ������ �� ����.
		move_error("");
		$depth2 = "";
	}
	## ������Ʈ���� ���� ��ȣ�� ������ ���Ѵ�.
	for ($i=0; $i<$component_num; $i++) {
		list($key, $value) = each($components[$i]);
		if (!strcmp($value, "���ڿ�")) {
			$length = $lib_insiter->cluster($design, $key);
			for ($j=$length[0]; $j<=$length[1]; $j++) {
				$design[$j] = "";
			}
			$design[$key] = "${design[$key]}(:\n{$length[2]}\n):\n";
		} else if (!strcmp($value, "�Խù������Է»���")) {
			$exp = explode(":", $design[$key+1]);
			if (!strcmp($exp[0], "�⺻����")) {
				$length = $lib_insiter->cluster($design, $key+1);
				for ($j=$length[0]; $j<=$length[1]; $j++) {
					$design[$j] = "";
				}
				$design[$key+1] = "";
				$design[$key] = "${design[$key]}\n�⺻����:\n(:\n{$length[2]}\n):\n";
			}
		}
		$cLine[] = $key;
		$cValue[] = $design[$key];
	}
	$cComp = explode(":", $cValue[$cpn-1]);
	$design[$cLine[$cpn-1]] = "";	// ���� ������Ʈ�� �����Ѵ�.
	if (!strcmp("top", $depth2)) {		// ���� �̵�
		if ($cComp[11] > 0) {	// ���� ������Ʈ�� <br>�� �ִ��� �˻�
			if ($cpn != 1) {			// ù��° ������Ʈ�� �ƴҶ��� ���� �̵�
				$pComp = explode(":", $cValue[$cpn-2]);
				if ($pComp[11] > 0) {	// �ٷ� ���� ������Ʈ�� <br>�� �ִ��� �˻�
					$cComp[11] = $cComp[11] - 1;
					$cpn = fix_up($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue);
				} else {
					$cComp[11] = $cComp[11] - 1;
					$pComp[11] = $pComp[11] + 1;
					$design[$cLine[$cpn-2]] = implode(":", $pComp);
					$cpn = fix_up($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue);
					$lib_handle->refresh2($design_name, $code, $index, $cpn);
				}
			} else {
				move_error("����");
			}
		} else {
			if ($cpn == 1) {
				$cComp[11] = $cComp[11] + 1;
				$design[$cLine[$cpn-1]] = implode(":", $cComp);
				$lib_insiter->input_modify($design, $design_dir, $design_file);
			} else {
				$cpn = fix_up($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue);
			}
			$lib_handle->refresh2($design_name, $code, $index, $cpn);
		}					
	}
	if (!strcmp("bottom", $depth2)) {		// �Ʒ��� �̵�
		if ($cComp[11] > 0) {	// ���� ������Ʈ�� <br>�� �ִٸ�
			if ($cpn != $component_num) {	// ���� ������Ʈ�� ������ ������Ʈ�� �ƴҶ�
				$pComp = explode(":", $cValue[$cpn-2]);
				if ($pComp[11] > 0) {	// �ٷ� ���� ������Ʈ�� <br>�� �ִ��� �˻�
					$cComp[11] = $cComp[11] - 1;
					$design[$cLine[$cpn-1]] = implode(":", $cComp);
					$lib_insiter->input_modify($design, $design_dir, $design_file);
				} else {
					$cComp[11] = $cComp[11] - 1;
					$design[$cLine[$cpn-1]] = implode(":", $cComp);
					$pComp[11] = $pComp[11] + 1;
					$design[$cLine[$cpn-2]] = implode(":", $pComp);
					$lib_insiter->input_modify($design, $design_dir, $design_file);
				}
				$lib_handle->refresh2($design_name, $code, $index, $cpn);
			}
		} else {
			if ($cpn == $component_num) {	// ������ ������Ʈ�̸�
				$pComp = explode(":", $cValue[$cpn-2]);
				if ($pComp[11] <= 0) {
					$pComp[11] = $pComp[11] + 1;
					$design[$cLine[$cpn-2]] = implode(":", $pComp);
					$design[$cLine[$cpn-1]] = implode(":", $cComp);
					$lib_insiter->input_modify($design, $design_dir, $design_file);
					$lib_handle->refresh2($design_name, $code, $index, $cpn);
				} else {
					move_error("�Ʒ���");
				}
			} else {
				$cpn = fix_down($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue, $component_num);
				$lib_handle->refresh2($design_name, $code, $index, $cpn);
			}
		}					
	}
	if (!strcmp("left", $depth2)) {		// �������� �̵�
		$pComp = explode(":", $cValue[$cpn-2]);
		if ($pComp[11] > 0 || $cpn == 1) {
			move_error("��������");
		} else {
			if ($cComp[11] > 0) {
				$cComp[11] = $cComp[11] - 1;
				$pComp[11] = $pComp[11] + 1;
				$cpn = fix_swap($design, $design_dir, $design_file, $cpn, $cLine[$cpn-1], $cLine[$cpn-2], $cComp, $pComp, "left");
			} else {
				$cpn = fix_swap($design, $design_dir, $design_file, $cpn, $cLine[$cpn-1], $cLine[$cpn-2], $cComp, $pComp, "left");
			}
			$lib_handle->refresh2($design_name, $code, $index, $cpn);
		}
	}
	if (!strcmp("right", $depth2)) {		// ���������� �̵�
		if (($cComp[11] > 0) || ($cpn == $component_num)) {
			move_error("����������");
		} else {
			$nComp = explode(":", $design[$cLine[$cpn]]);
			if ($nComp[11] > 0) {
				$cComp[11] = $cComp[11] + 1;
				$nComp[11] = $nComp[11] - 1;
				$cpn = fix_swap($design, $design_dir, $design_file, $cpn, $cLine[$cpn-1], $cLine[$cpn], $cComp, $nComp, "right");
			} else {
				$cpn = fix_swap($design, $design_dir, $design_file, $cpn, $cLine[$cpn-1], $cLine[$cpn], $cComp, $nComp, "right");
			}
			$lib_handle->refresh2($design_name, $code, $index, $cpn);
		}
	}
	//$lib_handle->refresh2($design_name, $code, $index, $cpn);
}
?>
<html>
<head>
<title>������Ʈ ��ġ����</title>
<?echo($html_header)?>
<SCRIPT LANGUAGE='JavaScript'>
<!--
//������Ʈ ��ġ ���� �Լ�
function ComponentPosition(po) {
	window.location.href='component_edit.php?code=$code&index=$index&cpn=$cpn&parent=component&depth1=position&depth2='+po;
}
function reload() {
	var form = eval(document.component_blank_form);
	form.reset();
}
function adjustSubmit() {
	var form = eval(document.component_blank_form);
	form.action = form.action + '&adjust=Y';
	form.submit();
}
//-->
</SCRIPT>
</head>

<body bgcolor='white'  leftmargin='0' marginwidth='0' topmargin='0' marginheight='0'>
<?
if ($mode == "position") {	// �׸� ��ġ�̵�
?>

<table width='453' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			<table width='434' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr> 
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'>������ ��ġ �̵�</font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='434' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr> 
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>&nbsp;</td>
					<td width='432'> 
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td>
									<table align='center' border='0' width='150' height='150'>
                            <tr>
                                <td width='50' height='50' align='center'>
                                    &nbsp;
                                </td>
                                <td width='50' height='50' align='center'>
                                    <p style='line-height:200%;'><a href=\"javascript:ComponentPosition('top')\"><img src='<?echo($DIRS[designer_root])?>images/up.gif' width='10' height='10' border='0' alt='������ĭ�̵�'><br>��</a>
                                </td>
                                <td width='50' height='50' align='center'>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td width='50' height='50' align='center'>
                                    <a href=\"javascript:ComponentPosition('left')\"><img src='<?echo($DIRS[designer_root])?>images/left.gif' width='10' height='10' border='0' alt='�������� ��ĭ�̵�'> 
                                    ��</a>
                                </td>
                                <td width='50' height='50' align='center'>
                                    <font color='blue'>����<br>��ġ</font>
                                </td>
                                <td width='50' height='50' align='center'>
                                    <a href=\"javascript:ComponentPosition('right')\">��&nbsp;<img src='<?echo($DIRS[designer_root])?>images/right.gif' width='10' height='10' border='0' alt='���������� ��ĭ�̵�'></a>
                                </td>
                            </tr>
                            <tr>
                                <td width='50' height='50' align='center'>
                                    &nbsp;
                                </td>
                                <td width='50' height='50' align='center'>
                                    <a href=\"javascript:ComponentPosition('bottom')\">��<br><img src='<?echo($DIRS[designer_root])?>images/down.gif' width='10' height='10' border='0' alt='�Ʒ��� ��ĭ�̵�'></a>
                                </td>
                                <td width='50' height='50' align='center'>
                                    &nbsp;
                                </td>
                            </tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr> 
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif' width='192'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<br>
<table width='453' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			<table width='434' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr> 
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'>����</font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='434' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr> 
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>&nbsp;</td>
					<td width='432'> 
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td height='70' width='100%' >
									<p style='line-height:150%; margin-right:10px; margin-left:10px;'>
									 ��&nbsp;������ ��ġ������ ���� ������Ʈ�� ��ġ�� ��,��,��,�쿡 �ִ� �ٸ� ������Ʈ�� ��ġ�� �ٲٴ� ����Դϴ�.
								</td>
							</tr>
						</table>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr> 
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif' width='192'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?
} else { 
	$location = "index=" . $index;
	$search = $lib_fix->search_index($design, "ĭ", $location);
	$components = $lib_insiter->search_all_commands($design, $search[0]+1, $search[1]);
	if (!is_array($components)) {
		echo("<font color='red'>�Է� ����!!</font>&nbsp;����ִ� ĭ���� ������Ʈ �����ֱ⸦ �õ� �߽��ϴ� <br><br> �Ǵ� ������Ʈ ��ȣ�� ��Ȯ���� �ʽ��ϴ�.");
		exit;
	}
	list($key, $val) = each($components[$cpn-1]);
	$exp = explode(":", $design[$key]);
?>
<form name='component_blank_form' method='post' action='design_save.php?code=$code&index=$index&cpn=$cpn&parent=component&depth1=blank'>
<table width='453' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			<table width='434' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr> 
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'>������ ���� ����</font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='434' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr> 
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>&nbsp;</td>
					<td width='432'> 
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td>
									<table align='center' border='0' width='250' height='150'>
                            <tr>
                                <td width='100%' height='50' align='center' colspan='3' valign='middle'>
                                    <p style='line-height:200%;'><img src='<?echo($DIRS[designer_root])?>images/up.gif' width='10' height='10' border='0' alt='���ʿ���'><br>�� 
                                    <input type='text' name='top_blank' size='3' maxlength='3' value='$exp[10]' style='text-align:right;'> 
                                    ĭ
                                </td>
                            </tr>
                            <tr>
                                <td width='75' height='50' align='center' valign='middle'>
                                    <img src='<?echo($DIRS[designer_root])?>images/left.gif' width='10' height='10' border='0' alt='���ʿ���'><br>�� <input type='text' name='left_blank' size='3' maxlength='3' value='$exp[12]' style='text-align:right;'> 
                                    ĭ
                                </td>
                                <td width='50' height='50' align='center' valign='middle'>
                                    <font color='blue'>����<br>��ġ</font>
                                </td>
                                <td width='75' height='50' align='center' valign='middle'>
                                    <img src='<?echo($DIRS[designer_root])?>images/right.gif' width='10' height='10' border='0' alt='����������'><br>��&nbsp;<input type='text' name='right_blank' size='3' maxlength='3' value='$exp[13]' style='text-align:right;'> 
                                    ĭ
                                </td>
                            </tr>
                            <tr>
                                <td width='100%' height='50' align='center' colspan='3' valign='middle'>
                                    �� <input type='text' name='bottom_blank' size='3' maxlength='3' value='$exp[11]' style='text-align:right;'> 
                                    ĭ<br><img src='<?echo($DIRS[designer_root])?>images/down.gif' width='10' height='10' border='0' alt='�Ʒ��ʿ���'>
                                </td>
                            </tr>
                        </table>
								</td>
							</tr>
						</table>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr> 
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif' width='192'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width='430' height='20' colspan='4' align='right' valign='top'>
			<a href='javascript:adjustSubmit()'><img src='<?echo($DIRS[designer_root])?>images/bt_appli.gif' border='0'></a>
			<input type='image' src='<?echo($DIRS[designer_root])?>images/bt_enter.gif' border='0'>
			<a href='javascript:document.frm.reset()'><img src='<?echo($DIRS[designer_root])?>images/bt_repeat.gif' border='0'></a>
		</td>
	</tr>
</table>
</form>
<table width='453' border='0' cellpadding='5' cellspacing='3'>
	<tr>
		<td>
			<table width='434' border='0' background='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_back.gif' cellpadding='0' cellspacing='0'>
				<tr> 
					<td width='20'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_01.gif' width='20' height='26'></td>
					<td><font color='#5145FF'>����</font></td>
					<td width='11'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_top_01_02.gif' width='11' height='26'></td>
				</tr>
			</table>
			<table width='434' border='0' bgcolor='F3F3F3' cellpadding='0' cellspacing='0'>
				<tr> 
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_01.gif' width='8'>&nbsp;</td>
					<td width='432'> 
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr> 
								<td height='70' width='100%' >
									<p style='line-height:150%; margin-right:10px; margin-left:10px;'>
									 ��&nbsp;������ ���� ������ ������ �������� ������� ������ �����ϴ� ����Դϴ�. ���������� ���� �������δ� br �±װ� �¿� �������δ� nbsp �±װ� ���Ե˴ϴ�.
								</td>
							</tr>
						</table>
					</td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_02.gif' width='10'>&nbsp;</td>
				</tr>
				<tr> 
					<td width='8'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_01.gif' width='8' height='10'></td>
					<td background='<?echo($DIRS[designer_root])?>images/inputbox/tab_01_03.gif' width='192'></td>
					<td width='10'><img src='<?echo($DIRS[designer_root])?>images/inputbox/tab_p_01_02.gif' width='10' height='10'></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
	");
} 
function fix_up($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue) {
	global $lib_handle;
	for ($i=$cpn-2; $i>=0; $i--) {
		$pComp = explode(":", $cValue[$i]);
		if ($pComp[11] > 0) {
			$is_br = $cLine[$i];
			$is_br_cpn = $i + 1;
			break;
		}
	}
	if ($is_br != "") {
		$uComp = explode(":", $design[$is_br]);
		$uComp[11] = $uComp[11] - 1;
		$design[$is_br] = implode(":", $uComp);
		$cComp[11] = $cComp[11] + 1;
		$design = $lib_handle->increase_design($design, 1, $is_br+1);
		$design[$is_br+1] = implode(":", $cComp);
		$lib_insiter->input_modify($design, $design_dir, $design_file);
		$cpn = $is_br_cpn + 1;
		return $cpn;
	} else {
		$cComp[11] = $cComp[11] + 1;
		$design = $lib_handle->increase_design($design, 1, $cLine[0]);
		$design[$cLine[0]] = implode(":", $cComp);
		$lib_insiter->input_modify($design, $design_dir, $design_file);
		$cpn = 1;
		return $cpn;
	}
}

function fix_down($design, $design_dir, $design_file, $cpn, $cComp, $cLine, $cValue, $component_num) {
	global $lib_handle;
	for ($i=$cpn; $i<$component_num; $i++) {
		$nComp = explode(":", $cValue[$i]);
		if ($nComp[11] > 0) {
			$is_br = $cLine[$i];
			$is_br_cpn = $i;
			break;
		}
	}
	if ($is_br != "") {
		$design = $lib_handle->increase_design($design, 1, $is_br+1);
		$design[$is_br+1] = implode(":", $cComp);
		$lib_insiter->input_modify($design, $design_dir, $design_file);
		$cpn = $is_br_cpn +1 ;
		return $cpn;
	} else {
		$lastComp = explode(":", $cValue[$component_num-1]);
		$lastComp[11] = $lastComp[11] + 1;
		$design[$cLine[$component_num-1]] = implode(":", $lastComp);
		$design = $lib_handle->increase_design($design, 1, $cLine[$component_num-1]+1);
		$design[$cLine[$component_num-1]+1] = implode(":", $cComp);
		$lib_insiter->input_modify($design, $design_dir, $design_file);
		$cpn = $component_num;
		return $cpn;
	}
}

function fix_swap($design, $design_dir, $design_file, $cpn, $cLine, $pLine, $cValue, $pValue, $direction) {
	global $lib_handle;
	$design[$cLine] = implode(":", $pValue);
	$design[$pLine] = implode(":", $cValue);
	if (!strcmp("left", $direction)) $cpn = $cpn - 1;
	else if (!strcmp("right", $direction)) $cpn = $cpn + 1;
	$lib_insiter->input_modify($design, $design_dir, $design_file);
	return $cpn;
}

function move_error($direction) {
	$message = "���̻� {$direction} �̵��� �� �����ϴ�.";
	echo("
		<script language=\"javascript\"> 
			<!--
				alert('$message');
			//-->   
		</script>
	");
}
?>
