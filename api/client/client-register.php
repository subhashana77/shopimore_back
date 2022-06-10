<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$result = DBUtil::executeUpdate(
    $connection,
    "INSERT INTO client (name, telephone, email, password, country, address, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?)",
    $requestBody['name'],
    $requestBody['telephone'],
    $requestBody['email'],
    $requestBody['password'],
    $requestBody['country'],
    $requestBody['address'],
    $requestBody['reg_date']
);

if ($result) {
    Utility::sendResponse(
        true,
        "Client registered!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Registration fail!",
        null
    );
}