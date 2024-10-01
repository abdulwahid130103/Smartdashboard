@extends('admin.layout.main')
@section('title', 'Rekap Retribusi - Smart Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Rekap Retribusi</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Retribusi</a></li>
                    <li class="breadcrumb-item active">Rekap Retribusi</li>
                </ol>
            </div>
            <div class="col-sm-6">
            </div>

        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
        </div>
        <div class="col-xl-12">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <h6>Tabel Rekap Retribusi</h6>
                    <div class="row">
                        <div class="col-lg-6"></div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-2">
                                        <select id="tahun_filter" name="tahun_filter" class="col-sm-12">
                                            @foreach (array_combine(range(date('Y'), 2018), range(date('Y'), 2018)) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <a class='btn btn-primary btn-sm' onclick='filterTahunRekap()'><i class='fa fa-search'></i>
                                        Terapkan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable_rekap_retribusi" id="datatable_rekap_retribusi">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Opd</th>
                                    <th>Nama Retribusi</th>
                                    <th>Januari</th>
                                    <th>Februari</th>
                                    <th>Maret</th>
                                    <th>April</th>
                                    <th>Mei</th>
                                    <th>juni</th>
                                    <th>Juli</th>
                                    <th>Agustus</th>
                                    <th>September</th>
                                    <th>Oktober</th>
                                    <th>November</th>
                                    <th>Desember</th>
                                    <th>Total Semua</th>
                                </tr>
                            </thead>
                        </table>
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
<script>

        const day = new Date();
        var currentYear = day.getFullYear();
        var currentMonth = day.getMonth() + 1;
        let pencapaianBulan = (100 / 12) * currentMonth;
        let pencapaianBulanLalu = (100 / 12) * (currentMonth - 1);
    function formatRupiah(angka){
        var options = {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
        };
        var formattedNumber = angka.toLocaleString('ID', options);
        return formattedNumber;
    }function formatRupiah(angka) {
            var options = {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
            };
            var formattedNumber = angka.toLocaleString('ID', options);
            return formattedNumber;
        }

        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function(e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function(e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function(e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };


    function datatable_rekap_retribusi(tahun_rekap = currentYear){
       var table = $(".datatable_rekap_retribusi").DataTable({
            dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                                "<'row'<'col-sm-12'tr>>" + // Add table
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [{
                "extend": 'excel',
                "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                "titleAttr": 'Export to Excel',
                "filename": 'Rekap Retribusi',
                "action": newexportaction
            }, ],
			processing: true,
	        serverSide: true,
	        responsive: true,
	        searchDelay: 2000,
	        ajax: {
                url : '{{ route('retribusi.rekap_retribusi.datatable_rekap_retribusi') }}',
                data : {
                    tahun : tahun_rekap,
                },
            },
	        columns: [
                {
                    data: 'no',
                    name: 'no'
                },
	            {
                    data: 'nama_opd',
                    name: 'nama_opd'
                },
	            {
                    data: 'nama_retribusi',
                    name: 'nama_retribusi'
                },
                {
                    data: 'januari',
                    name: 'januari'
                },
	            {
                    data: 'februari',
                    name: 'februari'
                },
	            {
                    data: 'maret',
                    name: 'maret'
                },
	            {
                    data: 'april',
                    name: 'april'
                },
	            {
                    data: 'mei',
                    name: 'mei'
                },
	            {
                    data: 'juni',
                    name: 'juni'
                },
	            {
                    data: 'juli',
                    name: 'juli'
                },
	            {
                    data: 'agustus',
                    name: 'agustus'
                },
	            {
                    data: 'september',
                    name: 'september'
                },
	            {
                    data: 'oktober',
                    name: 'oktober'
                },
	            {
                    data: 'november',
                    name: 'november'
                },
	            {
                    data: 'desember',
                    name: 'desember'
                },
	            {
                    data: 'total_semua',
                    name: 'total_semua'
                },
	        ],
            order: [[1, 'asc']],
		});
    }

    function filterTahunRekap(){
        var tahun_rekap = $('#tahun_filter').val();
        $("#datatable_rekap_retribusi").DataTable().destroy();
        datatable_rekap_retribusi(tahun_rekap);
    }

	$(document).ready(function(){
        $("#tahun_filter").select2({
            placeholder: "Pilih Tahun"
        });
        datatable_rekap_retribusi(currentYear);

	})
</script>
@endsection
