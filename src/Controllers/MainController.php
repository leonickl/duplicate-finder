<?php

namespace App\Controllers;

use App\File;
use App\HashTree;
use PXP\Core\Controllers\Controller;

class MainController extends Controller
{
    public function pairs()
    {
        $files = File::make('/home/leo/Pictures')->recursive();

        $tree = perma('tree');
        $pairs = perma('pairs');

        if($tree === null || $pairs === null) {
            $tree = HashTree::new();
    
            $pairs = c();
    
            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }
    
                $hash = $file->hash();
    
                if ($duplicate = $tree->get($hash)) {
                    echo "duplicate: $file & $duplicate\n";
    
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

        return view('pairs', ['pairs' => perma('pairs')]);
    }

    public function image()
    {
        header('Content-Type: image/jpeg');

        readfile(request('file'));
    }
}
