<?

class Request
{

	var $Server = "211.233.57.174";
	var $Port = 40000;
	var $Timeout = 10000000;
	var $Socket;
	var $originator;
	var $nRemainCount;
	var $cbName = "";
	var $cbPhone = "";

	var $ErrNo = 0;
	var $ErrMsg = "";
	var $ErrCodes = array(
		800 => "Connection server failed",
	 );

	function Request()
	{
		$this->ErrNo = 0;
	}
	
	function Connect($smsid, $smspwd)
	{
		$sbMsg = "";
		$rcvMsg = "";
		$nRet = 0;
		
		$encSmsid = "";
		$encSmspwd = "";
		if($this->Socket = fsockopen($this->Server, $this->Port, &$this->ErrNo, &$this->ErrMsg, $this->Timeout)) {
			
			$encSmsid = $this->encryptData($smsid);	// smsid 를 암호화
			$encSmspwd = $this->encryptData($smspwd);	// smspwd 를 암호화
			
			$sbMsg = "LOGONREQ:smsid=".$encSmsid.",smspwd=".$encSmspwd.",\n";

			fputs($this->Socket, $sbMsg);
			$rcvMsg = fgets($this->Socket, 1024);
			$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		} else {
			// 원래의 소스코드에 있던 에러처리루틴
			if ($this->ErrNo == 0) {
				$this->ErrNo = 800;
				$this->ErrMsg = $this->ErrCodes[$this->ErrNo];
			}
			$nRet = $this->get_msgcode("ERROR_CONN");
		}
		
		return $nRet;
	}

	function SendPrompt($seq, $title, $dest, $body, $callback)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		$sTitle = "";
		$newBody = "";

		if($title != "") $sTitle = $title;

		if(!$this->Check_phonenum($dest)) return 301;
	    $sendMsg = "SUBMITREQ:sequence=".$seq.",title=".$sTitle.",destination=".$dest.",originator=".$this->originator.",body=";
		
		if(!$this->check_msg($body)) return 303;
		
		$newBody = str_replace(",", ":2c", $body);

		$sendMsg = $sendMsg.$newBody.",callback=";

		if(!$this->check_sendnum($callback)) return 302;
		$sendMsg = $sendMsg.$callback.",pryn=P,cbyn=N,\n";

		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	

		return $nRet;

	}

	function SendReserve($seq, $title, $dest, $body, $callback, $senddate, $sendtime)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		$sTitle = "";

		if($title != "") $sTitle = $title;

		if(!$this->check_phonenum($dest)) return 301;
	    $sendMsg = "SUBMITREQ:sequence=".$seq.",title=".$sTitle.",destination=".$dest.",originator=".$this->originator.",body=";
		
		if(!$this->check_msg($body)) return 303;
		
		$newBody = str_replace(",", ":2c", $body);

		$sendMsg = $sendMsg.$newBody.",callback=";

		if(!$this->check_sendnum($callback)) return 302;
		$sendMsg = $sendMsg.$callback.",senddate=";

		if(!$this->check_dateform($senddate)) return 304;
		$sendMsg = $sendMsg.$senddate.",sendtime=";

		if(!$this->check_timeform($sendtime)) return 305;
		$sendMsg = $sendMsg.$sendtime.",pryn=R,cbyn=N,\n";
		
		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);
		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	

		return $nRet;

	}

	function Disconnect()
	{
		$nRet = 0;
		$rcvMsg = "";
		$sbMsg = "LOGOFFREQ:\n";
		
		fputs($this->Socket, $sbMsg);
		$rcvMsg = fgets($this->Socket, 1024);
		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	

		return $nRet;
	}

	function SendOneshotPrompt($smsid, $smspwd, $seq, $title, $dest, $body, $callback)
	{

		$nConn = $this->Connect($smsid, $smspwd);
		if($nConn <= 100 or $nConn > 200) return false;
		$nSend = $this->SendPrompt($seq, $title, $dest, $body, $callback);
		if($nSend <= 100 or $nSend > 200) return false;
		$nClose = $this->Disconnect();
		if($nClose <= 100 or $nClose > 200) return false;

		return true;
	}

	function SendOneshotReserve($smsid, $smspwd, $seq, $title, $dest, $body, $callback, $senddate, $sendtime)
	{

		$nConn = $this->Connect($smsid, $smspwd);
		if($nConn <= 100 or $nConn > 200) return false;
		$nSend = $this->SendReserve($seq, $title, $dest, $body, $callback, $senddate, $sendtime);
		if($nSend <= 100 or $nSend > 200) return false;
		$nClose = $this->Disconnect();
		if($nClose <= 100 or $nClose > 200) return false;

		return true;
	}

	function InitSmsInfo($smsid, $smspwd, $name, $sendnum, $email)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		$encSmsid = "";
		$encSmspwd = "";

		if($smsid == "") return 306;
		if($smspwd == "") return 307;
		if($name == "") return 308;
		if($sendnum == "") return 309;
		if($email == "") return 310;
		
		if($this->Socket = fsockopen($this->Server, $this->Port, &$this->ErrNo, &$this->ErrMsg, $this->Timeout)) {
			
			$encSmsid = $this->encryptData($smsid);	// smsid 를 암호화
			$encSmspwd = $this->encryptData($smspwd);	// smspwd 를 암호화
			
			$sendMsg = "INITREQ:smsid=".$encSmsid.",smspwd=".$encSmspwd.",name=".$name.",pnum=".$sendnum.",snum=".$sendnum.",email=".$email.",\n";

			fputs($this->Socket, $sendMsg);
			$rcvMsg = fgets($this->Socket, 1024);

			$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	

			if ($this->Socket) {
				fclose($this->Socket);
			}
		} else {
			// 원래의 소스코드에 있던 에러처리루틴
			if ($this->ErrNo == 0) {
				$this->ErrNo = 800;
				$this->ErrMsg = $this->ErrCodes[$this->ErrNo];
			}
			$nRet = $this->get_msgcode("ERROR_CONN");
		}

		return $nRet;
	}
	
	function SetSmsPassword($newpasswd)
	{
		$encNewp = "";	// $newpasswd 를 암호화
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return 312;
		if(strlen($newpasswd) < 1) return 307;
		
		$encNewp = $this->encryptData($newpasswd);	// smspwd 를 암호화

		$sendMsg = "UPDATEREQ:originator=".$this->originator.",newp=".$encNewp.",\n";
		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $nRet;
	}

	function SetSmsName($newname)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return 312;
		if(strlen($newname) < 1) return 308;

		$sendMsg = "UPDATEREQ:originator=".$this->originator.",name=".$newname.",\n";
		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $nRet;
	}

	function SetSmsEmail($newmail)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return 312;
		if(strlen($newmail) < 1) return 310;

		$sendMsg = "UPDATEREQ:originator=".$this->originator.",email=".$newmail.",\n";
		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $nRet;
	}
	
	function SetSmsPhonenum($newpnum)
	{
		$nRet = 0;
		$rcvMsg = "";
		$sendMsg = "";

		if($this->originator == "") return 312;
		if(strlen($newpnum) < 1) return 309;

		$sendMsg = "UPDATEREQ:originator=".$this->originator.",snum=".$newpnum.",pnum=".$newpnum.",\n";
		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $nRet;
	}

	function ResetMethods()
	{

		unset($this->Server);
		unset($this->Port);
		unset($this->Timeout);
		unset($this->Socket);
		unset($this->originator);
		unset($this->ErrNo);
		unset($this->ErrMsg);
		unset($this->ErrCodes);

	}

	function check_dateform($sDate)
	{
		if(strlen($sDate) != 8) return false;
		if(is_numeric($sDate)) return true;
		else return false;
	}

	function check_timeform($sTime)
	{
		if(strlen($sTime) != 6) return false;
		if(is_numeric($sTime)) return true;
		else return false;
	}

	function check_msg($msg) 
	{
		if(strlen($msg) > 160) return false;

		else return true;

	}
	
	function check_phonenum($pNum)
	{
		if($pNum == "") return false;
		if(strlen($pNum) < 10 or strlen($pNum) > 11) return false;
		$carrier = substr($pNum, 0, 3);
		if(!is_numeric($pNum)) return false;
		if(strcmp($carrier, "010") == 0 or strcmp($carrier, "011") == 0 or strcmp($carrier, "016") == 0 or strcmp($carrier, "017") == 0 or strcmp($carrier, "018") == 0 or strcmp($carrier, "019") == 0) return true;
		else return false;
	}
	
	function check_sendnum($pNum)
	{
		if($pNum == "") return false;
		if(!is_numeric($pNum)) return false;
		return true;
	}

	function parse_message($msg)
	{
		$tokens = explode(":", $msg);
		$sCommand = $tokens[0];
		$sParam = $tokens[1];
		$sReson = "";
		$sRet = "";

		$tokens = explode(",", $sParam);

		for($i = 0; $i < sizeof($tokens); $i++) {
			$sTemp = $tokens[$i];
			$arrTemp = explode("=", $sTemp);
 
			if(strcmp($arrTemp[0], "ORIGINATOR") == 0) {
				$this->originator = $arrTemp[1];
			}
			if(strcmp($arrTemp[0], "REASON") == 0) $sReason = $arrTemp[1];
			if(strcmp($arrTemp[0], "REMAIN") == 0) $this->nRemainCount = $arrTemp[1];
			if(strcmp($arrTemp[0], "CBNAME") == 0) $this->cbName = $arrTemp[1];
			if(strcmp($arrTemp[0], "CBPHONE") == 0) $this->cbPhone = $arrTemp[1];
		}

		if(strcmp($sCommand, "UPDATECONF") == 0) $sRet = "SUCC_UPDCONF";
		if(strcmp($sCommand, "INITCONF") == 0) $sRet = "SUCC_INITCONF";
		if(strcmp($sCommand, "LOGONCONF") == 0) $sRet = "SUCC_LOGONCONF";
		if(strcmp($sCommand, "SUBMITCONF") == 0) $sRet = "SUCC_SUBMITCONF";
		if(strcmp($sCommand, "LOGOFFCONF") == 0) $sRet = "SUCC_LOGOFFCONF";
		if(strcmp($sCommand, "SENDREMAINCONF") == 0) $sRet = "SUCC_SENDREMAINCONF";
		if(strcmp($sCommand, "SENDBASICCONF") == 0) $sRet = "SUCC_SENDBASICCONF";
		if(strcmp($sCommand, "SENDCHARGECONF") == 0) $sRet = "SUCC_SENDCHARGECONF";
		if(strcmp($sCommand, "INITREJ") == 0 or strcmp($sCommand, "LOGONREJ") == 0 or strcmp($sCommand, "SUBMITREJ") == 0 or strcmp($sCommand, "LOGOFFREJ") == 0) {
			$sRet = "ERROR_".$sReason;
		}

		return $sRet;
	}
	
	function get_code_message($ncode)
	{
		$ret_msg = "";
		switch($nCode) {
			case 101 :
				$ret_msg = "Logon success";
				break;
			case 102 :
				$ret_msg = "Submit Success";
				break;
			case 103 :
				$ret_msg = "Logoff Success";
				break;
			case 104 :
				$ret_msg = "SendRemain Success";
				break;
			case 105 :
				$ret_msg = "SendBasicRemain Success";
				break;
			case 106 :
				$ret_msg = "SendChargeRemain Success";
				break;
			case 107 :
				$ret_msg = "SendCallbackInfo Success";
				break;
			case 108 :
				$ret_msg = "SendUpdateCallbackPhone Success";
				break;
			case 109 :
				$ret_msg = "ResistSmsIdInfo Success";
				break;
			case 110 :
				$ret_msg = "Change password Success";
				break;
			case 201 :
				$ret_msg = "Connection Error";
				break;
			case 202 :
				$ret_msg = "Logon Required before sending message";
				break;
			case 203 :
				$ret_msg = "Logon failed";
				break;
			case 204 :
				$ret_msg = "Short of cash to send";
				break;
			case 205 :
				$ret_msg = "Submitreq message required";
				break;
			case 206 :
				$ret_msg = "Error in Register Request Message";
				break;
			case 207 :
				$ret_msg = "Error in changing password";
				break;
			case 208 :
				$ret_msg = "Login failed with smsid";
				break;
			case 209 :
				$ret_msg = "Login failed with smspwd";
				break;
			case 210 :
				$ret_msg = "Login failed for invalid cash";
				break;
			case 211 :
				$ret_msg = "Login failed for deleted smsid";
				break;
			case 212 :
				$ret_msg = "Login failed for already login user";
				break;
			case 301 :
				$ret_msg = "Error in destination number";
				break;
			case 302 :
				$ret_msg = "Error in callback number";
				break;
			case 303 :
				$re_msg = "Error in body";
				break;
			case 304 :
				$ret_msg = "Error in senddate";
				break;
			case 305 :
				$ret_msg = "Error in sendtime";
				break;
			case 306 :
				$ret_msg = "Blank in smsid";
				break;
			case 307 :
				$ret_msg = "Blank in smspwd";
				break;
			case 308 :
				$ret_msg = "Blank in name column";
				break;
			case 309 :
				$ret_msg = "Blank in phonenum column";
				break;
			case 310 :
				$ret_msg = "Blank in email column";
				break;
			case 311 :
				$ret_msg = "Blank in new password column";
				break;
			case 312 :
				$ret_msg = "Logon Required";
				break;

			default :
				$ret_msg = "others";
		}

		return $ret_msg;
	}
	
	function get_msgcode($sMsg)
	{
		if($sMsg == "") return -1;
		if(strcmp($sMsg, "ERROR_CONN") == 0) return 201;
		if(strcmp($sMsg, "ERROR_LOG_REQ") == 0) return 202;
		if(strcmp($sMsg, "ERROR_LOG_FAIL") == 0) return 203;
		if(strcmp($sMsg, "ERROR_SHORT_CASH") == 0) return 204;
		if(strcmp($sMsg, "ERROR_SUBMITREQ_REQ") == 0) return 205;
		if(strcmp($sMsg, "ERROR_ERR_INIT") == 0) return 206;
		if(strcmp($sMsg, "ERROR_ERR_PWD") == 0) return 207;
		if(strcmp($sMsg, "ERROR_MISMATCH_SMSID") == 0) return 208;
		if(strcmp($sMsg, "ERROR_MISMATCH_SMSPWD") == 0) return 209;
		if(strcmp($sMsg, "ERROR_INVALID_CASH") == 0) return 210;
		if(strcmp($sMsg, "ERROR_DELETED_SMSID") == 0) return 211;
		if(strcmp($sMsg, "ERROR_LOGIN_ALREADY") == 0) return 212;

		if(strcmp($sMsg, "SUCC_LOGONCONF") == 0) return 101;
		if(strcmp($sMsg, "SUCC_SUBMITCONF") == 0) return 102;	
		if(strcmp($sMsg, "SUCC_LOGOFFCONF") == 0) return 103;
		if(strcmp($sMsg, "SUCC_SENDREMAINCONF") == 0) return 104;
		if(strcmp($sMsg, "SUCC_SENDBASICCONF") == 0) return 105;
		if(strcmp($sMsg, "SUCC_SENDCHARGECONF") == 0) return 106;
		if(strcmp($sMsg, "SUCC_SENDCALLBACKCONF") == 0) return 107;
		if(strcmp($sMsg, "SUCC_SENDEDITCBCONF") == 0) return 108;
		if(strcmp($sMsg, "SUCC_INITCONF") == 0) return 109;
		if(strcmp($sMsg, "SUCC_UPDCONF") == 0) return 110;

		return -1;
	}

	function Destroy()
	{
		if ($this->Socket) {

			fclose($this->Socket);
		}
	}

	function encryptData($sSrc)
	{
		$str = "";
		$num = 0;
		$changed = "";
		$retStr = "";
		for($i = 0; $i < strlen($sSrc); $i++) {
			$num = ord($sSrc[$i]);
			$str = "$num";
			if(strlen($str) == 1) {
				$changed = $str;
			}
			if(strlen($str) == 2) {
				$changed = $str[1].$str[0];
			}
			if(strlen($str) == 3) {
				$changed = $str[2].$str[1].$str[0];
			}

			$changed = strlen($changed).$changed;
			$retStr = $retStr.$changed;
		}

		return $retStr;
	}

	function getRemainCount()
	{
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return -1;
		$sendMsg = "SENDREMAINREQ:originator=".$this->originator.",\n";

		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $this->nRemainCount;
	}

	function getBasicRemain()
	{
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return -1;
		$sendMsg = "SENDBASICREQ:originator=".$this->originator.",\n";

		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $this->nRemainCount;
	}

	function getChargeRemain()
	{
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return -1;
		$sendMsg = "SENDCHARGEREQ:originator=".$this->originator.",\n";

		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$nRet = $this->get_msgcode($this->parse_message($rcvMsg));	
		
		return $this->nRemainCount;
	}

	function getCallbackInfo()
	{
		$rcvMsg = "";
		$sendMsg = "";
		
		if($this->originator == "") return 312;
		$sendMsg = "SENDCALLBACKREQ:originator=".$this->originator.",\n";

		fputs($this->Socket, $sendMsg);
		$rcvMsg = fgets($this->Socket, 1024);

		$this->parse_message($rcvMsg);
		
		return 101;
	}

	function getCallbackName()
	{
		return $this->cbName;
	}

	function getCallbackPhone()
	{
		return $this->cbPhone;
	}
}

class Response extends Request
{

	var $StatusCode;
	var $Data = array();
	var $Data_Info = array();
	var $Infomation = array();
	var $Count = 0;
	var $errNo = 0;
	var $errMsg = "";

	function Response($Socket)
	{
		$this->Socket = $Socket;
		$Response = $this->Connect();
		return $Response;

	}

	function ParseResponse($Response)
	{
		return true;
	}
}
?>
