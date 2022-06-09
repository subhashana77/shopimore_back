<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$result = DBUtil::executeQuery(
    $connection,
    "SELECT * FROM admin WHERE email = ? AND password = ?",
    $requestBody['email'],
    $requestBody['password']
);

if (count($result) > 0) {
    $result[0]['password'] = '*****';
    $token = JwtUtil::generateAccessToken($result[0], USER_ROLE_ADMIN, ADMIN_ACCESS_TOKEN_EXP_TIME);

    Utility::sendResponse(
        true,
        null,
        $token
    );
} else {
    Utility::sendResponse(
        false,
        null,
        null
    );
}