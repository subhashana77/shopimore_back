<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeUpdate(
    $connection,
    "UPDATE category SET category = ? WHERE id = ?",
    $requestBody['category'],
    $requestBody['id']
);

echo $result;

if ($result) {
    Utility::sendResponse(
        true,
        "Category updated!",
        $requestBody
    );
} else {
    Utility::sendResponse(
        false,
        "Update fail!",
        null
    );
}