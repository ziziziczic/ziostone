<?
require "header.inc.php";

$prev_month  = mktime (0,0,0, date("m")-3, date("d"), date("Y"));
$P_contents = "
<script language='javascript'>
    function visit_delete_submit(f) {
        if (confirm('���� �����Ͻðڽ��ϱ�?')) return true;
        return false;
    }
</script>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td width='100%'>
			<table border='0' cellpadding='7' cellspacing='1'  width='100%' class=input_form_table>
				<tr>
					<form name=fo_visit_date action='visit_date.php'>
					<input type='hidden' name='is_stripslashes' value='N'>
					<td class='input_form_title' width=120>�Ϻ� �湮�� ��Ȳ</td>
					<td class='input_form_value'>
						<input type=text name=fr_date size=10 maxlength=10 value='" . date("Y-m-d") . "' class='designer_text'> �� ����
						<input type=text name=to_date size=10 maxlength=10 value='" . date("Y-m-d") . "' class='designer_text'> �� ����
						<input type=submit value='Ȯ��' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_month action='visit_month.php'>
					<td class='input_form_title'>���� �湮�� ��Ȳ</td>
					<td class='input_form_value'>
						<input type=text name=fr_month size=7 maxlength=7 value='" . date("Y-m") . "' class='designer_text'> �� ����
						<input type=text name=to_month size=7 maxlength=7 value='" . date("Y-m") . "' class='designer_text'> �� ����
						<input type=submit value='Ȯ��' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_year action='visit_year.php'>
					<td class='input_form_title'>�⺰ �湮�� ��Ȳ</td>
					<td class='input_form_value'>
						<input type=text name=fr_year size=4 maxlength=4 value='" . date("Y") . "' class='designer_text'> �� ���� 
						<input type=text name=to_year size=4 maxlength=4 value='" . date("Y") . "' class='designer_text'> �� ���� 
						<input type=submit value='Ȯ��' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_total action='visit_total_update.php'>
					<td class='input_form_title'>�湮�� �հ迡 �ݿ�</td>
					<td class='input_form_value' colspan='3'>
						* ī���Ͱ� Ʋ���� ����ϼ���. <input type=submit value='Ȯ��' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_delete action='visit_update.php' onsubmit='return visit_delete_submit(this);'>
					<td class='input_form_title'>
						ī���� DB ����
					</td>
					<td class='input_form_value' colspan='3'>
						<input type=text name=to_date size=10 maxlength=10 value='" . date("Y-m-d", $prev_month) . "' class='designer_text'> ���� ���� ����
						<input type=hidden name=j value=d>
						<input type=submit value='Ȯ��' class=designer_button><br>
						* DB �뷮�� ���� ��쿡 ����մϴ�.
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"�湮�����˻�"));
echo($P_contents);
include "footer.inc.php";
?>
