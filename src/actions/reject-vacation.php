<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;
use App\Entities\Vacations;
use App\Mail\RejectedVacationNotification;
use App\Api\VacationsResponse AS Response;

$app = new App\App();
// Redirect non-logged in user to login form.
if ( !$app->getAuth()->isUserLogged() ) {
    header('Location: /epignosi/login.php');
    exit();
}

$dbConnection = $app->getDatabaseConnection();
$userEntity = new Users( $dbConnection );
$userData = $userEntity->find([ Users::COLUMN_ID => $app->getAuth()->getUserId() ])[0];

if ( $userData[ Users::COLUMN_USER_TYPE ] !== Users::USER_TYPE_ADMIN || empty( @$_GET['id'] ) ) {
    header('Location: /epignosi/portal.php');
    exit();
}

$responseMessage = Response::MESSAGE_WRONG_DATA;

$vacationEntity = new Vacations( $dbConnection );
$vacation = $vacationEntity->find([ Vacations::COLUMN_ID => $_GET['id'] ]);

if ( !empty( $vacation ) ) {

    $responseMessage = '';
    $vacation = $vacation[0];
    
    if ( $vacation[ Vacations::COLUMN_STATUS ] !== Vacations::STATUS_PENDING ) {
        $responseMessage .= 'Vacation status was "' . Vacations::STATUS_PENDING . '".';
    }

    $values = [ Vacations::COLUMN_STATUS => Vacations::STATUS_REJECTED ];
    $update = $vacationEntity->update( $values, [ Vacations::COLUMN_ID => $_GET['id'] ]);

    if ( $update ) {

        $responseMessage .= 'Vacation status now is "' . Vacations::STATUS_REJECTED . '".';

        try {
            // Get the user's email.
            $user = $userEntity->find([ Users::COLUMN_ID => $vacation[ Vacations::COLUMN_USER_ID ] ], 1, 
                [ Users::COLUMN_EMAIL ]);
            $userEmail = $user[0][ Users::COLUMN_EMAIL ];

            $mail = new RejectedVacationNotification( $vacation[ Vacations::COLUMN_CREATED ] );
            $mail->send( $userEmail );
        }
        catch ( \Exception $e ) {
            // TODO: Log error that we couldn't send email.
        }

    } else {
        $responseMessage = 'There was an error during update. Please try again';
    }

}

echo $responseMessage;

?>