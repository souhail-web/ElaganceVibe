<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Nom de la table (facultatif si le nom est bien 'carts')
    protected $table = 'carts';

    // Champs autorisés à être remplis automatiquement
    protected $fillable = [
        'user_id',
        'status',
    ];

    // Laravel gère automatiquement created_at et updated_at (par défaut)
    public $timestamps = true;

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les produits (si applicable)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
