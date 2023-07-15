<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersBalanceInfo extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'users_balance_info';
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBalanceAttribute($value)
    {
        return 'Rp. '.number_format($value, 0, ',', '.');
    }
}
