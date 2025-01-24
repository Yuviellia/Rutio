<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository {
    public function getUser(string $email): ?User {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users_details WHERE email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) return null;

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['salt'],
            $user['name'],
            $user['surname'],
            $user['phone']
        );
    }

    public function createUser(string $email, string $password, string $salt, string $name, string $surname, string $phone)  {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');

        try {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO user_details (name, surname, phone) 
                VALUES (?, ?, ?) 
                RETURNING id
            ');
            $stmt->execute([$name, $surname ,$phone]);
            $userDetailsId = $stmt->fetchColumn();

            $stmt = $this->database->connect()->prepare('
                INSERT INTO users (iddetails, email, password, salt) 
                VALUES (?, ?, ?, ?)
            ');
            $stmt->execute([$userDetailsId, $email, $password, $salt]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }
}