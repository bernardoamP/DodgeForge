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

    {{--form de connection--}}
    <div class="mx-1 mx-sm-5 px-1 px-sm-4 justify-content-center align-items-center cadreblanc">
        <div class="justify-content-center align-items-center text-center">
            <H5 class="text-center text-light cadreblanc mt-2 mb-2 mt-sm-4 mx-auto p-2 w-75 ">MOT DE PASSE OUBLIE</H5>
        </div>
        @if(isset($error))
            <div class="alert alert-danger align-items-center justify-content-center text-center">
                {{ $error }}
            </div>
         @endif
        <div class="d-flex align-items-center justify-content-center">
            <form action="{{route('authenticateCode')}}" method="post">
                @csrf

                <div class="m-4 justify-content-center align-items-center text-center">
                    <label class="form-label d-block font-weight-bold text-light mb-2">Adresse mail</label>
                    <input type="email" name="email" id="email" value="{{$email}}" class="form-control cadre-input cadreblanclight" readonly>
                </div>

                <div class="m-4 justify-content-center align-items-center text-center">
                    <label class="form-label d-block font-weight-bold text-light mb-2">code de confirmation</label>
                    <input type="text" name="code" placeholder="code de confirmation" class="form-control cadre-input cadreblanclight" required>
                </div>

                <div class="m-2 d-flex justify-content-center align-items-center text-center">
                    <button class="rounded-2 degrade-diagonal-rouge px-6">
                           valider
                    </button>
                </div>
            </form>
        </div>
    </div>


</div>

@endsection
