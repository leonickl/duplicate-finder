<?php

namespace App;

use PXP\Core\Lib\Collection;

class Directory
{
    public function __construct(public string $path) {}

    public function list(): Collection
    {
        return c(...scandir($this->path))
            ->filter(fn ($path) => ! str_starts_with($path, '.'))
            ->map(fn ($path) => File::make("$this->path/$path"));
    }

    public function recursive(): Collection
    {
        $list = c();

        foreach ($this->list() as $file) {
            if ($file instanceof Directory) {
                $list = $list->with(...$file->recursive());
            }

            if ($file instanceof File) {
                $list = $list->with($file);
            }
        }

        return $list;
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
