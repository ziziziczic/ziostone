<?php 
// =============================================//
// version : 1.5 (2003.07.3)
// ����� : 
// nc_coin_p.php Page�� Post ������� a1=�̸�,a2=�ֹι�ȣ�� ������.
// =============================================//

// =============================================//
// ȸ���� ID, ��й�ȣ �� ��Ÿ  ����
// =============================================//
// sURLnc�� ���� ���� �� �������� �θ��� page�� �����ؾ� �����մϴ�.
// �ܺ� ����ڰ� �� URL�� ��ũ�����Ͽ� �ҹ����� ����ϴ� ���� ���� ����.
$root = "../../";
include "{$root}include/verify_input.inc.php";

$sSiteID = "S220";  	// ����Ʈ id 
$sSitePW = "55956232";   // ��й�ȣ

$cb_encode_path = "/home/hosting_users/insiter1/www/tools/auth_real_name/cb_namecheck";			// cb_namecheck ����� ��ġ�� ��ġ 

$strJumin= $jumin_number_1 . $jumin_number_2;		// �ֹι�ȣ
$strName = $a1;		// �̸�

$iReturnCode  = '';
//echo("$cb_encode_path $sSiteID $sSitePW $strJumin $strName");
//exit;
$iReturnCode = `$cb_encode_path $sSiteID $sSitePW $strJumin $strName`;

$iReturnCode = '1';
if ($iReturnCode == '1') {				// �Ǹ������Ȱ��
	$real_input_name = $a1;
	$user_info_jumin_number = $jumin_number_1 . "-" . $jumin_number_2;
	$design_file = "member.php";
	include "{$root}db.inc.php";
	include "{$root}config.inc.php";
	include "{$root}include/viewer.inc.php";
	mysql_close();
} else {													// �ȵȰ��
	$GLOBALS[lib_common]->alert_url("�Ǹ������� �����Ͽ����ϴ�. ���԰� �ֹε�Ϲ�ȣ�� Ȯ���� �ֽñ� �ٶ��ϴ�.");
}

/*
<P>
<P>
<HR>
<font color=red>�� ���� �κ��� ���� ���񽺽� �����Ͻñ� �ٶ��ϴ�.
</font>
<HR>
CREDITBANK�� ����� �߻��� RETURN CODE ����<P>
<PRE>
�ڵ�	����
------- ---------------------------------------------------------------------------------
0	�⺻����. $HTTP_REFERER�� sURLnc�� ���ϴ� if�� ���� False�϶�. 
1	���� ����
2	���� �ƴ�
3	�ڷ����
4	kis �ý��� ���.
5	�ֹι�ȣ ����
7	�������ε� �ϹݽǸ�Ȯ�� ���񽺷� ���°��.
8	�ϹݽǸ�Ȯ�� �����ε� �������� ���°��.
9	request ����Ÿ ����.(�ֹι�ȣ, ��й�ȣ, ����Ʈ���̵�, ���� �� �Ѱ��� �����Ͷ� �����ų� ������ �ִ� ���)
10	����Ʈ�ڵ� ����
11	����Ʈ ����������
12	����Ʈ �н����� ����
13	����Ʈ �����ý��� ���
15	Decoding ����(Data)
16	Decoding �ý������
18	���������� ������ �Ҹ�Ȱ��.

</PRE>

<HR>
CREDITBANK�� ������� �߻��� RETURN CODE ����<P>
<PRE>
�ڵ�	����
------- ---------------------------------------------------------------------------------
21	��ȣȭ ������ ����.(�ֹι�ȣ_��й�ȣ �ڸ����� 21�� �ƴҰ��)
24	��ȣȭ ������ ����
31	�������
32	����� �̻�(result= ) �������� �����Ͱ� �Ѿ���� ���� ��졦
34	����� ��ֹ߻�
</PRE>
*/
?>
