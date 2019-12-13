<?php

switch ( $METHOD ) {
    case 'GET':
//        $services = R::findAll( $TABLE, 'LIMIT :offset, :count', ['offset' => $offset, 'count' => $amount] );
//        $RESPONSE = R::exportAll( $services );
        $services = R::getAll('
            SELECT *
            FROM services
            ORDER BY services.id;');
        $RESPONSE = $services;
        break;

//        это другой!
//    case 'POST':
//        if ($AUTH['rights']) {
//            $order = R::dispense( 'orders' );
//            $order[ 'id_user' ] = $AUTH['id'];
//            $order[ 'id_service' ] = $POST_DATA -> id_service;
//            $order[ 'date' ] = $POST_DATA -> date;
//            $id = R::store( $order );
//            $RESPONSE = ['message' => 'Added successfully!',
//                         'id' => $id];
//        } else {
//            http_response_code(401); //Unauthorized
//            $RESPONSE = ['error' => 'Unauthorized'];
//        }
//        break;

    default:
        http_response_code(405); //Method Not Allowed
        $RESPONSE = ['error' => "Wrong method for $TABLE" ];
        break;
}