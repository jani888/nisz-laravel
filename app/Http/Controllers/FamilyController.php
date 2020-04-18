<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    public function join(Request $request) {
        $this->validate($request, ['code' => ['min:12', 'max:12', 'required']]);

        if(auth()->user()->family != null){
            return redirect('home')->with(['status' => 'error', 'message' => 'Már tagja vagy egy családnak']);
        }

        auth()->user()->family()->associate(Family::findOrFail($request->code));
        auth()->user()->save();
    }

    public function store(Request $request) {
        $this->validate($request, ['name' => ['min:3', 'max:255', 'required']]);
        $family = Family::create([
            'name' => $request->name,
            'id' => Str::random(12)
        ]);
        auth()->user()->family()->associate($family);
        return view('family.invite', compact('family'));
    }
}
