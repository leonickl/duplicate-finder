<?php

namespace App;

use Exception;

class HashTree
{
    private array $children = [];

    private mixed $leaf = null;

    private function __construct() {}

    public static function new(): HashTree
    {
        return new HashTree;
    }

    public function put(string $hash, mixed $leaf): void
    {
        if (strlen($hash) === 0) {
            if ($this->leaf !== null) {
                throw new Exception('leaf not empty');
            }

            $this->leaf = $leaf;

            return;
        }

        if (! array_key_exists($hash[0], $this->children)) {
            $this->children[$hash[0]] = HashTree::new();
        }

        $this->children[$hash[0]]->put(substr($hash, 1), $leaf);
    }

    public function get(string $hash): mixed
    {
        if (strlen($hash) === 0) {
            return $this->leaf;
        }

        if (! array_key_exists($hash[0], $this->children)) {
            return false;
        }

        return $this->children[$hash[0]]->get(substr($hash, 1));
    }
}
