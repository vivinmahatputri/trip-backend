<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spiritix\LadaCache\Database\LadaCacheTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use LadaCacheTrait;
    protected $fillable = ['name', 'description', 'display_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
