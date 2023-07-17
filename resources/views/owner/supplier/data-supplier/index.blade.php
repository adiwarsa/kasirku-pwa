@extends('layouts.app')
@section('container.isi')
@section('active_supplier', 'active')

@section('container.css')
    <style>
        .btn-aktif {
            padding: 3px 7px !important;
            border-radius: 2px !important;
            font-size: 0.613rem !important;
            width: 90px !important;
            margin: 0 auto !important;
            background-color: #e8fadf !important;
            color: #71dd37 !important;
            height: 20px !important;
            line-height: normal;
            text-transform: uppercase;
            font-family: 'Neuton_Reguler' !important;
        }

        .btn-tidak-aktif {
            padding: 3px 7px !important;
            border-radius: 2px !important;
            font-size: 0.613rem !important;
            width: 90px !important;
            margin: 0 auto !important;
            background-color: #ffe0db !important;
            color: #ff3e1d !important;
            height: 20px !important;
            line-height: normal;
            text-transform: uppercase;
            font-family: 'Neuton_Reguler' !important;
        }
    </style>
@endsection

<div class="section-body">
    <div class="mb-3">
        @if (auth()->user()->role == 2)
            <button class="btn btn-primary" onclick="ModalTambah('{{ route('supplier.create') }}', 'modal-lg')">Tambah
                Supplier</button>&ensp;
        @endif
        <button class="btn btn-info" id="button_supplier_Tidak_Aktif">Supplier Tidak Aktif</button>
        <input type="checkbox" id="checkbox_supplier_Tidak_Aktif" style="opacity: 0;">
    </div>
    @if (auth()->user()->role == 2)
        <div class="dropdown mb-4">
            <button class="btn btn-icon btn-danger btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Data Supplier
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="export-csv-supplier" target="_blank" class=" dropdown-item me-1">Export Data CSV</a>
                <a href="javascript:void(0)" class=" dropdown-item me-1" onclick="ModalImport('import-supplier')">Import
                    Data
                    CSV</a>
            </div>
        </div>
    @endif

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


@section('container.js')
    <script>
        $(document).ready(function() {

            tabelSupplier();

        });

        function tabelSupplier() {
            $.get("{{ url('supplier/tabel-supplier') }}/tanpa-filter", {}, function(data, status) {
                $("#data_tabel").html(data);
            });
        };

        function tabelSupplierTidakAktif() {
            $.get("{{ url('supplier/tabel-supplier') }}/filter", {}, function(data, status) {
                $("#data_tabel").html(data);
            });
        }

        $('#button_supplier_Tidak_Aktif').click(function() {

            var x = document.getElementById("checkbox_supplier_Tidak_Aktif").checked;
            var CheckedClass = document.getElementById("button_supplier_Tidak_Aktif");

            if (x == true) {

                document.getElementById("checkbox_supplier_Tidak_Aktif").checked = false;

            } else {

                document.getElementById("checkbox_supplier_Tidak_Aktif").checked = true;

            }

            var el = CheckedClass;
            var par = el.parentNode;
            var next = el.nextSibling;
            par.removeChild(el);
            setTimeout(function() {
                par.insertBefore(el, next);
            }, 0)

            var y = document.getElementById("checkbox_supplier_Tidak_Aktif").checked;
            if (y == true) {
                CheckedClass.classList.add("checked-class");
                tabelSupplierTidakAktif();

            } else {
                CheckedClass.classList.remove("checked-class");
                tabelSupplier();

            }
        });

        function status(id, status) {
            var y = document.getElementById("checkbox_supplier_Tidak_Aktif").checked;
            $.get("{{ url('supplier/status') }}/" + id + status, {}, function(data, status) {
                if (y == true) {
                    tabelSupplierTidakAktif();
                } else {
                    tabelSupplier();
                }
            });
        }

        function noWa(value) {
            var data = value.replaceAll('-', '');

            if (value < 0) {
                $('#no_wa').val(data);
            }

            $('#no_wa').focus();

        }
    </script>

@endsection
@endsection
