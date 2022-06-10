<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$checkId = DBUtil::executeQuery(
    $connection,
    "SELECT id FROM category WHERE id = ?",
    $requestBody['id']
);

if ($checkId == null) {
    Utility::sendResponse(
        false,
        "Selected category not found!",
        null
    );
} else {
    $checkCategory = DBUtil::executeQuery(
        $connection,
        "SELECT category FROM category WHERE category = ?",
        $requestBody['category']
    );

    if ($checkCategory != null) {
        Utility::sendResponse(
            false,
            $requestBody['category']. " is already exist!",
            null
        );
    } else {
        $result = DBUtil::executeUpdate(
            $connection,
            "UPDATE category SET category = ? WHERE id = ?",
            $requestBody['category'],
            $requestBody['id']
        );

        if ($result) {
            Utility::sendResponse(
                true,
                $requestBody['category']." updated!",
                $requestBody
            );
        } else {
            Utility::sendResponse(
                false,
                $requestBody['category']." rename fail!",
                null
            );
        }
    }
}