<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/public/css/variables.css" type="text/css" rel="stylesheet">
    <link href="/public/css/login.css" type="text/css" rel="stylesheet">
    <title>Rutio | Login</title>
</head>
<body>
    <div id="login">
        <h1>Login</h1>

        <form action="/login" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="messages"><?php if(isset($messages)){foreach($messages as $message) echo $message;}?></div>

            <button type="submit">Log In</button>
        </form>

        <div class="footer">
            <p>Don't have an account? <a href="/register">Sign up</a></p>
        </div>
    </div>
</body>
</html>
