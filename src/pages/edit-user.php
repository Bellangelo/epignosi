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

if ( $userData[ Users::COLUMN_USER_TYPE ] !== Users::USER_TYPE_ADMIN || empty( @$_GET['id'] ) ) {
    header('Location: /epignosi/portal.php');
    exit();
}

$security = $app->getSecurity();
$user = $userEntity->find([ Users::COLUMN_ID => $_GET['id'] ], 1);

?>
<!DOCTYPE html>
    <head>
        <title>Admin Portal - Edit User</title>
        <link href="/epignosi/css/edit-user.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
        <script src="/epignosi/js/edit-user.js"></script>
    </head>
    <body>
        <div class="main">
            <a class="sticky" href="/epignosi/portal.php">
                <button class="full-width-button">Users List</button>
            </a>
            <div class="users-list">
                <div class="title">Edit User</div>
                <div class="users">
                    <?php if ( empty( $user ) ) { ?>
                        Couldn't find the specified user.
                    <?php
                    }
                    else {
                    ?>
                    <form class="user" onsubmit="editUser( this, event )">
                        <div class="user-data">
                            <span>First Name: </span>
                            <span>
                                <input type="text" name="first_name" value="<?php echo $security->preventXSS( $user[0][ Users::COLUMN_FIRST_NAME ] ) ?>" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Last Name: </span>
                            <span>
                                <input type="text" name="last_name" value="<?php echo $security->preventXSS( $user[0][ Users::COLUMN_LAST_NAME ] ) ?>" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Email: </span>
                            <span>
                                <input type="email" name="email" value="<?php echo $security->preventXSS( $user[0][ Users::COLUMN_EMAIL ] ) ?>" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Password: </span>
                            <span>
                                <input type="password" name="password" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Confirm Password: </span>
                            <span>
                                <input type="password" name="password_2" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>User Type: </span>
                            <span>
                                <select name="user_type" value="<?php echo $security->preventXSS( $user[0][ Users::COLUMN_USER_TYPE ] ) ?>">
                                    <option value="<?php echo Users::USER_TYPE_ADMIN ?>"><?php echo Users::USER_TYPE_ADMIN ?></option>
                                    <option value="<?php echo Users::USER_TYPE_EMPLOYEE ?>"><?php echo Users::USER_TYPE_EMPLOYEE ?></option>
                                </select>
                            </span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $security->preventXSS( $user[0][ Users::COLUMN_ID ] ) ?>" />
                        <input type="submit" class="full-width-button" value="Edit User" />
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>