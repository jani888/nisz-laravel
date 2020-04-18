<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\User;
use Illuminate\Http\Request;

class TodoController extends Controller {

    public function index() {
        $todos = auth()->user()->todos()->orderBy('is_done')->orderBy('created_at', 'DESC')->get();
        return view('todo.index', compact('todos'));
    }

    public function markAsDone(Todo $todo) {
        $todo->users()->findOrFail(auth()->user()->id);

        $todo->update(['is_done' => true]);
        return redirect()->route('todo.index');
    }

    public function destroy(Todo $todo) {
        $todo->users()->findOrFail(auth()->user()->id);
        $todo->delete();
        return redirect()->route('todo.index');
    }

    public function edit(Todo $todo) {
        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo) {
        $todo->users()->findOrFail(auth()->user()->id);
        $this->validate($request, [
            'title'       => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'users' => [
                'required',
                'array'
            ]
        ]);

        $todo->update(['title' => $request->title, 'description' => $request->description]);

        $todo->users()->detach();
        foreach($request->users as $user){
            $user = User::findOrFail($user);
            abort_unless($user->family_id == auth()->user()->family_id, 403);
            $todo->users()->attach($user);
        }

        $todo->save();
        return back();
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title'       => [
                'required',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'users' => [
                'required',
                'array'
            ]
        ]);

        $todo = Todo::create(['title' => $request->title, 'description' => $request->description]);

        foreach($request->users as $user){
            $user = User::findOrFail($user);
            abort_unless($user->family_id == auth()->user()->family_id, 403);
            $todo->users()->attach($user);
        }

        $todo->save();
        return back();
    }
}
