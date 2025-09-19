<?php

namespace App\Models;

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
}
