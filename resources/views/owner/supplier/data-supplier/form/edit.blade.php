<form method="post" id="form_edit_supplier">
    @method('put')
    <input type="hidden" id="id" name="id" value="{{ $data->id }}">
    <input type="hidden" id="route" value="{{ route('supplier.update', $data->id) }}">
    <div class="row">
        <div class="form-group col-md-6" style="padding-right: 0 !important;">
            <label for="nama_supplier">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" placeholder="Masukkan Nama Supplier"
                name="nama_supplier" onkeyup="ucword('#nama_supplier',this.value)" value="{{ $data->nama_supplier }}"
                autocomplete='off' required>
        </div>
        <div class="form-group col-md-6">
            <label for="no_wa">No WhatsApp</label>
            <input type="number" class="form-control" id="no_wa" placeholder="081*********" name="no_wa"
                value="{{ $data->no_wa }}" onchange="noWa(this.value)" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12" style="padding-right: 0 !important;">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" rows="3" name="keterangan" placeholder="Masukkan keterangan"
                style="height: 5em" onkeyup="this.value = this.value.capitalize()">{{ $data->keterangan }}</textarea>
        </div>
    </div>
    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_close_modalUpdate">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    $("#form_edit_supplier").submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        let cek_cheked = $('#checkbox_supplier_Tidak_Aktif').prop('checked');

        $.ajax({
            url: $('#route').val(),
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (cek_cheked == true) {
                    tabelSupplierTidakAktif();
                } else {
                    tabelSupplier();
                }
                $("#modalEdit").modal('hide');
            }
        });
    });
</script>
