<?php

namespace App\Controllers;

use App\File;
use Exception;
use PXP\Core\Controllers\Controller;
use PXP\Core\Lib\Collection;
use PXP\Core\Lib\Router;

class MainController extends Controller
{
    public function scan()
    {
        $files = File::make(config('path'))->recursive();

        $counter = 0;

        foreach ($files as $file) {
            $record = \App\Models\File::findByOrNull('path', $file->path);

            if (! $record) {
                \App\Models\File::create(path: $file->path, hash: $file->hash());

                $counter++;
            }
        }

        return ['counter' => $counter];
    }

    public function all()
    {
        $files = \App\Models\File::duplicates();

        return view('all', [
            'pairs' => $files,
        ]);
    }

    public function removeFile(int $id)
    {
        $file = \App\Models\File::find($id);

        $output = new File($file->path)->waste();

        if(str_contains($output, "Wasted:")) {
            $file->delete();
        }

        return Router::redirect('/all');
    }


    public function image()
    {
        header('Content-Type: image/jpeg');

        $path = request('file');

        if (file_exists($path)) {
            readfile($path);
        }
    }

    public function panes()
    {
        $leftPath = rtrim(request()->left ?? config('path'), '/').'/';
        $rightPath = rtrim(request()->right ?? config('path'), '/').'/';

        $files = c(...\App\Models\File::duplicates());

        $leftFiles = $files->filter(function(Collection $files) use ($leftPath) {
            foreach($files as $file) {
                if(str_starts_with($file->path, $leftPath)) {
                    return true;
                }
            }

            return false;
        });

        $rightFiles = $files->filter(function(Collection $files) use ($rightPath) {
            foreach($files as $file) {
                if(str_starts_with($file->path, $rightPath)) {
                    return true;
                }
            }

            return false;
        });

        return view('panes', [
            'leftPath' => $leftPath,
            'rightPath' => $rightPath,

            'leftFiles' => $leftFiles,
            'rightFiles' => $rightFiles,
        ]);
    }

    // public function remove()
    // {
    //     $pairs = perma('pairs');

    //     if ($pairs === null) {
    //         throw new Exception('pairs must not be null');
    //     }

    //     $origin = request('origin');
    //     $copy = request('copy');

    //     if (! $origin || ! $copy) {
    //         throw new Exception('origin and copy must be given');
    //     }

    //     perma([
    //         'pairs' => $pairs->filter(fn (array $pair) => ! (str_starts_with($pair[0], $origin) && str_starts_with($pair[1], $copy)
    //             || str_starts_with($pair[0], $copy) && str_starts_with($pair[1], $origin))),
    //     ]);

    //     $paths = $pairs
    //         ->map(function (array $pair) use ($origin, $copy) {
    //             if (str_starts_with($pair[0], $origin) && str_starts_with($pair[1], $copy)) {
    //                 return $pair[1];
    //             }

    //             if (str_starts_with($pair[0], $copy) && str_starts_with($pair[1], $origin)) {
    //                 return $pair[0];
    //             }

    //             return null;
    //         })
    //         ->filter()
    //         ->map(fn (string $path) => str_replace(' ', '\\ ', $path))
    //         ->join(' ');

    //     $result = shell_exec("waste $paths");

    //     return view('console', [
    //         'lines' => [$result],
    //         'back' => '/pairs',
    //     ]);
    // }
}
