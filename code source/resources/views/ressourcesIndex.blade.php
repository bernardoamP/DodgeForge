@extends('master')

@section('title', 'ressources')

@section('content')

@include('header')

<div class="container-fluid mt-2">

    {{-- Header avec le bouton pour ouvrir un nouveau post--}}
    <div class="row cadreblanc mt-1">
        <div class="col-sm-10 d-flex justify-content-center align-items-center">
            <h1 class="mx-2 font-weight-bold text-with-shadow">RESSOURCES</h1>
            <div class="d-none d-sm-block mx-3 d-flex align-items-center">
                <p class="d-flex mb-0 align-items-center font-weight-bold text-with-shadow">
                    <b>Le lieu de toutes les questions!!</b>
                </p>
            </div>
        </div>
        @auth
        <div class="col-sm-2 d-flex align-items-center justify-content-center mb-1 mb-sm-0">
            <button type="button" class="degrade-diagonal-rouge rounded-2 float-sm-end" data-bs-toggle="modal" data-bs-target="#modalFormRessource">
                Déposer une ressource
            </button>
        </div>
        @endauth
    </div>

    {{--corp de la ressource--}}
    <div class="row cadreblanc mt-1">

        {{--Colonne de recherche--}}
        <div class="col-sm-auto items-center justify-content-center text-center cadreblanc">
            <h5 class="font-weight-bold mt-2 text-with-shadow m-1 p-1 d-sm-none" data-bs-toggle="collapse" data-bs-target="#searchCollapse">RECHERCHE RAPIDE</h5>
            <div id="searchCollapse" class="collapse d-sm-flex flex-column mt-3 mb-2">

                {{--selection des auteurs--}}
                <div class="mt-3 mb-2 cadreblanc">
                    <p class="font-weight-bold text-with-shadow mb-0">Par auteur</p>
                    <div class="dropdown mx-1 justify-content-center align-items-center">
                        <button class="btn degrade-diagonal-rouge dropdown-toggle text-light w-100 mb-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @isset($currentUser)
                                {{$currentUser->name}} {{$currentUser->first_name}}
                            @else
                                Auteurs
                            @endisset
                        </button>

                        <ul class="dropdown-menu text-center degrade-diagonal-rouge scroll-autors">
                            <li><a class="dropdown-item text-light" href="{{route("ressourcePostByUsers", ['id'=>0])}}">Tous</a></li>
                            <div class="dropdown-divider"></div>
                            @foreach ($users as $user)
                                <li><a class="dropdown-item text-light" href="{{route("ressourcePostByUsers", ['id'=>$user->id])}}">{{$user->name}} {{$user->first_name}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                {{--selection des themes par categorie--}}
                <div class="mt-3 mb-1 cadreblanc">
                    <p class="float-left font-weight-bold text-with-shadow mb-0 mt-0">Par thèmes</p>
                    @foreach ($categories as $category)
                    <div class="dropdown mx-1 justify-content-center align-items-center">
                        <button class="btn degrade-diagonal-rouge dropdown-toggle text-light w-100 mb-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{$category->label}}
                        </button>

                        <ul class="dropdown-menu text-center degrade-diagonal-rouge themeDropdown">
                            @foreach ($category->themes as $theme)
                            @if($theme->forum_post->isNotEmpty())
                                <li><a class="dropdown-item text-light" href="#theme{{$theme->id}}">{{$theme->label}}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>

                {{--selection par mot clé--}}
                <div class="mt-3 mb-2 cadreblanc">
                    <form action="{{route('forumPostByKeyWord')}}" method="post">
                        @csrf
                        <p class="font-weight-bold text-with-shadow mb-0 ">Par mot clé</p>

                        <input type="text" name="keyword" placeholder="Mot-clé" class="form-control text-light degrade-diagonal-rouge" value="{{ Session::get('last_keyword', old('keyword')) }}" required>

                        <div class="toggle-switch mt-1">
                            <input type="checkbox" id="option1" name="titleFilter" value="1" class="degrade-diagonal-rouge">
                            <label for="option1" class="text-light">Titre seulement</label>
                        </div>

                        <button type="submit" class="btn btn-sm mt-2 degrade-diagonal-rouge">Rechercher</button>
                    </form>
                </div>

            </div>
        </div>

        {{--liste des post du ressource--}}
        <div class="col-sm cadreblanc scoll-content">
            <div class="col-md-9 justify-content-center align-content-center w-100">
                @foreach ($categories as $category)
                    <h2 class="gradient-text text-center text-uppercase mt-1 mb-1 font-weight-bold m-2 mt-4 p-1 text-with-shadow">
                        {{$category->label}}
                    </h2>
                    <div class=" cadreblancbas"></div>
                    @foreach ($category->themes as $theme)
                        @if($theme->ressource_post->isNotEmpty())
                            <h5 id="theme{{$theme->id}}" class="d-inline-block font-weight-bold mt-2 text-with-shadow">{{$theme->label}}</h5>
                            @foreach ($theme->ressource_post as $post)
                                <div class="card mb-1 degrade-diagonal-rouge text-white">
                                    <div class="card-body p-0">
                                        {{--card enroulé--}}
                                        <div class="ressource-titre" style="cursor: pointer;">
                                            <div class="d-flex">
                                                <div class="fw-bold me-2">{{$post->user->name}}</div>
                                                <div>{{$post->created_at->format('d/m/Y')}}</div>
                                                @auth
                                                    @if(auth()->user()->isAdmin())
                                                        <a class="ms-auto p-0 m-0" href="{{route('showRessourcePost', ['id'=>$post->id])}}"><img src="{{ asset('images/editer.png') }}" alt="Editer"></a>
                                                    @endif
                                                @endauth
                                            </div>

                                            <div class="text-center">
                                                <h5 class="mb-1"><b>{{$post->title}}</b></h5>
                                            </div>
                                        </div>

                                            <!--card deroulé-->
                                        <div class="ressource-content" style="display: none;">
                                            <div class="d-flex mb-4">
                                                <div class="ms-3">
                                                    <p>Description: {{$post->description}}</p>
                                                    <p><a href="{{ route('downloadRessource', ['id'=>$post->id]) }}"><button class="degrade-diagonal-info rounded-2 px-4 py-2">{{Auth::check()?'Télécharger la ressource':'Se connecter'}}</button>
                                                    </a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>


{{--modal form--}}
    <div class="modal fade" id="modalFormRessource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content  degrade-diagonal">
                <div class="modal-header pb-1 pt-1">
                    <h5 class="modal-title text-with-shadow" id="ModalLabel text-with-shadow">Déposer une ressource</h5>
                    <button type="button" class="close rounded-2 degrade-diagonal-rouge" data-bs-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-1 pt-1">
                    <form action="{{ route('storeRessourcePost') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col mt-2">
                                <label for="category" class="text-with-shadow">Catégorie</label>
                                <select class="form-select-arrow degrade-diagonal-rouge rounded-2" id="categorySelect" name="category">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" data-bs-themes='{{ json_encode($category->themes->map(function ($theme) {
                                            return ['id' => $theme->id, 'label' => $theme->label];
                                        })) }}'>{{ $category->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mt-2">
                                <label for="theme" class="text-with-shadow">Thème</label>
                                <select class="form-select-arrow degrade-diagonal-rouge rounded-2" id="themeSelect" name="theme">
                                    {{-- Les options seront ajoutées dynamiquement via JavaScript --}}
                                </select>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="title" class="text-with-shadow">Titre</label>
                            <input type="text" class="form-control degrade-diagonal-rouge text-light" id="title" name="title" placeholder="Titre du message" value="{{ old('title') }}" required>
                        </div>

                        <div class="mt-2">
                            <label for="content" class="text-with-shadow">Description</label>
                            <textarea class="form-control degrade-diagonal-rouge text-light" id="description" name="description" placeholder="Contenu du message" rows="10" required>{{old('description')}}</textarea>
                        </div>

                        <div class="mt-2">
                            <label for="file" class="text-with-shadow">Ajouter un fichier</label>
                            <input type="file" class="form-control degrade-diagonal-rouge text-light" id="file" name="file" value="{{ old('file') }}">
                        </div>

                        <button type="submit" class="btn degrade-diagonal-rouge float-end mt-1">Soumettre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--script pour derouler les card post--}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
    $('.ressource-titre').on('click', function() {
        $('.ressource-content').not($(this).next('.ressource-content')).slideUp(); // Ferme les autres éléments
        $(this).next('.ressource-content').slideToggle();
    });
});
</script>

{{--script pour mettre a jour les selecteurs themes en fonction du selecteur category dans le modal--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Sélecteurs
    var categorySelect = document.getElementById('categorySelect');
    var themeSelect = document.getElementById('themeSelect');

    // Écouteur d'événement sur le changement de catégorie
    categorySelect.addEventListener('change', function () {
        // catégorie sélectionnée
        var selectedCategory = categorySelect.options[categorySelect.selectedIndex];

        // objets themes associés à la catégorie sélectionnée
        var themes = JSON.parse(selectedCategory.getAttribute('data-bs-themes'));

        // Réinitialiser la liste des thèmes
        themeSelect.innerHTML = '';

        // Ajouter les options de thèmes avec la classe degrade-diagonal-rouge
        themes.forEach(function (theme) {
            var option = document.createElement('option');
            option.value = theme.id;
            option.text = theme.label;
            themeSelect.add(option);
        });
    });

    // Déclenchez l'événement de changement initial si une catégorie est déjà sélectionnée
    if (categorySelect.selectedIndex !== -1) {
        categorySelect.dispatchEvent(new Event('change'));
    }
});
</script>

{{--Script pour faire defiler la page a la selection d'un theme--}}
<script>
    document.getElementById('themeSelector').addEventListener('change', function() {
        // Récupérer la valeur sélectionnée
        var selectedTheme = this.value;

        // Vérifier si l'ancre du thème existe sur la page
        var themeAnchor = document.getElementById('theme' + selectedTheme);

        if (themeAnchor) {
            // Faire défiler la page jusqu'à l'ancre du thème sélectionné
            themeAnchor.scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.themeDropdown .dropdown-item').on('click', function() {
            $('#searchCollapse').collapse('hide');
        });

        $('[data-bs-toggle="collapse"]').on('click', function() {
            var target = $(this).data('bs-target');
            var target = $(this).data('bs-target');
            $(target).collapse('toggle');
        });
    });
</script>

