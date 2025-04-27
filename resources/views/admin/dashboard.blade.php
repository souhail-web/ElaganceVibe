@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="content">
        <div class="title-info">
            <p>Tableau de bord</p>
            <i class="fas fa-chart-bar"></i>
        </div>

        <div class="data-info"> 

            <div class="box">
                <i class="fas fa-user"></i>
                <div class="data">
                    <p>Utilisateurs</p>
                    <span>100</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-bottle-droplet"></i>
                <div class="data">
                    <p>Produit</p>
                    <span>1000</span>
                </div>
            </div>

            <div class="box">
            <i class="fa-solid fa-dollar-sign"></i>
                <div class="data">
                    <p>Revenus</p>
                    <span>10000</span>
                </div>
            </div>
        </div>

        <div class="title-info">
            <p> Produits</p>
            <i class="fa-solid fa-box-open"></i>
        </div>

        <table>

            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>

                <tr>
                    <td>xxxx</td>
                    <td><span class="price">$142</span></td>
                    <td><span class="count">999</span></td>
                </tr>
                

                
            </tbody>
        </table>
    </div>  
@endsection