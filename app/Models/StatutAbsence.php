<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatutAbsence extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nom', 'description'];

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
