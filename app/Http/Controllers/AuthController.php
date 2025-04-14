<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\User;
use App\Mail\twoAuthEmail;

class AuthController extends Controller
{
    public function showAuth(){
        return view('auth');
    }

    public function authUser(Request $request){
        $dados = $request->except('_token');

        if(!User::where('email', $dados['email'])->exists()){
            return redirect()->back()->with('errorLogin','Email não cadastrado');
        }

        $user = User::where('email', $dados['email'])->first();

        if(!Hash::check($dados['password'], $user->password)){
            return redirect()->back()->with('errorLogin','Email e senha não coincidem');
        }

        $token = Str::uuid()->toString();
        $user->remember_token = $token;
        $user->save();

        $dadosMail['username'] = $user->user_name;
        $dadosMail['token'] = $user->remember_token;

        Mail::to($dados['email'])->send(new twoAuthEmail($dadosMail));
        return redirect()->route('auth.receive.token', ['email'=>$user->email]);
    }

    public function showReceiveToken($email){
        return view('mails.verifyToken', ['email'=>$email]);
    }

    public function verifyToken(Request $request){
        $dados = $request->except('_token');
        $user = User::where('email', $dados['email'])->first();

        if($user->remember_token == $dados['token']){
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('lobby.index');
        }else{
            return redirect()->back()->with('errorToken','Token invalido');
        }
    }

    public function resendToken($email){
        $user = User::where('email', $email)->first();

        $token = Str::uuid()->toString();
        $user->remember_token = $token;
        $user->save();

        $dadosMail['username'] = $user->user_name;
        $dadosMail['token'] = $user->remember_token;

        Mail::to($email)->send(new twoAuthEmail($dadosMail));
        return redirect()->route('auth.receive.token', ['email'=>$user->email]);
    }

    public function logoutUser(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index')->with('message','Logout efetuado com sucesso');
    }
}
