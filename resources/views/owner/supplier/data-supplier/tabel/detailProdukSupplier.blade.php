<div class="table-responsive " width="675" border="0" cellpadding="0" cellspacing="0"
    style="display:block !important;">
    <table class="table table-bordered table-md tableInfo">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Supplier</th>
                <th>No whatsapp</th>
                <th>Total Pembayaran</th>
                <th>Keterangan</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Expired</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="{{ $data['produkSupplier']->count() }}" style="{{ $class }}">1</td>
                <td rowspan="{{ $data['produkSupplier']->count() }}" style="{{ $class }}" class="text-left">
                    {{ $data['supplier']->nama_supplier }}</td>
                <td rowspan="{{ $data['produkSupplier']->count() }}" style="{{ $class }}">
                    {{ $data['supplier']->no_wa }}</td>
                <td rowspan="{{ $data['produkSupplier']->count() }}" style="{{ $class }}" class="text-right"
                    style="width: 20%;">
                    @currency2($data['supplier']->total_pembayaran)</td>
                <td rowspan="{{ $data['produkSupplier']->count() }}" style="{{ $class }}">
                    {{ $data['supplier']->keterangan }}</td>
                @foreach ($data['produkSupplier'] as $key => $value)
                    <td>{{ $value->kode }}</td>
                    <td class="text-left">{{ $value->nama_produk }}</td>
                    <td class="text-right" style="width: 20%;">@currency2($value->harga_beli)</td>
                    <td class="text-right" style="width: 20%;">@currency2($value->harga_jual)</td>
                    <td style="width: 20%;"> {{ Carbon\Carbon::parse($value->expired)->isoFormat('DD-MM-YYYY') }}</td>
                    <td>{{ $value->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
