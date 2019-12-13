<?php

switch ( $METHOD ) {
    case 'GET':

        $orders = R::getAll('
            SELECT users.name, services.title, orders.date, orders.done
            FROM orders
            INNER JOIN users
            ON users.id = orders.id_user
            INNER JOIN services
            ON services.id = orders.id_service
            ORDER BY orders.id;');
        $RESPONSE = $orders;
        break;

    case 'POST':
        if ($AUTH['rights']) {
            $order = R::dispense( 'orders' );
            $order[ 'id_user' ] = $AUTH['id'];
            $order[ 'id_service' ] = $POST_DATA -> id_service;
            $order[ 'date' ] = $POST_DATA -> date;
            $id = R::store( $order );
            $RESPONSE = ['message' => 'Added successfully!',
                         'id' => $id];
        } else {
            http_response_code(401); //Unauthorized
            $RESPONSE = ['error' => 'Unauthorized'];
        }
        break;

    default:
        http_response_code(405); //Method Not Allowed
        $RESPONSE = ['error' => "Wrong method for $TABLE" ];
        break;
}