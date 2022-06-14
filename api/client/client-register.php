<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

if ($requestBody['name'] == null) {
    Utility::sendResponse(
        false,
        "name is required!",
        null
    );
} else if ($requestBody['telephone'] == null) {
    Utility::sendResponse(
        false,
        "telephone is required!",
        null
    );
} else if ($requestBody['email'] == null) {
    Utility::sendResponse(
        false,
        "email is required!",
        null
    );
} else if ($requestBody['password'] == null) {
    Utility::sendResponse(
        false,
        "password is required!",
        null
    );
} else if ($requestBody['country'] == null) {
    Utility::sendResponse(
        false,
        "country is required!",
        null
    );
} else if ($requestBody['address'] == null) {
    Utility::sendResponse(
        false,
        "country is required!",
        null
    );
} else if ($requestBody['reg_date'] == null) {
    Utility::sendResponse(
        false,
        "register date is required!",
        null
    );
} else {

    $password = $requestBody['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $checkTelephone = DBUtil::executeQuery(
        $connection,
        "SELECT telephone FROM client WHERE telephone = ?",
        $requestBody['telephone']
    );

    $checkEmail = DBUtil::executeQuery(
        $connection,
        "SELECT email FROM client WHERE email = ?",
        $requestBody['email']
    );

    if ($checkTelephone != null) {
        Utility::sendResponse(
            false,
            $requestBody['telephone']." already registered",
            null
        );
    } else if ($checkEmail != null) {
        Utility::sendResponse(
            false,
            $requestBody['email']." already registered",
            null
        );
    } else {
        $result = DBUtil::executeUpdate(
            $connection,
            "INSERT INTO client (name, telephone, email, '$hash', country, address, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?)",
            $requestBody['name'],
            $requestBody['telephone'],
            $requestBody['email'],
            $requestBody['country'],
            $requestBody['address'],
            $requestBody['reg_date']
        );

        if ($result) {
            Utility::sendResponse(
                true,
                "Client registered!",
                $requestBody
            );
        } else {
            Utility::sendResponse(
                false,
                "Registration fail!",
                null
            );
        }
    }
}
