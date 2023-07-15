<?php

namespace App\Models\Master;

use App\Models\Users\UserPrivileges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstRolesModel extends Model
{
    use HasFactory;

    protected $table = 'mst_roles';
    protected $fillable = ['name'];

    public function access()
    {
        return $this->hasMany(UserPrivileges::class, 'role_id', 'id');
    }
}
