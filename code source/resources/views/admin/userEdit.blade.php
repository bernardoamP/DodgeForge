@extends('master')
@section('title', 'Connexion')

@section('content')

<div class="container-fluid">

    {{--entête de la page--}}
    <div class="d-inline-flex m-2 w-100">
        <a class="me-4" href="https://www.groupe-eduservices.fr/" target="_blank">
            <img src="{{asset("images/logoeduservice.png")}}" alt="logo" class="img-fluid w-100">
        </a>
        <div class="col-sm-10 justify-content-center align-items-center">
            <a class="text-decoration-none" href="{{route('AdminMain')}}"><h1 class="mx-2 font-weight-bold text-light">RETOUR ADMIN</h1></a>
        </div>
    </div>

    {{--fiche utilisateur--}}
    <div class="mx-1 mx-sm-5 px-1 px-sm-4 justify-content-center align-items-center cadreblanc">
        <div class="row align-content-center justify-content-center">
            <div class="col-sm-10 d-flex align-items-center justify-content-center">
                <h1 class="text-with-shadow text-center me-sm-4">GESTION UTILISATEUR</h1>
            </div>
            <div class="col-sm-2 text-center d-flex align-items-center justify-content-center">
                <form id="deleteUserForm" action="{{route('deleteUser', ['id'=>$user->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="degrade-diagonal-danger rounded-2 mt-2" onclick="confirmPostDelete()">Supprimer</button>
                </form>
            </div>
        </div>
        <div class="d-flex p-2">
            <label for="create_at" class="text-light me-2">Date d'inscription:</label>
            <label for="date" class="text-light">{{$user->created_at->format('d/m/Y')}}</label>
        </div>
        {{--form de modification--}}
        <form action="{{route('updateUser')}}" method="post">
            @csrf
            <div>
                <div class="row">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold text-light mb-1">Nom</label>
                        <input type="text" name="name" placeholder="nom" class="form-control cadre-input cadreblanclight" value="{{$user->name}}" required>
                    </div>

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Prenom</label>
                        <input type="text" name="first_name" placeholder="prenom" class="form-control cadre-input cadreblanclight" value="{{$user->first_name}}" required>
                    </div>

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Formation</label>
                            <select name="formation_id" id="formation-dropdown" class="form-select cadreblanclight">
                                @foreach ($formations as $formation)
                                <option value="{{$formation->id}}" @if($formation->id == $user->formation_id) selected @endif>{{$formation->label}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="mt-2">
                    <label class="form-label font-weight-bold mb-1 text-light">Email</label>
                    <input type="email" name="email" placeholder="email" class="form-control cadre-input cadreblanclight" value="{{$user->email}}" required>
                </div>

                <div class="d-flex justify-content-center align-items-center text-center m-3">
                    <button class="degrade-diagonal-rouge rounded-2" style="width: 200px">
                        modifier
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

{{--Ajout d'un pop up pour confirmer la suppression d'un post--}}
<script>
    function confirmPostDelete() {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce post ?")) {
            document.getElementById('deleteUserForm').submit();
        }
    }
</script>
