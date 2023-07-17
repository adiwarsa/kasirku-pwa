<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PembayaranSupplier;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => "Supplier",
            'toko' => Toko::first(),
        ];

        return view('owner.supplier.data-supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.supplier.data-supplier.form.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //DateTime
        $currentime = Carbon::now();

        // Date
        $tanggal = $currentime->toDateString();

        $cek = Supplier::find($request->id);
        $cekDataSupplier = Supplier::where('no_wa', $request->no_wa)->first();
        $cekDataSupplier2 = Supplier::where('nama_supplier', $request->nama_supplier)->first();
        $cekKodeProduk = Produk::where('kode', $request->kode)->first();
        $harga_beli = str_replace('.', '', $request->harga_beli);
        $harga_jual = str_replace('.', '', $request->harga_jual);
        $alert = "";
        $kode = $request->kode;
        $stok = $request->stok;

        if ($kode == null) {
            $produk = Produk::where('kode', 'LIKE', '%LOI%')->OrderByDesc('id')->get();

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
            $kode = "LOI" . sprintf("%03s", $angka);
        }

        // Tambah Supplier
        if ($cek == null) {

            if ($cekDataSupplier == null && $cekDataSupplier2 == null) {

                if ($cekKodeProduk == null) {
                    $dataSupplier = array(
                        'nama_supplier' => $request->nama_supplier,
                        'no_wa' => $request->no_wa,
                        'keterangan' => $request->keterangan,
                        'total_pembayaran' => 0,
                        'tanggal' => $tanggal,
                        'status' => 1,
                    );
                    $supplier = Supplier::create($dataSupplier);

                    // $sub_total = $request->harga_beli * $request->stok;
                    $dataProduk = array(
                        'id_supplier' => $supplier->id,
                        'kode' => $kode,
                        'nama_produk' => $request->nama_produk,
                        'harga_beli' => $harga_beli,
                        'harga_jual' => $harga_jual,
                        'sub_total' => 0,
                        'expired' => $request->expired,
                        'stok' => $stok,
                        'produk_supplier_terjual' => 0,
                        'status' => 'supplier',
                    );
                    Produk::create($dataProduk);
                } else {
                    $alert = "Data Produk Sudah Ada!";
                }
            } else {
                $alert = "Data Supplier Sudah Ada!";
            }
            return response()->json($alert);

            // Tambah Produk Supplier
        } else {

            if ($cekKodeProduk == null) {
                $dataProduk = array(
                    'id_supplier' => $cek->id,
                    'kode' => $kode,
                    'nama_produk' => $request->nama_produk,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'sub_total' => 0,
                    'expired' => $request->expired,
                    'stok' => $stok,
                    'produk_supplier_terjual' => 0,
                    'status' => 'supplier',
                );
                Produk::create($dataProduk);

                $dataSupplierNew = array(
                    'tanggal' => $tanggal
                );
                Supplier::where('id', $cek->id)->update($dataSupplierNew);
                return response()->json($alert);
            } else {
                $alert = "Data Produk Sudah Ada!";
                return response()->json($alert);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cek_id = $id;
        $data = [
            'supplier' => Supplier::find($id),
            'produkSupplier' => Produk::where('id_supplier', $cek_id)->get(),
        ];

        if ($data['produkSupplier']->count() > 1) {
            $class = "vertical-align: middle;";
        } else {
            $class = "";
        }
        return view('owner.supplier.data-supplier.tabel.detailProdukSupplier', compact('data', 'class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Supplier::find($id);
        return view('owner.supplier.data-supplier.form.edit', compact('data'));
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

        // UPDATE SUPPLIER
        if ($request->id != 00) {
            $dataSupplier = array(
                'nama_supplier' => $request->nama_supplier,
                'no_wa' => $request->no_wa,
                'keterangan' => $request->keterangan,
            );
            Supplier::find($id)->update($dataSupplier);

            return response()->json();

            // UPDATE PRODUK SUPPLIER
        } else {

            $dataProduk = array(
                'kode' => $request->kode,
                'nama_produk' => $request->nama_produk,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'expired' => $request->expired,
                'stok' => $request->stok,
            );
            Produk::where('id', $id)->update($dataProduk);

            return response()->json();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Produk::with('supplier')->where('id', $id)->first();
        Produk::find($id)->delete();

        return redirect()->to('supplier/data-produk/' . $data->supplier->nama_supplier);
    }

    public function tabelSupplier($status)
    {
        if ($status == "tanpa-filter") {
            $data = Supplier::where('status', 1)->OrderByDesc('id')->get();
        } else {
            $data = Supplier::where('status', 0)->OrderByDesc('id')->get();
        }
        return view('owner.supplier.data-supplier.tabel.supplier', compact('data'));
    }

    public function status($id, $status)
    {
        $dataSupplier = array(
            'status' => $status,
        );
        Supplier::where('id', $id)->update($dataSupplier);

        $produk = Produk::where('id_supplier', $id)->get();
        if ($status == 0) {
            foreach ($produk as $key => $value) {
                Produk::where('id', $value->id)->update([
                    'status' => 0,
                ]);
            }
        } else {
            foreach ($produk as $key => $value) {
                Produk::where('id', $value->id)->update([
                    'status' => "supplier",
                ]);
            }
        }

        return response()->json();
    }

    public function indexProduk($nama)
    {
        $supplier = Supplier::where('nama_supplier', $nama)->first();
        $data = [
            'title' => "Data Produk Supplier",
            'toko' => Toko::first(),
            'supplierProduk' => Produk::where('id_supplier', $supplier->id)->OrderByDesc('id')->get(),
            'supplierProdukStok' => Produk::where([['id_supplier', '=', $supplier->id], ['stok', '>', 0]])->OrderByDesc('id')->get(),
            'id' => $supplier->id,
            'hari_down' => Carbon::now()->translatedFormat('l, d F Y')
        ];

        $nama = Str::replace('.', '', $supplier->nama_supplier);
        return view('owner.supplier.data-produk-supplier.index', compact('data', 'nama'));
    }

    public function tabelProdukSupplier($id)
    {
        $data = Produk::where('id_supplier', $id)->OrderByDesc('id')->get();

        return view('owner.supplier.data-produk-supplier.tabel.produkSupplier', compact('data'));
    }

    public function createProdukSupplier($id)
    {
        return view('owner.supplier.data-produk-supplier.form.tambah', compact('id'));
    }

    public function historyPembayaran($id)
    {
        $data = PembayaranSupplier::with('supplier')->where('id_supplier', $id)->get();

        return view('owner.supplier.data-produk-supplier.tabel.historyPembayaran', compact('data'));
    }

    public function totalPembayaran($id, $id_supplier)
    {
        $produkSupplier = Produk::find($id);
        PembayaranSupplier::create([
            'id_supplier' =>  $produkSupplier->id_supplier,
            'nama_produk_supplier' => $produkSupplier->nama_produk,
            'total_penjualan' => $produkSupplier->produk_supplier_terjual,
            'total_pembayaran' => $produkSupplier->sub_total,
            'tanggal' => date('Y-m-d')
        ]);
        $supplier = Supplier::find($id_supplier);
        $total_pembayaran = $supplier->total_pembayaran - $produkSupplier->sub_total;
        $supplier->update(['total_pembayaran' => $total_pembayaran]);

        $produkSupplier->update([
            'produk_supplier_terjual' => 0,
            'sub_total' => 0
        ]);
        $cekProdukSupplier = Produk::where('id_supplier', $id_supplier)->get();

        if ($cekProdukSupplier->sum('sub_total') == 0) {
            $supplier->update(['total_pembayaran' => 0]);
        }

        return response()->json();
    }

    public function editProdukSupplier($id)
    {
        $data = Produk::find($id);

        return view('owner.supplier.data-produk-supplier.form.edit', compact('data'));
    }
}
