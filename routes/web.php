<?php

use App\Exports\ProdukExport;
use App\Exports\SupplierExport;
use App\Imports\ProdukImport;
use App\Imports\SupplierImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('index-login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'checkrole:1']], function () {

  //DASHBOARD   
  Route::get('dashboard/chart/{tanggal}', [App\Http\Controllers\Owner\DashboardController::class, 'chart']);
  Route::resource('dashboard', App\Http\Controllers\Owner\DashboardController::class, ['names' => 'dashboard']);

  // LAPORAN
  Route::get('laporan/tabel-laporan', [App\Http\Controllers\Owner\LaporanController::class, 'tabelLaporan'])->name('tabel-laporan');
  Route::post('laporan/tabel-laporan-pencarian', [App\Http\Controllers\Owner\LaporanController::class, 'tabelLaporanPencarian'])->name('tabel-laporan-pencarian');
  Route::get('laporan/keuntungan/{tanggal}/{pembayaran}/{cek}', [App\Http\Controllers\Owner\LaporanController::class, 'keuntungan']);
  Route::get('laporan/detail-pendapatan-keuntungan/{status}/{id_invoice}/{cek_pembayaran}/{cek_tanggal}/{klik_apa}', [App\Http\Controllers\Owner\LaporanController::class, 'detailPendapatanKeuntungan']);
  Route::get('laporan/detail-bank/{data_bank}/{status}', [App\Http\Controllers\Owner\LaporanController::class, 'detailBank']);
  Route::get('laporan/tabel-excel/{id_invoice}/{data_pendapatan}/{bri_id}/{bpd_id}', [App\Http\Controllers\Owner\LaporanController::class, 'tabelExcel']);
  Route::get('laporan/info-laporan/{id}/{status}', [App\Http\Controllers\Owner\LaporanController::class, 'infoLaporan']);
  Route::resource('laporan', App\Http\Controllers\Owner\LaporanController::class, ['names' => 'laporan']);
});

Route::group(['middleware' => ['auth', 'checkrole:2']], function () {

  // KASIR
  Route::get('kasir/change-value/{kode}', [App\Http\Controllers\Kasir\TransaksiController::class, 'changeValue'])->name('change-value');
  Route::get('kasir/hapus-produk/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'destroy'])->name('hapus-produk');
  Route::get('kasir/index-transaksi/{status}', [App\Http\Controllers\Kasir\TransaksiController::class, 'indexTransaksi'])->name('index-transaksi');
  Route::get('kasir/index-print/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'print']);
  Route::post('kasir/pembayaran-transaksi', [App\Http\Controllers\Kasir\TransaksiController::class, 'pembayaranTransaksi'])->name('pembayaran-transaksi');
  Route::get('kasir/index-history', [App\Http\Controllers\Kasir\TransaksiController::class, 'indexHistory'])->name('index-history');
  Route::post('kasir/index-history-filter', [App\Http\Controllers\Kasir\TransaksiController::class, 'filterHistory'])->name('filter-history');
  Route::get('kasir/data-stok', [App\Http\Controllers\Kasir\TransaksiController::class, 'dataStok'])->name('data-stok');
  Route::get('kasir/disable-alert', [App\Http\Controllers\Kasir\TransaksiController::class, 'disableAlert'])->name('disable-alert');

  Route::resource('kasir', App\Http\Controllers\Kasir\TransaksiController::class, ['names' => 'kasir']);

  Route::resource('keranjang', App\Http\Controllers\Kasir\KeranjangController::class, ['names' => 'keranjang']);
  Route::get('keranjang/hapus/{id}', [App\Http\Controllers\Kasir\KeranjangController::class, 'destroy']);
});

Route::group(['middleware' => ['auth', 'checkrole:1,2']], function () {
  Route::post('profile/update-shop/{id}', [App\Http\Controllers\ProfileController::class, 'updateShop'])->name('update-shop');
  Route::resource('profile', App\Http\Controllers\ProfileController::class, ['names' => 'profile']);

  // PRODUK
  Route::get('export-csv-produk', function () {
    return Excel::download(new ProdukExport, 'Data Produk CSV' . Carbon::now()->translatedFormat('l, d F Y') . '.csv');
  });
  Route::post('import-produk', function () {
    Excel::import(new ProdukImport, request()->file('file'));
    return redirect()->back();
  });
  Route::get('produk/tabel-produk/{status}', [App\Http\Controllers\Owner\ProdukController::class, 'tabelProduk']);
  Route::get('produk/tabel-keterangan/{status}', [App\Http\Controllers\Owner\ProdukController::class, 'tabelKeterangan']);
  Route::get('produk/hapus/{id}', [App\Http\Controllers\Owner\ProdukController::class, 'destroy']);
  Route::resource('produk', App\Http\Controllers\Owner\ProdukController::class, ['names' => 'produk']);

  //SUPPLIER
  Route::get('export-csv-supplier', function () {
    return Excel::download(new SupplierExport, 'Data-Supplier-CSV ' . Carbon::now()->translatedFormat('l, d F Y') . '.csv');
  });
  Route::post('import-supplier', function () {
    Excel::import(new SupplierImport, request()->file('file'));
    return redirect()->back();
  });
  Route::get('supplier/status/{id}{status}', [App\Http\Controllers\Owner\SupplierController::class, 'status']);
  Route::get('supplier/tabel-supplier/{status}', [App\Http\Controllers\Owner\SupplierController::class, 'tabelSupplier']);

  Route::get('supplier/data-produk/{nama}', [App\Http\Controllers\Owner\SupplierController::class, 'indexProduk'])->name('index-produk');
  Route::get('supplier/tabel-produk-supplier/{id}', [App\Http\Controllers\Owner\SupplierController::class, 'tabelProdukSupplier']);
  Route::get('supplier/create-produk-supplier/{id}', [App\Http\Controllers\Owner\SupplierController::class, 'createProdukSupplier'])->name('produk-supplier.create');
  Route::get('supplier/edit-produk-supplier/{id}', [App\Http\Controllers\Owner\SupplierController::class, 'editProdukSupplier'])->name('produk-supplier.edit');
  Route::get('supplier/history-pembayaran-supplier/{id}', [App\Http\Controllers\Owner\SupplierController::class, 'historyPembayaran'])->name('history-pembayaran-supplier');
  Route::get('supplier/total-pembayaran/{id}/{id_supplier}', [App\Http\Controllers\Owner\SupplierController::class, 'totalPembayaran']);
  Route::get('supplier/hapus/{id}', [App\Http\Controllers\Owner\SupplierController::class, 'destroy']);

  Route::resource('supplier', App\Http\Controllers\Owner\SupplierController::class, ['names' => 'supplier']);
});
