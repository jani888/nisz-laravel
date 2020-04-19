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
                <div class="card shadow border-bottom-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Tennivalók
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-modal">
                            <i class="fa fa-plus"></i> hozzáadás
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{route('todo.store')}}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Új teendő</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Teendő neve</label>
                                            <input class="form-control" id="name" name="title" placeholder="Teendő neve" type="text" value="{{old('title')}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="control-label">Teendő leírása</label>
                                            <textarea id="description" placeholder="Leírás" name="description" class="form-control">{{old('description')}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <h6>Kinek a feladata?</h6>
                                            @foreach(auth()->user()->family->users as $user)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="users[]" value="{{$user->id}}" id="defaultCheck{{$user->id}}">
                                                    <label class="form-check-label" for="defaultCheck{{$user->id}}">
                                                        {{$user->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">mégsem</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            Teendő létrehozása
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($todos as $item)
                            <div class="card mb-2">
                                <div class="card-body py-2 px-3 d-flex @if($item->is_done) bg-light text-muted @endif">
                                    <div class="col">
                                        <h5>{{$item->title}}</h5>
                                        <p class="my-1 text-muted">{{$item->description ?? 'Nincs leírás'}}</p>
                                    </div>
                                    @if(!$item->is_done)
                                        <div class="col-auto border-left d-flex align-items-center">
                                            <form action="{{config('app.url')}}/todo/{{$item->id}}/done" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-link text-primary p-0">
                                                    <i class="fa fa-check"></i>
                                                    Megjelölés készként
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-auto border-left d-flex align-items-center">
                                            <div class="d-flex flex-column text-right">
                                                <a href="{{route('todo.edit', $item->id)}}" class="p-0 btn btn-link">
                                                    <i class="fas fa-pen"></i>
                                                    szerkesztés
                                                </a>
                                                <form action="{{config('app.url')}}/todo/{{$item->id}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link text-danger p-0">
                                                        <i class="fa fa-times"></i>
                                                        Törlés
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-auto d-flex align-items-center">
                                            <i class="fa fa-check mr-2"></i> Befejezve
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection