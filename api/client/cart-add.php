<?php

include_once '../../db/DBUtil.php';
include_once '../../common/Utility.php';
include_once '../../common/JwtUtil.php';

$connection = DBUtil::getConnection();
$requestBody = Utility::getRequestBody();

$decodedToken = JwtUtil::validateAccessToken(USER_ROLE_CLIENT);

if ($requestBody['quantity'] == null) {
    Utility::sendResponse(
        false,
        "Quantity is required!",
        null
    );
} else if ($requestBody['item_id'] == null) {
    Utility::sendResponse(
        false,
        "item is required!",
        null
    );
} else {

    /*
        check the cart if is exist item, if is it exist, update the cart, if not exist add to the cart
    */

    try{
        $connection->beginTransaction();
        $resultOrders = DBUtil::executeUpdate(
            $connection,
            "INSERT INTO orders (date, status, quantity, price, item_id) VALUES (?, ?, ?, ?, ?)",
            $requestBody['date'],
            $requestBody['status'],
            $requestBody['quantity'],
            $requestBody['price'],
            $requestBody['item_id']
        );

        $resultCart= DBUtil::executeUpdate(
            $connection,
            "INSERT INTO cart (price, quantity, client_id, orders_id) VALUES (?, ?, ?, ?)",
            $requestBody['price'],
            $requestBody['quantity'],
            $requestBody['client_id'],
            $requestBody['orders_id']
        );

        $connection->commit();
    } catch (mysqli_sql_exception $exception) {
        $connection->rollBack();
        Utility::sendResponse(
            false,
            "Transaction fail!",
            $exception
        );
    }

    if ($resultOrders && $resultCart) {
        Utility::sendResponse(
            true,
            "Add to cart!",
            $requestBody
        );
    } else {
        Utility::sendResponse(
            false,
            "Adding fail!",
            null
        );
    }
}

