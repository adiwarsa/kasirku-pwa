<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $data['title'] }} &mdash; {{ $data['toko']->nama_toko }}</title>

    @include('layouts.includes.css')

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            @include('layouts.includes.navbar')

            @include('layouts.includes.sideBar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1 style="font-family: 'Lt_Museum_Light' !important;">{{ $data['title'] }}</h1>
                    </div>

                    @yield('container.isi')
                    <input type="hidden" id="data_pencarian" value="">

                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    <div class="bullet"></div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambah">Tambah Data</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="form_tambah">
                </div>
            </div>
        </div>
    </div>{{-- End Modal Tambah  --}}

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit">Edit Data</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="form_edit">
                </div>
            </div>
        </div>
    </div>{{-- End Modal Edit  --}}


    <!-- modal hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapus" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalHapus">Hapus Data!</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin Ingin Menghapus!?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close" data-dismiss="modal">Close</button>
                    <a href="javascript:void(0)" type="submit" class="btn btn-danger" id="btn_hapus">Hapus</a>
                </div>
            </div>
        </div>
    </div> <!-- end modal hapus -->

    <!-- Modal Info -->
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfo"></h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="data_info">
                </div>
                <div id="footer">
                </div>
            </div>
        </div>
    </div>{{-- End Modal Info  --}}

    <!-- Modal Import-->
    <div class="modal fade" id="ModalImport" tabindex="-1" aria-labelledby="ModalImport" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalImport">Import CSV</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="form-import">
                        @csrf

                        <div class="mb-3 col-md-12">
                            <div class="custom-file file-custom">
                                <input type="file" name="file" class="custom-file-input"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    id="site-favicon">
                                <label class="custom-file-label">Choose File</label>
                            </div>

                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>{{-- End Modal Import --}}


    @include('layouts.includes.javascript')

</body>

</html>
