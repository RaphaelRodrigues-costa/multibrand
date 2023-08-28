<!DOCTYPE html>
<html>
<head>
    <title>Multimarcas</title>
    <!-- Adicione os links para os arquivos de estilo CSS do Bootstrap -->
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
                <a class="nav-link" href="{{route('cars.index')}}">Lista de Veiculos</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{route('profile.edit')}}">Perfil</a>
            </li>
        </ul>
    </div>
    <form class="form-inline my-2 my-lg-0" action="{{route('cars.index')}}" method="get">
        <div style="display: flex; align-items: center; ">
            <input class="form-control mr-sm-2" type="search" id="brand" name="name" placeholder="Filtrar por marca"
                   aria-label="Pesquisar" style=" margin-right: 10px;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
        </div>
    </form>
</nav>
<div style="width: 50%; margin: 0 auto;">

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif
        @foreach ($cars as $car)
            <div class="col">
                <div class="card h-100">
                    <img src="{{$car->linkImage}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$car->carName}}</h5>
                        <p class="list-group-item">Ano: {{$car->year}}</p>
                        @if(!empty($valor))
                            <p class="list-group-item">Combustivel: {{$car->fuel}}</p>
                        @endif
                        @if(!empty($car->doors))
                            <p class="list-group-item">Portas: {{$car->doors}}</p>
                        @endif
                        <p class="list-group-item">Quilometragem: {{$car->kilometers}}</p>
                        <p class="list-group-item">Cambio: {{$car->gearbox}}</p>
                        <p class="list-group-item">Cor: {{$car->color}}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-body-secondary">valor : {{$car->price}}</small>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cars.delete', $car->id) }}" method="post">
                            {{method_field('delete')}}
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-outline-danger">Deletar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>

