<?php


require_once(__DIR__ . '/../models/Database.php');
require_once('./User.php');

$host = "localhost";
$user = "root";
$password = "root";
$database = "my_meetic";

$databaseInstance = Database::getInstance();

$userModel = User::getInstance($databaseInstance);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST['password']);

    $result = $userModel->authenticateUser($email, $password);

    $databaseInstance->closeConnection();

    $response = array('message' => $result);

    if ($result === 'Successful connection') {
        $response['redirect'] = '../User/user_view.php';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('message' => 'Unauthorized method');
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode($response);
}
