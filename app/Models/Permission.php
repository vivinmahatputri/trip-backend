<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use LadaCacheTrait;

    protected $fillable = ['name', 'description', 'display_name'];
}
