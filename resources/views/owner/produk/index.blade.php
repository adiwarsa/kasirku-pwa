@extends('layouts.app')
@section('container.isi')
@section('active_produk', 'active')

<div class="section-body">
    <div class="d-flex mb-4">
        @if (auth()->user()->role == 1)
            <a href="javascript:void(0)" class="btn btn-icon btn-success mt-1" title="Klik 2x Untuk Export Excel!"
                id="button-export-excel">
                <i class="fa fa-file-excel"></i>
            </a>
        @else
            <button class="btn btn-primary mt-1" onclick="ModalTambah('{{ route('produk.create') }}', 'modal-md')">
                Tambah Produk
            </button>
            <div class="dropdown ml-2 mt-1">
                <button class="btn btn-icon btn-danger btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Data Produk &nbsp;
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="export-csv-produk" target="_blank" class=" dropdown-item me-1">Export Data CSV</a>
                    <a href="#" class=" dropdown-item me-1" onclick="ModalImport('import-produk')">Import Data
                        CSV</a>
                    <a href="#" class=" dropdown-item me-1" id="button-export-excel">Export Data To Excel</a>
                </div>
            </div>
        @endif

        <button class="btn btn-info ml-2 mt-1" data-toggle="collapse" data-target="#collapseExample2"
            aria-expanded="false" aria-controls="collapseExample2">&ensp;Keterangan&ensp;</button>
        <button class="btn btn btn-icon btn-danger ml-2 mt-1" id="button_stok" title="Klik Untuk Melihat Stok Minimum!">
            <i class="fas fa-exclamation-triangle"></i>
        </button>
        <input type="checkbox" id="checkbox_stok" style="opacity: 0;">
    </div>
    <div class="collapse" id="collapseExample2">
        <div class="table-responsive" id="data_tabel_keterangan">
        </div>
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
</div>

<div hidden>
    <table id="export-excel" class="table table-bordered table-md">
        <thead>
            <tr>
                <th><b>
                        <center>#</center>
                    </b></th>
                <th><b>
                        <center>Kode</center>
                    </b></th>
                <th><b>
                        <center>Nama</center>
                    </b></th>
                <th><b>
                        <center>Harga Beli</center>
                    </b></th>
                <th><b>
                        <center>Harga Jual</center>
                    </b></th>
                <th><b>
                        <center>Stok</center>
                    </b></th>
                <th><b>
                        <center>Expired</center>
                    </b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['produk'] as $num => $value)
                <tr>
                    <td>{{ $num + 1 }}</td>
                    <td>'{{ $value->kode }}</td>
                    <td>{{ $value->nama_produk }}</td>
                    <td>{{ $value->harga_beli }}</td>
                    <td>{{ $value->harga_jual }}</td>
                    <td>
                        {{ $value->stok }}
                    </td>
                    @if ($value->expired == null)
                        <td>----------------</td>
                    @else
                        <td>{{ Carbon\Carbon::parse($value->expired)->isoFormat('DD-MM-YYYY') }}</td>
                    @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="3" id="total_excel">
                    Total
                </td>
                <td>{{ $data['produk']->sum('harga_beli') }}</td>
                <td>{{ $data['produk']->sum('harga_jual') }}</td>
                <td>{{ $data['total_stok']->sum('stok') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
<input type="hidden" id="hari_down" value="{{ $data['hari'] }}">
@section('container.js')

    <script>
        $(document).ready(function() {


            const queryString = window.location.search;
            if (queryString == "?updateStok") {
                $('#button_stok').click();
                tabelProdukStok();
                tabelKeteranganFilter();
                document.getElementById("checkbox_stok").checked = true;
            } else {
                tabelProduk();
                tabelKeterangan();
            }

            window.history.pushState({}, document.title, "/" + "produk");

        });

        // Read Data Produk
        function tabelProduk() {
            $.get("{{ url('produk/tabel-produk') }}/tanpa-filter", {}, function(data, status) {
                $("#data_tabel").html(data);
            });
        };

        function tabelProdukStok() {
            $.get("{{ url('produk/tabel-produk') }}/stok", {}, function(data, status) {
                $("#data_tabel").html(data);
            });
        };

        function tabelKeterangan() {
            $.get("{{ url('produk/tabel-keterangan') }}/tanpa-filter", {}, function(data, status) {
                $("#data_tabel_keterangan").html(data);
            });
        };

        function tabelKeteranganFilter() {
            $.get("{{ url('produk/tabel-keterangan') }}/filter", {}, function(data, status) {
                $("#data_tabel_keterangan").html(data);
            });
        };
        $('#button_stok').click(function() {

            var x = document.getElementById("checkbox_stok").checked;
            var CheckedClass = document.getElementById("button_stok");

            if (x == true) {

                document.getElementById("checkbox_stok").checked = false;

            } else {

                document.getElementById("checkbox_stok").checked = true;

            }

            var el = CheckedClass;
            var par = el.parentNode;
            var next = el.nextSibling;
            par.removeChild(el);
            setTimeout(function() {
                par.insertBefore(el, next);
            }, 0)

            var y = document.getElementById("checkbox_stok").checked;
            if (y == true) {
                CheckedClass.classList.add("checked-class2");
                tabelProdukStok();

                tabelKeteranganFilter();
            } else {
                CheckedClass.classList.remove("checked-class2");
                tabelProduk();
                tabelKeterangan();

            }
        });

        $(function() {

            $("#button-export-excel").click(function() {
                $("#export-excel").table2excel({
                    // exclude CSS class
                    // exclude: ".centerrr",
                    sheetName: "Sheet",
                    filename: "Data Produk " + $('#hari_down').val(), //do not include extension
                    fileext: ".xls", // file extension
                    preserveColors: true

                });
            });
        });
    </script>
@endsection
@endsection
