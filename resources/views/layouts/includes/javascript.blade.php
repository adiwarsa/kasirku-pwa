{{-- Bootstrap --}}
<script src="{{ asset('jquery/jquery.min.js') }}"></script>
<script src="{{ asset('jquery/ajax.popper.min.js') }}"></script>
<script src="{{ asset('jquery/ajax.nicescroll.min.js') }}"></script>
<script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('jquery/ajax.moment.min.js') }}"></script>
<script src="{{ asset('../assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->


<!-- Template JS File -->
<script src="{{ asset('/assets/js/scripts.js') }}"></script>

<!-- Page Specific JS File -->

<!-- Page Specific JS File -->

<script type="text/javascript" charset="utf8" src="{{ asset('/DataTables/dataTables.js') }}"></script>
<script src="{{ asset('/scanJS/html5-qrcode.min.js') }}"></script>
<script src="{{ asset('/assets/js/custom.js') }}"></script>
<script src="{{ asset('/excel/jquery.table2excel.js') }}"></script>
<script src="{{ asset('/assets/apexcharts/apexcharts.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    /* Fungsi formatRupiah */
    // const formatRupiah = (money) => {
    //     return new Intl.NumberFormat('id-ID', {
    //         style: 'currency',
    //         currency: 'IDR',
    //         minimumFractionDigits: 0
    //     }).format(money);
    // }

    function FormatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function ucword(id, value) {

        value = value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        $(id).val(value);

    }

    Object.defineProperty(String.prototype, 'capitalize', {
        value: function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        },
        enumerable: false
    });

    function ModalTambah(href, size) {
        $.get(href, {}, function(data, status) {
            $("#form_tambah").html(data);
            var modal = $("#modalTambah").modal({
                show: true,
                backdrop: 'static',
            });
            modal.find('.modal-dialog').addClass(size);
        });
        $('.btn-close').click(function(e) {
            $("#modalTambah").modal('hide');

        });
    }

    function ModalEdit(href, size) {
        $.get(href, {}, function(data, status) {
            $("#form_edit").html(data);
            var modal = $("#modalEdit").modal({
                show: true,
                backdrop: 'static',
            });
            modal.find('.modal-dialog').addClass(size);
        });
        $('.btn-close').click(function(e) {
            $("#modalEdit").modal('hide');

        });
    }

    function ModalHapus(href) {
        $("#modalHapus").modal('show');
        $('.btn-close').click(function(e) {
            $("#modalHapus").modal('hide');

        });
        $('#btn_hapus').click(function(e) {
            location.href = href;
        });
    }

    function ModalInfo(href, title, size) {
        $.get(href, {}, function(data, status) {
            $("#data_info").html(data);
            var modal = $("#modalInfo").modal({
                show: true,
                backdrop: 'static',
            });
            modal.find('.modal-title').text(title);
            modal.find('.modal-dialog').addClass(size);
        });
        $('.btn-close').click(function(e) {
            $("#modalInfo").modal('hide');

        });
    }

    function ModalImport(action) {
        var modal = $("#ModalImport").modal({
            show: true,
            backdrop: 'static',
        });
        $('#form-import').attr('action', action);
        $('.btn-close').click(function(e) {
            $("#ModalImport").modal('hide');

        });
    };

    function FilterTanggal(status) {
        var tanggal_pertama = $('#tanggal_pertama');
        var tanggal_kedua = $('#tanggal_kedua');
        tanggal_pertama.css('border-color', '');
        tanggal_kedua.css('border-color', '');

        if (status == "tanggal_pertama") {

            tanggal_kedua.attr('min', tanggal_pertama.val());
        } else if (status == "tanggal_kedua") {

            tanggal_pertama.attr('max', tanggal_kedua.val());

        }
    }
</script>

<script type="module">
    import { Eggy } from '{{ asset("./eggyAlert/build/js/eggy.js") }}';
    function AlertEggy(type, message) {
        var title = "Berhasil!";

        if (type == 'error') {
            title = "Erorr!";
        }else if (type == 'warning') {
            title = "Warning!";
        }

        Eggy({
            title: title,
            message: message,
            position: 'top-right',
            duration: 3000,
            type: type

        });
    }
    window.AlertEggy=AlertEggy;

</script>

@if (session()->has('success'))
    <script type="module">
import { Eggy } from './eggyAlert/build/js/eggy.js';
Eggy({
    title: 'Success'
    , message: '{{ session('success') }}'
    , position: 'top-right'
    , duration: 3000,
    

});
</script>
@endif

@if (session()->has('errors'))
    <script type="module">
import { Eggy } from './eggyAlert/build/js/eggy.js';
Eggy({
    title: 'Errors'
    , message: '{{ session('errors') }}'
    , position: 'top-right'
    , duration: 3000,
    type:  'error'

});
</script>
@endif
@yield('container.js')
