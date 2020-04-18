@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Csatlakozás családhoz</div>

                <div class="card-body">
                    Meglévő családhoz csatlakozás

                    <form action="/join" method="get">
                        <div class="form-group">
                            <label for="familyCode" class="font-weight-bold">Család kód</label>
                            <input type="text" name="code" class="form-control" placeholder="12-jegyű család kód" id="familyCode" aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">A család adminisztrátora hozza létre</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Csatlakozás</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">Új család</div>
                <div class="card-body">
                    <p>Új család létrehozása</p>
                    <form action="/family" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="familyName" class="font-weight-bold">Család név</label>
                            <input type="text" name="name" class="form-control" placeholder="A család neve" id="familyName">
                        </div>
                        <button type="submit" class="btn btn-primary">Létrehozás</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
