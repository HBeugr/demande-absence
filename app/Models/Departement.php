<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nom', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
