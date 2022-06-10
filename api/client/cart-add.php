<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_CLIENT);

$connection->beginTransaction();
try{
    $result = DBUtil::executeUpdate(
        $connection,
        "INSERT INTO orders (date, status, client_id) VALUES (?, ?, ?)",
        $requestBody['date'],
        $requestBody['status'],
        $requestBody['client_id']
    );
    $connection->commit();
} catch (mysqli_sql_exception $exception) {
    $connection->rollBack();
    Utility::sendResponse(
        false,
        "Transaction fail!",
        $exception
    );
}


if ($result) {
    Utility::sendResponse(
        true,
        "Add to cart!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Adding fail!",
        null
    );
}
