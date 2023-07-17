<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Laporan;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => "Dashboard",
            'toko' => Toko::first(),
            'total_supplier' => Supplier::where('status', 1)->get()->count(),
            'total_produk' => Produk::where([['stok', '>', 0], ['status', 'LIKE', '%supplier%']])->get()->count(),
            'data_laporan' => Laporan::with('invoice')->whereRelation('invoice', ['tanggal' => date('Y-m-d')])->get(),
            'minggu_sekarang' => Carbon::now()->startOfWeek()->toDateString() . '&' . Carbon::now()->endOfWeek()->toDateString(),
            'minggu_sekarang_ke' => Carbon::now()->startOfWeek()->isoFormat('MMMM Y') .  ' Minggu Ke ' . Carbon::now()->weekNumberInMonth
        ];
        $totalKeuntungan = $data['data_laporan']->sum('total_keuntungan');
        $totalPendapatan = $data['data_laporan']->sum('sub_total');
        $chart = Invoice::get();
        $tanggal_ = [];
        foreach ($chart as $key => $value) {
            $cek_tanggal = Carbon::parse($value->tanggal);
            $tanggal_[] = [
                'minggu_awal' => $cek_tanggal->startOfWeek()->toDateString(),
                'minggu_akhir' => $cek_tanggal->endOfWeek()->toDateString(),
                'minggu_berapa' => $cek_tanggal->isoFormat('MMMM Y') .  ' Minggu Ke ' . $cek_tanggal->weekNumberInMonth
            ];
        }

        if (count($tanggal_) == 0) {
            $tanggal_[] = [
                'minggu_awal' => Carbon::now()->startOfWeek()->toDateString(),
                'minggu_akhir' => Carbon::now()->endOfWeek()->toDateString(),
                'minggu_berapa' => Carbon::now()->isoFormat('MMMM Y') .  ' Minggu Ke ' . Carbon::now()->weekNumberInMonth
            ];
        }
        $tanggal = array_map("unserialize", array_unique(array_map("serialize", $tanggal_)));
        // dd($tanggal[1]['minggu_awal'] . '&' . $tanggal[1]['minggu_akhir'] == $data['minggu_sekarang']);

        return view('owner.dashboard.index', compact("data", "totalKeuntungan", "totalPendapatan", "tanggal"));
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

    public function chart($tanggal)
    {
        $minggu = explode('&', $tanggal);
        if ($minggu[0] == "perminggu") {
            for ($i = 0; $i < 7; $i++) {
                $tanggal_ = Carbon::parse($minggu[1])->addDays($i)->toDateString();
                $invoice = Invoice::where('tanggal', $tanggal_)->get();
                $penjualan[] = $invoice->sum('sub_total');
                $hari[] = Carbon::parse($tanggal_)->isoFormat('dddd');
            }

            $data = [
                'penjualan' => $penjualan,
                'hari' => $hari,
                'title' => $minggu[3]
            ];
        } elseif ($minggu[0] == "perbulan") {

            $tanggal_awal = $minggu[1];
            $tanggal_akhir = $minggu[2];
            $data_penjualan = Invoice::whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir])->distinct()->get('tanggal');

            if ($data_penjualan->count() > 0) {
                foreach ($data_penjualan as $key => $value) {
                    $penjualan[] = Invoice::where('tanggal', $value->tanggal)->get()->sum('sub_total');
                    $hari[] = Carbon::parse($value->tanggal)->isoFormat('DD/MM/YYYY');
                }
                $title = Carbon::parse($tanggal_awal)->isoFormat('DD/MM/YYYY') . ' - ' . Carbon::parse($tanggal_akhir)->isoFormat('DD/MM/YYYY');
            } else {
                $penjualan = [0];
                $hari = ["Data Tidak Ditemukan!"];
                $title = "Tidak Ditemukan!";
            }

            $data = [
                'penjualan' => $penjualan,
                'hari' => $hari,
                'title' => $title
            ];
        }

        return response()->json($data);
    }
}
