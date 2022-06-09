<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "INSERT INTO category (category) VALUES (?)",
    $requestBody['category']
);

if ($result) {
    Utility::sendResponse(
        true,
        "Category Added!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Category not added!",
        null
    );
}
