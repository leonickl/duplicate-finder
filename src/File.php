<?php

namespace App;

class File
{
    public function __construct(public string $path) {}

    public static function make(string $path): File|Directory
    {
        $file = new File($path);

        if ($file->isDir()) {
            return $file->toDir();
        }

        return $file;
    }

    public function isDir(): bool
    {
        return is_dir($this->path);
    }

    public function toDir(): Directory
    {
        return new Directory($this->path);
    }

    public function __toString(): string
    {
        return $this->path;
    }

    public function hash(): string
    {
        return hash_file('sha256', $this->path);
    }
}
