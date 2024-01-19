<?php
require_once "../lib/library.php";

$mode			= isset($_REQUEST["mode"]) ? RemoveXSS($_REQUEST["mode"]) : '';
$seq_code	= isset($_REQUEST["seq_code"]) ? RemoveXSS($_REQUEST["seq_code"]) : '';

$today			= date("Y-m-d H:i:s", time());

$appl_name		= isset($_REQUEST["appl_name"]) ? RemoveXSS($_REQUEST["appl_name"]) : '';
$appl_email		= isset($_REQUEST["appl_email"]) ? RemoveXSS($_REQUEST["appl_email"]) : '';
$inquiary			= isset($_REQUEST["inquiary"]) ? RemoveXSS($_REQUEST["inquiary"]) : '';

$_SQL = new MySql();
$results["result"] = "";

header("Content-Type: application/json");
switch ($mode) {
	/**
	 * 코드 생성
	 */
	case "code":
		$results["code"] = makeSeqCode();
		break;

	case "update":
		$sqlTemp = "SELECT COUNT(seq) FROM " . PREFIX . "_request WHERE is_delete = '0' and seq_code = '". $seq_code ."'";
		$temp = $_SQL->fetch($sqlTemp);
		if($temp[0] > 0) {
			$results["sqlTemp"] = $sqlTemp;
			$results["result"] = "duplicate";
			echo json_encode($results);
			exit;
		}

		$sql = "
			INSERT	INTO " . PREFIX . "_request
			(	seq_code
				,	appl_name
				,	appl_email
				,	inquiary
				,	reg_date
			) VALUES (
					'" . $seq_code . "'
				,	'" . $appl_name . "'
				,	'" . $appl_email . "'	
				,	'" . $inquiary . "'
				,	'" . $today . "'
			);
		";
		$result = $_SQL->execute($sql);

		if ($result) {
			$results["result"] = "success";
		}
		else {
			$results["result"] = "ERROR_DB";
		}
		break;
}

echo json_encode($results);
?>
