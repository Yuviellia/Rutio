<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/ToDoFile.php';

class ToDoRepository extends Repository {
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
        $stmt = $this->database->connect()->prepare('
            INSERT INTO todo (iduser, task, createdat)
            VALUES (?, ?, ?)
        ');

        $user = 1;
        $currentDate = date('Y-m-d H:i:s');
        $line = trim($f);
        if (!empty($line)) {
            $stmt->execute([$user, $line, $currentDate]);
        }
    }
    public function deleteSingleToDo($f): void {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM todo
            WHERE id = ? AND iduser = ?
        ');

        $user = 1;

        $stmt->execute([$f, $user]);
    }

    public function addToDo(ToDoFile $toDo): void {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO todo (iduser, task, createdat)
            VALUES (?, ?, ?)
        ');

        $deleteStmt = $this->database->connect()->prepare('
            DELETE FROM todo WHERE iduser = ?
        ');

        $user = 1;
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
        $stmt = $this->database->connect()->prepare('
            SELECT id, task FROM todo WHERE iduser = ? ORDER BY createdat ASC
        ');
        $stmt->execute([1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}