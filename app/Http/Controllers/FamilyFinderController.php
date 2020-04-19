<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyFinderController extends Controller {

    public function index() {
        $families = Family::whereDoesntHave('friends', function ($query){
            $query->where('family1_id', auth()->user()->family->id)->orWhere('family2_id', auth()->user()->family->id);
        })->where('id', '<>', auth()->user()->family->id)->get()->where('distance', '<=', 20)->sortBy('distance');
        $family = auth()->user()->family;
        $friends = auth()->user()->family->friends;
        return view('familyFinder.index', compact('family', 'families', 'friends'));
    }

    public function friendRequest(Family $family) {
        $family->friends()->attach(auth()->user()->family);

        $chat = \Chat::createConversation([]);
        $family->users->each(function ($user) use ($chat) {
            $chat->addParticipants([$user]);
        });
        auth()->user()->family->users->each(function ($user) use ($chat) {
            $chat->addParticipants([$user]);
        });
        $chat->update(['data' => ['title' => $family->name . ' - ' . auth()->user()->family->name]]);
        return redirect()->route('chat');
    }

    public function setLocation(Request $request) {
        $this->validate($request, [
            'longitude' => [
                'required',
                'numeric',
            ],
            'latitude'  => [
                'required',
                'numeric',
            ],
        ]);

        auth()->user()->family->update([
            'longitude' => $request->longitude,
            'latitude'  => $request->latitude,
        ]);

        return back();
    }
}
