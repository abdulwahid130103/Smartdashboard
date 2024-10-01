@extends('admin.layout.main')
@section('title', 'Manajamen Retribusi OPD')

@section('content')
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="page-header">
                <h1 class="page-title">Manajamen Retribusi (OPD {{ $data['nama_opd'] }})</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah</a></li>
                    <li class="breadcrumb-item active">Retribusi</li>
                </ol>
            </div>
        </div>
        <div class="panel">
            <header class="panel-heading">
                <h3 class="panel-title">
                    <button type="button" class="btn btn-primary" id="btn_tambah"><i class='fa fa-plus'></i></button>
                </h3>
            </header>
            <div class="panel-body">
                <table class="table table-hover dtTable table-striped w-full display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="examplemodal" aria-hidden="true" aria-labelledby="examplemodal" role="dialog">
        <div class="modal-dialog modal-simple modal-top modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-backdrop="static"
                        data-keyboard="false" id="btn-close-modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title"></h4>
                </div>
                <form id="form_modal" autocomplete="off">
                    <input type="hidden" name="popup_id">
                    <input type="hidden" name="popup_idgrup" value="{{ $data['id'] }}">
                    <div class="modal-body" id="modal_body">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Retribusi</label>
                            <div class="col-lg-9">
                                <select name="popup_grup" id="popup_grup" class="form-control" style="width: 100%">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="modal_footer">
                        <button type="button" class="btn btn-primary" id="btn_simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script type="text/javascript">
        $('#btn-close-modal').on('click', function() {
            $('#examplemodal').modal('hide');
        });
        var table;
        $(document).ready(function() {
            $("[name=popup_grup]").select2({
                dropdownParent: $("#examplemodal")
            });

            get_menu();

            table = $(".dtTable").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: '{{ route('retribusi.kelola-opd.get_data_detail') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(data) {
                        data.id = "{{ $data['id'] }}";
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama_retribusi',
                        name: 'nama_retribusi'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        })

        $("#btn_tambah").click(function() {
            clear_input();
            $("#modal_title").text("Tambah");
            $("#examplemodal").modal('show');
        })

        function clear_input() {
            $("[name=popup_id]").val('');
            $("[name=popup_grup]").val('');
        }

        $("#btn_simpan").click(function() {
            var id = $("[name=popup_id]").val();
            var nama = $("[name=popup_grup]").val();

            if (nama != '') {
                $.ajax({
                    url: "{{ route('retribusi.kelola-opd.simpan_retribusi') }}",
                    type: "POST",
                    dataType: "json",
                    data: $("#form_modal").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(respon) {
                        table.ajax.reload();
                        get_menu();
                        $("#examplemodal").modal('hide');
                    }
                })
            } else {

            }

        })

        function hapus(this_) {
            var id = $(this_).data("id");
            swal({
                title: "Hapus data?",
                text: "Anda akan menghapus data ini",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: 'Ya',
                cancelButtonText: "Tidak",
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('retribusi.kelola-opd.hapus_detail') }} ",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(respon) {
                            if (respon.status == 1) {
                                swal("", respon.keterangan, "success");
                            } else {
                                swal("", respon.keterangan, "error");
                            }
                            table.ajax.reload();
                        }
                    })
                }
            })
        }


        function trigger(value) {
            $(value).html("<option value=''> -- Pilih -- </option>");
            $(value).val("").trigger("change");
        }

        function get_menu() {
            var id = "{{ $data['id'] }}";
            if (id != '') {
                $.ajax({
                    url: "{{ url('retribusi/kelola-opd/detail/get_retribusi') }}",
                    type: "post",
                    dataType: 'html',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(respon) {
                        $("[name=popup_grup]").html(respon);
                    }
                })
            } else {}
        }
    </script>
@endsection
