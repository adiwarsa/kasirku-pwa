<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Toko;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => "Profile",
            'toko' => Toko::first(),
        ];
        return view('profile.index', compact('data'));
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
        $passEncrypt = Hash::make($request->new_password);
        $user = User::find($id);

        $dataUser = array(
            'name' => $request->name,
            'email' => $request->email,
        );
        if ($request->input('old_password')) {
            if (password_verify($request->old_password, auth()->user()->password)) {
                $dataUser['password'] = $passEncrypt;
            } else {
                return redirect(route('profile.index'))->with('errors', 'Password Lama Salah!');
            }
        }

        $user->update($dataUser);


        $foto = $request->file('foto');

        $dataUser = User::find($id);
        $imgDb = $dataUser->foto;
        $imagePath = public_path('image/profile/' . $dataUser->foto);

        if ($request->hasFile('foto') == true) {
            $ekstensi_diperbolehkan    = array('image/png', 'image/jpg', 'image/jpeg');
            $ekstensi = $foto->getClientMimeType();
            $ukuran    = $foto->getSize();

            if (in_array($ekstensi, $ekstensi_diperbolehkan) == true) {
                if ($ukuran > 3048000) {
                    return redirect(route('profile.index'))->with('errors', 'Upload Foto Kurang dari 3mb!');
                } else {
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $fileName = time() . '.' . $foto->getClientOriginalExtension();
                    $foto->move('image/profile/', $fileName);
                    $imgDb = $fileName;
                    $dataUser->update(['foto' => $imgDb]);
                }
            } else {
                return redirect(route('profile.index'))->with('errors', 'Upload Foto Dengan Ekstensi png/jpg/jpeg!');
            }
        }

        $dataUserDetail = array(
            'telp' => $request->telp,
            'alamat' => $request->alamat,
        );
        $dataUser->update($dataUserDetail);
        return redirect(route('profile.index'))->with('success', 'Berhasil Update Profile');
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

    public function updateShop(Request $request, $id)
    {
        $dataShop = array(
            'nama_toko' => ucwords($request->nama_toko),
            'alamat_toko' => ucwords($request->alamat_toko),
            'no_telepon_toko' => $request->no_telepon_toko
        );
        Toko::find($id)->update($dataShop);
        return redirect(route('profile.index'))->with('success', 'Berhasil Update Data Toko');
    }
}
