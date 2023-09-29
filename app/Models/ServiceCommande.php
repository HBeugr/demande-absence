<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCommande extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['commande_id','service_id'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
