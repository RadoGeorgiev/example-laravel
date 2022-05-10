<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    //
    public function create(Request $request) {

        $message = new Message();

        $message->title = $request->input('title');

        $message->content = $request->input('content');

        $message->save();

        return redirect('/');

    }

    public function view($id) {

        $message = Message::findOrFail($id);

        return view('message',[

            'message' => $message

        ]);
    }

}
