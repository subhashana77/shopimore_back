<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$nameIndex = $requestBody['name'];
$searchName =  '%'.$nameIndex.'%';

$result = DBUtil::executeQuery(
    $connection,
    "SELECT i.id, i.name, i.weight, i.unit, i.unit_price, i.quantity, i.code, i.thumbnail, c.category 
FROM item i, category c WHERE c.id = i.category_id AND name LIKE '$searchName' GROUP BY i.id ORDER BY i.name ASC"
);

if ($result) {
    Utility::sendResponse(
        true,
        $requestBody['name']." are fetched!",
        $result
    );
} else {
    Utility::sendResponse(
        false,
        $requestBody['name']." not found!",
        null
    );
}
