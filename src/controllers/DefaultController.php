<?php

require_once 'src/controllers/AppController.php';
class DefaultController extends AppController{
    public function index(){
        $this->render('login');
    }

    public function dashboard(){

        $this->render('dashboard');
    }

}
