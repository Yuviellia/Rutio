<?php
require_once 'src/controllers/AppController.php';
require_once __DIR__.'/../models/BackupFile.php';

class ImportController extends AppController {
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_FILE_TYPES = ['text/csv', 'text/plain'];
    const UPLOAD_DIRECTORY = '/../public/backups/';

    private $messages = [];

    public function import() {
        if($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']);
            return $this->render('backup', ['messages' => $this->messages]);
        }

        $backup = new BackupFile($_FILES['file']['name']);

        $this->render("backup", ['messages' => $this->messages]);
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