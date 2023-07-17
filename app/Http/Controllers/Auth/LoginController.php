<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toko = Toko::first();
        return view('auth.index', compact('toko'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == null) {
            session()->flash('errors', 'Email Tidak Ditemukan!');
            return redirect('/');
        } else {
            if (Auth::attempt($request->only('email', 'password'))) {
                if (auth()->user()->status == 0) {
                    return redirect('/');
                } elseif (auth()->user()->status == 1) {
                    if (auth()->user()->role == 1) {
                        session()->flash('success', 'Login Successful!');
                        return redirect()->route('dashboard.index');
                    } elseif (auth()->user()->role == 2) {
                        session()->flash('success', 'Login Successful!');
                        session(['alert_produk' => 'aktif']);
                        return redirect()->route('kasir.index');
                    }
                }
            } else {
                session()->flash('errors', 'Password Salah!');
                return redirect('/');
            }
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
