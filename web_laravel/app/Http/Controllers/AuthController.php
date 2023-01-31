<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
//        dd(1);
        return view('auth/login');
    }
    public function processLogin(Request $request){
        try{
            $user = User::query()->where('email',$request->get('email'))
                ->firstOrFail();
            if (!Hash::check($request->get('password'), $user->password)) {
                throw new \Exception('Invalid password');
            }

            session()->put('id',$user->id);
            session()->put('name',$user->name);
            session()->put('level',$user->level);
            return  redirect()->route('course.index');
        }catch (\Throwable $e){
            return redirect()->route('login')->with('error','sai email hoac password');
        }

    }
    public function logout(){
        session()->flush();
        return redirect()->route('login');
    }
    public function register(){
        return view('auth/register');
    }
    public function processRegister(Request $request){
        $user = User::query()
            ->create([
                'email' => $request->get('email'),
                'name' => $request->get('name'),
                'password' => Hash::make($request->get('password')),
                'level' => 0,
            ]);
        UserRegisteredEvent::dispatch($user);
    }
}
