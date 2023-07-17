@extends('layouts.app')
@section('container.isi')
@section('active_supplier', 'active')
<div class="section-body">
    <div class="mb-3">
        <a href="{{ route('supplier.index') }}" class="btn btn-icon btn-danger"><i class="fas fa-arrow-left"></i></a>&ensp;
        @if (auth()->user()->role == 2)
            <button class="btn btn-primary"
                onclick="ModalTambah('{{ route('produk-supplier.create', $data['id']) }}', 'modal-lg')">Tambah
                Produk
                Supplier
            </button>
        @endif
        <button class="btn btn-info" value="{{ $data['id'] }}"
            onclick="ModalInfo('{{ route('history-pembayaran-supplier', $data['id']) }}', 'History Pembayaran Supplier', 'modal-xl')">History
            Pembayaran</button>
        @if ($data['supplierProduk']->count() > 0)
            <a href="javascript:void(0)" class="btn btn-icon btn-success" title="Klik Untuk Export Excel!"
                id="button-export-excel-supplier">
                <i class="fa fa-file-excel"></i>
            </a>
        @endif
    </div>
    <div class="row">
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="data_tabel">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div hidden>
        <table id="export-excel-supplier" class="table table-bordered table-md">
            <thead>
                <tr>
                    <th colspan="9" style="background-color: aqua !important;">
                        <b>
                            @if ($data['supplierProduk']->count() > 0)
                                <center>{{ $data['supplierProduk'][0]->supplier->nama_supplier }}</center>
                            @endif
                        </b>
                    </th>
                </tr>
                <tr>
                    <th><b>
                            <center>#
                        </b></center>
                    </th>
                    <th><b>
                            <center>Kode Produk
                        </b></center>
                    </th>
                    <th><b>
                            <center>Nama Produk
                        </b></center>
                    </th>
                    <th><b>
                            <center>Harga Beli
                        </b></center>
                    </th>
                    <th><b>
                            <center>Harga Jual
                        </b></center>
                    </th>
                    <th><b>
                            <center>Stok
                        </b></center>
                    </th>
                    <th><b>
                            <center>Produk Terjual
                        </b></center>
                    </th>
                    <th><b>
                            <center>Total
                        </b></center>
                    </th>
                    <th><b>
                            <center>Expired
                        </b></center>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['supplierProduk'] as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $value->kode }}</td>
                        <td>{{ $value->nama_produk }}</td>
                        <td>{{ $value->harga_beli }}</td>
                        <td>{{ $value->harga_jual }}</td>
                        <td>{{ $value->stok }}</td>
                        <td>{{ $value->produk_supplier_terjual }}</td>
                        <td>{{ $value->sub_total }}</td>
                        <td>{{ Carbon\Carbon::parse($value->expired)->isoFormat('DD-MM-YYYY') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Total</td>
                    <td>{{ $data['supplierProduk']->sum('harga_beli') }}</td>
                    <td>{{ $data['supplierProduk']->sum('harga_jual') }}</td>
                    <td>{{ $data['supplierProdukStok']->sum('stok') }}</td>
                    <td>{{ $data['supplierProduk']->sum('produk_supplier_terjual') }}</td>
                    <td>{{ $data['supplierProduk']->sum('sub_total') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" id="hari-down" value="{{ $data['hari_down'] }}">
<input type="hidden" id="nama_supplier" value="{{ $nama }}">
<input type="hidden" id="id_supplier" value="{{ $data['id'] }}">

@section('container.js')
    <script>
        $(document).ready(function() {

            tabelProdukSupplier();

        });

        function tabelProdukSupplier() {
            $.get("{{ url('supplier/tabel-produk-supplier') }}/" + $('#id_supplier').val(), {}, function(data, status) {
                $("#data_tabel").html(data);
            });
        };

        $(function() {

            $("#button-export-excel-supplier").click(function() {
                $("#export-excel-supplier").table2excel({
                    // exclude CSS class
                    // exclude: ".centerrr",
                    sheetName: "Sheet",
                    filename: "Data Produk Supplier " + $('#nama_supplier').val() + " " + $(
                            '#hari-down')
                        .val(), //do not include extension
                    fileext: ".xls", // file extension
                    preserveColors: true

                });
            });

        });

        function pembayaranSupplier(id, supplier_id) {

            $("#data_info").html("Yakin Ingin Membayar Produk Supplier!?");
            var modal = $("#modalInfo").modal({
                show: true,
                backdrop: 'static',
            });
            modal.find('.modal-title').text('PemBayaran Supplier!!!');
            modal.find('.modal-dialog').removeClass("modal-xl")
            modal.find('.modal-dialog').addClass('modal-md');
            modal.find('#footer').addClass('modal-footer');
            modal.find('#footer').html(
                '<a href="javascript:void(0)" type="submit" class="btn btn-warning" id="bayar-supplier">Ya!</a><button type="button" class="btn btn-secondary btn-close" id="btn-close" data-bs-dismiss="modal">Tidak</button>'
            );
            $('#bayar-supplier').click(function(e) {
                $.get("{{ url('supplier/total-pembayaran') }}/" + id + "/" + supplier_id, {}, function(data,
                    status) {
                    location.reload();
                    tabelSupplier();
                });

            });
            $('.btn-close').click(function(e) {
                $("#modalInfo").modal('hide');
                modal.find('#footer').removeClass('modal-footer');
                modal.find('#footer').html('');
            });
        }
    </script>
@endsection
@endsection
