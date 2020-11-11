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

if ( $userData[ Users::COLUMN_USER_TYPE ] !== Users::USER_TYPE_ADMIN ) {
    header('Location: /epignosi/portal.php');
    exit();
}

?>
<!DOCTYPE html>
    <head>
        <title>Admin Portal - Create User</title>
        <link href="/epignosi/css/create-user.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
        <script src="/epignosi/js/create-user.js"></script>
    </head>
    <body>
        <div class="main">
            <a class="sticky" href="/epignosi/portal.php">
                <button class="full-width-button">Users List</button>
            </a>
            <div class="users-list">
                <div class="title">Create User</div>
                <div class="users">
                    <form class="user" onsubmit="createUser( this, event )">
                        <div class="user-data">
                            <span>First Name: </span>
                            <span>
                                <input type="text" name="first_name" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Last Name: </span>
                            <span>
                                <input type="text" name="last_name" />
                            </span>
                        </div>
                        <div class="user-data">
                            <span>Email: </span>
                            <span>
                                <input type="email" name="email" />
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
                                <select name="user_type">
                                    <option value="<?php echo Users::USER_TYPE_ADMIN ?>"><?php echo Users::USER_TYPE_ADMIN ?></option>
                                    <option value="<?php echo Users::USER_TYPE_EMPLOYEE ?>"><?php echo Users::USER_TYPE_EMPLOYEE ?></option>
                                </select>
                            </span>
                        </div>
                        <input type="submit" class="full-width-button" value="Create User" />
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>