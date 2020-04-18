<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller {

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
            'deadline' => [
                'nullable',
                'datetime'
            ],
            ''
        ]);
    }
}
