<h6>Tabel Data Produk Yang Hampir Habis dan Yang Sudah Habis</h6>
<table id="DataTable2" class="table table-bordered table-md">
  <thead>
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>Stok</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $key => $value)
    <tr>
      <td>{{ $key + 1 }}</td>
      <td class="text-left">{{ ucwords(strtolower($value->nama_produk)) }}</td>
      <td>{{ $value->stok }}</td>
    </tr>
    @endforeach
  </tbody>
</table><br>
<button type="button" class="btn btn-danger btn_close" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary" onclick="updateStok()">Update Stok</button>
<button type="button" class="btn btn-warning" onclick="disableAlert()">Jangan Tampilkan Lagi!</button>
<script>
  $('#DataTable2').DataTable({
    pageLength: 5
    , searching: false,
    // paging: false,
    // ordering: false,
    "lengthChange": false
    , info: false
    , language: {
      url: "{{ asset('/DataTables/bahasa.json') }}"
    }
  });

</script>
