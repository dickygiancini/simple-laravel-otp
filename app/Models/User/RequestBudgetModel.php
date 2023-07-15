<?php

namespace App\Models\User;

use App\Models\Master\MasterStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBudgetModel extends Model
{
    use HasFactory;

    protected $table = 'request_budgets';
    protected $fillable = ['user_id', 'balance', 'status_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(MasterStatus::class, 'status_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getBalanceAttribute($value)
    {
        return 'Rp. '.number_format($value, 0, ',', '.');
    }
}
