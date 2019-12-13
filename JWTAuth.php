<?php
use \Firebase\JWT\JWT;
require_once( "libs\php-jwt\JWT.php" );

class JWTAuth {
    private const KEY = "cWt3S1tkEb";
    private $token = [];
    private $jwt;
    
    public function __construct($id, $login) {
        $this -> token = ["iss" => $_SERVER["SERVER_NAME"],
                          "exp" => time() + 1800]; //один час
        $this -> token['id'] = $id;
        $this -> token['login'] = $login;
        $this -> jwt = JWT::encode($this -> token, self::KEY);
    }
    
    public function get() {
        return $this -> jwt;
    }
    
    public static function verify($jwt) {
        $decoded = JWT::decode($jwt, self::KEY, array('HS256'));
//        $id = $decoded -> id;
//        $login = $decoded -> login;
        return $decoded;
        //exit(json_encode($decoded));
    }
}