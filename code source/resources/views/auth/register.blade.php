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
            <a class="text-decoration-none" href="{{route('acceuil')}}"><h1 class="mx-2 font-weight-bold text-light">DODGE FORGE</h1></a>
        </div>
    </div>
    <div class="m-3 d-none d-sm-block">
        <p class="mb-0 align-items-center justify-content-center text-center font-weight-bold text-light">
            <b>Le site d'echange numerique Eduservice</b>
        </p>
    </div>

    {{--form d'inscription--}}
    <div class="mx-1 mx-sm-5 px-1 px-sm-4 justify-content-center align-items-center cadreblanc">

        <div class="justify-content-center align-items-center text-center">
            <H5 class="text-center text-light cadreblanc mt-2 mb-2 mx-auto p-2 w-75 ">INSCRIPTION</H5>
        </div>

        <form action="{{route('storeUser')}}" method="post">
            @csrf
            <div>
                <div class="row">

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold text-light mb-1">Nom</label>
                        <input type="text" name="name" placeholder="nom" class="form-control cadre-input cadreblanclight" value="{{old("name")}}" required>
                    </div>

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Prenom</label>
                        <input type="text" name="first_name" placeholder="prenom" class="form-control cadre-input cadreblanclight" value="{{old("first_name")}}" required>
                    </div>

                    <div class="col-sm-4 mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Formation</label>
                            <select name="formation_id" id="formation-dropdown" class="form-select cadreblanclight">
                                @foreach ($formations as $formation)
                                    <option value="{{$formation->id}}">{{$formation->label}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="mt-2">
                    <label class="form-label font-weight-bold mb-1 text-light">Email</label>
                    <input type="email" name="email" placeholder="email" class="form-control cadre-input cadreblanclight" required>
                </div>

                <div class="row">
                    <div class="col-sm mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Mot de passe</label>
                        <input type="password" name="password" placeholder="mot de passe" class="form-control cadre-input cadreblanclight" required>
                    </div>

                    <div class="col-sm mt-2">
                        <label class="form-label font-weight-bold mb-1 text-light">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" placeholder="mot de passe" class="form-control cadre-input cadreblanclight" required>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center align-items-center text-center">
                    <p class="text-light">En validant vous acceptez les conditions d'utilisation ainsi la polique de confidentialité</p>
                </div>
                <div class="d-flex justify-content-center align-items-center text-center">
                    <button class="rounded-2 degrade-diagonal-rouge" style="width: 200px">
                        s'inscrire
                    </button>
                </div>
                <div class="m-2 d-flex justify-content-center align-items-center text-center">
                    <a href="{{route('consent')}}" class="text-with-shadow">politique de confidentialité</a>
                </div>
            </div>
        </form>
    </div>

</div>

@endsection
