<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/public/css/variables.css" type="text/css" rel="stylesheet">
    <link href="/public/css/login.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="./public/js/login.js" defer></script>
    <title>Rutio | Register</title>
</head>
<body>
<div id="login">
    <h1>Register</h1>

    <form action="/register" method="POST">
        <p>Email</p>
        <input type="email" name="email" placeholder="Email" required>
        <p>Name</p>
        <input type="text" name="name" placeholder="Name">
        <p>Surname</p>
        <input type="text" name="surname" placeholder="Surname">
        <p>Phone Number</p>
        <input type="text" name="phone" placeholder="Phone">
        <p>Password</p>
        <input type="password" name="password1" placeholder="Password" required>
        <input type="password" name="password2" placeholder="Password" required>

        <div class="messages"><?php if(isset($messages)){foreach($messages as $message) echo $message;}?></div>

        <button type="submit">Register</button>
    </form>

    <div class="footer">
        <p>Already have an account? <a href="/login">Sign up</a></p>
    </div>
</div>
</body>
</html>
