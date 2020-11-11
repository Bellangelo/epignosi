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
    && !empty( @$_POST['user_type'] )
    && !empty( @$_POST['email'] )
    && !empty( @$_POST['id'] ) ) {
    
    $user = $userEntity->find([ Users::COLUMN_ID => $_POST['id'] ]);

    if ( empty( $user ) ) {
        $responseMessage = Response::MESSAGE_USER_DOES_NOT_EXIST;
    } // Check that passwords are the same.
    else if ( ( !empty( @$_POST['password'] ) || !empty( @$_POST['password_2'] ) )
        && @$_POST['password'] !== @$_POST['password_2'] ) {
        $responseMessage = Response::MESSAGE_PASSWORD_MISMATCH;
    } // Check that the email is valid.
    else if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) ) {
        $responseMessage = Response::MESSAGE_INVALID_EMAIL;
    } // Check that email does not elready exists.
    else if ( $_POST['email'] !== $user[0][ Users::COLUMN_EMAIL ]
        && !empty( $userEntity->find([ Users::COLUMN_EMAIL => $_POST['email'] ]) ) ) {
        $responseMessage = Response::MESSAGE_EMAIL_ALREADY_EXISTS;
    }
    else {
        
        $values = [
            Users::COLUMN_FIRST_NAME => $_POST['first_name'],
            Users::COLUMN_LAST_NAME => $_POST['last_name'],
            Users::COLUMN_EMAIL => $_POST['email'],
            Users::COLUMN_USER_TYPE => $_POST['user_type'],
            Users::COLUMN_PASSWORD => $user[0][ Users::COLUMN_PASSWORD ],
        ];

        if ( !empty( @$_POST['password'] ) ) {
            $values[ Users::COLUMN_PASSWORD ] = $_POST['password'];
        }

        $updateUser = $userEntity->update( $values, [ Users::COLUMN_ID => $_POST['id'] ] );

        if ( $updateUser ) {
            $responseType = Response::SUCCESS_TYPE;
            $responseMessage = '';
        }

    }

}

echo $response->returnJSONResponse( $responseType, $responseData, $responseMessage );

?>