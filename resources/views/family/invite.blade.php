@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Családtagok meghívása</div>

                    <div class="card-body">
                        <h4>Csatlakozási link</h4>
                        <p>Küldd el családtagjaidnak ezt linket. Ennek segítségével csatlakozhatnak a családodhoz.</p>
                        <input type="text" readonly class="form-control" value="{{config('app.url')}}/register?redirectTo=join/{{$family->id}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
