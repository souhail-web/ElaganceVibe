<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nom de la table (facultatif si le nom est bien 'orders')
    protected $table = 'orders';

    // Champs autorisés à être remplis automatiquement
    protected $fillable = [
        'user_id',
        'cart_id',
        'total_amount',
        'status',
    ];

    // Laravel gère automatiquement created_at et updated_at (par défaut)
    public $timestamps = true;

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le panier
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
