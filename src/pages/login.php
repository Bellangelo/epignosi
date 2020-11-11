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