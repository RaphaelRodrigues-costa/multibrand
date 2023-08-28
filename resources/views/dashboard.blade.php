<!DOCTYPE html>
<html>
<head>
    <title>Multimarcas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #DEE8E9">
<nav class="navbar navbar-expand-lg navbar-light bg-light" style=" margin-bottom: 10px;">
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{route('cars-list')}}">Lista de Veiculos</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{route('profile.edit')}}">Perfil</a>
            </li>
        </ul>
    </div>
</nav>
<main style="width: 50%; margin: 0 auto;">
    <form method="post" action="{{ route('cars') }}" style=" margin-top: 40px; ">
        @csrf
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <input type="text" class="form-control" id="brand" name="brand" style="margin-right: 10px;"
                   placeholder="Busque pela marca ...">

            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

        @error('brand')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif
    </form>
</main>
</body>
</html>

