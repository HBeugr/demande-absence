<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['date_facture', 'numero_facture', 'montant_facture','commande_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
