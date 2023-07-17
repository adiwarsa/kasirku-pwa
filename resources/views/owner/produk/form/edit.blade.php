<form method="post" id="form_edit_produk">
    @method('put')
    <input type="text" id="id" name="id" value="{{ $data->id }}" hidden>
    <input type="hidden" id="route" value="{{ route('produk.update', $data->id) }}">
    <div class="form-row">
        <div class="form-group col-md-6" style="padding-right: 0 !important;">
            <label for="kode">Kode Produk</label>
            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Produk"
                onkeyup="this.value = this.value.toUpperCase()" autocomplete='off' value="{{ $data->kode }}">
        </div>
        <div class="form-group col-md-6">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk"
                onkeyup="this.value = this.value.capitalize()" autocomplete='off' value="{{ $data->nama_produk }}"
                required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" class="form-control text-right" id="harga_beli" name="harga_beli" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" value="@currency2($data->harga_beli)" required>
        </div>
        <div class="form-group col-md-5">
            <label for="harga_jual">Harga Jual</label>
            <input type="text" class="form-control text-right" id="harga_jual" name="harga_jual" placeholder="0"
                onkeyup="this.value = FormatRupiah(this.value)" value="@currency2($data->harga_jual)" required>
        </div>
        <div class="form-group col-md-2">
            <label for="stok">Stok</label>
            <input type="number" class="form-control text-right" id="stok" placeholder="0" name="stok"
                value="{{ $data->stok }}" onchange="stokk()" required>
        </div>
    </div>
    <div class="form-group">
        <label for="expired">Expired</label>
        <input type="date" class="form-control date" id="expired" name="expired" data-date-format="DD/MM/YYYY"
            value="{{ $data->expired }}">
    </div>
    <button type="button" class="btn btn-danger btn_close" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
    $("#form_edit_produk").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        let cek_cheked = $('#checkbox_stok').prop('checked');

        $.ajax({
            url: $('#route').val(),
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (cek_cheked == true) {
                    tabelProdukStok()
                } else {
                    tabelProduk();

                }
                $("#modalEdit").modal('hide');
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
