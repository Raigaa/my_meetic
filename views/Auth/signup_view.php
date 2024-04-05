<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up My_meetic</title>
    <link rel="stylesheet" href="../../public/style/signup.css">
</head>

<body>
    <h1>Create an Account</h1>

    <form class="form__create-account" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname"><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname"><br>

        <label for="tel">Telephone Number:</label>
        <input type="tel" id="tel" name="phone"><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br>

        <div class="genderContainer">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="3">Non-binary</option>
                <option value="4">Other</option>
            </select><br>

        </div>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="birthdate"><br>

        <div class="hobbyContainer">

        </div>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location"><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>

        <input type="submit" value="Submit">
    </form>
    <a href="login_view.php">Already have an account?</a>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../../public/js/Request/AjaxSignup.js"></script>
    <script src="../../public/js/Component/GetHobbies.js"></script>

</body>

</html>