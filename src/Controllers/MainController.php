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

    public function removeFolder(string $path)
    {
        $path = urldecode($path);

        if(trim($path, '/ ') === '') {
            throw new Exception('invalid path given');
        }

        $files = c(...\App\Models\File::duplicates())
            ->map(function(Collection $files) use ($path) {
                foreach($files as $file) {
                    if(str_starts_with($file->path, $path)) {
                        return str_replace(' ' , "\\ ", $file->path);
                    }
                }

                return null;
            })
            ->filter()
            ->values()
            ->join(' ');

        $output = shell_exec("waste $files");

        return view('console', [
            'lines' => explode("\ ", $output),
            'back' => '/panes',
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

    public function panes()
    {
        $leftPath = rtrim(request('left') ?? config('path'), '/').'/';
        $rightPath = rtrim(request('right') ?? config('path'), '/').'/';

        $files = c(...\App\Models\File::duplicates());

        $leftFiles = $files
            ->map(function(Collection $files) use ($leftPath) {
                foreach($files as $file) {
                    if(str_starts_with($file->path, $leftPath)) {
                        return $file->path;
                    }
                }

                return null;
            })
            ->filter()
            ->values();

        $rightFiles = $files
            ->map(function(Collection $files) use ($rightPath) {
                foreach($files as $file) {
                    if(str_starts_with($file->path, $rightPath)) {
                        return $file->path;
                    }
                }

                return null;
            })
            ->filter()
            ->values();

        return view('panes', [
            'leftPath' => $leftPath,
            'rightPath' => $rightPath,

            'leftFiles' => $leftFiles,
            'rightFiles' => $rightFiles,
        ]);
    }
}
