<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Laporan;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $tahun_bulan = [
            'tahun' => $tahun,
            'bulan' => Carbon::now()->translatedFormat('F')
        ];
        $data = [
            'title' => "Laporan",
            'toko' => Toko::first(),
            'laporan' => Laporan::with('invoice')->whereRelation('invoice', function ($query) use ($tahun, $bulan) {
                $query->whereNot('status', ["belum-lunas"])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun);
            })->get(),
            'total_tf_bri' => Invoice::whereNot('status', ["belum-lunas"])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun)->where('bank_tujuan', "BANK BRI")->get(),
            'total_tf_bpd' => Invoice::whereNot('status', ["belum-lunas"])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun)->where('bank_tujuan', "BANK BPD")->get(),
            'hari' => Carbon::now()->translatedFormat('l, d F Y')

        ];

        $pendapatan = $data['laporan']->sum('sub_total');
        $keuntungan = $data['laporan']->sum('total_keuntungan');
        if ($data['laporan']->sum('total_keuntungan') == 0) {
            $keuntungan = 0;
        }
        if ($data['laporan']->count() > 0) {

            foreach ($data['laporan'] as $key => $value) {
                $cek_id_invoice[] = $value->id_invoice;
            }

            $data_id_invoice = implode(', ', array_values(array_unique($cek_id_invoice)));
        } else {
            $data_id_invoice = 0;
        }

        if ($data['total_tf_bri']->count() == 0) {
            $data_bri = 0;
        } else {
            foreach ($data['total_tf_bri'] as $key => $value) {
                $data_bri[] = $value->id;
            }
            $data_bri = implode(', ', $data_bri);
        }

        if ($data['total_tf_bpd']->count() == 0) {
            $data_bpd = 0;
        } else {
            foreach ($data['total_tf_bpd'] as $key => $value) {
                $data_bpd[] = $value->id;
            }
            $data_bpd = implode(', ', $data_bpd);
        }


        $data_bank = [
            'bri' => $data_bri,
            'bpd' => $data_bpd
        ];

        return view('owner.laporan.index', compact('data', 'keuntungan', 'tahun', 'pendapatan', 'tahun_bulan', 'data_id_invoice', 'data_bank'));
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

    public function tabelLaporan()
    {
        $data = Invoice::whereNotIn('status', ["belum-lunas"])->whereMonth('tanggal', '=', date('m'))->whereYear('tanggal', '=', date('Y'))->OrderByDesc('tanggal')->OrderByDesc('id')->get();

        return view('owner.laporan.tabel.laporan', compact('data'));
    }

    public function tabelLaporanPencarian(Request $request)
    {
        $tanggal_pertama = $request->tanggal_pertama;
        $tanggal_kedua = $request->tanggal_kedua;
        $cekPembayaran = explode(" ", $request->pembayaran);
        $cekData = $request->cek;
        $tahun = date('Y');
        $bulan = date('m');

        if ($cekData == "tanggal saja") {

            $data = Invoice::whereNot('status', "belum-lunas")->whereBetween('tanggal', [$tanggal_pertama, $tanggal_kedua])->OrderByDesc('tanggal')->get();
        } elseif ($cekData == "status saja") {

            if ($cekPembayaran[0] == 1) {

                $data = Invoice::whereNot('status', "belum-lunas")->where(['status' => $cekPembayaran[1]])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun)->get();
            } elseif ($cekPembayaran[0] == 2) {

                $data = Invoice::whereNot('status', "belum-lunas")->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2]])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun)->get();
            } elseif ($cekPembayaran[0] == 3) {

                $data = Invoice::whereNot('status', "belum-lunas")->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2], $cekPembayaran[3]])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun)->get();
            }
        } elseif ($cekData == "tanggal dan status") {
            if ($cekPembayaran[0] == 1) {

                $data = Invoice::whereNot('status', "belum-lunas")->where(['status' => $cekPembayaran[1]])->whereBetween('tanggal', [$tanggal_pertama, $tanggal_kedua])->get();
            } elseif ($cekPembayaran[0] == 2) {

                $data = Invoice::whereNot('status', "belum-lunas")->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2]])->whereBetween('tanggal', [$tanggal_pertama, $tanggal_kedua])->get();
            } elseif ($cekPembayaran[0] == 3) {

                $data = Invoice::whereNot('status', "belum-lunas")->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2], $cekPembayaran[3]])->whereBetween('tanggal', [$tanggal_pertama, $tanggal_kedua])->get();
            }
        }

        return view('owner.laporan.tabel.laporan', compact('data'));
    }

    public function keuntungan($tanggal, $pembayaran, $cek)
    {
        $rangeTanggal = explode(" ", $tanggal);
        $cekPembayaran = explode(" ", $pembayaran);
        $cekData = $cek;
        $tahun = date('Y');
        $bulan = date('m');
        $cek_pengeluaran = 'tanggal';

        if ($cekData == 'tanggal saja') {
            $data = Laporan::with('invoice')->whereRelation('invoice', function ($query) use ($rangeTanggal) {
                $query->whereBetween('tanggal', [$rangeTanggal[0], $rangeTanggal[1]]);
            })->get();
        } elseif ($cekData == 'status saja') {
            if ($cekPembayaran[0] == 1) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($tahun, $bulan) {
                        $query->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun);
                    })
                    ->whereRelation('invoice', ['status' => $cekPembayaran[1]])->get();
            } elseif ($cekPembayaran[0] == 2) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($tahun, $bulan, $cekPembayaran) {
                        $query->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2]])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun);
                    })->get();
            } elseif ($cekPembayaran[0] == 3) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($tahun, $bulan, $cekPembayaran) {
                        $query->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2], $cekPembayaran[3]])->whereMonth('tanggal', '=', $bulan)->whereYear('tanggal', '=', $tahun);
                    })->get();
            }

            $cek_pengeluaran = 'status';
        } elseif ($cekData == 'tanggal dan status') {
            if ($cekPembayaran[0] == 1) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($rangeTanggal) {
                        $query->whereNotIn('status', ["belum-lunas"])->whereBetween('tanggal', [$rangeTanggal[0], $rangeTanggal[1]]);
                    })
                    ->whereRelation('invoice', ['status' => $cekPembayaran[1]])->get();
            } elseif ($cekPembayaran[0] == 2) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($rangeTanggal, $cekPembayaran) {
                        $query->whereNotIn('status', ["belum-lunas"])->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2]])->whereBetween('tanggal', [$rangeTanggal[0], $rangeTanggal[1]]);
                    })->get();
            } elseif ($cekPembayaran[0] == 3) {

                $data = Laporan::with('invoice')
                    ->whereRelation('invoice', function ($query) use ($rangeTanggal, $cekPembayaran) {
                        $query->whereNotIn('status', ["belum-lunas"])->whereIn('status', [$cekPembayaran[1], $cekPembayaran[2], $cekPembayaran[3]])->whereBetween('tanggal', [$rangeTanggal[0], $rangeTanggal[1]]);
                    })->get();
            }
        }

        if ($data->count() > 0) {
            foreach ($data as $key => $value) {
                $cek_id_invoice[] = $value->id_invoice;
            }
            $data_id_invoice = implode(', ', array_values(array_unique($cek_id_invoice)));
        } else {
            $data_id_invoice = 0;
        }



        $total_keuntungan = $data->sum('total_keuntungan');
        if ($data->count() == 0) {
            $data_bank_bri = [0];
            $data_bank_bpd = [0];
        } else {

            foreach ($data as $key => $value) {
                $cek_data = Invoice::find($value->id_invoice);

                if ($cek_data->status == "transfer") {
                    # code...
                    if ($cek_data->bank_tujuan == "BANK BRI") {
                        $data_bank_bri[] = $value->id_invoice;
                    } else {
                        $data_bank_bri[] = null;
                    }

                    if ($cek_data->bank_tujuan == "BANK BPD") {
                        $data_bank_bpd[] = $value->id_invoice;
                    } else {
                        $data_bank_bpd[] = null;
                    }
                } else {
                    $data_bank_bri[] = null;
                    $data_bank_bpd[] = null;
                }
            }
            $data_bank_bri = array_values(array_diff($data_bank_bri, [null]));
            $data_bank_bpd = array_values(array_diff($data_bank_bpd, [null]));
        }

        if ($data_bank_bri == null) {
            $data_bank_bri = [0];
        }

        if ($data_bank_bpd == null) {
            $data_bank_bpd = [0];
        }
        // dd(Invoice::whereIn('id', $data_bank_bri)->get()->sum('pembayaran_transfer'));

        $laporan = [
            'pendapatan' => $data->sum('sub_total'),
            'keuntungan' => $total_keuntungan,
            'id_invoice' => $data_id_invoice,
            'cek_pembayaran' => $pembayaran,
            'cek_tanggal' => $tanggal,
            'data_bank_bri' => implode(', ', $data_bank_bri),
            'data_bank_bpd' => implode(', ', $data_bank_bpd),
            'total_bank_bri' => Invoice::whereIn('id', $data_bank_bri)->get()->sum('pembayaran_transfer'),
            'total_bank_bpd' => Invoice::whereIn('id', $data_bank_bpd)->get()->sum('pembayaran_transfer'),
        ];
        return response()->json($laporan);
    }

    public function detailPendapatanKeuntungan($status, $id_invoice, $cek_pembayaran, $cek_tanggal, $klik_apa)
    {
        if ($id_invoice == 0) {
            $data_id_invoice = $id_invoice;
        } else {
            $data_id_invoice = explode(', ', $id_invoice);
        }

        $status_pembayaran = explode(' ', $cek_pembayaran);
        $rangeTanggal = explode(" ", $cek_tanggal);

        $tahun = date('Y');
        $bulan = date('m');
        $id_pendapatan_invoice = [0];
        $id_pendapatan_bill = [0];
        if ($status == "pendapatan") {

            if ($cek_pembayaran == "kosong") {
                $laporan = Invoice::whereIn('id', $data_id_invoice)->orderBy('tanggal', 'ASC')->get();
                $count_data = $laporan->count();
            } else {
                if ($cek_pembayaran != null) {

                    if ($cek_tanggal == "kosong") {

                        if (array_intersect(['cash', 'transfer'], array_diff($status_pembayaran, [1, 2, 3])) == true) {
                            $laporan = Invoice::whereIn('id', $data_id_invoice)->orderBy('tanggal', 'ASC')->get();
                            $count_data = $laporan->count();
                        } else {
                            $count_data = 0;
                        }
                    } else {
                        if ($cek_pembayaran == "kosong") {
                            $laporan = Invoice::whereIn('id', $data_id_invoice)->orderBy('tanggal', 'ASC')->get();
                            $count_data = $laporan->count();
                        } else {
                            if (array_intersect(['cash', 'transfer'], array_diff($status_pembayaran, [1, 2, 3])) == true) {
                                $laporan = Invoice::whereIn('id', $data_id_invoice)->orderBy('tanggal', 'ASC')->get();
                                $count_data = $laporan->count();
                            } else {
                                $count_data = 0;
                            }
                        }
                    }
                } else {
                    $count_data = 0;
                }
            }

            if ($count_data > 0) {
                foreach ($laporan as $key => $value) {
                    $dataPendapatan[] = [
                        'id_invoice' => $value->id,
                        'invoice' => $value->invoice,
                        'status' => ucwords($value->status),
                        'tanggal' => $value->tanggal,
                        'total' => $value->sub_total
                    ];
                }

                $data = $dataPendapatan;
                if (count($dataPendapatan) > 0) {
                    unset($id_pendapatan_invoice);

                    foreach ($dataPendapatan as $key => $value) {
                        $id_pendapatan_invoice[] = $value['id_invoice'];
                    }
                    $id_pendapatan_invoice = implode(', ',  $id_pendapatan_invoice);
                }
            }


            // dd($id_pendapatan_invoice);
            foreach ($data as $key => $value) {
                $totalPembayaran[] = $value['total'];
            }
            $sub_total = array_sum($totalPembayaran);
            // 
            $data_pengeluaran = [];
        } elseif ($status == "keuntungan") {


            if ($data_id_invoice == 0) {
                $data = [];
            } else {
                $laporan = Invoice::whereIn('id', $data_id_invoice)->get();

                foreach ($laporan as $key => $value) {

                    $laporan = Laporan::where('id_invoice', $value->id)->get();

                    $keuntunganLaporan = $laporan->sum('total_keuntungan');
                    $data[] = [
                        'invoice' => $value->invoice,
                        'tanggal' => $value->tanggal,
                        'total' => $keuntunganLaporan
                    ];
                }
                foreach ($data as $key => $value) {
                    $totalKeuntungan[] = $value['total'];
                }


                $sub_total = array_sum($totalKeuntungan);
            }
            $id_pendapatan_bill = 0;
            $id_pendapatan_invoice = 0;
        }

        // if (count($id_pendapatan_bill) == 0) {
        //     $id_pendapatan_bill = 0;
        // }
        // if (count($id_pendapatan_invoice) == 0) {
        //     $id_pendapatan_invoice = 0;
        // }
        // dd(count($id_pendapatan_bill));
        if ($klik_apa == "tidak") {
            return view('owner.laporan.tabel.detail.pendapatanKeuntungan', compact('data', 'sub_total', 'status', 'id_pendapatan_invoice', 'id_pendapatan_bill'));
        } elseif ($klik_apa == "ya") {
            $data = [
                'id_pendapatan_invoice' => $id_pendapatan_invoice,
            ];

            return response()->json($data);
        }
    }

    public function detailBank($data_bank, $status)
    {
        $bank = explode(", ", $data_bank);
        $data = Invoice::whereIn('id', $bank)->get();
        // dd($data);

        return view('owner.laporan.tabel.detail.bank', compact('data'));
    }

    public function infoLaporan($id, $status)
    {
        if ($status == "laporan") {

            $data = Laporan::with('invoice')->where('id_invoice', $id)->OrderByDesc('tanggal')->get();
            return view('owner.laporan.tabel.detail.info', compact('data'));
        }
    }

    public function tabelExcel($id_invoice,  $data_pendapatan, $bri_id, $bpd_id)
    {
        $tahun = date('Y');
        $bulan = date('m');
        $id_invoice = explode(', ', $id_invoice);
        $id_bri = explode(', ', $bri_id);
        $id_bpd = explode(', ', $bpd_id);
        $invoice = Invoice::whereIn('id', $id_invoice)->get();
        $cek_produk = Laporan::whereIn('id_invoice', $id_invoice)->get();

        $bri = Invoice::whereIn('id', $id_bri)->get();
        $bpd = Invoice::whereIn('id', $id_bpd)->get();

        if ($invoice->count() == 0) {
            $data = [];
            $total = [
                'qty' => '',
                'sub_total' => '',
                'pembayaran' => '',
                'pembayaran_transfer' => '',
                'kembalian' => '',
                'harga_jual' => '',
                'keuntungan_per_item' => '',
                'total_keuntungan' => '',
                'qty_produk' => '',
                'sub_total_produk' => '',
            ];
        } else {

            foreach ($invoice as $key => $value) {
                $produk = Laporan::where('id_invoice', $value->id)->get();
                $data[] = [
                    'invoice' => $value->invoice,
                    'qty' => $value->qty,
                    'sub_total' => $value->sub_total,
                    'pembayaran_cash' => $value->pembayaran,
                    'pembayaran_transfer' => $value->pembayaran_transfer,
                    'kembalian' => $value->kembalian,
                    'tanggal' => $value->tanggal,
                    'status' => $value->status,
                    'total_keuntungan' => $produk->sum('total_keuntungan'),
                    'produk' => $produk
                ];
            }
            $total_keuntungan = array_sum(array_column($data, 'total_keuntungan'));

            $total = [
                'qty' => $invoice->sum('qty'),
                'sub_total' => $invoice->sum('sub_total'),
                'pembayaran' => $invoice->sum('pembayaran'),
                'pembayaran_transfer' => $invoice->sum('pembayaran_transfer'),
                'kembalian' => $invoice->sum('kembalian'),
                'harga_jual' => $cek_produk->sum('harga_jual'),
                'keuntungan_per_item' => $cek_produk->sum('keuntungan_per_item'),
                'total_keuntungan' => $cek_produk->sum('total_keuntungan'),
                'qty_produk' => $cek_produk->sum('qty'),
                'sub_total_produk' => $cek_produk->sum('sub_total'),
            ];
        }

        $id_pendapatan = $id_invoice;

        $pendapatan = Invoice::whereIn('id', $id_pendapatan)->get();

        foreach ($pendapatan as $key => $value) {
            $dataPendapatan[] = [
                'id_invoice' => $value->id,
                'invoice' => $value->invoice,
                'status' => ucwords($value->status),
                'tanggal' => $value->tanggal,
                'total' => $value->sub_total
            ];
        }
        $angka = 0;

        if ($pendapatan->count() > 0) {
            $data_pendapatan = $dataPendapatan;
        } else {

            $data_pendapatan = [];
        }
        if (count($data_pendapatan) == 0) {

            $total_data_pendapatan = 0;
        } else {

            $total_data_pendapatan = array_sum(array_column($data_pendapatan, 'total'));
        }

        $bank = [
            'bri' => $bri,
            'bpd' => $bpd
        ];


        return view('owner.laporan.tabel.excel', compact('data', 'total', 'data_pendapatan', 'total_data_pendapatan', 'total_keuntungan', 'bank'));
    }
}
