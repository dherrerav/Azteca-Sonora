<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
/**
 * ACYBA
 */
class acymailingElasticemail {
	var $username = '';
	var $password = '';
	/**
	 * Ressources : Connection to the elasticemail server
	 */
	var $conn;

	/**
	 * String : Last error...
	 */
	var $error;

	function getCredits(){

		$header = "GET /mailer/account-details?username=".urlencode($this->username)."&api_key=".urlencode($this->password)." HTTP/1.0\r\n";
		$header .= "Host: api.elasticemail.com\r\n";
		$header .= "Connection: Close\r\n\r\n";

		$result = $this->sendinfo($header);
		if(!$result) return false;

		if(preg_match('#<credit>(.*)</credit>#Ui',$result,$explodedResults)){
			return $explodedResults[1];
		}else{
			$this->error = $result;
			return $result;
		}

	}

	function send(&$mailer){
		$res = "";

		$data = "username=".urlencode($this->username);
		$data .= "&api_key=".urlencode($this->password);
		$data .= "&from=".urlencode($from);
		$data .= "&from_name=".urlencode($fromName);
		$data .= "&to=".urlencode($to);
		$data .= "&subject=".urlencode($subject);
		if($body_html)
			$data .= "&body_html=".urlencode($body_html);
		if($body_text)
			$data .= "&body_text=".urlencode($body_text);

		$header = "POST /mailer/send HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";

		return sendinfo($header.$data);
	}

	function connect(){
		if(is_resource($this->conn)) return true;
		$this->conn = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 20);
		if(!$this->conn){
			$this->error = "Could not open connection ".$errstr;
			return false;
		}

		return true;
	}

	function sendinfo(&$info){
		//Check if the connection is Ok... and if not we return false.
		if(!$this->connect()){
			return false;
		}

		$res = '';
		fwrite($this->conn, $info);
		while(!feof($this->conn)) {
			$res .= fread($this->conn, 1024);
		}

		return $res;
	}

	function close(){
		fclose($this->conn);
	}
}