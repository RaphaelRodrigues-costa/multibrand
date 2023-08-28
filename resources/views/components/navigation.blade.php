<nav class="navbar navbar-expand-lg navbar-light bg-light" style=" margin-bottom: 10px;">
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('dashboard')}}">Carregar carros</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{route('cars.index')}}">Listar veiculos</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{route('profile.edit')}}">Perfil</a>
            </li>
        </ul>
    </div>
    {{ $slot }}
</nav>
