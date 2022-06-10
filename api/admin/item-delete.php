<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "DELETE FROM item WHERE id = ?",
    $requestBody['id']
);

if ($result) {
    Utility::sendResponse(
        true,
        "Item Deleted!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Item not deleted!",
        null
    );
}

