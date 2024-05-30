<?php

header('Content-Type: application/json');

// Basic authentication credentials
$username = 'SB-Mid-server-yIQsPkGPeYXJDAM2voIw1mp_';

// JSON data from request body
$requestBody = file_get_contents('php://input');
$requestData = json_decode($requestBody, true);

// Generate response JSON based on request data
$responseData = [
 "payment_type" => $requestData["payment_type"],
 "transaction_details" => [
  "order_id" => isset($requestData["transaction_details"]["order_id"]) ? $requestData["transaction_details"]["order_id"] : "order_id-" . rand(1000, 9999),
  "gross_amount" => isset($requestData["transaction_details"]["gross_amount"]) ? $requestData["transaction_details"]["gross_amount"] : 100000
 ],
 "qris" => [
  "acquirer" => $requestData["qris"]["acquirer"]
 ]
];

// Output the response JSON
echo json_encode($responseData);
