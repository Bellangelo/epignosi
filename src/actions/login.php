<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;
use App\Api\UsersResponse AS Response;

$app = new App\App();
// Redirect logged in user to login form.
if ( $app->getAuth()->isUserLogged() ) {
    header('Location: /epignosi/portal.php');
    exit();
}

$response = new Response();

$dbConnection = $app->getDatabaseConnection();
$userEntity = new Users( $dbConnection );

$responseType = Response::ERROR_TYPE;
$responseData = [];
$responseMessage = Response::MESSAGE_WRONG_DATA;

if ( !empty( @$_POST['email'] ) && !empty( @$_POST['password'] ) ) {
    
    $userData = [ Users::COLUMN_PASSWORD, Users::COLUMN_ID ];
    $user = $userEntity->find( [ Users::COLUMN_EMAIL => $_POST['email'] ], 1, $userData );
    // Email does not exist.
    if ( empty( $user ) ) {
        $responseMessage = Response::MESSAGE_USER_DOES_NOT_EXIST;
    }
    else if ( $userEntity->verifyPassword( $_POST['password'], $user[0][ Users::COLUMN_PASSWORD ] ) ) {
        // Email and password are correct.
        $app->getAuth()->logUser( $user[0][ Users::COLUMN_ID ] );
        $responseType = Response::SUCCESS_TYPE;
        $responseData = [
            'user_id' => $user[0][ Users::COLUMN_ID ]
        ];
        $responseMessage = '';

    } // Password is incorrect.
    else {
        $responseMessage = Response::MESSAGE_INCORRECT_PASSWORD;
    }

}

echo $response->returnJSONResponse( $responseType, $responseData, $responseMessage );

?>