<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $remember = $request->remember != null ? true : false;
        if(Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 1
        ], $remember) || Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 1
        ], $remember)){
            $user = Auth::user();

            $user->last_active_at = now();
            $user->save();

            if ($user->device_token) {
                Auth::logout();
                $user = Auth::user();
                $user->device_token = null;
                $user->save();
                return redirect('login')->with('alert', 'Akun ini sudah digunakan di perangkat lain.');
            }

            $deviceToken = Str::uuid();
            $user->device_token = $deviceToken;
            $user->save();
            $request->session()->put('device_token', $deviceToken);

            Session::put('sweetalert', 'success');
            return redirect()->route('dashboard')->with('alert', 'Selamat Datang!');
        }elseif(Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 2
        ], $remember) || Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 2
        ], $remember)){
            $user = Auth::user();

            $user->last_active_at = now();
            $user->save();

            if ($user->device_token) {
                Auth::logout();
                $user = Auth::user();
                $user->device_token = null;
                $user->save();
                return redirect('login')->with('alert', 'Akun ini sudah digunakan di perangkat lain.');
            }

            $deviceToken = Str::uuid();
            $user->device_token = $deviceToken;
            $user->save();
            $request->session()->put('device_token', $deviceToken);

            Session::put('sweetalert', 'success');
            return redirect()->route('dashboard')->with('alert', 'Selamat Datang!');
        }elseif(Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 3
        ], $remember) || Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 3
        ], $remember)){
            $user = Auth::user();

            $user->last_active_at = now();
            $user->save();

            if ($user->device_token) {
                Auth::logout();
                $user = Auth::user();
                $user->device_token = null;
                $user->save();
                return redirect('login')->with('alert', 'Akun ini sudah digunakan di perangkat lain.');
            }

            $deviceToken = Str::uuid();
            $user->device_token = $deviceToken;
            $user->save();
            $request->session()->put('device_token', $deviceToken);

            Session::put('sweetalert', 'success');
            return redirect()->route('dashboard')->with('alert', 'Selamat Datang!');
        }elseif(Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 4
        ], $remember) || Auth::attempt([
            'username'     => $request->username,
            'password'  => $request->password,
            'role_id'      => 4
        ], $remember)){
            $user = Auth::user();

            $user->last_active_at = now();
            $user->save();

            if ($user->device_token) {
                Auth::logout();
                $user = Auth::user();
                $user->device_token = null;
                $user->save();
                return redirect('login')->with('alert', 'Akun ini sudah digunakan di perangkat lain.');
            }

            $deviceToken = Str::uuid();
            $user->device_token = $deviceToken;
            $user->save();
            $request->session()->put('device_token', $deviceToken);

            Session::put('sweetalert', 'success');
            return redirect()->route('dashboard')->with('alert', 'Selamat Datang!');
        }

        return redirect('login')->with('alert','Username atau Password anda salah!');
    }

    public function logout(Request $request){
        $user = Auth::user();
        $user->device_token = null;
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::put('sweetalert', 'success');
        return redirect()->route('login')->with('alert', 'Sign Out Berhasil!');
    }
}
