<table id="DataTable" class="table table-bordered table-md">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>No WhatsApp</th>
            <th>Total Pembayaran</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td class="text-left">{{ $value->nama_supplier }}</td>
                <td>{{ $value->no_wa }}</td>
                <td class="text-right">@currency2($value->total_pembayaran)</td>
                <td class="text-left">{{ $value->keterangan }}</td>
                <td>
                    @if ($value->status == 1)
                        <a href="javascript:void(0)" class="btn btn-aktif"
                            onclick="status({{ $value->id }}, 0)">Aktif</a>
                    @elseif ($value->status == 0)
                        <a href="javascript:void(0)" class="btn btn-tidak-aktif" data-id="{{ $value->id }}"
                            onclick="status({{ $value->id }}, 1)">Tidak Aktif</a>
                    @endif
                </td>
                <td>{{ Carbon\Carbon::parse($value->tanggal)->isoFormat('DD-MM-YYYY') }}</td>
                <td style="width: 25%">
                    @if (auth()->user()->role == 2)
                        <a href="javascript:void(0)" class="btn btn-icon btn-primary"
                            onclick="ModalEdit('{{ route('supplier.edit', $value->id) }}', 'modal-md')"
                            title="Klik Untuk Update Data!">
                            <i class="far fa-edit"></i>
                        </a>
                    @endif
                    <a href="{{ route('index-produk', $value->nama_supplier) }}" class="btn btn-icon btn-success"
                        title="Klik Untuk Tambah Produk Supplier!">
                        <i class='fas fa-paste' style='font-size:14px'></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-icon btn-info"
                        title="Klik Untuk Melihat Detail Produk Supplier!"
                        onclick="ModalInfo('{{ route('supplier.show', $value->id) }}', 'Detail Produk Supplier', 'modal-xl')">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
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
