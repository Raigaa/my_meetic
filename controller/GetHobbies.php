<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');


$databaseInstance = Database::getInstance();

$userInstance = User::getInstance($databaseInstance);

$hobbiesdb = $userInstance->getDatabaseHobbies();

header('Content-Type: application/json');
echo json_encode($hobbiesdb);
