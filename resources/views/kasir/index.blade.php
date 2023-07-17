@extends('layouts.app')
@section('container.isi')
@section('active_trans', 'active')

@section('container.css')
    <style>
        .bg-purple {
            background-color: #6777ef;
            border-radius: 0.25rem;
        }

        .btnScan {
            width: 50px;
        }

        .shortcut {
            display: flex;
            flex-direction: row;
            align-content: space-around;
        }

        @media (min-width: 167px) and (max-width: 575px) {
            .shortcut {
                flex-direction: column !important;
            }

            .marginTop {
                margin-top: 1em;
            }

            .diHP {
                display: none;
            }
        }
    </style>
@endsection
<div id="data_content"></div>
<input type="hidden" id="stok_sedikit" value="{{ $data['stok_produk'] }}">
@section('container.js')
    <!-- Modal Scan-->
    <div class="modal fade" id="modalScan" tabindex="-1" aria-labelledby="modalScan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScanLabel">Scanner</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa fa-times"></i></button>
                </div>
                <div class="modal-body" id="showScan">
                    <div id="reader" width="600px"></div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#data_content').load("{{ route('index-transaksi', 'transaksi') }}");

            if ("{{ session('alert_produk') }}" == 'aktif') {
                if ($('#stok_sedikit').val() > 0) {
                    $.get("{{ route('data-stok') }}", {}, function(data, status) {
                        $("#data_info").html(data);
                        var modal = $("#modalInfo").modal('show');
                        modal.find('.modal-title').text("Peringatan!, Data Produk Hampir Habis!");
                        modal.find('.modal-dialog').addClass('modal-md');
                    });
                    $('.btn-close').click(function(e) {
                        $("#modalInfo").modal('hide');

                    });
                }
            }
        });

        function updateStok() {
            window.location.href = "{{ route('produk.index') }}" + "?updateStok";
        }

        function disableAlert() {
            $.get("{{ route('disable-alert') }}", {}, function(data, status) {
                location.reload();
            });

        }
        $('#modalInfo').on('hidden.bs.modal', function() {
            $('#kode').trigger('focus')
        })
    </script>
@endsection
@endsection
