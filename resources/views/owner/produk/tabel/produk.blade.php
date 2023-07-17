<table id="DataTable" class="table table-bordered table-md">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Expired</th>
            @if (auth()->user()->role == 2)
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $num => $value)
            <tr>
                <td>{{ $num + 1 }}</td>
                <td class="text-left">{{ $value->kode }}</td>
                <td class="text-left">{{ $value->nama_produk }}</td>
                <td class="text-right">@currency2($value->harga_beli)</td>
                <td class="text-right">@currency2($value->harga_jual)</td>
                <td>{{ $value->stok }}</td>
                @if ($value->expired == null)
                    <td>----------------</td>
                @else
                    <td>
                        {{ Carbon\Carbon::parse($value->expired)->isoFormat('DD-MM-YYYY') }}
                    </td>
                @endif
                @if (auth()->user()->role == 2)
                    <td style="width: 25%;">
                        <a href="javascript:void(0)" class="btn btn-icon btn-primary"
                            onclick="ModalEdit('{{ route('produk.edit', $value->id) }}', 'modal-md')"
                            title="Klik Untuk Edit Data">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-icon btn-danger" data-bs-toggle="tooltip"
                            title="Klik Untuk Hapus Data" onclick="ModalHapus('produk/hapus/{{ $value->id }}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                @endif

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

    $(document).on("keyup", 'input[type="search"]', function() {
        // cek = table.rows({
        //     search: 'applied'
        // }).count();

        var pencarian = this.value;
        $('#data_pencarian').val(pencarian);

    })
    $('#DataTable').DataTable().search($('#data_pencarian').val()).draw();
</script>
