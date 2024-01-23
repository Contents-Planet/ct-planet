<?php
error_reporting(0);
require_once $_SERVER["DOCUMENT_ROOT"] . '/app/service/Pwe.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/app/service/CtplanetService.php';

use app\service\Pwe;
use app\service\CtplanetService;

$_actionMode = isset($_POST['mode']) ? $_POST['mode'] : null;

$pwe = new Pwe();

switch ($_actionMode) {

  case "getList":
    try {
      $ctplanetService = new CtplanetService("portfolio");
      $team = $_POST['team'];

      echo json_encode($ctplanetService->referenceList($team));

    } catch (Exception $e) {
      // var_dump($e->getMessage());
      echo json_encode([
        "result" => 400
      ]);
    }
    break;

  case "getDetail":
    try {
      $ctplanetService = new CtplanetService("portfolio");
      $seq = isset($_POST['seq']) ? $_POST['seq'] : null;

      echo json_encode($ctplanetService->referenceDetail($seq));

    } catch (Exception $e) {
      // var_dump($e->getMessage());
      echo json_encode([
        "result" => 400
      ]);
    }
    break;
}
exit;
