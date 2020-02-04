<?php

switch ( $METHOD ) {
    case 'GET':
        $orders = R::getAll('
            SELECT orders.id, users.name, services.title, orders.date, orders.done
            FROM orders
            INNER JOIN users
            ON users.id = orders.id_user
            INNER JOIN services
            ON services.id = orders.id_service
            ORDER BY orders.date;');
        $RESPONSE = $orders;
        break;
        //выборка помесячно
//        $start = $_GET['month'];
//        $start = '"2020-02-01"';
//        $end = '"2020-03-01"';
//        $orders = R::getAll('
//            SELECT orders.id, users.name, services.title, orders.date, orders.done
//            FROM orders
//            INNER JOIN users
//            ON users.id = orders.id_user
//            INNER JOIN services
//            ON services.id = orders.id_service
//            WHERE orders.date BETWEEN ' . $start . ' AND ' . $end . '
//            ORDER BY orders.date;');
//        $RESPONSE = $orders;
//        break;
        
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