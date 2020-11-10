<!DOCTYPE html>
    <head>
        <title>Login</title>
        <link href="/epignosi/css/login.css" rel="stylesheet" />
    </head>
    <body>
        <div class="main">
            <form action="/epignosi/actions/login.php" method="POST">
                <div class="title">Login</div>
                <input type="text" placeholder="Email" required />
                <input type="text" placeholder="Password" required />
                <input type="submit" value="Login" />
            </form>
        </div>
    </body>
</html>