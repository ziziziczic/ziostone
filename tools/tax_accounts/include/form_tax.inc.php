<?
include "contents_header.inc.php";

// tax_info �� ��Ŭ��� ���� �Ѿ��.
$voucher_supply_tax = $lh_vg_tax->get_supply_tax($tax_info[biz_amount], $tax_info[biz_tax_inc]);
$total_sell_price_supply = round($voucher_supply_tax[0]);	// ���ް�
$total_sell_tax = round($voucher_supply_tax[1]);						// ����
$voucher_total_price = $voucher_supply_tax[2];							// �հ�

$sbn = substr($tax_info[biz_a_number], 0, 3) . '-' . substr($tax_info[biz_a_number], 3, 2) . '-' . substr($tax_info[biz_a_number], 5);	// ������ ����� ��ȣ
$bbn_array = $tax_info[biz_b_number];												// ���� �޴��� ����ڹ�ȣ
$voucher_tax_date_str = date("Y-m-d", $tax_info[biz_issue_date]);	// �߱޳�¥
$voucher_tax_date_array = explode("-", $voucher_tax_date_str);

// �Ϸù�ȣ
$T_serial_num = (string)$tax_info[serial_num];
$T_tail_size = 6 - strlen($T_serial_num);
for ($i=0; $i<$T_tail_size; $i++) $T_serial_num = '0' . $T_serial_num;

// ���ް��� , ����
$T_total_sell_price_supply = (string)$total_sell_price_supply;
$T_total_sell_tax = (string)$total_sell_tax;
$T_voucher_total_price = (string)$voucher_total_price;
$blank_nums = 11 - strlen($T_total_sell_price_supply);
$T_total_sell_price_supply = strrev($T_total_sell_price_supply);
$T_total_sell_tax = strrev($T_total_sell_tax);

// ǰ��
$voucher_item = $tax_info[biz_goods];

$voucher_tax_value_seller = "
	<table cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td style='font-size:7pt;color=#FF0000'>[���� �� 11ȣ ����]</td>
						<td align=right style='font-size:7pt;color=#FF0000'>(����)</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border='0' cellpadding='0' cellspacing='0' width='580' style='border-top:2px solid #FF0000; border-bottom:2px solid #FF0000; border-left:2px solid #FF0000; border-right:2px solid #FF0000;'>
					<tr>
						<td width='100%' colspan='2'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td width='300' align=center style='border-bottom:1px solid #FF0000;'>
										<table cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td style='font-size:17pt;color:#FF0000'><font color='#FF0000' face='�ü�'>�� �� �� �� ��</font></td><td style='font-size:8pt;color:#FF0000'>&nbsp;&nbsp;(�����ں�����)</td>
											</tr>
										</table>
									</td>
									<td style='border-bottom:1px solid #FF0000;'>
										<table border='0' cellpadding='1' cellspacing='0' width='100%'>
											<tr>
												<td height=25 width=70 align=center style='border-right:1px solid #FF0000; color=#FF0000'>å&nbsp; �� ȣ</td>
												<td align=right colspan='3' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000'>1 ��</td>
												<td align=right colspan='4' style='border-bottom:1px solid #FF0000; color=#FF0000'>1 ȣ</td>
											</tr>
											<tr>
												<td align=center style='border-right:1px solid #FF0000; color=#FF0000;'>�Ϸù�ȣ</td>
												<td align='center' style='border-right:1px solid #FF0000;'>$T_serial_num[0]</td>
												<td align='center' style='border-right:1px solid #FF0000;'>$T_serial_num[1]</td>
												<td align='center' style='border-right:1px solid #FF0000;'>-</td>
												<td align='center' style='border-right:1px solid #FF0000;'>$T_serial_num[2]</td>
												<td align='center' style='border-right:1px solid #FF0000;'>$T_serial_num[3]</td>
												<td align='center' style='border-right:1px solid #FF0000;'>$T_serial_num[4]</td>
												<td align='center'>$T_serial_num[5]</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width='50%'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td width='17' align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;font-weight:bold; color=#FF0000'>��<br><br>��<br><br>��</td>
									<td>
										<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr>
												<td width='100%'>
													<table border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
														<tr>
															<td width='50' height=30 align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-left:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��Ϲ�ȣ</td>
															<td align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000; font-size:11pt'><b>$sbn</b></td>
														</tr>
														<tr>
															<td align='center' style='border-bottom:2px solid #FF0000; border-left:1px solid #FF0000; border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'>��ȣ<br>(���θ�)</td>
															<td align='center' style='border-bottom:2px solid #FF0000;'>
																<table border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
																	<tr>
																		<td align=center style='border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_a_name]</td>
																		<td width='50' style='border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'><p align='center'>����<br>(��ǥ��)</td>
																		<td style='border-right:2px solid #FF0000; font-size:8pt;' nowrap><p align='right'>$tax_info[biz_a_ceo]<font color='#FF0000'>(��)</font></td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'>�����<br>������</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_a_address]</td>
														</tr>
														<tr>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
															<td align='center'>
																<table height=25 border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
																	<tr>
																		<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_a_cond]</td>
																		<td width='30' align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
																		<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_a_type]</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
						<td width='50%'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td width='17' align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;font-weight:bold; color=#FF0000'>��<br>��<br>��<br>��<br>��</td>
									<td>
										<table border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
											<tr>
												<td width='50' align='center' height=31 style='border-left:1px solid #FF0000; border-top:1px solid #FF0000; border-bottom:2px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��Ϲ�ȣ</td>
												<td style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-left:1px solid #FF0000;'>
													<table border='0' cellpadding='0' cellspacing='0' width='100%' height=100%>
														<tr>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[0]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[1]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[2]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>-</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[3]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[4]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>-</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[5]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[6]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[7]</td>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'><b>$bbn_array[8]</td>
															<td align='center' style='border-bottom:1px solid #FF0000;'><b>$bbn_array[9]</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'>��ȣ<br>(���θ�)</td>
												<td>
													<table border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
														<tr>
															<td align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_b_name]</td>
															<td width='50' align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'>����<br>(��ǥ��)</td>
															<td style='border-bottom:1px solid #FF0000; font-size:8pt;' nowrap><p align='right'>$tax_info[biz_b_ceo]<font color='#FF0000'>(��)</font></td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; line-height=120%; color=#FF0000;'>�����<br>������</td>
												<td align='center' style='border-bottom:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_b_address]</td>
											</tr>
											<tr>
												<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
												<td>
													<table height=25 border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
														<tr>
															<td align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_b_cond]</td>
															<td width='40' align=center style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
															<td align='center' style='border-bottom:1px solid #FF0000; font-size:8pt;' nowrap>$tax_info[biz_b_type]</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width='100%' colspan='2'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td width='95' align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�� ��</td>
									<td width=250 align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�� �� �� ��</td>
									<td width='5' align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td width='170' align='center' style='border-top:1px solid #FF0000; border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>�� ��</td>
									<td width='60' align='center' style='border-bottom:1px solid #FF0000; color=#FF0000;'>���</td>
								</tr>
								<tr>
									<td width=95>
										<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr>
												<td width='46%' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td width='27%' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td width='27%' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
											</tr>
											<tr>
												<td align='center' style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$voucher_tax_date_array[0]</td>
												<td align='center' style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$voucher_tax_date_array[1]</td>
												<td align='center' style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$voucher_tax_date_array[2]</td>
											</tr>
										</table>
									</td>
									<td width=250>
										<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr align=center>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>������</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>õ</td>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>õ</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
											</tr>
											<tr align=center>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$blank_nums</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[10]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_price_supply[9]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[8]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[7]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_price_supply[6]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[5]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[4]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_price_supply[3]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[2]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[1]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_price_supply[0]��</td>
											</tr>
										</table>
									</td>
									<td width=5 style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td width=170 style='border-right:1px solid #FF0000;'>
										<table border='0' cellpadding='0' cellspacing='0' width='100%'>
											<tr align=center>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>õ</td>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:2px solid #FF0000; color=#FF0000;'>õ</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
												<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��</td>
											</tr>
											<tr align=center>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_tax[9]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[8]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[7]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_tax[6]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[5]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[4]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:2px solid #FF0000;'>$T_total_sell_tax[3]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[2]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[1]��</td>
												<td style='border-bottom:2px solid #FF0000; border-right:1px solid #FF0000;'>$T_total_sell_tax[0]��</td>
											</tr>
										</table>
									</td>
									<td width=60 style='border-bottom:1px solid #FF0000;'>��</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width='100%' colspan='2'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout:fixed'>
								<tr align=center>
									<td width='50' colspan='2' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�� ��</td>
									<td width='150' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>ǰ��</td>
									<td width='40' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�԰�</td>
									<td width='30' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
									<td width='80' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�ܰ�</td>
									<td width='80' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>���ް���</td>
									<td width='70' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
									<td width='80' style='border-bottom:1px solid #FF0000; color=#FF0000;'>���</td>
								</tr>
								<tr align=center height=25>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>$voucher_tax_date_array[1]��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>$voucher_tax_date_array[2]��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; font-size:8pt;' nowrap>{$voucher_item}��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>" . number_format($total_sell_price_supply) ."��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>" . number_format($total_sell_price_supply) . "��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>" . number_format($total_sell_tax) . "��</td>
									<td style='border-bottom:1px solid #FF0000;'>��</td>
								</tr>
								<tr align=center>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>���Ͽ���</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000;'>��</td>
								</tr>
								<tr>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000;'>��</td>
								</tr>
								<tr>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000;'>��</td>
									<td style='border-bottom:1px solid #FF0000;'>��</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width='100%' colspan='2'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%'>
								<tr>
									<td width='95' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�հ�ݾ�</td>
									<td width='90' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
									<td width='90' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>��ǥ</td>
									<td width='90' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>����</td>
									<td width='90' align='center' style='border-bottom:1px solid #FF0000; border-right:1px solid #FF0000; color=#FF0000;'>�ܻ�̼���</td>
									<td width='125' align=center rowspan='2' style=' color=#FF0000;'>�� �ݾ��� <b>{$vg_tax_pay[$tax_info[biz_receipt]]}</b> ��</td>
								</tr>
								<tr height=30>
									<td align=center style='border-right:1px solid #FF0000;'>" . number_format($voucher_total_price) . "��</td>
									<td style='border-right:1px solid #FF0000;'>��</td>
									<td style='border-right:1px solid #FF0000;'>��</td>
									<td style='border-right:1px solid #FF0000;'>��</td>
									<td style='border-right:1px solid #FF0000;'>��</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width=100% cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td style='font-size:7pt;color=#FF0000'>22226-28132 96.3.27����</td>
						<td align=right style='font-size:7pt;color=#FF0000'>182�� x 128�� �μ����Ư��</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
";
$voucher_tax_value_buyer = str_replace("#FF0000", "#0066FF", $voucher_tax_value_seller);
$voucher_tax_value_buyer = str_replace("����", "û��", $voucher_tax_value_buyer);
$voucher_tax_value_buyer = str_replace("������", "���޹޴���", $voucher_tax_value_buyer);
?>