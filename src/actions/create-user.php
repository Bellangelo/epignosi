<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;
use App\Api\UsersResponse AS Response;

$app = new App\App();
// Redirect non-logged in user to login form.
if ( !$app->getAuth()->isUserLogged() ) {
    header('Location: /epignosi/login.php');
    exit();
}

$dbConnection = $app->getDatabaseConnection();
$userEntity = new Users( $dbConnection );
$userData = $userEntity->find([ Users::COLUMN_ID => $app->getAuth()->getUserId() ])[0];

if ( $userData[ Users::COLUMN_USER_TYPE ] !== Users::USER_TYPE_ADMIN ) {
    header('Location: /epignosi/portal.php');
    exit();
}

$response = new Response();
$responseType = Response::ERROR_TYPE;
$responseData = [];
$responseMessage = Response::MESSAGE_WRONG_DATA;

if ( !empty( @$_POST['first_name'] )
    && !empty( @$_POST['last_name'] )
    && !empty( @$_POST['password'] )
    && !empty( @$_POST['password_2'] ) 
    && !empty( @$_POST['user_type'] )
    && !empty( @$_POST['email'] ) ) {
    // Check that passwords are the same.
    if ( $_POST['password'] !== $_POST['password_2'] ) {
        $responseMessage = Response::MESSAGE_PASSWORD_MISMATCH;
    } // Check that the email is valid.
    else if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) ) {
        $responseMessage = Response::MESSAGE_INVALID_EMAIL;
    } // Check that email does not elready exists.
    else if ( !empty( $userEntity->find([ Users::COLUMN_EMAIL => $_POST['email'] ]) ) ) {
        $responseMessage = Response::MESSAGE_EMAIL_ALREADY_EXISTS;
    } // Should do more checks here like the length of each data.
    else {
        
        $currentDate = (new DateTime() )->format('Y-m-d H:i:s');
        $userEntity->set( Users::COLUMN_FIRST_NAME, $_POST['first_name'] );
        $userEntity->set( Users::COLUMN_LAST_NAME, $_POST['last_name'] );
        $userEntity->set( Users::COLUMN_USER_TYPE, $_POST['user_type'] );
        $userEntity->set( Users::COLUMN_EMAIL, $_POST['email'] );
        $userEntity->set( Users::COLUMN_CREATED, $currentDate );
        $userEntity->set( Users::COLUMN_PASSWORD, $userEntity->createHash( $_POST['password'] ) );
        
        $createUser = $userEntity->insert();

        if ( $createUser ) {
            $responseType = Response::SUCCESS_TYPE;
            $responseMessage = '';
        }

    }

}

echo $response->returnJSONResponse( $responseType, $responseData, $responseMessage );

?>