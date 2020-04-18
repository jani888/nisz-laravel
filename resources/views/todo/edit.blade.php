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
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title" id="exampleModalLabel">Teendő szerkesztése</h5>
            </div>
            <div class="card-body">
                <form action="/todo/{{$todo->id}}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="control-label">Teendő neve</label>
                        <input class="form-control" id="name" name="title" placeholder="Teendő neve" type="text" value="{{$todo->title}}">
                    </div>

                    <div class="form-group">
                        <label for="description" class="control-label">Teendő leírása</label>
                        <textarea id="description" placeholder="Leírás" name="description" class="form-control">{{$todo->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <h6>Kinek a feladata?</h6>
                        @foreach(auth()->user()->family->users as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="users[]" @if ($todo->users->contains($user))checked @endif value="{{$user->id}}" id="defaultCheck{{$user->id}}">
                                <label class="form-check-label" for="defaultCheck{{$user->id}}">
                                    {{$user->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Teendő frissítése</button>
                </form>
                <form action="{{route('todo.delete', $todo->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger mt-2">Törlés</button>
                </form>
            </div>
        </div>
    </div>
@endsection