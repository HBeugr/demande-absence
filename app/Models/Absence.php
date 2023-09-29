<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'statut_absence_id',
        'motif_absence_id', 'date_debut','reponse',
        'date_fin', 'cancelled_at', 'cancelled_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statutAbsence()
    {
        return $this->belongsTo(StatutAbsence::class);
    }

    public function motifAbsence()
    {
        return $this->belongsTo(MotifAbsence::class);
    }
}
