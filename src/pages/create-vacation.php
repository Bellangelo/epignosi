<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

use App\Entities\Users;

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

?>
<!DOCTYPE html>
    <head>
        <title>Submit Vacation</title>
        <link href="/epignosi/css/create-vacation.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
        <script src="/epignosi/js/create-vacation.js"></script>
    </head>
    <body>
        <div class="main">
            <a class="sticky" href="/epignosi/portal.php">
                <button class="full-width-button">Vacations List</button>
            </a>
            <div class="users-list">
                <div class="title">Submit Vacation</div>
                <div class="users">
                    <form class="user" onsubmit="createVacation( this, event )">
                        <div class="user-data">
                            <span>Date from: </span>
                            <span>
                                <input type="date" required name="date_from" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Date to: </span>
                            <span>
                                <input type="date" required name="date_to" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Reason: </span>
                            <span>
                                <textarea name="reason"></textarea>
                            </span>
                        </div>
                        <input type="submit" class="full-width-button" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>