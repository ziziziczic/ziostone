<?
require_once("xmlrpc.inc");

class SyncDATA {
	var $Args;
	var $Host;
	var $Port;
	var $Path;
	var $errMsg;
	//var $manager_sync_list;
	var $sync_urls;
	var $sync_pw;

	function SyncDATA($sync_urls, $sync_pw) {
		$this->Args = array();
		$this->sync_urls = $sync_urls;
		$this->sync_pw = $sync_pw;
	}
	
	// 대상 주소값을 분석하여 연결 값 설정
	function setURL($url) {
		if(!$m = parse_url($url)) return $this->setError("파싱이 불가능한 URL입니다.");
		$this->Host = $m['host'];
		$this->Port = ($m['port']) ? $m['port'] : 80;
		$this->Path = ($m['path']) ? $m['path'] : "/";
		return true;
	}

	// 지입매물 원격지 등록
	function jiib_info_add($record) {
		global $DIRS, $DB_TABLES;
		for ($i=0; $i<sizeof($this->sync_urls); $i++) {
			$remote_url = "http://" . trim($this->sync_urls[$i]) . "/VG_sync/server.php";			// 원격지 서버 url 파악, 접속설정
			echo($remote_url);
			$this->setURL($remote_url);
			$record[sync_pw] = $this->sync_pw;
			$result = $this->xmlrpc_send("server.jiib_info_add", $record);
			if ($result[ok] == "Y") {
				// 동기화 결과저장
				$input_record = array();
				$input_record[svc_table] = $DB_TABLES[jiib_sell];
				$input_record[svc_table_serial] = $record[serial_num];
				$input_record[remote_url] = $remote_url;
				$input_record[remote_serial] = $result[serial_num];
				$GLOBALS[lib_common]->input_record($DB_TABLES[sync], $input_record);
			} else {
				// nothing
			}
		}
	}

	// 정보전송
	function xmlrpc_send($func, $args) {
		if ($func != "server.file_upload") {
			foreach($args as $key => $value) {
				if (is_int($key)) continue;
				$args[$key] = base64_encode($value);
			}
		}
		$server = new xmlrpc_client($this->Path, $this->Host, $this->Port);
		$server->setDebug(1);
		$message = new xmlrpcmsg($func, array(php_xmlrpc_encode($args)));
		$result = $server->send($message);
		echo($result->serialize());
		if ($result) {
			if ($ret = $result->value()) return php_xmlrpc_decode($ret);
			else return $this->setError($result->faultCode() . " : " . $result->faultString());
		} else {
			return $this->setError("Connect server error..");
		}
	}

	function setError($msg) {
		$this->errMsg = $msg;
		return false;
	}

	function login($id, $pass, $user_level) {
		$this->Args['id'] = $id;
		$this->Args['pw'] = $pass;
		$this->Args['level'] = $user_level;
	}

	function file_upload($file_names, $etc_info) {
		if ($file_names == '' || str_replace(';', '', $file_names) == '') return 0;
		$exp = explode(';', $file_names);
		$file_nums = sizeof($exp);
		$args = array("nums"=>$file_nums, "path"=>$etc_info[path]);
		for ($i=0; $i<$file_nums; $i++) {
			$file_path_full = "{$args[path]}{$exp[$i]}";
			if (!file_exists($file_path_full)) continue;
			$file_handle = fopen($file_path_full, 'r');
			$file_content = fread($file_handle, filesize($file_path_full));
			fclose($file_handle);
			$key_name = "name_{$i}";
			$key_contents = "contents_{$i}";
			$args[$key_name] = $exp[$i];
			$args[$key_contents] = chunk_split(base64_encode($file_content));
		}
		$result = $this->xmlrpc_send("server.file_upload", $args);
		if ($result[ok] == "Y") {
		} else {
		}
	}

	/*
	// 원격지 정보추출 함수
	function get_remote_info($field_name, $remote_site_id) {
		$exp = explode("\n", $this->manager_sync_list[$field_name]);
		for ($i=0; $i<sizeof($exp); $i++) {
			$exp_1 = explode(';', trim($exp[$i]));
			if ($exp_1[0] == $remote_site_id) {
				return $exp_1[1];
			}
		}
	}
	*/
}
?>