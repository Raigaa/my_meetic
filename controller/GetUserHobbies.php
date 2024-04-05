<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$userInstance = User::getInstance(Database::getInstance());

if ($userInstance->getLoggedInUser()) {
    $email = $_SESSION['email']; 
    $userHobbies = $userInstance->getUserHobbies($email);
    
    $userHobbiesJSON = json_encode($userHobbies);

    header('Content-Type: application/json');
    echo $userHobbiesJSON;
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Utilisateur non connecté."));
}
