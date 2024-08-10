<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kritik extends Model
{
    use HasFactory;

    protected $table = 'kritik';

    protected $fillable = ['user_id', 'film_id', 'content'];

    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
