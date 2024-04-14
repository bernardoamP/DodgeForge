@extends('master')

@section('title', 'Page d\'accueil')

@section('content')

@include('header')

<section class="degrade-diagonal d-flex align-items-center justify-content-center" style="height: calc(100vh - 10vh);">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-20">
                    <h1 class="display-3 font-weight-bold text-with-shadow">DODGE FORGE</h1>
                    <p class="text-with-shadow">Le lieu de toutes les questions!!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="separator-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="gradient-text">Notre Projet !</h2>
                    <p class="mb-0">DODGE FORGE est un outil de partage de ressources numériques interne. Il s’agit d’un outil collaboratif pédagogique et ludique, que l’AFTEC peut proposer aux formations de la tech</p>
                </div>
            </div>
            <div class="m-2 d-flex justify-content-center align-items-center text-center">
                <a href="{{route('consent')}}" class="text-decoration-none">politique de confidentialité</a>
            </div>
        </div>
    </section>

@endsection
