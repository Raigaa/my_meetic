<?php

require_once(__DIR__ . '/../controller/User.php');
require_once(__DIR__ . '/../models/Database.php');

function generateWhereClause($locations, $gender, $hobbies, $minAge, $maxAge) {
    $conditions = array();
    if (!empty($locations)) {
        $conditions[] = "location IN ('" . implode("','", $locations) . "')";
    }
    if (!empty($gender)) {
        $conditions[] = "gender_id = :gender";
    }
    if (!empty($hobbies)) {
        foreach ($hobbies as $index => $hobby) {
            $hobbyParam = ':hobby' . $index;
            $conditions[] = "id IN (SELECT id_user FROM user_hobbies WHERE id_hobbies = $hobbyParam)";
        }
    }
    if (!empty($minAge) && !empty($maxAge)) {
        $conditions[] = "birthdate BETWEEN :minDate AND :maxDate";
    }
    if (!empty($conditions)) {
        $whereClause = " WHERE " . implode(" AND ", $conditions);
    } else {
        $whereClause = "";
    }
    return $whereClause;
}

function getUsers($whereClause, $gender, $minDate, $maxDate, $hobbies) {
    $databaseInstance = Database::getInstance();
    $databaseConnection = $databaseInstance->getConnection();
    $userInstance = User::getInstance($databaseConnection);
    $loggedInUser = $userInstance->getLoggedInUser();
    $query = "SELECT * FROM user" . $whereClause;
    
    if ($loggedInUser && empty($whereClause)) {
        $query .= " WHERE id != :loggedInUserId";
    } elseif ($loggedInUser && !empty($whereClause)) {
        $query .= " AND id != :loggedInUserId";
    }

    $statement = $databaseConnection->prepare($query);

    if (!empty($gender)) {
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
    }
    if (!empty($minDate) && !empty($maxDate)) {
        $statement->bindParam(':minDate', $minDate, PDO::PARAM_STR);
        $statement->bindParam(':maxDate', $maxDate, PDO::PARAM_STR);
    }

    foreach ($hobbies as $index => $hobby) {
        $hobbyParam = ':hobby' . $index;
        $statement->bindValue($hobbyParam, $hobby, PDO::PARAM_INT);
    }

    if ($loggedInUser) {
        $loggedInUserId = $loggedInUser['id'];
        $statement->bindParam(':loggedInUserId', $loggedInUserId, PDO::PARAM_INT);
    }

    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    $databaseInstance->closeConnection();
    return $users;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : array();
    $locations = isset($_POST['locations']) ? $_POST['locations'] : array();
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $minAge = isset($_POST['minAge']) ? $_POST['minAge'] : '';
    $maxAge = isset($_POST['maxAge']) ? $_POST['maxAge'] : '';

    $whereClause = generateWhereClause($locations, $gender, $hobbies, $minAge, $maxAge);

    $minDate = !empty($minAge) && !empty($maxAge) ? date('Y-m-d', strtotime("-$maxAge years")) : null;
    $maxDate = !empty($minAge) && !empty($maxAge) ? date('Y-m-d', strtotime("-$minAge years")) : null;

    $users = getUsers($whereClause, $gender, $minDate, $maxDate, $hobbies);

    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    http_response_code(405);
    $response = array('message' => 'Méthode non autorisée');
    echo json_encode($response);
}
