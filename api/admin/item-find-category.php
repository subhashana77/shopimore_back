<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeQuery(
    $connection,
    "SELECT i.id, i.name, i.weight, i.unit, i.unit_price, i.quantity, i.code, i.thumbnail, c.category 
FROM item i, category c WHERE c.id = i.category_id AND c.category = ? GROUP BY i.id ORDER BY i.name ASC",
    $requestBody['category']
);

if ($result) {
    Utility::sendResponse(
        true,
        $result[0]['name']." are found!",
        $result
    );
} else {
    Utility::sendResponse(
        false,
        "items not found!",
        null
    );
}
