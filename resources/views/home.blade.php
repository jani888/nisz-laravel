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
        <div class="row">
            <div class="col">
                <h3 class="text-primary text-uppercase font-weight-bold">{{auth()->user()->family->name}}</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Tennivalók</div>

                    <div class="card-body">
                        <pre>{{auth()->user()->family}}</pre>
                        <div class="card">
                            <div class="card-body py-2 px-3">
                                <h5>Todo1</h5>
                                <p class="my-1">Lorem ipsum</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
