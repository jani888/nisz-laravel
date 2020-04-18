<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Musonza\Chat\Models\Conversation;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Chat::conversations()->setParticipant(auth()->user())->get();
    }

    public function show($convo_id) {
        \Chat::conversation(Conversation::find($convo_id))->setParticipant(auth()->user())->readAll();
        return \Chat::conversation(Conversation::find($convo_id))->setParticipant(auth()->user())->getMessages();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
