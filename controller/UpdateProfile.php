<?php
require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$dbUpdate = Database::getInstance();
$userInstance = User::getInstance($dbUpdate);

$formData = $_POST['formModifiedObject'];

$id = $_POST['user_id'];

if (isset($formData['password'])) {
    $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);
    $formData['password'] = $hashedPassword;
}

$userInstance->updateProfile($id, $formData);



