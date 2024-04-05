<?php

class User
{
    private static $instance;
    private $db;

    private function __construct($database)
    {
        $this->db = $database;
        session_start();
    }

    public static function getInstance($database)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($database);
        }
        return self::$instance;
    }

    public function authenticateUser($email, $password)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!$this->db->isConnected()) {
            return "Database connection error";
        }

        if ($this->checkLogin($email, $password)) {
            $_SESSION['email'] = $email;
            return "Successful connection";
        } else {
            return "Connection failed. Check your e-mail address and password.";
        }
    }

    public function processFormData($formData)
    {
        try {
            $email = filter_var($formData['email'], FILTER_VALIDATE_EMAIL);
            $firstname = filter_var($formData['firstname'], FILTER_SANITIZE_STRING);
            $lastname = filter_var($formData['lastname'], FILTER_SANITIZE_STRING);
            $phone = filter_var($formData['phone'], FILTER_SANITIZE_STRING);
            $description = filter_var($formData['description'], FILTER_SANITIZE_STRING);
            $birthdate = $formData['birthdate'];
            $location = filter_var($formData['location'], FILTER_SANITIZE_STRING);
            $password = password_hash($formData['password'], PASSWORD_DEFAULT);
            $gender_id = $formData['gender_id'];

            if (!$email || !$firstname || !$lastname || !$phone || !$description || !$birthdate || !$location || !$password || !$gender_id) {
                throw new Exception('Failed to validate form data.');
            }

            $user_id = $this->createUser($firstname, $lastname, $email, $password, $phone, $birthdate, $description, $location, $gender_id);

            if (!empty($formData['hobbies']) && is_array($formData['hobbies'])) {
                foreach ($formData['hobbies'] as $hobby_id) {
                    $this->addUserHobby($user_id, $hobby_id);
                }
            }

            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function createUser($firstname, $lastname, $email, $password, $phone, $birthdate, $description, $location, $gender_id)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }

            $sql = "INSERT INTO user (firstname, lastname, email, password, phone, birthdate, description, location, gender_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = Database::getInstance()->getConnection()->prepare($sql);

            $stmt->bindParam(1, $firstname);
            $stmt->bindParam(2, $lastname);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $phone);
            $stmt->bindParam(6, $birthdate);
            $stmt->bindParam(7, $description);
            $stmt->bindParam(8, $location);
            $stmt->bindParam(9, $gender_id);

            $stmt->execute();

            $user_id = Database::getInstance()->getConnection()->lastInsertId();

            return $user_id;
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    private function checkLogin($email, $password)
    {
        $conn = Database::getInstance()->getConnection();
    
        $request = "SELECT * FROM user WHERE email=?";
        $stmt = $conn->prepare($request);
        $stmt->execute([$email]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            if (password_verify($password, $result['password']) && $result['active'] == 1) {
                return true;
            }
        }
    
        return false;
    }
    

    public function getDatabaseHobbies()
    {
        $conn = Database::getInstance()->getConnection();
        $request = "SELECT id, name FROM hobbies";
        $stmt = $conn->prepare($request);
        $stmt->execute();
        $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $hobbies;
    }

    public function getLoggedInUser()
    {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $conn = Database::getInstance()->getConnection();
            $request = "SELECT * FROM user WHERE email=?";
            $stmt = $conn->prepare($request);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } else {
            return null;
        }
    }

    public function getUserHobbies($email)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }

            $sql = "SELECT h.id, h.name 
                    FROM user u
                    LEFT JOIN user_hobbies uh ON u.id = uh.id_user
                    LEFT JOIN hobbies h ON uh.id_hobbies = h.id
                    WHERE u.email = ?";

            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindParam(1, $email);
            $stmt->execute();

            $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $hobbies;
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function updateProfile($id, $data)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }

            $sql = "UPDATE user SET ";

            $values = [];
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $values[] = "$key = :$key";
                }
            }

            $sql .= implode(', ', $values);
            $sql .= " WHERE id = :id";

            $stmt = Database::getInstance()->getConnection()->prepare($sql);

            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $stmt->bindValue(":$key", $value);
                }
            }
            $stmt->bindValue(":id", $id);

            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    private function addUserHobby($user_id, $hobby_id)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }

            $sql = "INSERT INTO user_hobbies (id_user, id_hobbies) VALUES (?, ?)";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $hobby_id);
            $stmt->execute();


            return true;
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function deleteAllUserHobbies($user_id)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }

            $sql = "DELETE FROM user_hobbies WHERE id_user = ?";
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->execute([$user_id]);

            return true;
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateUserHobbies($user_id, $selected_hobbies)
    {
        try {
            if (!$this->db->isConnected()) {
                throw new Exception('Database connection error');
            }
            $this->deleteAllUserHobbies($user_id);

            foreach ($selected_hobbies as $hobby_id) {
                $this->addUserHobby($user_id, $hobby_id);
            }
            return true;
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getLocation()
    {
        $conn = Database::getInstance()->getConnection();
        $request = "SELECT location FROM user";
        $stmt = $conn->prepare($request);
        $stmt->execute();
        $userLocation = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userLocation;
    }

    public function getGender()
    {
        $conn = Database::getInstance()->getConnection();
        $request = "SELECT id, name FROM gender";
        $stmt = $conn->prepare($request);
        $stmt->execute();
        $userGender = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $userGender;
    }

}
