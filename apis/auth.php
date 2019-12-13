<?php

switch ( $ROUTE_ARR[2] ) {
    case 'signin':
        //проверка, может уже есть логин такой
        //$l  = R::find( 'users', "{$POST_DATA -> login}");
        $l = R::getCell( "SELECT (login) FROM users WHERE login='{$POST_DATA -> login}'" );
        if ( $POST_DATA -> login === $l ) {
            http_response_code(409); //Conflict
            exit( json_encode( ['error' => "Already exists: $l"] ) );
        } else {
            $ph = password_hash($POST_DATA -> password, PASSWORD_DEFAULT);
            $t = R::dispense( 'users' );
            $t -> name = $POST_DATA -> name;
            $t -> login = $POST_DATA -> login;
            $t -> hash = $ph;
            R::store( $t );
            $RESPONSE = ['message' => "User added successfully!"];
        }
        break;

    case 'login':
        $user = R::findOne( 'users', "login='{$POST_DATA -> login}'");
        $ver = password_verify($POST_DATA -> password, $user['hash']);
        if ( $ver ) {
            $jwtO = new JWTAuth( $user['id'], $user['login'] );
            $jwt = $jwtO -> get();
            $RESPONSE = ['name' => $user['name'], 'jwt' => $jwt];
        } else {
            http_response_code(401); //Unauthorized
            $RESPONSE = ['error' => 'Invalid login or password'];
        }
        break;
    
    case 'logout':
        exit( json_encode( ['message' => 'Logout successfully!',
                            'jwt' => ''] ) );
        break;
    
    default:
        http_response_code(400); //Bad Request
        $RESPONSE = ['error' => 'Bad Request: ' . $ROUTE];
}