<?php
require_once 'Repository.php';

class TagRepository extends Repository {
    public function getTags(): array {
        $stmt = $this->database->connect()->prepare('
            SELECT id, name FROM tags WHERE iduser = ? ORDER BY createdat ASC
        ');
        $stmt->execute([1]);
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
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tags (iduser, name, createdat)
            VALUES (?, ?, ?)
        ');

        $user = 1;
        $currentDate = date('Y-m-d H:i:s');
        $line = trim($f);
        if (!empty($line)) {
            $stmt->execute([$user, $line, $currentDate]);
        }
    }

    public function deleteTag($f): void {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM tags
            WHERE id = ? AND iduser = ?
        ');

        $user = 1;

        $stmt->execute([$f, $user]);
    }

    public function mark($id, $date): void {
        $stmt = $this->database->connect()->prepare('
            SELECT 1
            FROM tags
            WHERE id = ? AND iduser = ?
        ');

        $user = 1;
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
        $stmt = $this->database->connect()->prepare('
            SELECT 1
            FROM user_tag_marked
            WHERE idtag = ? AND iduser = ?
        ');

        $user = 1;
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