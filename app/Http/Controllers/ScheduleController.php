<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller {

    public function index() {
        $events = auth()->user()->family->schedule;
        return view('schedule.index', compact('events'));
    }

    public function destroy(Schedule $item) {
        abort_unless($item->user_id == auth()->user()->id, 403);

        $item->delete();
        return back();
    }

    public function store(Request $request) {
        $this->validate($request, [
            'from' => ['required'],
            'to'   => ['required'],
        ]);

        $title = auth()->user()->name;

        Schedule::create([
            'title'     => $title,
            'start'     => Carbon::createFromFormat('Y.m.d. H:i', $request->from),
            'end'       => Carbon::createFromFormat('Y.m.d. H:i', $request->to),
            'user_id'   => auth()->user()->id,
            'family_id' => auth()->user()->family_id,
        ]);

        return back();
    }
}
