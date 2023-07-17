<div class="table-responsive " width="675" border="0" cellpadding="0" cellspacing="0"
    style="display:block !important;">
    <table class="table table-md tableInfo" id="DataTable-History">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Supplier</th>
                <th>Nama Produk</th>
                <th>Total Penjualan</th>
                <th>Total Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-left">{{ $value->supplier->nama_supplier }}</td>
                    <td class="text-left">{{ $value->nama_produk_supplier }}</td>
                    <td>{{ $value->total_penjualan }} pcs</td>
                    <td class="text-right">@currency2($value->total_pembayaran)</td>
                    <td>{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#DataTable-History').DataTable({
            "pageLength": 10,
            language: {
                url: "{{ asset('/DataTables/bahasa.json') }}"
            }
        });
    });
</script>
