<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "INSERT INTO item (name, weight, unit, unit_price, quantity, code, thumbnail, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
    $requestBody['name'],
    $requestBody['weight'],
    $requestBody['unit'],
    $requestBody['unit_price'],
    $requestBody['quantity'],
    $requestBody['code'],
    $requestBody['thumbnail'],
    $requestBody['category_id']
);

if ($result) {
    Utility::sendResponse(
        true,
        "Item Added!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Item not added!",
        null
    );
}
