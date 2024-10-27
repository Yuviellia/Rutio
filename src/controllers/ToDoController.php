<?php
require_once 'src/controllers/AppController.php';
require_once __DIR__ . '/../models/ToDoFile.php';
require_once __DIR__ . '/../repository/ToDoRepository.php';

class ToDoController extends AppController {
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_FILE_TYPES = ['text/csv', 'text/plain'];
    const UPLOAD_DIRECTORY = '/../public/upload/';

    private $messages = [];
    private $toDoRepository;

    public function __construct() {
        parent::__construct();
        $this->toDoRepository = new ToDoRepository();
    }

    public function todo(){
        $toDo = $this->toDoRepository->getToDos();
        $this->render('todo', ['toDo' => $toDo]);
    }

    public function import() {
        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']);

            $toDo = new ToDoFile($_FILES['file']['name']);
            $this->toDoRepository->addToDo($toDo);

            header("Location: /todo");
        }
        $toDos = $this->toDoRepository->getToDos();
        return $this->render("todo", ['messages' => $this->messages, 'toDo' => $toDos]);
    }
    public function addD() {
        if($this->isPost()){
            $this->toDoRepository->addSingleToDo($_POST['task']);
        }
        header("Location: /todo");
    }
    public function deleteD() {
        if($this->isPost()){
            $this->toDoRepository->deleteSingleToDo($_POST['task']);
        }
        header("Location: /todo");
    }

    public function validate(array $file): bool {
        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File too large';
            return false;
        }

        if(!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_FILE_TYPES)) {
            $this->messages[] = 'Wrong file type';
            return false;
        }
        return true;
    }
}