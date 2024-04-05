<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$userInstance = User::getInstance(Database::getInstance());

$allGender = $userInstance->getGender();

echo json_encode($allGender);