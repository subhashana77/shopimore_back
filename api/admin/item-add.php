<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

if ($requestBody['name'] == null) {
    Utility::sendResponse(
        false,
        "Name is required!",
        null
    );
} else if ($requestBody['weight'] == null) {
    Utility::sendResponse(
        false,
        "Weight is required!",
        null
    );
} else if ($requestBody['unit'] == null) {
    Utility::sendResponse(
        false,
        "Unit is required!",
        null
    );
} else if ($requestBody['unit_price'] == null) {
    Utility::sendResponse(
        false,
        "Unit Price is required!",
        null
    );
} else if ($requestBody['quantity'] == null) {
    Utility::sendResponse(
        false,
        "Quantity is required!",
        null
    );
} else if ($requestBody['code'] == null) {
    Utility::sendResponse(
        false,
        "Code is required!",
        null
    );
} else if ($requestBody['thumbnail'] == null) {
    Utility::sendResponse(
        false,
        "Thumbnail is required!",
        null
    );
} else if ($requestBody['category_id'] == null) {
    Utility::sendResponse(
        false,
        "Category is required!",
        null
    );
} else {

    $checkResult = DBUtil::executeQuery(
        $connection,
        "SELECT * FROM item WHERE code = ?",
        $requestBody['code']
    );

    if ($checkResult != null) {
        Utility::sendResponse(
            false,
            "Code can not be duplicate!",
            null
        );
    } else {
        $result = DBUtil::executeUpdate(
            $connection,
            "INSERT INTO item (name, weight, unit, unit_price, quantity, code, thumbnail, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            $requestBody['name'],
            $requestBody['weight'],
            $requestBody['unit'],
            $requestBody['unit_price'],
            $requestBody['quantity'],
            $requestBody['code'],
            $requestBody['thumbnail'],
            $requestBody['category_id']
        );

        if ($result) {
            Utility::sendResponse(
                true,
                $requestBody['name']." Added!",
                $requestBody
            );
        } else {
            Utility::sendResponse(
                false,
                $requestBody['name']." not added!",
                null
            );
        }
    }
}