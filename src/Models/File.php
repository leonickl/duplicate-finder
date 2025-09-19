<?php

namespace App\Models;

use PXP\Core\Lib\DB;
use PXP\Core\Lib\Model;

/**
 * @property int $id
 * @property string $path
 * @property string $hash
 */
class File extends Model
{
    protected $table = 'files';

    protected $fields = ['id', 'path', 'hash'];

    public static function duplicates()
    {
        $hashes = DB::init()
            ->select('select hash from files where deleted_at is null group by hash having count(*) > 1;')
            ->map(fn($record) => $record['hash']);

        $pairs = [];

        foreach($hashes as $hash) {
            $pairs[$hash] = self::findAllBy('hash', $hash);
        }

        return $pairs;
    }
}
