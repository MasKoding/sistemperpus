<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function index(){
        // simpan data user jika ada
        $user =  Auth::user();
        //cek data user ada atau tidak
        if($user){
            if($user->level =='admin'){
                return redirect()->intended('admin');
            }
            else if($user->level=='user'){
                return redirect()->intended('user');
            }
        }
        return view('login');
     }

     public function proses_login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        $credential = $request->only('username','password');
      // cek user udah login atau belum dan username sama password sesuai
        if(Auth::attempt($credential)){
            $user = Auth::user();
            if($user->level =='admin'){
                return redirect()->intended('admin');
            }
            else if($user->level=='user'){
                return redirect()->intended('user');
            }
            else if($user->level=='manager'){
                return redirect()->intended('manager');
            }
            else if($user->level=='executive'){
                return redirect()->intended('executive');
            }
            return redirect()->intended('/');
        }
        return redirect('login')
        ->withInput()->withErrors(['login_gagal'=>'Username atau Password tidak ditemukan']);

      }
      public function register(){ 
        return view('register');
      }

      public function proses_register(Request $request){ 
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return redirect('/register')
               ->withErrors($validator)
               ->withInput();
        }
        $request['level'] = 'user';
        $request['password'] = bcrypt($request->password);
        User::create($request->all());

        return redirect()->route('login');

      }

      public function logout(Request $request){
         $request->session()->flush();
         Auth::logout();
         
         return Redirect('login');
       }
}
