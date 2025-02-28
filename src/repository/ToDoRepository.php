<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/ToDoFile.php';

class ToDoRepository extends Repository {
    public function test(string $s) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO backups (iduser, filename) VALUES (2, ?) ');
        $stmt->execute([$s]);
    }

    public function getToDo(int $id): ?ToDoFile {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM upload WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $toDo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($toDo == false) return null;
        return new ToDoFile( $toDo['filename'] );
    }

    public function addSingleToDo($f): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO todo (iduser, task, createdat)
            VALUES (?, ?, ?)
        ');

        $user = $_SESSION['id'];
        $currentDate = date('Y-m-d H:i:s');
        $line = trim($f);
        if (!empty($line)) {
            $stmt->execute([$user, $line, $currentDate]);
        }
    }
    public function deleteSingleToDo($f): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            DELETE FROM todo
            WHERE id = ? AND iduser = ?
        ');

        $user = $_SESSION['id'];

        $stmt->execute([$f, $user]);
    }

    public function addToDo(ToDoFile $toDo): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO todo (iduser, task, createdat)
            VALUES (?, ?, ?)
        ');

        $deleteStmt = $this->database->connect()->prepare('
            DELETE FROM todo WHERE iduser = ?
        ');

        $user = $_SESSION['id'];
        $filePath = __DIR__."/../../public/upload/".$toDo->getFile();


        if (($handle = fopen($filePath, "r")) !== false) {
            $currentDate = date('Y-m-d H:i:s');
            $deleteStmt->execute([$user]);

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if (!empty($line)) {
                    $stmt->execute([$user, $line, $currentDate]);
                }
            }
            fclose($handle);
        } else {
            throw new Exception("Unable to open the file: $filePath");
        }
    }

    public function getToDos(): array{
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            SELECT id, task FROM todo WHERE iduser = ? ORDER BY createdat ASC
        ');
        $stmt->execute([$_SESSION['id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getToDosByName(string $s) {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $s = '%'.strtolower($s).'%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM todo 
            WHERE iduser = ? AND LOWER(task) LIKE ? 
            ORDER BY createdat ASC
        ');
        $stmt->execute([$_SESSION['id'], $s]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}