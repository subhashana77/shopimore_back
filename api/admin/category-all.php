<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$result = DBUtil::executeQuery(
    $connection,
    "SELECT id, category FROM category ORDER BY category ASC"
);

if ($result) {
    Utility::sendResponse(
        true,
        "Categories are fetched!",
        $result
    );
} else {
    Utility::sendResponse(
        false,
        "Category not found!",
        null
    );
}
