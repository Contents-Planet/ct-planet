<?php
@header("P3P: CP='ALL IND DSP COR ADM CONo CUR CUSo IVAo IVDo PSA PSD TAI TELo OUR SAMo CNT COM INT NAV ONL PHY PRE PUR UNI'");
@header("Content-Type: text/html; charset=UTF-8");

@session_start();

define("__KEY", substr(hash('sha256', "password", true), 0, 32));
define("__IV", chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0));
$psw  = openssl_decrypt(base64_decode('TFxmMZ91TXAakqJ6RcWPKw=='), 'aes-256-cbc', __KEY, OPENSSL_RAW_DATA, __IV);

define("VERSION", "20230619");
define("PREFIX", "ctplanet");
define("TITLE_NAME", "");
define("ASSETS_PATH", "");
define("DOMAIN", "https://ct-planet.co.kr");
define("ABS_ROOT", $_SERVER['DOCUMENT_ROOT'] . ASSETS_PATH);

define("DB_HOST", "planworks2024.cvjejucpf1xq.ap-northeast-2.rds.amazonaws.com");
define("DB_USER", "root");
define("DB_PASSWORD", "plan!db6200**");
define("DB_DBNAME", "ctplanet");

define("MAIL_ADDRESS", "kkt@ct-planet.co.kr");

$__nowDate = date('Y-m-d');

/*$__member_seq = ($_COOKIE[md5(PREFIX . '_seq')]) ? base64_decode($_COOKIE[md5(PREFIX . '_seq')]) : 0;
$__member_name = ($_COOKIE[md5(PREFIX . '_name')]) ? base64_decode($_COOKIE[md5(PREFIX . '_name')]) : "";
$__member_lv = ($_COOKIE[md5(PREFIX . '_lv')]) ? base64_decode($_COOKIE[md5(PREFIX . '_lv')]) : 0;*/

function getFileExt($fname)
{
	$temp = explode(".", $fname);

	return strtolower($temp[sizeof($temp) - 1]);
}

function makeSeqCode()
{
	$code = md5(microtime());
	$code = md5(microtime() . $code);

	return $code;
}

function setLog($_type, $_category)
{
	$_SQL = new MySql();

	$sql = "
		INSERT	INTO " . PREFIX . "_log
		(		type
			,	category
			,	reg_date
		) VALUES (
				'" . $_type . "'
			,	'" . $_category . "'
			,	'" . date("Y-m-d H:i:s") . "'
		);
	";
	return $_SQL->execute($sql);
}

class MySql
{
	private $con;
	private $affected = 0;
	private $lastInsertId = 0;
	public $query = "";

	function __construct()
	{
		$this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or $this->error(mysqli_connect_error());
		mysqli_select_db($this->con, DB_DBNAME) or $this->error("no database");
	}

	function __destrust()
	{
		mysqli_close($this->con);
	}

	function sqlEscape($txt) {
		return mysqli_real_escape_string($this->con, $txt);
	}

	function execute($query)
	{
		return $this->query($query) ? true : false;
	}

	function query($query)
	{
		$result = mysqli_query($this->con, $query);

		$stmt = mysqli_query($this->con, "select last_insert_id()");

		$row = mysqli_fetch_array($stmt);
		$this->lastInsertId = $row[0];

		return $result;
	}

	function fetch($query)
	{
		$result = $this->query($query);

		return mysqli_fetch_array($result);
	}

	function lastInsertId()
	{
		return $this->lastInsertId;
	}

	function begin()
	{
		$this->query("BEGIN");
	}

	function commit()
	{
		$this->query("COMMIT");
	}

	function rollback()
	{
		$this->query("ROLLBACK");
	}

	function error($err = '')
	{
		echo "MySql Error : " . $err;
	}

	function connError()
	{
		echo "<script>alert('DB 접속 장애가 발생했습니다.'); history.back();</script>";
		exit;
	}

	//query 실행 후 영향을 받은 row의 카운트 반환
	function getAffectedRows()
	{
		return $this->affected ? $this->affected : false;
	}
}

class MySql2
{
	private $con;
	private $affected = 0;
	private $lastInsertId = 0;
	public $query = "";

	function __construct()
	{
		$this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or $this->error(mysqli_connect_error());
		mysqli_select_db($this->con, "pwe") or $this->error("no database");
	}

	function __destrust()
	{
		mysqli_close($this->con);
	}

	function sqlEscape($txt) {
		return mysqli_real_escape_string($this->con, $txt);
	}

	function execute($query)
	{
		return $this->query($query) ? true : false;
	}

	function query($query)
	{
		$result = mysqli_query($this->con, $query);

		$stmt = mysqli_query($this->con, "select last_insert_id()");

		$row = mysqli_fetch_array($stmt);
		$this->lastInsertId = $row[0];

		return $result;
	}

	function fetch($query)
	{
		$result = $this->query($query);

		return mysqli_fetch_array($result);
	}

	function lastInsertId()
	{
		return $this->lastInsertId;
	}

	function begin()
	{
		$this->query("BEGIN");
	}

	function commit()
	{
		$this->query("COMMIT");
	}

	function rollback()
	{
		$this->query("ROLLBACK");
	}

	function error($err = '')
	{
		echo "MySql Error : " . $err;
	}

	function connError()
	{
		echo "<script>alert('DB 접속 장애가 발생했습니다.'); history.back();</script>";
		exit;
	}

	//query 실행 후 영향을 받은 row의 카운트 반환
	function getAffectedRows()
	{
		return $this->affected ? $this->affected : false;
	}
}

function send_toast_sms($number, $msg, $title, $smType, $appKey, $sendNo) {
	if (!$smType) {
		$smType = "sms";
	}
	$url = "https://api-sms.cloud.toast.com/sms/v2.4/appKeys/". $appKey ."/sender/" . $smType;

	$data = [
		"body" => $msg,
		"sendNo" => $sendNo,
		"recipientList" => [
			[
				"internationalRecipientNo" => $number
			]
		]
	];

	if ($title) {
		$data["title"] = $title;
	}

	$header = array();
	$header[] = 'Content-Type: application/json;charset=UTF-8';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

	$res = curl_exec($ch);
	curl_close($ch);

	return $res;
}

function RemoveXSS($val) {
	$val = str_replace("<", "〈", $val);
	$val = str_replace("\"", "", $val);
	$val = str_replace(">", "〉", $val);
	$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for ($i = 0; $i < strlen($search); $i++) {
		$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
		$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
	}
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);
	$found = true;
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'〈x〉'.substr($ra[$i], 2);
			$val = preg_replace($pattern, $replacement, $val);
			if ($val_before == $val) {
				$found = false;
			}
		}
	}

	/*SQL Injection*/
	$val = preg_replace("/\s{1,}1\=(.*)+/","",$val); // 공백이후 1=1이 있을 경우 제거
	$val = preg_replace("/\s{1,}(or|and|null|where|limit)/i"," ",$val); // 공백이후 or, and 등이 있을 경우 제거
	//$val = preg_replace("/[\s\t\'\;\=]+/","", $val); //
	return $val;
}

class AESCrypt
{
	// 256 bit 키를 만들기 위해서 비밀번호를 해시해서 첫 32바이트를 사용합니다.
	function password($password){
		return substr(hash('sha256', $password, true), 0, 32);
	}

	// Initial Vector(IV)는 128 bit(16 byte)입니다.
	function iv(){
		return chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);;
	}

	function encrypted($str, $psw){
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		return base64_encode(openssl_encrypt($str, 'aes-256-cbc', $psw, OPENSSL_RAW_DATA, $iv));
	}

	function decrypted($str, $psw){
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		return openssl_decrypt(base64_decode($str), 'aes-256-cbc', $psw, OPENSSL_RAW_DATA, $iv);
	}
}

function setMasking($type, $obj) {
	$result = "";
	if(!empty($type)) {
		switch($type) {
			case "tel" :
				$re = '/^(\d{3})-?(\d{1,2})\d{2}-?\d(\d{3})$/';
				$subst = '$1-$2**-*$3';

				$result = preg_replace($re, $subst, $obj);
				break;
			case 'name':
				$originName = explode("", $obj);
				if (mb_strlen($obj) > 2) {
					foreach($originName as $key => $value) {
						if ($key === 0 || $key === mb_strlen($obj) - 1) {
							//$originName[$key] = $originName[$key];
						} else {
							//$originName[$key] = '*';
						}
					}

					$joinName = implode($originName);
					$result = $originName;
				} else {
					$result = preg_replace('/.(?!..)/u', '*', $obj);
				}
				break;
			case "left"   : $result = preg_replace('/.(?=.)/u', '*', $obj); break;
			case "center" : $result = preg_replace('/.(?=.$)/u', '*', $obj); break;
			case "right"  : $result = preg_replace('/.(?!..)/u', '*', $obj); break;
			case "all"    : $result = preg_replace('/./u', '*', $obj); break;
			default       : $result = preg_replace('/.(?=.$)/u', '*', $obj); break;
		}
	}

	return $result;
}

function WebHook($type, $msg) {
  $_header = array();
  $_header[] = 'Content-Type: application/json;charset=UTF-8';
  $_ch = curl_init();
  $url = 'https://hooks.slack.com/services/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';
  $data = '{ "text": "'. $msg .'" }';

  curl_setopt($_ch, CURLOPT_URL, $url);
  curl_setopt($_ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($_ch, CURLOPT_POST, TRUE);
  curl_setopt($_ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($_ch, CURLOPT_POST, true);
  curl_setopt($_ch, CURLOPT_HTTPHEADER, $_header);

  $res = curl_exec($_ch);
  curl_close($_ch);
}
?>
