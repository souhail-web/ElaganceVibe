<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Service;


class HomeController extends Controller
{
    public function index(){
        $serviceCount=service::count();
        $products = product::all(); // Récupérer tous les produits
        $productCount = Product::count(); // compter tous les produits
        
        // Compter clients et employés
        $clientCount = User::where('usertype', 'client')->count();
        $employeeCount = User::where('usertype', 'employee')->count();
        $userCount = $clientCount + $employeeCount;


        return view('admin.dashboard',compact('products','productCount','userCount','serviceCount'));
    }
}
