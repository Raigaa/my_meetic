<?php

require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../models/Database.php');

$databaseProfile = Database::getInstance();

$userInstance = User::getInstance($databaseProfile);
$user = $userInstance->getLoggedInUser();


$userHobbies = [];
if ($user) {
    $userHobbies = $userInstance->getUserHobbies($user['email']);
}

$userHobbiesJSON = json_encode($userHobbies);

if (!$databaseProfile->getConnection()) {
    die("Error: Unable to connect to the database.");
}

if (!$user) {
    header('Location: ../Auth/login_view.php');
    exit;
}

if (isset($_POST['delete_session'])) {
    session_unset();
    session_destroy();
    header("Location: ../views/Auth/login_view.php");
    exit;
}

if(isset($_POST['deactivate_account'])) {
    if(!$user || !isset($_SESSION['email'])) {
        header('Location: /index.html');
        exit;
    }
    
    $userEmail = $_SESSION['email']; 

    $sql = "UPDATE user SET active = 0 WHERE email = :userEmail";
    $stmt = $databaseProfile->getConnection()->prepare($sql);
    $stmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
    $result = $stmt->execute();

    if(!$result) {
        echo "Error: " . $stmt->errorInfo();
        exit;
    }

    session_unset();
    session_destroy();

    header("Location: /index.html");
    exit;
}

?>

<script>
    <?php if (isset($user) && !empty($user)): ?>
        var user = <?php echo json_encode($user); ?>;
    <?php endif; ?>

    <?php if (isset($userHobbiesJSON)): ?>
        var userHobbies = <?php echo $userHobbiesJSON; ?>;
        if (userHobbies.length > 0) {
            console.log(userHobbies);
        }
    <?php endif; ?>
</script>
