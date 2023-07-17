<style>
    .detail-pendapatan-keuntungan th {
        background-color: darkgray !important;
    }

    .data2 td {
        border-top: 5px solid black;
        text-align: right;
    }

    .border td {
        border-top: 2px solid black;
        text-align: center;
        color: red !important;
    }

    .border2 td {
        border-top: 2px solid black;

    }

    .detail-pendapatan-keuntungan {
        color: white;
    }
</style>
<div class="table-responsive" style="background-color: darkgray;">
    <table class="table table-bordered detail-pendapatan-keuntungan">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pemilik Bank</th>
                <th>Jenis Bank</th>
                <th>Tanggal</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-left">{{ $value->nama_pemilik_bank }}</td>
                    <td class="text-left">{{ $value->jenis_bank }}</td>
                    <td>{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                    <td class="text-right">@currency2($value->pembayaran_transfer)</td>
                </tr>
            @endforeach
        </tbody>
        <tr class="data2">
            <td colspan="4" class="text-right">Sub Total</td>
            <td class="text-right">@currency2($data->sum('pembayaran_transfer'))</td>
        </tr>
    </table>
</div>
