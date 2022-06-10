<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

if ($requestBody['category'] == null) {
    Utility::sendResponse(
        false,
        "Category is required!",
        null
    );
} else{
    $checkResult = DBUtil::executeQuery(
        $connection,
        "SELECT category FROM category WHERE category = ?",
        $requestBody['category']
    );

    if ($checkResult != null) {
        Utility::sendResponse(
            false,
            $requestBody['category']." is already exist!",
            null
        );
    } else {
        $result = DBUtil::executeUpdate(
            $connection,
            "INSERT INTO category (category) VALUES (?)",
            $requestBody['category']
        );

        if ($result) {
            Utility::sendResponse(
                true,
                $requestBody['category']." Added!",
                $requestBody
            );
        } else {
            Utility::sendResponse(
                false,
                $requestBody['category']." not added!",
                null
            );
        }
    }
}


