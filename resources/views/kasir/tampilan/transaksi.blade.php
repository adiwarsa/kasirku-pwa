<div class="section-body">
    <form method="post" id="form_keranjang">
        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-3 mb-3">
                <label class="small text-muted mb-1">Kode Produk</label>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="kode" onchange="changeValue(this.value)"
                            class="form-control form-control-md" id="kode" list="datalist1" autocomplete='off'
                            required autofocus>
                        <datalist id="datalist1">
                            @foreach ($data['produk'] as $value)
                                <option value="{{ $value->kode . '||' . $value->nama_produk . '||' . $value->stok }}">
                                </option>
                            @endforeach
                        </datalist>
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm btnScan" onclick="scan()" type="button">
                                <i class="fa fa-qrcode fa-1x" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-3 mb-3">
                <label class="small text-muted mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control form-control-md bg-light"
                    readonly>
            </div>
            <div class="col-8 col-sm-4 col-md-4 col-lg-2 mb-3">
                <label class="small text-muted mb-1">Harga</label>
                <input type="text" name="harga_jual" placeholder="0" id="harga_jual" onchange="InputSub()"
                    class="form-control text-right form-control-md bg-light" readonly>
                <input type="hidden" name="harga_beli" placeholder="0" id="harga_beli">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-1 mb-3">
                <label class="small text-muted mb-1">Qty</label>
                <input type="number" name="qty" id="qty" onchange="InputSub()" placeholder="0"
                    class="form-control form-control-md" required>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-3 mb-3">
                <label class="small text-muted mb-1">Subtotal</label>
                <div class="input-group">
                    <input type="text" name="sub_total" placeholder="0" id="sub_total" onchange="InputSub()"
                        class="form-control text-right form-control-md bg-light mr-2" readonly>
                    <div class="input-group-append">
                        <button type="reset" class="btn btn-danger btn-sm mr-2"
                            onclick="$('#kode').focus()">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm btn_simpan">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<br>
<div class="row">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="read">
                    <table id="DataTable" class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['keranjang'] as $num => $value)
                                <tr>
                                    <td>{{ $num + 1 }}</td>
                                    <td class="text-left">{{ $value->kode_produk }}</td>
                                    <td class="text-left">{{ ucwords(strtolower($value->nama_produk)) }}</td>
                                    <td class="text-right">@currency2($value->harga_jual)</td>
                                    <td>{{ $value->qty }}</td>
                                    <td class="text-right">@currency2($value->sub_total)</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-icon btn-danger"
                                            onclick="HapusProduk('{{ route('hapus-produk', $value->id) }}')"
                                            title="Klik Untuk Hapus Produk!">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-light p-3" style="border-radius:0.25rem;">
    <div class="row gy-3 align-items-center row-home">
        <div class="col-md-8 col-lg-6 mb-2">
            <input type="hidden" id="totalCart" value="">
            <div class="row">
                <div class="ml-4">
                    <h3>#shortcut</h3>
                    <i class="fas fa-arrow-up"></i> = Untuk Menampilkan Data Produk <br>
                    <i class="fas fa-arrow-right"></i> = Untuk Menuju Halaman Print
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-6 mb-2 text-primary text-right">
            <p class="small text-muted mb-0">Total Item</p>
            <h3 class="mb-0" style="font-weight:600;">
                @if ($data['keranjang']->count() > 0)
                    @currency($data['keranjang']->sum('sub_total'))
                @else
                    @currency(0)
                @endif
            </h3>
        </div>
        @if ($data['keranjang']->count() > 0)
            <div class="col-md-12 col-lg-12 mb-2 text-primary text-right" style="align-items: flex-end !important;">
                <button type="button" class="btn btn-primary btn-sm"
                    onclick="$('#data_content').load('{{ route('index-transaksi', 'pembayaran') }}');">
                    Simpan Keranjang
                </button>
            </div>
        @endif
    </div>
</div>
<input type="hidden" id="total_keranjang" value="{{ $data['keranjang']->count() }}">

<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            searching: false,
            paging: false,
            ordering: false,
            info: false,
            language: {
                url: "{{ asset('/DataTables/bahasa.json') }}"
            }
        });
        $('#kode').focus();
    });

    function changeValue(kode) {
        var link = "{{ route('change-value', ':kode') }}";
        href = link.replace(':kode', kode);
        $.get(href, {}, function(data, status) {
            $('#nama_produk').val(data.nama_produk);
            $('#harga_jual').val(FormatRupiah(data.harga_jual));
            $('#harga_beli').val(data.harga_beli);
            $("#qty").focus();
        });
    }

    function InputSub() {
        if ($('#qty').val() < 0) {
            $('#qty').val(0);
        }
        var harga_jual = parseInt($('#harga_jual').val().replaceAll(".", ""));
        var qty = parseInt($('#qty').val());
        var total = harga_jual * qty;
        $('#sub_total').val(FormatRupiah(total));
    };

    $("#form_keranjang").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        // console.log(fd);
        $.ajax({
            url: "{{ route('kasir.store') }}",
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == "kosong") {
                    AlertEggy('error', "Produk Tidak Ditemukan!");
                }
                $('#data_content').load("{{ route('index-transaksi', 'transaksi') }}");


            }
        });
    });

    function HapusProduk(link) {
        $.get(link, {}, function(data, status) {
            $('#data_content').load("{{ route('index-transaksi', 'transaksi') }}");
        });
    }

    addEventListener("keydown", function(event) {
        if (event.key === "ArrowRight") {
            event.preventDefault();
            if ($('#total_keranjang').val() == 0) {
                AlertEggy('error', 'Keranjang Masih Kosong!');
            } else {
                $('#data_content').load("{{ route('index-transaksi', 'pembayaran') }}");
            }
        }
    });

    $('#qty').keydown(function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            $('.btn_simpan').click();

        }
    });

    function scan() {
        $("#modalScan").modal({
            show: true,
            backdrop: 'static',

        });
        $('.btn-close').click(function(e) {
            $("#modalScan").modal('hide');

        });
        // =====================================  SCANNER  =======================================================
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            // console.log(`Code matched = ${decodedText}`, decodedResult);
            $('#kode').val(decodedText);
            changeValue(decodedText);
            $('#qty').focus();
            html5QrcodeScanner.clear();
            $('.btn-close').click();
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        // =====================================  END SCANNER  =======================================================

    }
</script>
