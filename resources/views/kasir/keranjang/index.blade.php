@extends('layouts.app')
@section('container.isi')
@section('active_keranjang', 'active')
<div class="row">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="read">
                    <table id="DataTable" class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['keranjang'] as $num => $value)
                                <tr>
                                    <td>{{ $num + 1 }}</td>
                                    <td class="text-left">{{ $value->kode_produk }}</td>
                                    <td class="text-left">{{ ucwords(strtolower($value->nama_produk)) }}</td>
                                    <td class="text-right">@currency2($value->harga_jual)</td>
                                    <td>{{ $value->qty }}</td>
                                    <td class="text-right">@currency2($value->sub_total)</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-icon btn-danger" data-bs-toggle="tooltip"
                                        title="Klik Untuk Hapus Data" onclick="ModalHapus('keranjang/hapus/{{ $value->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function HapusProduk(link) {
        $.get(link, {}, function(data, status) {
            $('#data_content').load("{{ route('index-transaksi', 'transaksi') }}");
        });
    }
</script>
@endsection

