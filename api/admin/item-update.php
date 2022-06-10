<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_ADMIN);

$checkId = DBUtil::executeQuery(
    $connection,
    "SELECT name, code FROM item WHERE id = ?",
    $requestBody['id']
);

if ($checkId == null) {
    Utility::sendResponse(
        false,
        "Selected item not in exist!",
        null
    );
} else {

    $code = $checkId[0]['code'];

        $result = DBUtil::executeUpdate(
            $connection,
            "UPDATE item SET name = ?, weight = ?, unit = ?, unit_price = ?, quantity = ?, code = '$code', thumbnail = ?, category_id = ? WHERE id = ?",
            $requestBody['name'],
            $requestBody['weight'],
            $requestBody['unit'],
            $requestBody['unit_price'],
            $requestBody['quantity'],
            $requestBody['thumbnail'],
            $requestBody['category_id'],
            $requestBody['id']
        );

        if ($result) {
            Utility::sendResponse(
                true,
                $requestBody['name']." updated!",
                $requestBody
            );
        } else {
            Utility::sendResponse(
                false,
                $requestBody['name']." update fail!",
                null
            );
        }
}