<div class="table-responsive">
    <table id="DataTable3" class="table table-bordered table-md ">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Keuntungan Per Item</th>
                <th>Total Keuntungan</th>
                <th>Qty</th>
                <th>Sub Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="9">{{ $data[0]->invoice->invoice }}</td>
            </tr>
            @if ($data[0]->invoice->status == 'transfer')
                <td colspan="2">
                    Nama Pemilik Bank
                </td>
                <td colspan="2">
                    {{ $data[0]->invoice->nama_pemilik_bank }}
                </td>
                <td>
                    Jenis Bank
                </td>
                <td>
                    {{ $data[0]->invoice->jenis_bank }}
                </td>
                <td colspan="2">
                    Bank Tujuan
                </td>
                <td>
                    {{ $data[0]->invoice->bank_tujuan }}
                </td>
            @endif
            @foreach ($data as $num => $value)
                <tr>
                    <td>
                        {{ $num + 1 }}
                    </td>
                    <td class="text-left">{{ $value->kode_produk }}</td>
                    <td class="text-left">{{ $value->nama_produk }}</td>
                    <td class="text-right">@currency2($value->harga_jual)</td>
                    <td class="text-right">@currency2($value->keuntungan_per_item)</td>
                    <td class="text-right">@currency2($value->total_keuntungan)</td>
                    <td>{{ $value->qty }}</td>
                    <td class="text-right">@currency2($value->sub_total)</td>
                    <td>{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#DataTable3').DataTable({
            // "pageLength": 10,
            searching: false,
            paging: false,
            ordering: false,
            info: false
        });
    });
</script>
