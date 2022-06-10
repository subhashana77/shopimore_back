<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$checkId = DBUtil::executeQuery(
    $connection,
    "SELECT name FROM item WHERE id = ?",
    $requestBody['id']
);

if ($checkId == null) {
    Utility::sendResponse(
        false,
        "Selected item not exist",
        null
    );
} else {
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
}


