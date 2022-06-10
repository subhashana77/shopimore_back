<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "UPDATE item SET name = ?, weight = ?, unit = ?, unit_price = ?, quantity = ?, code = ?, thumbnail = ?, category_id = ? WHERE id = ?",
    $requestBody['name'],
    $requestBody['weight'],
    $requestBody['unit'],
    $requestBody['unit_price'],
    $requestBody['quantity'],
    $requestBody['code'],
    $requestBody['thumbnail'],
    $requestBody['category_id'],
    $requestBody['id']
);

echo $result;

if ($result) {
    Utility::sendResponse(
        true,
        "Item updated!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Update fail!",
        null
    );
}