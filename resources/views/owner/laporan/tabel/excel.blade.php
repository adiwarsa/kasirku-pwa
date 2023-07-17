<table id="export-excel-laporan" class="table table-bordered table-lg">
    <thead>
        <tr>
            <th colspan="9" style="background-color: aqua !important;">
                <b>
                    <center>
                        Data Invoice
                    </center>
                </b>
            </th>
            <th colspan="7" style="background-color: aqua !important;">
                <b>
                    <center>Data Produk</center>
                </b>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Qty</th>
            <th>Sub Total</th>
            <th>Pembayaran Cash</th>
            <th>Pembayaran Transfer</th>
            <th>Kembalian</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Harga Produk</th>
            <th>Keuntungan Per Item</th>
            <th>Total Keuntungan</th>
            <th>Qty Produk</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
            <tr>
                <td @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='' @endif>

                    {{ $key + 1 }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    {{ $value['invoice'] }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    {{ $value['qty'] }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    {{ $value['sub_total'] }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    @if ($value['pembayaran_cash'] == null)
                        0
                    @else
                        {{ $value['pembayaran_cash'] }}
                    @endif

                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    @if ($value['pembayaran_transfer'] == null)
                        0
                    @else
                        {{ $value['pembayaran_transfer'] }}
                    @endif

                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    {{ $value['kembalian'] }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    {{ Carbon\Carbon::parse($value['tanggal'])->isoFormat('DD-MM-YYYY') }}
                </td>
                <td
                    @if ($value['produk']->count() > 1) rowspan="{{ $value['produk']->count() }}" style='vertical-align: middle;' @endif>
                    @if ($value['status'] == 'cash')
                        Cash
                    @elseif($value['status'] == 'transfer')
                        Transfer
                    @endif

                </td>
                @foreach ($value['produk'] as $key2 => $value2)
                    <td>{{ $value2->kode_produk }}</td>
                    <td>{{ $value2->nama_produk }}</td>
                    <td>{{ $value2->harga_jual }}</td>
                    <td>{{ $value2->keuntungan_per_item }}</td>
                    <td>{{ $value2->total_keuntungan }}</td>
                    <td>{{ $value2->qty }}</td>
                    <td>{{ $value2->sub_total }}</td>
            </tr>
        @endforeach
        @endforeach
        <tr>
            <td colspan="2">Total</td>
            <td>{{ $total['qty'] }}</td>
            <td>{{ $total['sub_total'] }}</td>
            <td>{{ $total['pembayaran'] }}</td>
            <td>{{ $total['pembayaran_transfer'] }}</td>
            <td>{{ $total['kembalian'] }}</td>
            <td colspan="4"></td>
            <td>{{ $total['harga_jual'] }}</td>
            <td>{{ $total['keuntungan_per_item'] }}</td>
            <td>{{ $total['total_keuntungan'] }}</td>
            <td>{{ $total['qty_produk'] }}</td>
            <td>{{ $total['sub_total_produk'] }}</td>
        </tr>
        <tr>
            <td colspan="16"></td>
        </tr>
        <tr>
            <td colspan="16" style="background-color: greenyellow;">
                <b style="color: white !important;">
                    <center>Rincian Penjualan</center>
                </b>
            </td>
        </tr>
        <tr>
            <td><b>Pendapatan</b></td>
            <td colspan="15"></td>
        </tr>
        <tr>
            <th colspan="4">Invoice</th>
            <th colspan="4">Status</th>
            <th colspan="4">Tanggal</th>
            <th colspan="4">Total</th>
        </tr>
        @foreach ($data_pendapatan as $key => $value)
            <tr>
                <td colspan="4">{{ $value['invoice'] }}</td>
                <td colspan="4">{{ $value['status'] }}</td>
                <td colspan="4">{{ Carbon\Carbon::parse($value['tanggal'])->isoFormat('DD-MM-YYYY') }} </td>
                <td colspan="4">{{ $value['total'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="12">Total</td>
            <td colspan="4">{{ $total_data_pendapatan }}</td>
        </tr>

        <tr>
            <td colspan="16"></td>
        </tr>
        <tr>
            <td><b>Keuntungan</b></td>
            <td colspan="15"></td>
        </tr>
        <tr>
            <th colspan="6">Invoice</th>
            <th colspan="6">Tanggal</th>
            <th colspan="4">Total Keuntungan</th>
        </tr>
        @foreach ($data as $key => $value)
            <tr>
                <td colspan="6">{{ $value['invoice'] }}</td>
                <td colspan="6">{{ Carbon\Carbon::parse($value['tanggal'])->isoFormat('DD-MM-YYYY') }}</td>
                <td colspan="4">{{ $value['total_keuntungan'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="12">Total</td>
            <td colspan="4">{{ $total_keuntungan }}</td>
        </tr>
        <tr>
            <td colspan="16"></td>
        </tr>
        @if ($bank['bri']->count() > 0 || $bank['bpd']->count() > 0)
            <tr>
                <td colspan="16" style="background-color: aquamarine;">
                    <b style="color: white !important;">
                        <center>Rincian TF Bank</center>
                    </b>
                </td>
            </tr>
        @endif
        @if ($bank['bri']->count() > 0)

            <tr>
                <th colspan="16">
                    <b>
                        BRI
                    </b>
                </th>
            </tr>
            <tr>
                <td colspan="4">Nama Pemilik Bank</td>
                <td colspan="4">Jenis Bank</td>
                <td colspan="4">Tanggal</td>
                <td colspan="4">Jumlah Pembayaran</td>
            </tr>
            @foreach ($bank['bri'] as $key => $value)
                <tr>
                    <td colspan="4">{{ $value->nama_pemilik_bank }}</td>
                    <td colspan="4">{{ $value->jenis_bank }}</td>
                    <td colspan="4">{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                    <td colspan="4">{{ $value->pembayaran_transfer }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="11"></td>
                <td>Total</td>
                <td colspan="4">{{ $bank['bri']->sum('pembayaran_transfer') }}</td>
            </tr>
        @endif
        @if ($bank['bpd']->count() > 0)
            <tr>
                <td colspan="16"></td>
            </tr>
            <tr>
                <th colspan="16">
                    <b>
                        BPD
                    </b>
                </th>
            </tr>
            <tr>
                <td colspan="4">Nama Pemilik Bank</td>
                <td colspan="4">Jenis Bank</td>
                <td colspan="4">Tanggal</td>
                <td colspan="4">Jumlah Pembayaran</td>
            </tr>
            @foreach ($bank['bpd'] as $key => $value)
                <tr>
                    <td colspan="4">{{ $value->nama_pemilik_bank }}</td>
                    <td colspan="4">{{ $value->jenis_bank }}</td>
                    <td colspan="4">{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                    <td colspan="4">{{ $value->pembayaran_transfer }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="11"></td>
                <td>Total</td>
                <td colspan="4">{{ $bank['bpd']->sum('pembayaran_transfer') }}</td>
            </tr>
        @endif
    </tbody>
</table>
