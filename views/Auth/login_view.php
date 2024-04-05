<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Meetic</title>
    <link rel="stylesheet" href="../../public/style/login.css">
</head>

<body>
    <form id="loginForm">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="button" id="loginButton">Connect</button>
        <a href="signup_view.php">Create account</a>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../../public/js/Request/AjaxLogin.js"></script>
</body>

</html>