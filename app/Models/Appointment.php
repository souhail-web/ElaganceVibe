<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'client_id',
        'employee_id',
        'service_id',
        'status',
    ];

    /**
     * Relation avec le client (user).
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation avec l'employé (user).
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Relation avec le service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
