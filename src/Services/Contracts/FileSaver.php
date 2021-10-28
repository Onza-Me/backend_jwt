<?php

namespace OnzaMe\JWT\Services\Contracts;

interface FileSaver
{
    public function save(string $filepath, $content): void;
    public function createBackup(string $filepath): void;
}
