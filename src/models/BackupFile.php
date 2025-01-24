<?php

class BackupFile {
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function getFile() { return $this->file; }
    public function setFile($file): void { $this->file = $file; }
}