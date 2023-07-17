@extends('layouts.app')
@section('active_laporan', 'active')
@section('container.isi')
@section('container.css')
<style>
  .btn-cash {
    padding: 3px 7px !important;
    border-radius: 2px !important;
    font-size: 0.613rem !important;
    width: 160px !important;
    margin: 0 auto !important;
    background-color: #dffaec !important;
    color: #59de38 !important;
    height: 20px !important;
    line-height: normal;
    text-transform: uppercase;
    font-family: 'Neuton_Reguler' !important;
  }

  .btn-transfer {
    padding: 3px 7px !important;
    border-radius: 2px !important;
    font-size: 0.613rem !important;
    width: 160px !important;
    margin: 0 auto !important;
    background-color: #dff9fa !important;
    color: #388bde !important;
    height: 20px !important;
    line-height: normal;
    text-transform: uppercase;
    font-family: 'Neuton_Reguler' !important;
  }

  .pointer {
    cursor: pointer;
  }

  @media (min-width: 298px) and (max-width:574px) {
    .custom-date {
      height: 2.2rem !important;
      width: 160% !important;
      margin: 1 !important;
    }

    .button-filter {
      display: none;
    }

    .custom-flex {
      flex-direction: column;
    }

    .flexxx {
      display: flex;
      margin-top: 1rem;
      width: 120% !important;
    }

    .custom-center-flex {
      -ms-flex-pack: start !important;
      justify-content: flex-start !important;
    }

    .hiddenn {
      display: none;
    }
  }

  @media (min-width: 576px) {
    .center-div {
      margin: auto !important;
    }

    .custom {
      margin-left: .5rem;
    }

    .custom-date {
      height: 2.2rem !important;
      width: 130% !important;
      margin: 1 !important;
    }

    .button-filter2 {
      display: none;
    }

    .custom-flex {
      -ms-flex-pack: distribute !important;
      justify-content: space-around !important;
      padding: 0;
    }

    .custom-center-flex {
      -ms-flex-pack: center !important;
      justify-content: center !important;
    }

    .flexxx {
      display: none;
    }
  }

</style>
@endsection
<div class="section-body">
  <div class="row">
    <div class="col-8 d-flex justify-content-center center-div">
      <form id="formPencarian" method="POST">
        <div class="row">
          <div class="mb-3 col-sm-4 col-md-4 col-lg-4">
            <label for="tanggal_pertama" class="form-label">Tanggal Pertama</label>
            <input type="date" class="form-control date custom-date" id="tanggal_pertama" name="tanggal_pertama" onchange="FilterTanggal('tanggal_pertama')" data-date-format="DD/MM/YYYY" required>
          </div>
          <div class="mb-3  col-sm-4 col-md-4 col-lg-4 custom">
            <label for="tanggal_kedua" class="form-label">Tanggal Kedua</label>
            <input type="date" class="form-control date custom-date" id="tanggal_kedua" name="tanggal_kedua" onchange="FilterTanggal('tanggal_kedua')" data-date-format="DD/MM/YYYY" ">
                    </div>
                    <div class=" ml-2 col-sm-1 col-md-1 col-lg-1 button-filter" style="margin-top: 7.1%;">
            <button type="button" class="btn btn-danger" id="btn_x" onclick="location.reload();" disabled>X</button>
          </div>
          <div class="ml-2 col-sm-1 col-md-1 col-lg-1 button-filter" style="margin-top: 7.1%;">
            <button type="button" class="btn btn-primary" onclick="FilterLaporan('tanggal')">Submit</button>
          </div>
        </div>
        <div class="button-filter2">
          <button type="button" class="btn btn-danger" id="btn_x" onclick="location.reload();" disabled>X</button>
          <button type="button" class="btn btn-primary" onclick="FilterLaporan('tanggal')">Submit</button>

        </div>
      </form>
    </div>
    <div class="col-12 d-flex justify-content-center mt-3">
      <div class="selectgroup selectgroup-pills">
        <label class="selectgroup-item">
          <input type="checkbox" name="cash" value="cash" class="selectgroup-input cash" onclick="FilterLaporan('status')" id="cash">
          <span class="selectgroup-button">Cash</span>
        </label>
      </div>
      <div class="selectgroup selectgroup-pills">
        <label class="selectgroup-item">
          <input type="checkbox" name="transfer" value="transfer" class="selectgroup-input transfer" onclick="FilterLaporan('status')" id="transfer">
          <span class="selectgroup-button">Transfer</span>
        </label>
      </div>
    </div>
    <div class="col-12 d-flex custom-center-flex mt-3">
      <div class="mb-2 ">
        <div class="d-flex custom-flex">
          <div class="col-md-4 col-lg-4 hiddenn">
            <label class="form-label pointer" for="pendapatan">Total Penjualan</label>
            <h5 class="pointer" id="pendapatan" onclick="detailPendapatan_Keuntungan('pendapatan')" title="Klik Untuk Melihat Detail Pendapatan!">
              @currency($pendapatan)</h5>
            <input type="hidden" id="cek_pendapatan" value="{{ $pendapatan }}">
          </div>
          <div class="col-md-4 col-lg-4 hiddenn">
            <label class="form-label pointer" for="keuntungan">Total Keuntungan</label>
            <h5 class="pointer" id="keuntungan" onclick="detailPendapatan_Keuntungan('keuntungan')" title="Klik Untuk Melihat Detail Keuntungan!">
              @currency($keuntungan)</h5>
            <input type="hidden" id="cek_keuntungan" value="{{ $keuntungan }}">
          </div>
          <div class="col-md-4 col-lg-4 hiddenn">
            <label class="form-label pointer" for="cek_tf_br">Total TF BANK BRI</label>
            <h5 class="pointer" id="text_bank_bri" onclick="detailBank('BRI')" title="Klik Untuk Melihat Detail TF BANK BRI!">
              @currency($data['total_tf_bri']->sum('pembayaran_transfer'))</h5>
            <input type="hidden" id="cek_tf_bri" value="{{ $data_bank['bri'] }}">
          </div>
          <div class="col-md-4 col-lg-4 hiddenn">
            <label class="form-label pointer" for="cek_tf_bpd">Total TF BANK BPD</label>
            <h5 class="pointer" id="text_bank_bpd" onclick="detailBank('BPD')" title="Klik Untuk Melihat Detail TF BANK BPD!">
              @currency($data['total_tf_bpd']->sum('pembayaran_transfer'))</h5>
            <input type="hidden" id="cek_tf_bpd" value="{{ $data_bank['bpd'] }}">
          </div>
          <div class="flexxx">
            <div class="col-md-4 col-lg-4">
              <label class="form-label pointer" for="pendapatan">Total Penjualan</label>
              <h5 class="pointer" id="pendapatan" onclick="detailPendapatan_Keuntungan('pendapatan')" title="Klik Untuk Melihat Detail Pendapatan!">
                @currency($pendapatan)</h5>
              <input type="hidden" id="cek_pendapatan" value="{{ $pendapatan }}">
            </div>
            <div class="col-md-4 col-lg-4">
              <label class="form-label pointer" for="keuntungan">Total Keuntungan</label>
              <h5 class="pointer" id="keuntungan" onclick="detailPendapatan_Keuntungan('keuntungan')" title="Klik Untuk Melihat Detail Keuntungan!">
                @currency($keuntungan)</h5>
              <input type="hidden" id="cek_keuntungan" value="{{ $keuntungan }}">
            </div>
          </div>
          <div class="flexxx">
            <div class="col-md-4 col-lg-4">
              <label class="form-label pointer" for="cek_tf_br">Total TF BANK BRI</label>
              <h5 class="pointer" id="text_bank_bri" onclick="detailBank('BRI')" title="Klik Untuk Melihat Detail TF BANK BRI!">
                @currency($data['total_tf_bri']->sum('pembayaran_transfer'))</h5>
              <input type="hidden" id="cek_tf_bri" value="{{ $data_bank['bri'] }}">
            </div>
            <div class="col-md-4 col-lg-4">
              <label class="form-label pointer" for="cek_tf_bpd">Total TF BANK BPD</label>
              <h5 class="pointer" id="text_bank_bpd" onclick="detailBank('BPD')" title="Klik Untuk Melihat Detail TF BANK BPD!">
                @currency($data['total_tf_bpd']->sum('pembayaran_transfer'))</h5>
              <input type="hidden" id="cek_tf_bpd" value="{{ $data_bank['bpd'] }}">
            </div>
          </div>
          <input type="hidden" id="invoice_id" value="{{ $data_id_invoice }}">
          <input type="hidden" id="cek_pembayaran" value="kosong">
          <input type="hidden" id="cek_tanggal" value="kosong">
        </div>
      </div>
    </div>
  </div>
  <div id="diable-btn">
    <a href="javascript:void(0)" class="btn btn-icon btn-success mb-3" title="Klik 2x Untuk Export Excel!" id="button-export-excel-laporan">
      <i class="fa fa-file-excel"></i>
    </a>
  </div>
  <div class="row">
    <div class="col-12 ">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive" id="data_tabel">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="data_pendapatan" value="0">
<input type="hidden" id="klik_apa" value="tidak">
<input type="hidden" id="hari_down" value="{{ $data['hari'] }}">
<div id="tabel-excell" hidden>

</div>
@section('container.js')
<script>
  $(document).ready(function() {
    tabelLaporan();
    tabelExcel();
  });

  // Read Data Laporan
  function tabelLaporan() {
    $.get("{{ route('tabel-laporan') }}", {}, function(data, status) {
      $("#data_tabel").html(data);
    });
  };

  function FilterLaporan(cek_status) {
    var cash = document.getElementById("cash");
    var transfer = document.getElementById("transfer");
    var tanggal1 = document.getElementById("tanggal_pertama");
    var tanggal2 = document.getElementById("tanggal_kedua");
    var link = "{{ route('tabel-laporan-pencarian') }}";

    var tanggal_awal = "";
    var tanggal_akhir = "";
    var cek_data_dibawa = "";
    var pembayaran = 0;
    var tanggal = "";

    var cek_klik = 0;

    if (cash.checked == true && transfer.checked == false) {
      // console.log("cash cek");
      pembayaran = 1 + " " + cash.value;
      // console.log(pembayaran);

    } else if (cash.checked == false && transfer.checked == true) {
      // console.log("transfer cek");
      pembayaran = 1 + " " + transfer.value;
      // console.log(pembayaran);

    } else if (cash.checked == true && transfer.checked == true) {
      // console.log("cash dan transfer cek");
      pembayaran = 2 + " " + cash.value + " " + transfer.value;
      // console.log(pembayaran);

    } else {
      pembayaran = 0;
    }

    if (cek_status == 'status') {
      if (tanggal1.value != "" && tanggal2.value != "" && pembayaran == 0) {
        cek_klik = 1;
      } else if (pembayaran != "") {
        cek_klik = 1;
      }
    } else if (cek_status == 'tanggal') {
      if (tanggal1.value == "" && tanggal2.value == "") {
        tanggal1.style.borderColor = "red";
        tanggal2.style.borderColor = "red";
        cek_klik = 2;
      } else if (tanggal1.value != "" || tanggal2.value != "") {
        cek_klik = 1;
      }
    }


    if (cek_klik == 1) {

      if (tanggal1.value != "" || tanggal2.value != "") {
        document.getElementById("btn_x").disabled = false;

        if (tanggal1.value == "") {
          tanggal1.style.borderColor = "red";

        } else if (tanggal2.value == "") {
          tanggal2.style.borderColor = "red";

        } else if (tanggal1.value != "" && tanggal2.value != "" && pembayaran == 0) {
          tanggal_awal = tanggal1.value;
          tanggal_akhir = tanggal2.value;
          cek_data_dibawa = 'tanggal saja';
          // console.log('tanggal23');
        } else if (tanggal1.value != "" && tanggal2.value != "" && pembayaran != "") {
          tanggal_awal = tanggal1.value;
          tanggal_akhir = tanggal2.value;
          cek_data_dibawa = 'tanggal dan status';
          // console.log('keduanya23');
        }
        tanggal = tanggal_awal + " " + tanggal_akhir;
      } else if (pembayaran != "") {

        tanggal_awal = "kosong"
        tanggal_akhir = "kosong";
        cek_data_dibawa = 'status saja';
        tanggal = "kosong";
      }

      $.ajax({
        url: link
        , method: 'post'
        , data: {
          'tanggal_pertama': tanggal_awal
          , 'tanggal_kedua': tanggal_akhir
          , 'cek': cek_data_dibawa
          , 'pembayaran': pembayaran,

        }
        , success: function(response) {
          $('#data_tabel').html(response);
        }
      });
      $.get("{{ url('laporan/keuntungan') }}/" + tanggal + "/" + pembayaran + "/" + cek_data_dibawa, {}
        , function(
          data
          , status) {
          $("#pendapatan").html(FormatRupiah(data['pendapatan'], 'Rp '));
          $("#keuntungan").html(FormatRupiah(data['keuntungan'], 'Rp '));
          $("#text_bank_bri").html(FormatRupiah(data['total_bank_bri'], 'Rp '));
          $("#text_bank_bpd").html(FormatRupiah(data['total_bank_bpd'], 'Rp '));
          document.getElementById("cek_tf_bri").value = data['data_bank_bri'];
          document.getElementById("cek_tf_bpd").value = data['data_bank_bpd'];
          document.getElementById("invoice_id").value = data['id_invoice'];
          document.getElementById("cek_pembayaran").value = data['cek_pembayaran'];
          document.getElementById("cek_tanggal").value = data['cek_tanggal'];
          document.getElementById("cek_pendapatan").value = data['pendapatan'];
          document.getElementById("cek_keuntungan").value = data['keuntungan'];
          tabelExcel();

          if (document.getElementById("invoice_id").value == 0) {
            $("#diable-btn").hide();

          } else {
            $("#diable-btn").show();
          }

        });

    } else if (cek_klik == 0) {
      location.reload();
    }
  }

  function detailPendapatan_Keuntungan(cek_status) {
    // $('#modalInfo').css('opacity', '1');

    var data_invoice_id = document.getElementById("invoice_id").value;
    var klik_apa = document.getElementById("klik_apa").value;
    var data_cek_pembayaran = document.getElementById("cek_pembayaran").value;
    var data_cek_tanggal = document.getElementById("cek_tanggal").value;
    var pendapatan = document.getElementById("cek_pendapatan").value;
    var keuntungan = document.getElementById("cek_keuntungan").value;
    var data = 0;
    // console.log(data_cek_tanggal);
    if (cek_status == "pendapatan") {
      if (pendapatan > 0) {
        data = 1;
      }
    } else if (cek_status == "keuntungan") {
      if (keuntungan > 0 || data_pengeluaran_id.length > 0) {
        data = 1;
      }
    }
    if (data_cek_pembayaran == 0) {
      data_cek_pembayaran = "kosong";
    }

    if (data == 1) {
      var lempar_data = cek_status + "/" + data_invoice_id + "/" + data_cek_pembayaran + "/" + data_cek_tanggal +
        "/" + klik_apa;

      $.get("{{ url('laporan/detail-pendapatan-keuntungan') }}/" + lempar_data, {}, function(data, status) {

        if (klik_apa == "tidak") {

          $("#data_info").html(data);

          var modal = $("#modalInfo").modal({
            show: true
          , });
          modal.find('.modal-dialog').addClass('modal-xl');

          // $('#modalInfo').on('shown.bs.modal', function() {
          //     $("#modalInfo").modal({
          //         show: true,
          //         backdrop: 'static',
          //     });
          // });



          if (cek_status == "pendapatan") {
            modal.find('.modal-title').text('Detail Penjualan');
          } else if (cek_status == "keuntungan") {
            modal.find('.modal-title').text('Detail Keuntungan');

          }
          $('.btn-close').click(function(e) {
            modal.modal('hide');

          });
        } else if (klik_apa == "ya") {
          console.log(data);
          $('#data_pendapatan').val(data['id_pendapatan_invoice']);
        }

      });
    }

  }

  function detailBank(status) {
    var bri = $('#cek_tf_bri').val();
    var bpd = $('#cek_tf_bpd').val();
    var data = "";
    var data_cek = "";
    var data_cek2 = 0;

    if (status == "BRI") {
      data = bri;
      data_cek = 1;
      if (bri != 0) {
        data_cek2 = 1;
      }

    } else if (status == "BPD") {
      data = bpd;
      data_cek = 2;
      if (bpd != 0) {
        data_cek2 = 1;
      }
    }

    if (data_cek2 == 1) {

      $.get("{{ url('laporan/detail-bank') }}/" + data + "/" + status, {}, function(data, status) {
        $("#data_info").html(data);

        var modal = $("#modalInfo").modal({
          show: true
        , });

        if (data_cek == 1) {
          modal.find('.modal-title').text('Detail BANK BRI');
        } else if (data_cek == 1) {
          modal.find('.modal-title').text('Detail BANK BPD');
        }
        modal.find('.modal-dialog').addClass('modal-xl');

        $('.btn-close').click(function(e) {
          modal.modal('hide');
        });
      });
    }

  }

  function infoLaporan(id, status) {
    var cek_status = status;

    $.get("{{ url('laporan/info-laporan') }}/" + id + "/" + cek_status, {}, function(data, status) {
      $("#data_info").html(data);
      var modal = $("#modalInfo").modal({
        show: true
        , backdrop: 'static'
      , });
      modal.find('.modal-dialog').addClass('modal-xl');

      if (cek_status == "laporan") {
        modal.find('.modal-title').text('Detail Laporan');
      } else if (cek_status == "pembayaran") {
        modal.find('.modal-title').text('Detail Pembayaran');

      }
      $('.btn-close').click(function(e) {
        modal.modal('hide');

      });
    });
  };

  function tabelExcel() {

    var klik_apa = document.getElementById("klik_apa").value = "ya";
    $('#pendapatan').click();

    var invoice_id = $('#invoice_id').val();
    var bri_id = $('#cek_tf_bri').val();
    var bpd_id = $('#cek_tf_bpd').val();
    var data_pendapatan = $('#data_pendapatan').val();


    var data_dibawa = invoice_id + "/" + data_pendapatan + "/" +
      bri_id + "/" + bpd_id;
    $.get("{{ url('laporan/tabel-excel') }}/" + data_dibawa, {}, function(data, status) {

      $('#tabel-excell').html(data);

    });
    var klik_apa = document.getElementById("klik_apa").value = "tidak";

  }
  $(function() {
    $("#button-export-excel-laporan").click(function() {
      tabelExcel();

      $("#export-excel-laporan").table2excel({
        // exclude CSS class
        // exclude: ".centerrr",
        sheetName: "Sheet"
        , filename: "Data Laporan " + $('#hari_down').val(), //do not include extension
        fileext: ".xls", // file extension
        preserveColors: true

      });
    });
  });

  $(".date").on("change", function() {
    if (this.value) {
      this.setAttribute(
        "data-date"
        , moment(this.value, "YYYY-MM-DD")
        .format(this.getAttribute("data-date-format"))
      )
    } else {
      $(this).attr('data-date', 'dd/mm/yyyy');

    }
  }).trigger("change")

</script>
@endsection
@endsection
