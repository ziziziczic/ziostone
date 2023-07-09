<?
require "header.inc.php";

$prev_month  = mktime (0,0,0, date("m")-3, date("d"), date("Y"));
$P_contents = "
<script language='javascript'>
    function visit_delete_submit(f) {
        if (confirm('정말 삭제하시겠습니까?')) return true;
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
					<td class='input_form_title' width=120>일별 방문자 현황</td>
					<td class='input_form_value'>
						<input type=text name=fr_date size=10 maxlength=10 value='" . date("Y-m-d") . "' class='designer_text'> 일 부터
						<input type=text name=to_date size=10 maxlength=10 value='" . date("Y-m-d") . "' class='designer_text'> 일 까지
						<input type=submit value='확인' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_month action='visit_month.php'>
					<td class='input_form_title'>월별 방문자 현황</td>
					<td class='input_form_value'>
						<input type=text name=fr_month size=7 maxlength=7 value='" . date("Y-m") . "' class='designer_text'> 월 부터
						<input type=text name=to_month size=7 maxlength=7 value='" . date("Y-m") . "' class='designer_text'> 월 까지
						<input type=submit value='확인' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_year action='visit_year.php'>
					<td class='input_form_title'>년별 방문자 현황</td>
					<td class='input_form_value'>
						<input type=text name=fr_year size=4 maxlength=4 value='" . date("Y") . "' class='designer_text'> 년 부터 
						<input type=text name=to_year size=4 maxlength=4 value='" . date("Y") . "' class='designer_text'> 년 까지 
						<input type=submit value='확인' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_total action='visit_total_update.php'>
					<td class='input_form_title'>방문자 합계에 반영</td>
					<td class='input_form_value' colspan='3'>
						* 카운터가 틀릴때 사용하세요. <input type=submit value='확인' class=button>
					</td>
					</form>
				</tr>
				<tr>
					<form name=fo_visit_delete action='visit_update.php' onsubmit='return visit_delete_submit(this);'>
					<td class='input_form_title'>
						카운터 DB 정리
					</td>
					<td class='input_form_value' colspan='3'>
						<input type=text name=to_date size=10 maxlength=10 value='" . date("Y-m-d", $prev_month) . "' class='designer_text'> 이전 내역 삭제
						<input type=hidden name=j value=d>
						<input type=submit value='확인' class=designer_button><br>
						* DB 용량이 없을 경우에 사용합니다.
					</td>
					</form>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"방문자통계검색"));
echo($P_contents);
include "footer.inc.php";
?>
