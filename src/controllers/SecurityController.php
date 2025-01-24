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

        if(!$user) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getEmail() !== $email) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getPassword() !== $password) return $this->render('login', ['error' => 'Wrong password']);
        return $this->render('dashboard');
    }

    public function register(){
        $userRepository = new UserRepository();

        if(!$this->isPost()) return $this->render('register');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if(!$user) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getEmail() !== $email) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getPassword() !== $password) return $this->render('login', ['error' => 'Wrong password']);
        return $this->render('dashboard');
    }
}