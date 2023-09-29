<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livraison extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['commande_id','date_livraison'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }
}
