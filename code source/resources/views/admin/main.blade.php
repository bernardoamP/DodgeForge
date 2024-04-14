@extends('master')
@section('title','page d\'aministration')
@section('content')
@include('header')

@auth
@if(auth()->user()->isAdmin())


    <div class="cadreblanc mt-1 d-flex justify-content-center align-items-center">
        <h1 class="mx-2 font-weight-bold text-with-shadow">ADMINISTRATION PRINCIPALE</h1>
    </div>


<div class="container-fluid mt-2">

    {{--gestion des themes et categorie--}}
    <div class="cadreblanc mt-3 align-content-center justify-content-center">
        <div class="row align-content-center justify-content-center">
            <div class="col-sm-9 d-flex align-items-center justify-content-center">
                <h1 class="text-with-shadow text-center me-sm-4">CATEGORIE ET THEME</h1>
            </div>
            <div class="col-sm-3 text-center d-flex align-items-center justify-content-center">
                <button class="degrade-diagonal-rouge rounded-2 p-2" data-bs-toggle="modal" data-bs-target="#categoriesModal">Ajouter une categorie</button>
            </div>
        </div>

        <div class="row m-2">
            @foreach ($categories as $category)
                <div class="col p-1 mb-2 w-100">
                    <h3 class="text-with-shadow">{{$category->label}}</h3>
                    <ul>
                        @foreach ($category->themes as $theme)
                            <li class="text-light">
                                {{$theme->label}}
                            </li>
                        @endforeach
                        <div class="text-with-shadow mt-2">
                            <button class="degrade-diagonal-rouge rounded-2 px-2" data-bs-toggle="modal" data-bs-target="#ThemeModal{{$category->id}}">
                                Ajouter un thème
                            </button>
                        </div>
                    </ul>
                </div>

                {{-- Modal pour les thèmes --}}
                <div class="modal fade" id="ThemeModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content degrade-diagonal-simple">
                            <div class="modal-header">
                                <h5 class="modal-title text-with-shadow" id="myModalLabel">Ajouter un thème</h5>
                                <button type="button" class="close degrade-diagonal-rouge rounded-2" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('storeTheme')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$category->id}}">
                                    <div class="form-group">
                                        <label class="text-with-shadow" for="theme">Label</label>
                                        <input class="degrade-diagonal-rouge text-light" type="text" class="form-control" id="theme" name="label" placeholder="Entrez un thème">
                                    </div>
                                    <button type="submit" class="degrade-diagonal-rouge rounded-2 mt-2">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{--modal pour les categorie--}}
    <div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content degrade-diagonal-simple">
            <div class="modal-header">
            <h5 class="modal-title text-with-shadow" id="myModalLabel">Ajouter une categorie</h5>
            <button type="button" class="close degrade-diagonal-rouge rounded-2" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{route('storeCategory')}}" method="post">
                @csrf
                <div class="form-group">
                <label class="text-with-shadow me-2" for="categorie">Label</label>
                <input class="degrade-diagonal-rouge text-light" type="text" class="form-control" id="categorie" name="label" placeholder="Entrez une catégorie">
                </div>
                <button type="submit" class="degrade-diagonal-rouge rounded-2 mt-2">Enregistrer</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    {{--gestion des formations--}}
    <div class="cadreblanc mt-3 align-content-center justify-content-center">
        <div class="row align-content-center justify-content-center mb-2">
            <div class="col-sm-9 d-flex align-items-center justify-content-center">
                <h1 class="text-with-shadow text-center me-sm-4">FORMATIONS</h1>
            </div>
            <div class="col-sm-3 text-center d-flex align-items-center justify-content-center">
                <button class="degrade-diagonal-rouge rounded-2 p-2" data-bs-toggle="modal" data-bs-target="#FormationModal">Ajouter une formation</button>
            </div>
        </div>

        <ul>
            @foreach ($formations as $formation)
            <li class="text-light">
                {{$formation->label}}
            </li>
            @endforeach
        </ul>
    </div>

    {{--modal pour les Formations--}}
    <div class="modal fade" id="FormationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content degrade-diagonal-simple">
            <div class="modal-header">
            <h5 class="modal-title text-with-shadow" id="myModalLabel">Ajouter une formation</h5>
            <button type="button" class="close degrade-diagonal-rouge rounded-2" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{route('storeFormation')}}" method="post">
                @csrf
                <div class="form-group">
                <label class="text-with-shadow me-2" for="formation">Label</label>
                <input class="degrade-diagonal-rouge text-light" type="text" class="form-control" id="formation" name="label" placeholder="Entrez une formation">
                </div>
                <button type="submit" class="degrade-diagonal-rouge rounded-2 mt-2">Enregistrer</button>
            </form>
            </div>
        </div>
        </div>
    </div>


    {{--gestion des utilisateurs--}}
    <div class="cadreblanc mt-3 mb-2 align-content-center justify-content-center">
        <div class="align-content-center justify-content-center mb-2">
            <h1 class="text-with-shadow text-center me-sm-4">UTILISATEURS</h1>
        </div>

        <ul>
        @foreach ($users as $user)
        @if (!$user->isAdmin() and !$user->isJohnDoe())
        <li class="mt-2">
            <span class="text-light me-1">{{$user->name. " " .$user->first_name}}</span>
            <a href="{{route('editUser',['id'=>$user->id])}}"><img src="{{ asset('images/editer.png') }}" alt="Editer"></a>
        </li>
        @endif
        @endforeach
        </ul>
    </div>
</div>





@endif
@endauth
@endsection
