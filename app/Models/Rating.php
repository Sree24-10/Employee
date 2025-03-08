<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model {
    use HasFactory;

    protected $fillable = ['date', 'employee_id', 'manager_id', 'rating'];

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
}

