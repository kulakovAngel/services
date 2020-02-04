<?php

switch ( $METHOD ) {
    case 'GET':
        //$order = R::load( $TABLE, $ID );
        $order = R::getRow("
            SELECT users.name, services.title, orders.date, orders.done
            FROM $TABLE
            INNER JOIN users
            ON users.id = orders.id_user
            INNER JOIN services
            ON services.id = orders.id_service
            WHERE $TABLE.id = $ID;");
        $RESPONSE = $order;
        break;

    case 'PUT':
        switch ( $AUTH['rights'] ) {
            case 0:
                http_response_code(401); //Unauthorized
                $RESPONSE = ['error' => 'Unauthorized'];
                break;
            case 1:
                http_response_code(403); //Forbidden
                $RESPONSE = ['error' => 'Forbidden'];
                break;
            case 2:
                $t = R::load( $TABLE, $ID );
                $t['done'] = true;
                R::store( $t );
                $RESPONSE = ['message' => 'Changed successfully!'];
                break;
        }
        break;

//    case 'DELETE':
//        if ($AUTH['rights'] == 2) {
//            $t = R::load( $TABLE, $ID );
//            R::trash( $t );
//            //$response = $t;
//            $RESPONSE = ['message' => 'Deleted successfully!'];
//        } else {
//            http_response_code(401); //Unauthorized
//            $RESPONSE = ['error' => 'Unauthorized'];
//        }
//        break;
    
    default:
        http_response_code(405); //Method Not Allowed
        $RESPONSE = ['error' => "Wrong method for $TABLE:$ID" ];
        break;
}