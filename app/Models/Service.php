<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nom', 'description', 'prix'];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'contenu')->withPivot('quantite');
    }
}
