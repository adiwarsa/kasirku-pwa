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
        @foreach ($data as $num => $value)
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
                    <a href="javascript:void(0)" class="btn btn-icon btn-info" onclick="doPrint({{ $value->id }})"
                        title="Klik Untuk Print Struk!">
                        <i class="fa fa-print"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $('#DataTable').DataTable({
        "pageLength": 10,
        language: {
            url: "{{ asset('/DataTables/bahasa.json') }}"
        }
    });
</script>
