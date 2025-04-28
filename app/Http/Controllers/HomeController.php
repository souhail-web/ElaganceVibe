<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        $products = product::all(); // Récupérer tous les utilisateurs
        $productCount = Product::count(); // compter tous les produits
        $userCount = User::count(); // compter tous les utilisateurs


        return view('admin.dashboard',compact('products','productCount','userCount'));
    }
}
