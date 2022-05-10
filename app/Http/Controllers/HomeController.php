<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class HomeController extends Controller
{
    //
    public function index() {

        $messages = Message::all();


        return view('newhome', [
            'messages' => $messages
        ]);
        //return view('welcome');
    }
}
