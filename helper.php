<?php

error_reporting(-1);
ini_set('display_errors', 'Off');
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/log.txt');
ini_set('log_errors', 'On');


function add_keys_to_obj( $to, $from ) {
  foreach( $from as $key => $value ) {
    $to -> $key = $value;
  }
}


function verifyRights($jwt) {
    
    if ( !isset( $jwt ) )
        return ['rights' => 0, 'status' => 'Ok'];
    
    try {
        $decoded = JWTAuth::verify( $jwt );
        $login = $decoded -> login;
        $id = $decoded -> id;
        
        $user = R::findOne( 'users', "login='$login'");
        $rights = $user['rights'];
        
        $jwt = new JWTAuth($id, $login);
        $newJWTToken = $jwt -> get();
        return ['rights' => $rights,
                'login' => $login,
                'id' => $id,
                'jwt' => $newJWTToken,
                'status' => 'Ok'];
        
    } catch (Error | Exception $e) {
        return ['rights' => 0, 'status' => 'Verification error'];
    }
}