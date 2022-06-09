<?php

class Utility
{
//    response message
    public static function sendResponse($success, $msg, $data)
    {
        echo json_encode([
            'success' => $success,
            'msg' => $msg,
            'data' => $data
        ]);
    }

//    get request from frontend
    public static function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}