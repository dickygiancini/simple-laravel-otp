<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstRolesModel extends Model
{
    use HasFactory;

    protected $table = 'mst_roles';
    protected $fillable = ['name'];
}
