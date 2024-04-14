@extends('master')

@section('title', 'gestion du forum')

@section('content')

@include('header')

@auth
@if(auth()->user()->isAdmin())
<div class="container-fluid mt-2">
    {{-- Header avec le bouton pour supprimer un post--}}
    <div class="row cadreblanc mt-1 mb-4">
        <div class="col-sm-10 d-flex justify-content-center align-items-center">
            <h1 class="mx-2 font-weight-bold text-with-shadow">ESPACE ADMIN FORUM</h1>
            <div class="d-none d-sm-block mx-3 d-flex align-items-center"><p class="d-flex mb-0 align-items-center font-weight-bold text-with-shadow"><b>Le lieu où on gère les questions!!</b></p></div>
        </div>
            <div class="col-sm-2 d-flex align-items-center ">
                <form id="deleteRessourcePost" class="justify-content-center mb-1 mb-sm-0" action="{{route('deleteRessourcePost', ['id'=>$post->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="degrade-diagonal-danger rounded-2 float-sm-end" onclick="confirmPostDelete()">
                        SUPPRIMER LE POST
                    </button>
                </form>
            </div>

    </div>

    <div class="d-flex text-light mb-3">
        <h3 class="me-4">CATEGORIE: {{$post->theme->category->label}}</h3>
        <button class="degrade-diagonal-info rounded-2" data-bs-toggle="modal" data-bs-target="#categoryModal">modifier</button>
     </div>
     <div class="d-flex text-light">
         <h3 class="me-4">THEME: {{$post->theme->label}}</h3>
        <button class="degrade-diagonal-info rounded-2" data-bs-toggle="modal" data-bs-target="#ThemeModal">modifier</button>
      </div>
    {{--corp du forum--}}
    <div class="degrade-diagonal-rouge mt-4 rounded-2 p-2">
    {{--post principal--}}
        {{--header du post--}}
        <div>
            <div class="d-flex">
                <div class="fw-bold me-2 text-light">{{$post->user->name}}</div>
                <div class="text-light">{{$post->created_at->format('d/m/Y')}}</div>
            </div>
            <div class="text-center mt-2">
                <h5 class="mb-1 text-light"><b>{{$post->title}}</b></h5>
            </div>
        </div>
        <div class="d-flex mb-4">
            <div class="ms-3 text-light">
                {{--corp du post--}}
                {{$post->description}}
            </div>
        </div>
    </div>
</div>

{{-- Modal pour la sélection de la catégorie et theme --}}
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateRessourcePost')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModal">Sélectionner une catégorie et un thème</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <label for="categorySelect">Catégorie</label>
                        <select id="categorySelect" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-bs-themes="{{ json_encode($category->themes) }}">{{ $category->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="themeSelect">Thème</label>
                        <select id="themeSelect" class="form-control" name="theme_id">
                            {{-- Les options seront remplies dynamiquement via JavaScript --}}
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal pour la sélection d'un theme --}}
<div class="modal fade" id="ThemeModal" tabindex="-1" role="dialog" aria-labelledby="ThemeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateRessourcePost')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ThemeModal">Sélectionner un thème</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <label for="categorySelect">Theme</label>
                        <select id="categorySelect" class="form-control" name="theme_id">
                            @foreach($post->theme->category->themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>


@else
<div>
    <h1 class="text-danger">Espace reserve a l'administrateur</h1>
</div>
@endif
@endauth
@endsection

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

{{--Ajout d'un pop up pour confirmer la suppression d'une ressource--}}
<script>
    function confirmPostDelete() {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce post ?")) {
            document.getElementById('deleteRessourcePost').submit();
        }
    }
</script>





