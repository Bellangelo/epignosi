<?php

require_once dirname( __FILE__ ) . '/../../vendor/autoload.php';

$app = new App\App();
// Redirect logged in user to portal.
if ( $app->getAuth()->isUserLogged() ) {
    header('Location: /epignosi/portal.php');
    exit();
}

?>
<!DOCTYPE html>
    <head>
        <title>Login</title>
        <link href="/epignosi/css/login.css" rel="stylesheet" />
        <script src="/epignosi/js/api_fetch.js"></script>
        <script src="/epignosi/js/login.js"></script>
    </head>
    <body>
        <div class="main">
            <form action="/epignosi/actions/login.php" method="POST" onsubmit="login(this, event)">
                <div class="title">Login</div>
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="submit" value="Login" />
            </form>
        </div>
    </body>
</html>