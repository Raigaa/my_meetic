<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Meetic User</title>
    <link rel="stylesheet" href="../../public/style/profile.css">

</head>

<body>
<div id="dropdown"></div>

    <h1 id="Title">Profile</h1>

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
            <label for="gender_id">Gender:</label>
            <select id="gender_id" name="gender_id">
                <option value="1">Male</option>
                <option value="2">Female</option>
                <option value="3">Non-binary</option>
                <option value="4">Other</option>
            </select><br>
        </div>

        <div class="hobbyContainer"></div>


        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="birthdate"><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location"><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>

        <input type="submit" name="update-profile" value="Submit" class="modify-profile">
        <button type="submit" name="delete_session" class="logout-button">Log out</button>

        <button type="submit" name="deactivate_account" class="deactivate-button">Deactivate Account</button>

    </form>
    
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../../public/js/Request/AjaxProfile.js"></script>
    <script src="../../public/js/Component/GetHobbies.js"></script>
    <script src="../../public/js/Component/NavBar.js"></script>
</body>

</html>

<?php
include "../../controller/Profile.php";
include "../../controller/UpdateUserHobbies.php";
?>
