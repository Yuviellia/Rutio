<?php
require_once 'src/controllers/AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController{
    public function login(){
        $user = new User('jg@gmail.com', 'h', 'j', 'g');

        if(!$this->isPost()) return $this->render('login');

        $email = $_POST['email'];
        $password = $_POST['password'];

        if($user->getEmail() !== $email) return $this->render('login', ['error' => "User doesn't exist"]);
        if($user->getPassword() !== $password) return $this->render('login', ['error' => 'Wrong password']);
        return $this->render('dashboard');
    }
}