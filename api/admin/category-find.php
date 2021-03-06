<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$categoryIndex = $requestBody['category'];
$searchCategory =  '%'.$categoryIndex.'%';

$result = DBUtil::executeQuery(
    $connection,
    "SELECT id, category FROM category WHERE category LIKE '$searchCategory'"
);

if ($result) {
    Utility::sendResponse(
        true,
        $result[0]['category']." is fetched!",
        $result
    );
} else {
    Utility::sendResponse(
        false,
        $result[0]['category']." not found!",
        null
    );
}
