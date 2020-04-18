<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index() {
        if(auth()->user()->family_id != null) return redirect('home');

        return view('onboarding');
    }
}
