<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$dbUpdate = Database::getInstance();
$userInstance = User::getInstance($dbUpdate);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user_id"]) && isset($_POST["checkedCheckboxes"])) {
        $user_id = $_POST["user_id"];
        $checkedCheckboxes = $_POST["checkedCheckboxes"];

        $result = $userInstance->updateUserHobbies($user_id, $checkedCheckboxes);
    }
}