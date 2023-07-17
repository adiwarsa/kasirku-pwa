@extends('layouts.app')
@section('container.isi')
@section('profile', 'index-profile')
@section('container.css')
    <style>
        .setting-custom {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
            box-shadow: 0 20px 20px rgba(14, 14, 14, 0.05);
        }

        label {
            font-weight: bold;
        }

        .iconBox {
            position: absolute;
            top: 64.5%;
            left: 88%;
            cursor: pointer;
        }



        .img-custom-setting {
            margin-left: 35%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
        }

        .file-custom {
            margin-top: 4%;
        }

        .iconX {
            position: absolute;
            margin-left: -1.5%;
            margin-top: -1%;
            cursor: pointer;

        }

        .iconX:hover {
            color: red;
        }
    </style>
@endsection

<div class="row">
    <div class="col-12  col-lg-12">
        <div class="card">
            <div class="card-body mt-4">
                @if (auth()->user()->role == 1)
                    <ul class="nav nav-pills wizard-steps justify-content-center mb-4" id="myTab3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                aria-controls="home" aria-selected="true">
                                <div class="wizard-step ">
                                    <div class="wizard-step-icon">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        User Account
                                    </div>
                                </div>
                            </a>
                        </li>&emsp;
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                aria-controls="profile" aria-selected="false">
                                <div class="wizard-step ">
                                    <div class="wizard-step-icon">
                                        <i class="fas fa-house-damage"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        Pengaturan
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                @endif
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row setting-custom">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ auth()->user()->name }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        value="{{ auth()->user()->email }}" />
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="old_password" class="form-label">Password Lama</label>
                                    <input class="form-control" type="password" id="old_password" name="old_password"
                                        placeholder="Masukkan Password Lama" onchange="myFunction()" />
                                    <i class='fas fa-eye-slash eyes1 iconBox' onclick="eyes1()"></i>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        placeholder="Masukkan Password Baru" onchange="myFunction()" />
                                    <i class='fas fa-eye-slash eyes2 iconBox' onclick="eyes2()"></i>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="cek_password" class="form-label">Konfirm Password</label>
                                    <input type="password" class="form-control" id="cek_password" name="cek_password"
                                        placeholder="Konfirmasi Password Baru" onchange="myFunction()" />
                                    <i class='fas fa-eye-slash eyes3 iconBox' onclick="eyes3()"></i>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="telp">No Telepon</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" id="telp" name="telp" class="form-control"
                                            placeholder="8123********" value="{{ auth()->user()->telp }}"
                                            style="height: 3.5em" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" style="height: 3.5em">{{ auth()->user()->alamat }}</textarea>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="alamat" class="form-label">Foto</label>
                                    <div class="custom-file file-custom">
                                        <input type="file" name="foto" class="custom-file-input"
                                            accept="image/png, image/jpeg" id="site-favicon"
                                            onchange="previewImage()">
                                        <label class="custom-file-label">Choose File</label>
                                    </div>

                                </div>
                                <div class="mb-3 col-md-6">
                                    @if (auth()->user()->foto == null)
                                        <img alt="image" src="{{ asset('../assets/img/avatar/avatar-1.png') }}"
                                            class="img-custom-setting img-preview">
                                        <i class="fa fa-times iconX" style='font-size:24px' onclick="btnX()"></i>
                                    @else
                                        <img alt="image"
                                            src="{{ asset('/image/profile/' . auth()->user()->foto) }}"
                                            class="img-custom-setting img-preview">
                                        <i class="fa fa-times iconX" style='font-size:24px' onclick="btnX()"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2" id="btn-sumbit">Save</button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <form class="wizard-content mt-2" action="{{ route('update-shop', 1) }}" method="POST">
                            @csrf
                            <div class="wizard-pane">
                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">Nama Toko</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="text" name="nama_toko" id="nama_toko" class="form-control"
                                            onkeyup="namaToko()" value="{{ $data['toko']->nama_toko }}">
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-md-4 text-md-right text-left">No Telepon Toko</label>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="no_telepon_toko" name="no_telepon_toko" class="form-control"
                                            value="{{ $data['toko']->no_telepon_toko }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 text-md-right text-left mt-2">Alamat Toko</label>
                                    <div class="col-lg-4 col-md-6">
                                        <textarea class="form-control" name="alamat_toko" style="height: 10em">{{ $data['toko']->alamat_toko }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-lg-4 col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary me-2"
                                            id="btn-sumbit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('container.js')
    <script>
        $(document).ready(function() {
            var old_password = document.getElementById("old_password");
            var new_password = document.getElementById("new_password");
            var cek_password = document.getElementById("cek_password");

            old_password.addEventListener("keyup", disable);
            new_password.addEventListener("keyup", disable);
            cek_password.addEventListener("keyup", disable);
        });

        function eyes1() {
            var eyes1 = $(".eyes1");

            if (old_password.type === "password") {
                old_password.type = "text";
                eyes1.removeClass("fa-eye-slash");
                eyes1.addClass("fa-eye");
            } else {
                old_password.type = "password";
                eyes1.removeClass("fa-eye");
                eyes1.addClass("fa-eye-slash");
            }
        }

        function eyes2() {
            var eyes2 = $(".eyes2");

            if (new_password.type === "password") {
                new_password.type = "text";
                eyes2.removeClass("fa-eye-slash");
                eyes2.addClass("fa-eye");
            } else {
                new_password.type = "password";
                eyes2.removeClass("fa-eye");
                eyes2.addClass("fa-eye-slash");
            }
        }

        function eyes3() {
            var eyes3 = $(".eyes3");

            if (cek_password.type === "password") {
                cek_password.type = "text";
                eyes3.removeClass("fa-eye-slash");
                eyes3.addClass("fa-eye");
            } else {
                cek_password.type = "password";
                eyes3.removeClass("fa-eye");
                eyes3.addClass("fa-eye-slash");
            }
        }

        function previewImage() {
            const image = document.querySelector('#site-favicon');
            const imgPreview = document.querySelector('.img-preview')

            // imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.removeAttribute('src');
                imgPreview.src = oFREvent.target.result;
            }
        }

        function myFunction() {
            if (new_password.value == "" && cek_password.value == "" && old_password.value == "") {

            } else {
                if (new_password.value != "" && cek_password.value != "") {
                    document.getElementById("btn-sumbit").disabled = true;
                    if (new_password.value == cek_password.value) {

                        if (old_password.value == "") {
                            document.getElementById("btn-sumbit").disabled = true;
                        } else {
                            document.getElementById("btn-sumbit").disabled = false;
                        }

                    } else {
                        cek_password.style.borderColor = "red";
                        document.getElementsByName('cek_password')[0].placeholder = 'Password Tidak Sama!';
                        cek_password.value = "";
                        cek_password.focus();
                    }
                }

            }
        }

        function disable() {
            if (new_password.value != "" || cek_password.value != "" || old_password.value != "") {
                document.getElementById("btn-sumbit").disabled = true;

            } else {
                document.getElementById("btn-sumbit").disabled = false;

            };
        }

        function btnX() {
            const imgPreview = document.querySelector('.img-preview')
            imgPreview.removeAttribute('src');
            imgPreview.src =
                "@if (auth()->user()->foto == null){{ asset('../assets/img/avatar/avatar-1.png') }}@else{{ asset('/image/profile/' . auth()->user()->foto) }}@endif";
            document.querySelector('#site-favicon').value = "";
        }

        function namaToko() {
            var nama_toko = $('#nama_toko');
            ucword('#nama_toko', nama_toko.val());

            if (nama_toko.val().length > 15) {
                AlertEggy('error', 'Maksimal 15 Karakter!');
                nama_toko.val('');
                nama_toko.focus();
            }
        }
    </script>


@endsection
@endsection
