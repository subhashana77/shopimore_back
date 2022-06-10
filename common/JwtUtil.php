<?php
define('JWT_SECRETE_KEY', 'shopimore@dilshanSubhashan123***');
define('JWT_ALGORITHM', 'HS256');

define('USER_ROLE_ADMIN', 'admin');
define('USER_ROLE_CLIENT', 'client');

define('TOKEN_TYPE_ACCESS', 'access');

define('UNAUTHORIZED_REQUEST_CODE', 401);

define('ADMIN_ACCESS_TOKEN_EXP_TIME', 60*60*24*30); //30 day
define('CLIENT_ACCESS_TOKEN_EXP_TIME', 60*60*24); //1 day

require_once(__DIR__.'/../jwt/jwt.php');

class JwtUtil {

    /**
     * @param $role -> set null if available for all user roles
     */
    public static function validateAccessToken($role): stdClass {
        $bearerToken = apache_request_headers()['Authorization'] ?? apache_request_headers()['authorization'] ?? null;
        if (isset($bearerToken)) {
            if (isset(explode(' ', $bearerToken)[1])) {
                $token = explode(' ', $bearerToken)[1];
                try {
                    $payload = JWT::decode($token, JWT_SECRETE_KEY, [JWT_ALGORITHM]);
                    if ($payload->type !== TOKEN_TYPE_ACCESS ||  $role === null ? false : $payload->role !== $role) {
                        JwtUtil::sendUnauthorizedRequestResponse();
                    } else {
                        return $payload;
                    }
                } catch (Exception $e) {
                    JwtUtil::sendUnauthorizedRequestResponse();
                }
            } else {
                JwtUtil::sendUnauthorizedRequestResponse();
            }
        } else {
            JwtUtil::sendUnauthorizedRequestResponse();
        }
    }

    public static function generateAccessToken($userObj, $role, $exp): string {
        return JWT::encode(
            [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + $exp,
                'role' => $role,
                'type' => TOKEN_TYPE_ACCESS,
                'user' => $userObj
            ],
            JWT_SECRETE_KEY
        );
    }

    private static function sendUnauthorizedRequestResponse() {
        http_response_code(UNAUTHORIZED_REQUEST_CODE);
        $response = json_encode([
            "success" => false,
            "msg" => 'Invalid or Expired access token!'
        ]);
        echo $response;
        exit();
    }

}