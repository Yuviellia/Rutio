<?php
require_once 'Repository.php';

class TagRepository extends Repository {
    public function getTags(): array {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            SELECT id, name FROM tags WHERE iduser = ? ORDER BY createdat ASC
        ');
        $stmt->execute([$_SESSION['id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMarked($id): array {
        $stmt = $this->database->connect()->prepare('
            SELECT id, "date" FROM marked WHERE idtag = ? ORDER BY "date" ASC
        ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTag($f): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO tags (iduser, name, createdat)
            VALUES (?, ?, ?)
        ');

        $user = $_SESSION['id'];
        $currentDate = date('Y-m-d H:i:s');
        $line = trim($f);
        if (!empty($line)) {
            $stmt->execute([$user, $line, $currentDate]);
        }
    }

    public function deleteTag($f): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            DELETE FROM tags
            WHERE id = ? AND iduser = ?
        ');

        $user = $_SESSION['id'];

        $stmt->execute([$f, $user]);
    }

    public function mark($id, $date): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            SELECT 1
            FROM tags
            WHERE id = ? AND iduser = ?
        ');

        $user = $_SESSION['id'];
        $stmt->execute([$id, $user]);

        if ($stmt->rowCount() > 0) {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO marked (idtag, date)
            VALUES (?, ?)
        ');

            $stmt->execute([$id, $date]);
        }
    }

    public function unmark($id, $date): void {
        session_start();
        if (!isset($_SESSION['id'])) { header('Location: /login'); }

        $stmt = $this->database->connect()->prepare('
            SELECT 1
            FROM user_tag_marked
            WHERE idtag = ? AND iduser = ?
        ');

        $user = $_SESSION['id'];
        $stmt->execute([$id, $user]);

        if ($stmt->rowCount() > 0) {
            $stmt = $this->database->connect()->prepare('
            DELETE FROM marked
            WHERE idtag = ? AND date = ?
        ');

            $stmt->execute([$id, $date]);
        }
    }
}