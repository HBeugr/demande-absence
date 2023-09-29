<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCommande extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['commande_id','client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
