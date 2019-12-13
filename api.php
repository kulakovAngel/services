<?php
require_once('helper.php');
require_once('db.php');
require_once('JWTAuth.php');

//header("Content-Type: application/json");
//header("Access-Control-Allow-Headers: *");
//header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Origin: *');
header('Content-Type: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT,DELETE');

mb_internal_encoding( "UTF-8" );

$POST_DATA_JSON = file_get_contents( 'php://input', true );
$POST_DATA = json_decode( $POST_DATA_JSON );

$METHOD = $_SERVER[ 'REQUEST_METHOD' ];
$ROUTE = mb_strtolower( $_SERVER[ 'REQUEST_URI' ] );

$ROUTE_ARR = explode( '/', $ROUTE );
if ( !$ROUTE_ARR[0] ) array_shift( $ROUTE_ARR );
if ( !end( $ROUTE_ARR ) ) array_pop( $ROUTE_ARR );


//получаем права
$AUTH = ['rights' => 0, 'status' => 'Ok'];
if ( isset ($POST_DATA -> jwt) ) {
    $AUTH = verifyRights( $POST_DATA -> jwt );
    unset( $POST_DATA -> jwt );
}



$RESPONSE = 'No data';
if ( $METHOD === 'OPTIONS' ) {
    http_response_code(200);
    exit();
}


if ( $ROUTE_ARR[0] !== 'api' ) {
    http_response_code(400); //Bad Request
    exit ( json_encode( ['error' => 'API interface reqiered. How did you get here??? - ' . $ROUTE] ) );
}


switch ( $ROUTE_ARR[1] ) {
    
    case 'auth':
        if ( $METHOD !== 'POST' ) {
            http_response_code(405); //Method Not Allowed
            exit ( json_encode( ['error' => 'Wrong method for auth' ] ) );
        } else {
            require_once('apis/auth.php');
        }
        break;
    
//    case 'orders':
//        $TABLE = $ROUTE_ARR[1];
//        if (isset ( $ROUTE_ARR[2] ) ) {
//            $ID = $ROUTE_ARR[2];
//            require_once('apis/order.php');
//        } else {
//            require_once('apis/orders.php');
//        }
//        break;
    case 'orders':
    case 'services':
        $TABLE = $ROUTE_ARR[1];
        if (isset ( $ROUTE_ARR[2] ) ) {
            $ID = $ROUTE_ARR[2];
            $file_name = substr($TABLE, 0, -1);
            require_once("apis/$file_name.php");
        } else {
            require_once("apis/$TABLE.php");
        }
        break;
    
    default:
        http_response_code(400); //Bad Request
        exit ( json_encode( ['error' => 'Bad Request: ' . $ROUTE] ) );
}


R::close();
if (isset( $AUTH['jwt'] )) {
    $RESPONSE['jwt'] = $AUTH['jwt'];
}

echo json_encode( $RESPONSE );