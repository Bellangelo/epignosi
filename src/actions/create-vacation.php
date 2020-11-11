<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;
use App\Entities\Vacations;
use App\Api\VacationsResponse AS Response;
use App\Mail\VacationSubmissionNotification;

$app = new App\App();
// Redirect non-logged in user to login form.
if ( !$app->getAuth()->isUserLogged() ) {
    header('Location: /epignosi/login.php');
    exit();
}

$dbConnection = $app->getDatabaseConnection();
$userEntity = new Users( $dbConnection );
$userData = $userEntity->find([ Users::COLUMN_ID => $app->getAuth()->getUserId() ])[0];

if ( $userData[ Users::COLUMN_USER_TYPE ] !== Users::USER_TYPE_EMPLOYEE ) {
    header('Location: /epignosi/portal.php');
    exit();
}

$vacationEntity = new Vacations( $dbConnection );
$response = new Response();
$responseType = Response::ERROR_TYPE;
$responseData = [];
$responseMessage = Response::MESSAGE_WRONG_DATA;

if ( !empty( @$_POST['date_from'] )
    && !empty( @$_POST['date_to'] ) ) {

    $currentDate = new \DateTime();
    $currentDateString = $currentDate->format('Y-m-d');
    // Check that start date is not today.
    if ( $vacationEntity->getDifferenceInDays( $currentDateString, $_POST['date_from'] ) === 1 ) {
        $responseMessage = Response::MESSAGE_START_CANNOT_BE_TODAY;
    } // Check that date is not in the past.
    else if ( $currentDate > ( new \DateTime( $_POST['date_from'] ) ) ) {
        $responseMessage = Response::MESSAGE_DATE_CANNOT_BE_IN_THE_PAST;
    } // Check that the date_from is before the date_to.
    else if ( new \DateTime( $_POST['date_from'] ) > new \DateTime( $_POST['date_to'] ) ) {
        $responseMessage = Response::MESSAGE_START_DATE_IS_LATER;
    }
    else {
        
        $vacationEntity->set( Vacations::COLUMN_REASON, @$_POST['reason'] );
        $vacationEntity->set( Vacations::COLUMN_START_DATE, $_POST['date_from'] );
        $vacationEntity->set( Vacations::COLUMN_END_DATE, $_POST['date_to'] );
        $vacationEntity->set( Vacations::COLUMN_CREATED, $currentDateString );
        $vacationEntity->set( Vacations::COLUMN_USER_ID, $app->getAuth()->getUserId() );
        $vacationEntity->set( Vacations::COLUMN_STATUS, Vacations::STATUS_PENDING );
        
        $createVacationId = $vacationEntity->insert();

        if ( $createVacationId ) {

            $responseType = Response::SUCCESS_TYPE;
            $responseMessage = '';
            // Send notification email to admin.
            try {
                // Get the first admin email.
                $admin = $userEntity->find([ Users::COLUMN_USER_TYPE => Users::USER_TYPE_ADMIN ], 1, 
                    [ Users::COLUMN_EMAIL ]);
                $adminEmail = $admin[0][ Users::COLUMN_EMAIL ];

                $userName = $userData[ Users::COLUMN_FIRST_NAME ] . ' ' . $userData[ Users::COLUMN_LAST_NAME ];
                $mail = new VacationSubmissionNotification( $userName, $_POST['date_from'],
                    $_POST['date_to'], $_POST['reason'], $createVacationId );
                $mail->send( $adminEmail );
            }
            catch ( \Exception $e ) {
                // TODO: Log error that we couldn't send email.
            }

        }

    }

}

echo $response->returnJSONResponse( $responseType, $responseData, $responseMessage );

?>