<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;

$app = new App\App();

$dbConnection = $app->getDatabaseConnection();
$userEntity = new Users( $dbConnection );

if ( !empty( @$_POST['email'] ) && !empty( @$_POST['password'] ) ) {
    
    $userData = [ Users::COLUMN_PASSWORD, Users::COLUMN_ID ];
    $user = $userEntity->find( [ Users::COLUMN_EMAIL => $_POST['email'] ], 1, $userData );

    if ( empty( $user ) ) {
        // Wrong email
    }
    else if ( password_verify( $_POST['password'], $user[0][ Users::COLUMN_PASSWORD ] ) ) {
        $app->getAuth()->logUser( $user[0][ Users::COLUMN_ID ] );
    }
    else {
        // Wrong password
    }

}

?>