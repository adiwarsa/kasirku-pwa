<form method="POST" id="form_edit_produk_supplier">
    @method('put')
    <div class="row">
        <input type="hidden" name="id" value="00">
        <input type="hidden" id="route" value="{{ route('supplier.update', $data->id) }}">
        <div class="form-group col-md-4" style="padding-right: 0 !important;">
            <label for="kode">Kode Produk</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Produk"
                onkeyup="this.value = this.value.toUpperCase()" autocomplete='off' value="{{ $data->kode }}">
        </div>
        <div class="form-group col-md-4">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                placeholder="Masukkan Nama Produk" onkeyup="this.value = this.value.capitalize()" autocomplete='off'
                value="{{ $data->nama_produk }}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" class="form-control text-right" id="harga_beli" name="harga_beli" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" value="{{ $data->harga_beli }}" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" class="form-control text-right" id="harga_jual" name="harga_jual" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" value="{{ $data->harga_jual }}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="stok">Stok</label>
            <input type="number" class="form-control text-right" id="stok" placeholder="0" name="stok"
                value="{{ $data->stok }}">
        </div>
        <div class="form-group col-md-4">
            <label for="expired">Expired</label>
            <input type="date" class="form-control date" id="expired" name="expired" data-date-format="DD/MM/YYYY"
                onchange="stokk()" value="{{ $data->expired }}">
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
    $("#form_edit_produk_supplier").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);

        $.ajax({
            url: $('#route').val(),
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {

                tabelProdukSupplier();
                $("#modalEdit").modal('hide');


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
