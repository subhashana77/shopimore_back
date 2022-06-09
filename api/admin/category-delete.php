<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "DELETE FROM category WHERE id = ?",
    $requestBody['id']
);

if ($result) {
    Utility::sendResponse(
        true,
        "Category Deleted!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Category not deleted!",
        null
    );
}

