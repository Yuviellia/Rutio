<?php
require_once 'src/controllers/AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController{
    public function login(){
        $userRepository = new UserRepository();

        if(!$this->isPost()) return $this->render('login');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        $password = hash('sha256', $password . $user->getSalt());

        if(!$user) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getEmail() !== $email) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getPassword() !== $password) return $this->render('login', ['error' => 'Wrong password']);

        session_start();
        $_SESSION['id'] = $user->getId();
        return header('Location: /dashboard');
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        header('Location: /login');
        exit();
    }

    public function register() {
        session_start();
        $userRepository = new UserRepository();

        if (!$this->isPost()) return $this->render('register');

        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];

        if ($password1 !== $password2) return $this->render('register', ['error' => 'Passwords do not match']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return $this->render('register', ['error' => 'Invalid email address']);
        if (!preg_match('/^\d{9}$/', $phone)) return $this->render('register', ['error' => 'Invalid phone number']);
        if (!preg_match('/^[A-Za-z]+$/', $name) || !preg_match('/^[A-Za-z]+$/', $surname)) return $this->render('register', ['error' => 'Name and surname must contain only letters']);
        if ($userRepository->getUser($email)) return $this->render('register', ['error' => 'Email already exists']);

        $salt = bin2hex(random_bytes(16));
        $hashedPassword = hash('sha256', $password1 . $salt);

        $userRepository->createUser($email, $hashedPassword, $salt, $name, $surname, $phone);

        session_start();
        $_SESSION['id'] = $userRepository->getUser($email)->getId();

        header('Location: /dashboard');
        exit();
    }

}