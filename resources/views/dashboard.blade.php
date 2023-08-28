<!DOCTYPE html>
<html>
<head>
    <title>Multimarcas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #DEE8E9">
@component('components.navigation')
@endcomponent
<main style="width: 50%; margin: 0 auto;">
    <form method="post" action="{{ route('cars.store') }}" style=" margin-top: 40px; ">
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

