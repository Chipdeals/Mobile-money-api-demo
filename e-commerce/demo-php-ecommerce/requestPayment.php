<?php

require_once("./libs/chipdeals-mobile-money-api.php");
require_once("./productUtils.php");

header('Content-Type: application/json; charset=utf-8');

$products = "fdf";

function launchPayment()
{
  $momo = new Momo();
  //Enter your apikey here
  $momo->setApiKey("test_FOdigzgSopV8GZggZa89");
  $momo->setApiKey("live-CHIPDEALS-CTO-2000-8100-ELR@81004s");

  $request_body = file_get_contents('php://input');
  $bodyData = json_decode($request_body, true);

  $phoneNumber =  $bodyData["phoneNumber"];
  $firstName =  $bodyData["firstName"];
  $lastName =  $bodyData["lastName"];
  $amount =  $bodyData["amount"];

  $transaction = $momo
    ->collect()
    ->amount("$amount")
    ->currency("XOF")
    ->from("$phoneNumber")
    ->firstName("$firstName")
    ->lastName("$lastName")
    ->create();

  $status = $transaction->getStatus();
  $response = '{}';

  if ($status == "pending") {
    $response = [
      "pending" => true,
      "error" => false,
      "success" => false,
      "transaction" => $transaction->getArray()
    ];
  } else {
    $response = [
      "pending" => false,
      "error" => true,
      "success" => false,
      "transaction" => $transaction->getArray(),
    ];
  }

  sendResponse(json_encode($response));
  if (!$response["pending"]) return;

  do {
    $transaction = $momo->getStatus($transaction->getReference());
    $status = $transaction->getStatus();

    if ($status == "error") {
      $response = [
        "pending" => false,
        "error" => true,
        "success" => false,
        "transaction" => $transaction->getArray()
      ];
    } else if ($status == "success") {
      $response = [
        "pending" => false,
        "error" => false,
        "success" => true,
        "transaction" => $transaction->getArray(),
      ];
    } else {
      $response = [
        "pending" => true,
        "error" => false,
        "success" => false,
        "transaction" => $transaction->getArray(),
      ];
    }

    sendResponse("NewStatus" . json_encode($response));
  } while ($response["pending"] == true);
}


function sendResponse($response)
{
  echo $response;
  ob_end_flush();
  flush();
}


launchPayment();
