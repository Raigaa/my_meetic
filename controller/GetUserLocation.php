<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$userInstance = User::getInstance(Database::getInstance());

$allLocation = $userInstance->getLocation();

echo json_encode($allLocation);
