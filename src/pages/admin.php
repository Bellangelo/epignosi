<?php

use App\Entities\Users;

// Disallow direct access and allow only admins to view this.
if ( !@$userData || $userData['user_type'] !== Users::USER_TYPE_ADMIN ) {
    header( 'Location: /epignosi/portal.php' );
}

$security = $app->getSecurity();
$users = $userEntity->find();

?>
<!DOCTYPE html>
    <head>
        <title>Admin Portal</title>
        <link href="/epignosi/css/admin.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
        <script src="/epignosi/js/admin.js"></script>
    </head>
    <body>
        <div class="main">
            <a class="sticky" href="/epignosi/create-user.php">
                <button class="full-width-button">Create User</button>
            </a>
            <div class="users-list">
                <div class="title">All Users</div>
                <div class="users">
                    <?php foreach ( $users as $user ) { ?>
                    <a href="/epignosi/edit-user.php?id=<?php echo $user[ Users::COLUMN_ID ] ?>">
                        <div class="user">
                            <div class="user-data">
                                <span>First Name: </span>
                                <span><?php echo $security->preventXSS( $user[ Users::COLUMN_FIRST_NAME ] ) ?></span>
                            </div>
                            <div class="user-data">
                                <span>Last Name: </span>
                                <span><?php echo $security->preventXSS( $user[ Users::COLUMN_LAST_NAME ] ) ?></span>
                            </div>
                            <div class="user-data">
                                <span>Email: </span>
                                <span><?php echo $security->preventXSS( $user[ Users::COLUMN_EMAIL ] ) ?></span>
                            </div>
                            <div class="user-data">
                                <span>User Type: </span>
                                <span><?php echo $security->preventXSS( $user[ Users::COLUMN_USER_TYPE ] ) ?></span>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>