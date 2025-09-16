<?php

namespace App\Controllers;

use App\File;
use App\HashTree;
use Exception;
use PXP\Core\Controllers\Controller;

class MainController extends Controller
{
    public function pairs()
    {
        if (request('remove')) {
            return $this->remove();
        }

        return $this->filter();
    }

    public function filter()
    {
        $files = File::make('/home/leo/Pictures')->recursive();

        $tree = perma('tree');
        $pairs = perma('pairs');

        if ($tree === null || $pairs === null) {
            $tree = HashTree::new();

            $pairs = c();

            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }

                $hash = $file->hash();

                if ($duplicate = $tree->get($hash)) {
                    $pairs = $pairs->with([(string) $file, (string) $duplicate]);
                } else {
                    $tree->put($hash, $file);
                }
            }

            perma([
                'tree' => $tree,
                'pairs' => $pairs,
            ]);
        }

        $pairs = perma('pairs');

        $origin = request('origin');
        $copy = request('copy');

        if ($origin !== null && $copy === null) {
            $pairs = $pairs->filter(fn (array $pair) => str_starts_with($pair[0], $origin) || str_starts_with($pair[0], $origin));
        }

        if ($origin !== null && $copy !== null) {
            $pairs = $pairs
                ->filter(fn (array $pair) => str_starts_with($pair[0], $origin) && str_starts_with($pair[1], $copy)
                    || str_starts_with($pair[0], $copy) && str_starts_with($pair[1], $origin));
        }

        return view('pairs', [
            'pairs' => $pairs,
            'origin' => $origin,
            'copy' => $copy,
        ]);
    }

    public function remove()
    {
        $pairs = perma('pairs');

        if ($pairs === null) {
            throw new Exception('pairs must not be null');
        }

        $origin = request('origin');
        $copy = request('copy');

        if (! $origin || ! $copy) {
            throw new Exception('origin and copy must be given');
        }

        perma([
            'pairs' => $pairs->filter(fn(array $pair) => !(str_starts_with($pair[0], $origin) && str_starts_with($pair[1], $copy)
                || str_starts_with($pair[0], $copy) && str_starts_with($pair[1], $origin))),
        ]);

        $paths = $pairs
            ->map(function (array $pair) use ($origin, $copy) {
                if (str_starts_with($pair[0], $origin) && str_starts_with($pair[1], $copy)) {
                    return $pair[1];
                }

                if (str_starts_with($pair[0], $copy) && str_starts_with($pair[1], $origin)) {
                    return $pair[0];
                }

                return null;
            })
            ->filter()
            ->map(fn (string $path) => str_replace(' ', '\\ ', $path))
            ->join(' ');

        $result = shell_exec("waste $paths");

        return view('console', [
            'lines' => [$result],
            'back' => '/pairs'
        ]);
    }

    public function image()
    {
        header('Content-Type: image/jpeg');

        $path = request('file');

        if (file_exists($path)) {
            readfile($path);
        }
    }
}
