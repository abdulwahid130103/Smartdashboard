@extends('admin.layout.main')
@section('title', 'Update Password - Smart Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Password</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Update</a></li>
                        <li class="breadcrumb-item active">Password</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid chart-widget">

        <div class="row">
            <div class="col-xl-12">
                <div class="row draggable">
                    <div class="card o-hidden">
                        <div class="card-header pb-0">
                            <h6>Update Password</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-5">
                                <div class="block block-rounded block-themed">
                                    <div class="block-content pb-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    @php
                                                        $session =  Session::get("user_app");
                                                        $id = decrypt($session['group_id']);
                                                        $id_user = decrypt($session['user_id']);
                                                        $data = DB::table('auth.user_group')->select("*")->where("id",$id)->first();
                                                    @endphp
                                                    <input type="text" class="form-control d-none" value="{{ $id_user }}" id="id_user_password">
                                                    <div class="mb-4">
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-key"></i>
                                                            </span>
                                                            <input type="password" class="form-control"
                                                                placeholder="Masukkan Password Baru ..." id="password-baru"
                                                                name="password-baru">
                                                            <button type="button" class="btn btn-outline-primary toggle-password">
                                                                <i class="fa fa-eye"></i> Show
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="form-label" for="example-text-input">Konfirmasi Password</label>
                                                    <div class="mb-4 input-group">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-key"></i>
                                                        </span>
                                                        <input type="password" class="form-control" placeholder="Konfirmasi password ..."
                                                            id="konfirmasi-password" name="konfirmasi-password">
                                                        <button type="button" class="btn btn-outline-primary toggle-password">
                                                            <i class="fa fa-eye"></i> Show
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary button-update-password"
                                                    data-toggle="layout" data-action="header_search_off">
                                                    <i class="fa fa-check-circle opacity-50 me-1"></i> Update Password
                                                </button>
                                            </div>
                                        </div>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('js')

    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>


        function updateProfile() {
            $('body').on('click', '.button-update-password', function(e) {
                e.preventDefault();
                var iduser = $('#id_user_password').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var newPassword = $('#password-baru').val();
                var confirmPassword = $('#konfirmasi-password').val();
                // alert("masuk");


                if (newPassword.trim() === '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password baru harus diisi',
                        icon: 'error',
                        timer: 5000,
                    });
                    return;
                }

                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password tidak sama',
                        icon: 'error',
                        timer: 5000,
                    });
                    return;
                }


                $.ajax({
                    url: "/login/update_password/" + iduser,
                    type: 'POST',
                    data: {
                        password_baru: newPassword,
                        _token: csrfToken
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Password berhasil diperbarui',
                                icon: 'success',
                                timer: 5000,
                            });

                            $('#password-baru').val('');
                            $('#konfirmasi-password').val('');
                        } else {
                            var errorMessages = "<ul>";
                            $.each(response.error, function (key, value) {
                                errorMessages += "<li>" + value + "</li>";
                            });
                            errorMessages += "</ul>";
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                html: errorMessages,
                            });
                        }
                    }
                });
            });
        }
        $(document).on('click', '.toggle-password', function() {
            $(this).toggleClass('show-password');
            var input = $(this).siblings('input');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i> Hide');
            } else {
                input.attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i> Show');
            }
        });
        $(document).ready(function() {
            updateProfile();
        })
    </script>
@endsection
