@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col mt-5">
                <h3 class="text-primary text-uppercase font-weight-bold">{{auth()->user()->family->name}}</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col mb-5">
                <div class="card my-5 shadow border-bottom-primary">
                    <div class="card-header">Családtagok meghívása</div>

                    <div class="card-body">
                        <h4>Csatlakozási link</h4>
                        <p>Küldd el családtagjaidnak ezt linket. Ennek segítségével csatlakozhatnak a családodhoz.</p>
                        <input type="text" readonly class="form-control" value="{{config('app.url')}}/register?redirectTo={{config('app.url')}}/join/{{$family->id}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
@endsection
