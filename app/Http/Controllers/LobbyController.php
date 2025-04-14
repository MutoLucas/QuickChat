<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Conversation;

class LobbyController extends Controller
{
    public function index($id = null){
        if($id){
            $conversation = Conversation::find($id);
            if($conversation->user_one_id !== auth()->user()->id && $conversation->user_two_id !== auth()->user()->id){
                return view('lobby', ['id'=>null]);
            }
            return view('lobby', ['id'=>$id]);
        }else{
            return view('lobby', ['id'=>null]);
        }

    }
}
