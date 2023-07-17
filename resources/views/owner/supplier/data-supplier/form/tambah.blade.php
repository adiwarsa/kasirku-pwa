<form method="POST" id="form_tambah_supplier">
    <div class="row">
        <div class="form-group col-md-6" style="padding-right: 0 !important;">
            <label for="nama_supplier">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" placeholder="Masukkan Nama Supplier"
                name="nama_supplier" onkeyup="ucword('#nama_supplier',this.value)" autocomplete='off' required>
        </div>
        <div class="form-group col-md-6">
            <label for="no_wa">No WhatsApp</label>
            <input type="number" class="form-control" id="no_wa" placeholder="081*********" name="no_wa"
                onchange="noWa(this.value)" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12" style="padding-right: 0 !important;">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" placeholder="Masukkan keterangan"
                style="height: 5em" onkeyup="this.value = this.value.capitalize()"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4" style="padding-right: 0 !important;">
            <label for="kode">Kode Produk</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Produk"
                onkeyup="this.value = this.value.toUpperCase()" autocomplete='off'>
        </div>
        <div class="form-group col-md-4">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                placeholder="Masukkan Nama Produk" onkeyup="this.value = this.value.capitalize()" autocomplete='off'
                required>
        </div>
        <div class="form-group col-md-4">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" class="form-control text-right" id="harga_beli" name="harga_beli" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" class="form-control text-right" id="harga_jual" name="harga_jual" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" required>
        </div>
        <div class="form-group col-md-4">
            <label for="stok">Stok</label>
            <input type="number" class="form-control text-right" id="stok" placeholder="0" name="stok"
                onchange="stokk()" required>
        </div>
        <div class="form-group col-md-4">
            <label for="expired">Expired</label>
            <input type="date" class="form-control date" id="expired" name="expired" data-date-format="DD/MM/YYYY">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-lg-8 ms-auto">
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_close_modalTambah">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<script>
    $("#form_tambah_supplier").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        let cek_cheked = $('#checkbox_supplier_Tidak_Aktif').prop('checked');

        $.ajax({
            url: "{{ route('supplier.store') }}",
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response == "") {
                    if (cek_cheked == true) {
                        tabelSupplierTidakAktif();
                    } else {
                        tabelSupplier();
                    }
                    $("#modalTambah").modal('hide');

                } else {
                    $("#modalTambah").modal('hide');
                    AlertEggy('error', response);
                }
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
