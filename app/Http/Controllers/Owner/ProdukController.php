<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::where('status', 'non-supplier')->orderBy('stok', 'DESC')->orderBy('id', 'ASC')->get();
        $data = [
            // 'produk' => Product::get(),
            'title' => "Produk",
            'toko' => Toko::first(),
            'produk' => $produk,
            'total_stok' => Produk::where([['status', '=', 'non-supplier']])->orderBy('stok', 'DESC')->orderBy('id', 'ASC')->get(),
            'hari' => Carbon::now()->translatedFormat('l, d F Y')
        ];
        $produk = Produk::where('kode', 'LIKE', '%ABC%')->OrderByDesc('kode')->get();


        return view('owner.produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.produk.form.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode = $request->kode;
        $nama_produk = $request->nama_produk;
        $harga_beli = str_replace('.', '', $request->harga_beli);
        $harga_jual = str_replace('.', '', $request->harga_jual);
        $expired = $request->expired;
        $stok = $request->stok;

        $totalProduk = Produk::count();
        $alert = "";

        if ($stok == null) {
            $stok = 1;
        }

        if ($kode == null) {
            $produk = Produk::where('kode', 'LIKE', '%ABC%')->OrderByDesc('id')->get();
            if ($produk->count() == 0) {
                $angka = 1;
            } else {

                $jumlahKarakter = strlen($produk[0]->kode);
                if ($jumlahKarakter > 7) {
                    $angka = substr($produk[0]->kode, 3, 5);
                    $angka++;
                } elseif ($jumlahKarakter > 6) {
                    $angka = substr($produk[0]->kode, 3, 4);
                    $angka++;
                } else {
                    $angka = substr($produk[0]->kode, 3, 3);
                    $angka++;
                }
            }
            $kode = "ABC" . $angka;
        }

        $dataProduk = array(
            'kode' => $kode,
            'nama_produk' => $nama_produk,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'expired' => $expired,
            'foto' => null,
            'status' => "non-supplier",
            'stok' => $stok,
        );

        if ($totalProduk == 0) {
            Produk::create($dataProduk);
        } else {
            $cek = Produk::where('kode', $kode)->first();
            if ($cek == null) {
                Produk::create($dataProduk);
            } else {
                $alert = "Kode Produk Sudah Ada!";
            }
        }
        return response()->json($alert);
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
        $data = Produk::find($id);
        return view('owner.produk.form.edit', compact('data'));
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
        $kode = $request->kode;
        $nama_produk = $request->nama_produk;
        $harga_beli = str_replace('.', '', $request->harga_beli);
        $harga_jual = str_replace('.', '', $request->harga_jual);
        $expired = $request->expired;
        $stok = $request->stok;

        if ($stok == null) {
            $stok = 0;
        }

        $dataProduk = array(
            'kode' => $kode,
            'nama_produk' => $nama_produk,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'expired' => $expired,
            'stok' => $stok,
        );

        Produk::find($id)->update($dataProduk);
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Produk::find($id)->delete();
        return redirect(route('produk.index'));
    }

    public function tabelProduk($status)
    {
        if ($status == 'stok') {
            $data = Produk::where([['stok', '<=', 5]])->OrderBy('stok', 'ASC')->get();
        } else {

            $data = Produk::where([['status', '=', 'non-supplier'], ['stok', '>', 0]])->OrderByDesc('id')->get();
        }

        return view('owner.produk.tabel.produk', compact('data'));
    }

    public function tabelKeterangan($status)
    {
        if ($status == 'filter') {
            $produk = Produk::where([['stok', '<=', 5]])->OrderByDesc('stok', 'id')->get();
        } else {
            $produk = Produk::where([['status', '=', 'non-supplier'], ['stok', '>', 0]])->OrderByDesc('id')->get();
        }
        $data = [
            'total_harga_beli' => $produk->sum('harga_beli'),
            'total_harga_jual' => $produk->sum('harga_jual'),
            'total_keuntungan' => $produk->sum('harga_jual') - $produk->sum('harga_beli'),
            'total_produk' => $produk->sum('stok'),
        ];
        return view('owner.produk.tabel.keterangan', compact('data'));
    }
}
