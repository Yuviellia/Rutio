<?php

class User {
    private $id;
    private $email;
    private $password;
    private $salt;
    private $name;
    private $surname;
    private $phone;

    public function __construct($id, $email, $password, $salt, $name, $surname, $phone) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
    }

    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getId(): int {  return $this->id; }
    public function getSalt(): string {  return $this->salt; }
    public function getName() { return $this->name; }
    public function getSurname() { return $this->surname; }
    public function getPhone() { return $this->phone; }


}