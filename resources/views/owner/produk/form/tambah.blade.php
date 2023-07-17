<form method="post" id="form_tambah_produk">
    <div class="form-row">
        <div class="form-group col-md-5" style="padding-right: 0 !important;">
            <label for="kode">Kode Produk</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Produk"
                onkeyup="this.value = this.value.toUpperCase()" autocomplete='off'>
        </div>
        <div class="input-group-append" style="height: 43px !important;  margin-top: 6%;">
            <button class="btn btn-primary btn-sm" style="width: 39px !important;" type="button" data-toggle="collapse"
                data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i
                    class="fa fa-qrcode fa-1x" aria-hidden="true"></i></button>
        </div>
        <div class="form-group col-md-6">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                placeholder="Masukkan Nama Produk" onkeyup="this.value = this.value.capitalize()" autocomplete='off'
                required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" class="form-control text-right" id="harga_beli" name="harga_beli" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" required>
        </div>
        <div class="form-group col-md-5">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" class="form-control text-right" id="harga_jual" name="harga_jual" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" required>
        </div>
        <div class="form-group col-md-2">
            <label for="stok">Stok</label>
            <input type="number" class="form-control text-right" id="stok" placeholder="0" name="stok"
                onchange="stokk()" required>
        </div>
    </div>
    <div class="form-group">
        <label for="expired">Expired</label>
        <input type="date" class="form-control date" id="expired" name="expired" data-date-format="DD/MM/YYYY">
    </div>
    <button type="button" class="btn btn-danger btn_close" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <div class="d-flex justify-content-center mt-3">
            <div id="reader" width="600px"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#kode').focus();

        // =====================================  SCANNER  =======================================================
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            // console.log(`Code matched = ${decodedText}`, decodedResult);
            $('#kode').val(decodedText);
            $('#nama_produk').focus();
            // html5QrcodeScanner.clear();
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
    });

    $("#form_tambah_produk").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        let cek_cheked = $('#checkbox_stok').prop('checked');

        $.ajax({
            url: "{{ route('produk.store') }}",
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response == "") {

                    if (cek_cheked == true) {
                        tabelProdukStok();
                    } else {
                        tabelProduk();
                    }
                    document.getElementById("form_tambah_produk").reset();

                    $('#kode').focus();

                } else {
                    $("#modalTambah").modal('hide');
                    document.getElementById("form_tambah_produk").reset();
                    AlertEggy('error', response);
                }
                $(".date").on("change", function() {
                    if (this.value) {
                        this.setAttribute(
                            "data-date",
                            moment(this.value, "YYYY-MM-DD")
                            .format(this.getAttribute("data-date-format"))
                        )
                    } else {
                        $(this).attr('data-date', 'dd/mm/yyyy');

                    }
                }).trigger("change")
            }
        });
    });

    $(".date").on("change", function() {
        if (this.value) {
            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                .format(this.getAttribute("data-date-format"))
            )
        } else {
            $(this).attr('data-date', 'dd/mm/yyyy');

        }
    }).trigger("change")

    function stokk() {
        let stok = $('#stok').val();
        if (stok <= 0) {
            $('#stok').val(1);
        }
    }
</script>
