<div class="row diHP">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-statistic-1" style="background-color: transparent;">
            <div class="card-wrap">
                <div class="card-body">
                    <h3>#shortcut</h3>
                    <div class="shortcut">
                        <div class="d-flex col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="flex" style="font-size: 0.9rem !important;">
                                <i class="fas fa-arrow-left"></i> = Untuk Kembali Ke Halaman Sebelumnya
                            </div>
                            <div id="shortcut-f3" class="ml-4" style="font-size: 0.9rem !important;" hidden>
                                'F3'= Untuk Klik Button Jika Tanpa Cash
                            </div>
                            <div class="ml-4" style="font-size: 0.9rem !important;">
                                'ENTER' = Untuk Print Struk
                            </div>
                            <div class="ml-4" style="font-size: 0.9rem !important;">
                                'ESC' = Untuk Reset / Cancel
                            </div>
                            <div class="ml-4" style="font-size: 0.9rem !important;" id="shortcut-pelanggan" hidden>
                                <i class="fas fa-arrow-up"></i>/<i class="fas fa-arrow-down"></i> = Untuk Melihat Nama
                                Pelanggan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-statistic-1" style="background-color: transparent;">
            <div class="card-wrap">
                <div class="card-body">
                    <h3>#shortcut</h3>
                    <div class="shortcut ">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 marginTop">
                            <h6 class="mr-2">F1 = Untuk Pembayaran Cash</h6>
                            <h6 class="ml-3">Tekan 2x F1 Untuk Fokus</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h1 class="h3 mb-2">
    Detail
    <span class="float-right">
        <a href="javascript:void(0)" class="btn btn-danger btn-sm px-3 mr-1"
            onclick="$('#data_content').load('{{ route('index-transaksi', 'transaksi') }}');">Kembali</a>
        <button type="button" class="btn btn-primary btn-sm px-3" onclick="cekData()" id="cetak">Cetak</button>
    </span>
</h1>

<div class="d-flex justify-content-between bg-purple p-2 text-white">
    <h5 class="mb-0 date-inv">Tanggal :
        {{ Carbon\Carbon::parse($data['keranjang'][0]->created_at)->isoFormat('DD-MM-YYYY') . ' ' . Carbon\Carbon::parse($data['keranjang'][0]->created_at)->toTimeString() }}
    </h5>
</div>
<div class="table-responsive">
    <table class="table table-striped table-md table-bordered dt-responsive nowrap print-none" id="cart"
        width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['keranjang'] as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-left">{{ $value->kode_produk }}</td>
                    <td class="text-left">{{ ucwords($value->nama_produk) }}</td>
                    <td class="text-right">@currency2($value->harga_jual)</td>
                    <td>{{ $value->qty }}</td>
                    <td class="text-right">@currency2($value->sub_total)</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row justify-content-between mt-1">
    <div class="col-sm-6 col-md-7 col-lg-8">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="cash-tab" data-toggle="tab" href="#cash" role="tab"
                    aria-controls="cash" aria-selected="true" onclick="textPembayaran('cash')">Cash</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" id="transfer-tab" data-toggle="tab" href="#transfer" role="tab"
                    aria-controls="transfer" aria-selected="false" onclick="textPembayaran('transfer')">Transfer</a>
            </li> --}}
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                <label for="pembayaran"
                    class="col-4 col-sm-4 col-md-4 col-lg-3 col-form-label col-form-label-sm mb-2">Pembayaran</label>
                <div class="col-8 col-sm-8 col-md-8 col-lg-9 mb-2">
                    <input type="text" name="pembayaran" class="form-control form-control-sm text-right"
                        id="pembayaran" autocomplete='off' placeholder="0" onkeyup="pembayaranCash()" required>
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                <form class="mt-4" id="form_pembayaran_transfer">
                    <div class="row">
                        <div class="col">
                            <label for="pembayaran_cash">Pembayaran Cash</label>
                            <input type="text" class="form-control text-right" id="pembayaran_cash"
                                name="pembayaran_cash" placeholder="Pembayaran Cash" value="@currency2($data['keranjang']->sum('sub_total'))"
                                readonly>
                        </div>
                        <div class="col">
                            <label for="pembayaran_transfer">Pembayaran Transfer</label>
                            <div class="d-flex">
                                <input type="text" class="form-control text-right tf" id="pembayaran_transfer"
                                    style="width: 20em;" autocomplete='off' name="pembayaran_transfer"
                                    placeholder="0" onkeyup="pembayaranTransfer()" required>&ensp;
                                <label class="selectgroup-item" title="Klik Jika Tanpa Cash!">
                                    <input type="checkbox" name="" value="" id="transfer_full"
                                        class="selectgroup-input" onclick="transferFull()">
                                    <span class="selectgroup-button" style="height: 3.2em;">-</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="nama_pemilik_bank">Nama Pemilik Bank</label>
                        <input type="text" class="form-control" id="nama_pemilik_bank" name="nama_pemilik_bank"
                            placeholder="Nama Pemilik Bank"
                            onkeyup="this.value = this.value.toUpperCase(); $(this).css('border-color', '');" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="jenis_bank">Jenis Bank</label>
                        <input type="text" class="form-control" id="jenis_bank" name="jenis_bank"
                            placeholder="Jenis Bank" list="datalist3" autocomplete='off'
                            onkeyup="this.value = this.value.toUpperCase(); $(this).css('border-color', '');" required>
                        <datalist id="datalist3">
                            @foreach ($data['bank'] as $value)
                                <option value="{{ $value['name'] }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group mt-2">
                        <div class="form-group">
                            <label>Bank Tujuan</label>
                            <select class="form-control" name="bank_tujuan" id="bank_tujuan"
                                onchange="this.style.borderColor = ''">
                                <option value="" disabled hidden selected>Bank Tujuan</option>
                                <option value="BANK BRI">BANK BRI</option>
                                <option value="BANK BPD">BANK BPD</option>
                            </select>
                        </div>
                    </div>
                    <button type="reset" id="reset_transfer" hidden></button>
                </form>
            </div> --}}
        </div>
    </div>
    <div class="col-sm-6 col-md-5 col-lg-4">
        <div class="bg-purple text-white p-2">
            <h6 class="mb-0">Total Item
                <span class="float-right">@currency($data['keranjang']->sum('sub_total'))</span>
                <input type="hidden" id="total_transaksi" value="{{ $data['keranjang']->sum('sub_total') }}">
            </h6>
        </div>
        <div class="bg-light p-2">
            <h6 class="mb-2" id="text_pembayaran_cash">Pembayaran Cash
                <span class="float-right" id="total_pembayaran_cash">@currency(0)</span>
            </h6>
            <h6 class="mb-2" id="text_pembayaran_tf" hidden>Pembayaran Transfer
                <span class="float-right" id="total_pembayaran_transfer">@currency(0)</span>
            </h6>
            <h6 class="mb-2" id="text_kembalian">Kembalian
                <span class="float-right" id="kembalian">@currency(0)</span>
            </h6>
            <h6 class="mb-0">Keterangan
                <span class="float-right" id="keterangan_pembayaran">Cash</span>
            </h6>
        </div>
        <div class="mt-4 diHP">
            <div id="shortcut-bawah" hidden>
                <h3>#shortcut ==========================</h3>
                <div>
                    'TAB' = Untuk Fokus Kolom Selanjutnya
                </div>
                <div>
                    'SHIFT + TAB' = Untuk Fokus Kolom Sebelumnya
                </div>
                <div id="shortcut-tf">
                    <div style="font-size: 0.9rem !important;">
                        <i class="fas fa-arrow-up"></i>/<i class="fas fa-arrow-down"></i> = Untuk Melihat Jenis Bank
                    </div>
                    <div>
                        'SPASI' = Untuk Melihat Bank Tujuan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="total_item" value="{{ $data['keranjang']->sum('sub_total') }}">
<script>
    $(document).ready(function() {
        $('#pembayaran').focus();

    });

    function pembayaranCash() {
        $("#pembayaran").css("border-color", "");
        $('#pembayaran').val(FormatRupiah($('#pembayaran').val()));
        var pembayaran = $('#pembayaran').val().replaceAll('.', "");
        var kembalian = pembayaran - $('#total_item').val();
        if (pembayaran == "") {
            pembayaran = 0;
            kembalian = 0;
        }
        $('#total_pembayaran_cash').html(FormatRupiah(pembayaran, 'Rp '));
        $('#kembalian').html(FormatRupiah(kembalian, 'Rp '));
    }

    function pembayaranTransfer() {
        $("#pembayaran_transfer").css("border-color", "");
        $('#pembayaran_transfer').val(FormatRupiah($('#pembayaran_transfer').val()));
        var pembayaran_transfer = $('#pembayaran_transfer').val().replaceAll('.', "");
        var pembayaran_cash = $('#total_item').val() - pembayaran_transfer;
        if (pembayaran_transfer == "" || pembayaran_cash < 0) {
            $('#reset_transfer').click();
            $('#pembayaran_transfer').focus();
            pembayaran_transfer = 0;
            pembayaran_cash = $('#total_item').val();
        }
        if (pembayaran_cash > 0) {
            $('#keterangan_pembayaran').html('Cash & Transfer');
        } else {
            $('#keterangan_pembayaran').html('Transfer');

        }
        $('#pembayaran_cash').val(FormatRupiah(pembayaran_cash));
        $('#total_pembayaran_transfer').html(FormatRupiah(pembayaran_transfer, 'Rp '));
        $('#total_pembayaran_cash').html(FormatRupiah(pembayaran_cash, 'Rp '));
    }

    function transferFull() {
        let cek_cheked = $('#transfer_full').prop('checked');
        var pembayaran_cash = $('#pembayaran_cash');
        var pembayaran_transfer = $('#pembayaran_transfer');
        var total_pembayaran_transfer = $('#total_pembayaran_transfer');
        var total_pembayaran_cash = $('#total_pembayaran_cash');

        if (cek_cheked == true) {
            pembayaran_transfer.val(FormatRupiah($("#total_item").val()));
            pembayaran_cash.val(0);
            pembayaran_transfer.attr('readonly', true);
            total_pembayaran_transfer.html(FormatRupiah($("#total_item").val(), 'Rp '));
            total_pembayaran_cash.html(FormatRupiah(0));
            $('#nama_pemilik_bank').focus();


        } else {
            $('#reset_transfer').click();
            pembayaran_transfer.attr('readonly', false);
            pembayaran_transfer.focus();
            total_pembayaran_transfer.html(FormatRupiah(0));
            total_pembayaran_cash.html(FormatRupiah($("#total_item").val(), 'Rp '));

        }
    }

    $("#pembayaran").keydown(function(event) {
        if (event.key === "Escape") {
            event.preventDefault();
            $('#pembayaran').val('');
        }
    });

    $("#form_pembayaran_transfer").keydown(function(event) {
        if (event.key === "Escape") {
            event.preventDefault();
            $('#reset_transfer').click();
            $('#pembayaran_transfer').focus();
            $('#pembayaran_transfer').attr('readonly', false);

        }
    });

    $("#pembayaran_transfer").keydown(function(event) {
        if (event.key === "F3") {
            event.preventDefault();
            $('#transfer_full').click();
        } else if (event.key === "Tab") {
            event.preventDefault();
            $('#nama_pemilik_bank').focus();
        }
    });

    $('#jatuh_tempo').keydown(function(event) {
        if (event.key === "F4") {
            event.preventDefault();
            $('#defaultCheck1').click();

        }
    });

    addEventListener("keydown", function(event) {
        if (event.key === "ArrowLeft") {
            event.preventDefault();
            $('#data_content').load("{{ route('index-transaksi', 'transaksi') }}");
        }

        if (event.key === "F1") {
            event.preventDefault();
            $('#cash-tab').click();
            $('#pembayaran').focus();

        } else if (event.key === "F2") {
            event.preventDefault();
            $('#transfer-tab').click();
            $('#pembayaran_transfer').focus();

        } else if (event.key == "F3") {
            event.preventDefault();

            transferFull();
        }

        if ($("#modalInfo").hasClass("show") == true) {
            if (event.key === "Enter") {
                event.preventDefault();
                doPrint();
            }
        } else {
            addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    cekData();

                }
            });
        }
    });

    function textPembayaran(status) {

        if (status == 'cash') {
            $('#total_pembayaran_cash').html(0, 'Rp ');
            $('#kembalian').html(0, 'Rp ');
            $('#reset_transfer').click();


            // TEXT
            $('#shortcut-f3').attr("hidden", true);
            $('#shortcut-pelanggan').attr("hidden", true);
            $('#shortcut-bawah').attr("hidden", true);
            $('#text_kembalian').attr("hidden", false);
            $('#text_pembayaran_tf').attr("hidden", true);
            $('#keterangan_pembayaran').html('Cash');
            $('#text_pembayaran_cash').attr("hidden", false);
            if ($('#jatuh_tempo').val()) {
                $('#jatuh_tempo').setAttribute(
                    "data-date",
                    moment($('#jatuh_tempo').val(), "YYYY-MM-DD")
                    .format($('#jatuh_tempo').getAttribute("data-date-format"))
                )
            } else {
                $($('#jatuh_tempo')).attr('data-date', 'dd/mm/yyyy');

            }

        } else if (status == 'transfer') {
            $('#pembayaran').val('');
            $('#keterangan_pembayaran').html('Transfer');
            $('#total_pembayaran_cash').html(FormatRupiah($("#total_item").val(), 'Rp '));

            // TEXT
            $('#shortcut-f3').attr("hidden", false);
            $('#shortcut-pelanggan').attr("hidden", true);
            $('#shortcut-bawah').attr("hidden", false);
            $('#shortcut-tf').attr("hidden", false);
            $('#text_kembalian').attr("hidden", true);
            $('#text_pembayaran_tf').attr("hidden", false);
            $('#text_pembayaran_cash').attr("hidden", false);
            $('#pembayaran_transfer').prop('readonly', false);
            if ($('#jatuh_tempo').val()) {
                $('#jatuh_tempo').setAttribute(
                    "data-date",
                    moment($('#jatuh_tempo').val(), "YYYY-MM-DD")
                    .format($('#jatuh_tempo').getAttribute("data-date-format"))
                )
            } else {
                $($('#jatuh_tempo')).attr('data-date', 'dd/mm/yyyy');

            }
        }
    }

    function modalStruk() {
        var modal = $("#modalInfo").modal({
            show: true,
            backdrop: 'static',
        });
        modal.find('.modal-dialog').addClass('modal-md');
        modal.find('.modal-title').text('Warning!!!!');
        $("#data_info").html(
            'Yakin Ingin Cetak Struk!?, Data Akan Tersimpan dan Tidak Bisa Dikembalikan! '
        );
        $('#footer').addClass('modal-footer');
        $('#footer').html(
            '<button type="button" class="btn btn-secondary" id="btn-close" data-bs-dismiss="modal">Close</button> <button type="button" class="btn btn-warning"  onclick="doPrint()">Cetak</button>'
        );
        $('.btn-close').click(function(e) {
            $("#modalInfo").modal('hide');

        });
        $('#btn-close').click(function(e) {
            $("#modalInfo").modal('hide');

        });
    }

    function cekData() {
        if ($("#cash").hasClass("active") == true) {
            if ($("#pembayaran").val() == 0 || $("#pembayaran").val() == "") {
                $("#pembayaran").focus();
                $("#pembayaran").css("border-color", "red");

            } else {
                var hasil = $("#pembayaran").val().replaceAll(".", "") - $("#total_item").val().replaceAll(".",
                    "");
                if (hasil >= 0) {

                    $("#status_pembayaran").val('cash');
                    modalStruk();


                } else {
                    $("#pembayaran").focus();
                    $("#pembayaran").css("border-color", "red");
                }
            }
        } else if ($("#transfer").hasClass("active") == true) {
            if ($("#pembayaran_transfer").val() == "" || $("#nama_pemilik_bank").val() == "" || $("#jenis_bank")
                .val() == "" || $("#bank_tujuan").val() == null) {
                if ($("#pembayaran_transfer").val() == "" || $("#pembayaran_transfer").val() == 0) {
                    $("#pembayaran_transfer").css("border-color", "red");
                    $("#pembayaran_transfer").focus();

                } else if ($("#nama_pemilik_bank").val() == "") {
                    $("#nama_pemilik_bank").css("border-color", "red");
                    $("#nama_pemilik_bank").focus();

                } else if ($("#jenis_bank").val() == "") {
                    $("#jenis_bank").css("border-color", "red");
                    $("#jenis_bank").focus();

                } else if ($("#bank_tujuan").val() == null) {
                    $("#bank_tujuan").css("border-color", "red");
                    $("#bank_tujuan").focus();
                }
            } else {
                $("#status_pembayaran").val('transfer');

                modalStruk();
            }
        }
    }

    function doPrint() {
        let link = "{{ route('pembayaran-transaksi') }}";
        let pembayaran = $("#pembayaran").val();

        var formData = "";
        if ($("#cash").hasClass("active") == true) {
            formData = new FormData();
            formData.append('pembayaran', pembayaran);
            formData.append('status', 'cash');
        } else if ($("#transfer").hasClass("active") == true) {
            formData = new FormData(document.getElementById('form_pembayaran_transfer'));
            formData.append('status', 'transfer');
        }

        $.ajax({
            url: link,
            method: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                location.href = "{{ url('kasir/index-print') }}/" + response;
            }
        });
    }

    $(".date").on("change", function() {
        console.log(this.value);
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
</script>
