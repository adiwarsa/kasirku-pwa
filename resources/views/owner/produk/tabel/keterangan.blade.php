<table class="table table-bordered table-md">
    <thead>
        <tr>
            <th>Total Harga Beli (Rp)</th>
            <th>Total Harga Jual Barang (Rp)</th>
            @if (auth()->user()->role == 1)
                <th>Total Keuntungan (Rp)</th>
            @endif
            <th>Total Stok Produk</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-right">@currency2($data['total_harga_beli'])</td>
            <td class="text-right">@currency2($data['total_harga_jual'])</td>
            @if (auth()->user()->role == 1)
                <td class="text-right">@currency2($data['total_keuntungan'])</td>
            @endif
            <td>{{ $data['total_produk'] }} pcs</td>
        </tr>
    </tbody>
</table>
