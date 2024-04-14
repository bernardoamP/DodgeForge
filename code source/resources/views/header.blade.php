<nav class="navbar navbar-expand-sm navbar-light headernav">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarNav1" class="collapse navbar-collapse bg-nav">
            <ul class="navbar-nav w-100">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <li class="nav-item">
                        <a class="navbar-brand" href="https://www.groupe-eduservices.fr/" target="_blank">
                            <img src="{{asset("images/logoeduservice.png")}}" alt="logo" class="img-fluid w-100">
                        </a>
                    </li>
                </div>
                <div class="d-flex align-items-center justify-content-center cadreblanc w-100">
                    <li class="nav-item">
                        <a href="{{route("acceuil")}}" class="nav-link p-0 mx-1">Accueil</a>
                    </li>
                </div>
                <div class="d-flex align-items-center justify-content-center cadreblanc w-100">
                    <li class="nav-item">
                        <a href="{{route("forumIndex")}}" class="nav-link p-0 mx-1">Forum</a>
                    </li>
                </div>
                <div class="d-flex align-items-center justify-content-center cadreblanc w-100">
                    <li class="nav-item">
                        <a href="{{route("ressource")}}" class="nav-link p-0 mx-1">Ressources</a>
                    </li>
                </div>
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="d-flex align-items-center justify-content-center cadreblanc w-100">
                            <li class="nav-item">
                                <a href="{{route('AdminMain')}}" class="nav-link p-0 mx-1">Administration</a>
                            </li>
                        </div>
                        @endif
                @endauth
                <div class="d-flex align-items-center justify-content-center cadreblanc w-100">
                    <li class="nav-item">
                        @auth
                            <a href="{{route('logout')}}" class="nav-link p-0 mx-1 degrade-diagonal-rouge">Se deconnecter</a>
                        @else
                            <a href="{{route('loggin')}}" class="nav-link p-0 mx-1 degrade-diagonal-rouge">Se connecter</a>
                        @endauth
                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>
