<table id="DataTable" class="table table-bordered table-md">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th style="width: 2%;">Stok</th>
            <th style="width: 2%;">Produk Terjual</th>
            <th>Total</th>
            <th>Expired</th>
            @if (auth()->user()->role == 2)
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td class="text-left">{{ $value->kode }}</td>
                <td class="text-left">{{ $value->nama_produk }}</td>
                <td class="text-right">@currency2($value->harga_beli)</td>
                <td class="text-right">@currency2($value->harga_jual)</td>
                <td>{{ $value->stok }}</td>
                <td>{{ $value->produk_supplier_terjual }}</td>
                <td class="text-right">@currency2($value->sub_total)</td>
                <td>{{ Carbon\Carbon::parse($value->expired)->isoFormat('DD-MM-YYYY') }}</td>
                @if (auth()->user()->role == 2)
                    <td style="width: 2%">
                        <div class="dropdown mb-4">
                            <button class="btn btn-icon btn-primary btn-info dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if ($value->sub_total == 0)
                                    <a href="javascript:void(0)" class="btn dropdown-item  mb-2"
                                        title="Produk Supplier Sudah Dibayar!"
                                        style="width: 3rem; font-size: 13px !important; color: red;" disabled>
                                        Supplier Sudah Dibayar!
                                    </a>
                                @else
                                    <a href="javascript:void(0)" class="btn dropdown-item  mb-2"
                                        onclick="pembayaranSupplier({{ $value->id . ',' . $value->id_supplier }})"
                                        title="Klik Jika Sudah Membayar Produk Supplier!"
                                        style="width: 3rem; font-size: 14px !important; font-weight: bold;">
                                        Bayar Supplier
                                    </a>
                                @endif
                                <a href="javascript:void(0)" class="btn dropdown-item  mb-2"
                                    onclick="ModalEdit('{{ route('produk-supplier.edit', $value->id) }}', 'modal-lg')"
                                    title="Klik Untuk Update Data Produk"
                                    style="width: 3rem; font-size: 14px !important; font-weight: bold;">
                                    Edit Produk Supplier
                                </a>
                                <a href="javascript:void(0)" class="btn dropdown-item  " data-bs-toggle="tooltip"
                                    title="Delete" onclick="ModalHapus('/supplier/hapus/{{ $value->id }}')"
                                    style="width: 3rem; font-size: 14px !important; font-weight: bold;">
                                    Hapus Produk Supplier
                                </a>
                            </div>
                        </div>
                    </td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            "pageLength": 10,
            language: {
                url: "{{ asset('/DataTables/bahasa.json') }}"
            }
        });
        $(document).on("keyup", 'input[type="search"]', function() {
            // cek = table.rows({
            //     search: 'applied'
            // }).count();

            var pencarian = this.value;
            $('#data_pencarian').val(pencarian);

        })
        $('#DataTable').DataTable().search($('#data_pencarian').val()).draw();
    });
</script>
