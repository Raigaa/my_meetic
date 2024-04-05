<?php
require_once('../models/Database.php');
require_once('./User.php');

$databaseInstance = Database::getInstance();
$user = User::getInstance($databaseInstance);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $formData = filter_input(INPUT_POST, 'formData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        if (empty($formData)) {
            throw new Exception('Invalid form data.');
        }

        $result = $user->processFormData($formData);

        $response = array('message' => 'Account created successfully', 'redirect' => 'login_view.php');
        header('Content-Type: application/json');
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array('message' => 'Form processing error');
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    $response = array('message' => 'Unauthorized method');
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode($response);
}
