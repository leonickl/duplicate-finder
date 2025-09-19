<?php

require __DIR__.'/vendor/autoload.php';

$db = \PXP\Core\Lib\DB::init();

$db->create('files', [
    'path' => 'string',
    'hash' => 'string',
]);
