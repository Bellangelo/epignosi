<?php

use App\Entities\Users;
use App\Entities\Vacations;

// Disallow direct access and allow only employees to view this.
if ( !@$userData || $userData['user_type'] !== Users::USER_TYPE_EMPLOYEE ) {
    header( 'Location: /epignosi/portal.php' );
}

$security = $app->getSecurity();
$vacationEntity = new Vacations( $app->getDatabaseConnection() );
$vacations = $vacationEntity->find([ Vacations::COLUMN_USER_ID => $userData[ Users::COLUMN_ID ] ]);

?>
<!DOCTYPE html>
    <head>
        <title>Vacations list</title>
        <link href="/epignosi/css/vacations-list.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
    </head>
    <body>
        <div class="main">
            <a class="sticky" href="/epignosi/create-vacation.php">
                <button class="full-width-button">Submit Vacation</button>
            </a>
            <div class="users-list">
                <div class="title">All Previous Vacations</div>
                <div class="users">
                    <?php 
                        foreach ( $vacations as $vacation ) {
                            $requestedDays = $vacationEntity->getDifferenceInDays( 
                                $vacation[ Vacations::COLUMN_START_DATE ], $vacation[ Vacations::COLUMN_END_DATE ]
                            );
                    ?>
                    <div class="user">
                        <div class="user-data">
                            <span>Date submitted: </span>
                            <span><?php echo $security->preventXSS( $vacation[ Vacations::COLUMN_CREATED ] ) ?></span>
                        </div>
                        <div class="user-data">
                            <span>Dates requested: </span>
                            <span><?php echo $security->preventXSS( $vacation[ Vacations::COLUMN_START_DATE ] ) . ' - ' . $security->preventXSS( $vacation[ Vacations::COLUMN_END_DATE ] ) ?></span>
                        </div>
                        <div class="user-data">
                            <span>Days requested: </span>
                            <span><?php echo $requestedDays ?></span>
                        </div>
                        <div class="user-data">
                            <span>Status: </span>
                            <span><?php echo $security->preventXSS( $vacation[ Vacations::COLUMN_STATUS ] ) ?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>