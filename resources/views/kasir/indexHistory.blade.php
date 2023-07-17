@extends('layouts.app')
@section('container.isi')
@section('active_history', 'active')
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <form id="form_filter" method="POST">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="tanggal_pertama" class="form-label">Tanggal Pertama</label>
                    <input type="date" class="form-control date" id="tanggal_pertama" name="tanggal_pertama"
                        onchange="FilterTanggal('tanggal_pertama')" data-date-format="DD/MM/YYYY"
                        style="height: 2.2rem !important; width: 130% !important; margin: 1 !important;" required>
                </div>
                <div class="mb-3 ml-2 col-md-4">
                    <label for="tanggal_kedua" class="form-label">Tanggal Kedua</label>
                    <input type="date" class="form-control date" id="tanggal_kedua" name="tanggal_kedua"
                        onchange="FilterTanggal('tanggal_kedua')" data-date-format="DD/MM/YYYY"
                        style="height: 2.2rem !important;  width: 130% !important;" required>
                </div>
                <div class="col-md-1 ml-2" style="margin-top: 7.1%;">
                    <button type="button" class="btn btn-danger" id="btn_x" onclick="location.reload();"
                        disabled>X</button>
                </div>
                <div class="col-md-1 ml-2" style="margin-top: 7.1%;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="filter_history">
                    <table id="DataTable" class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Qty</th>
                                <th style="width: 40rem !important;">Sub Total</th>
                                <th style="width: 40rem !important;">Pembayaran Cash</th>
                                <th style="width: 40rem !important;">Pembayaran Transfer</th>
                                <th style="width: 40rem !important;">Kembalian</th>
                                <th style="width: 40rem !important;">Tanggal</th>
                                <th style="width: 1rem !important;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['history'] as $num => $value)
                                <tr>
                                    <td>{{ $num + 1 }}</td>
                                    <td class="text-left">{{ $value->invoice }}</td>
                                    <td>{{ $value->qty }}</td>
                                    <td class="text-right">@currency2($value->sub_total)</td>
                                    <td class="text-right">@currency2($value->pembayaran)</td>
                                    <td class="text-right">@currency2($value->pembayaran_transfer)</td>
                                    <td class="text-right">@currency2($value->kembalian)</td>
                                    <td>{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-icon btn-info"
                                            onclick="doPrint({{ $value->id }})" title="Klik Untuk Print Struk!">
                                            <i class="fa fa-print"></i>
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
@section('container.js')
    <script>
        $('#DataTable').DataTable({
            "pageLength": 10,
            language: {
                url: "{{ asset('/DataTables/bahasa.json') }}"
            }
        });

        function doPrint(id) {

            location.href = "{{ url('kasir/index-print') }}/" + id;
        }

        $("#form_filter").submit(function(e) {
            e.preventDefault();
            let fd = new FormData(this);

            $.ajax({
                url: "{{ route('filter-history') }}",
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    document.getElementById("btn_x").disabled = false;
                    $('#filter_history').html('');
                    $('#filter_history').html(response);
                }
            });
        });

        $(".date").on("change", function() {
            if (this.value) {
                this.setAttribute(
                    "data-date",
                    moment(this.value, "YYYY-MM-DD")
                    .format(this.getAttribute("data-date-format"))
                )
            } else {
                $(this).attr('data-date', 'dd/mm/yyyy');

            }
        }).trigger("change")
    </script>
@endsection
@endsection
