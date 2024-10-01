@extends('admin.layout.main')
@section('title', 'Tunggakan PBB - Smart Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Tunggakan PBB</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">PBB</a></li>
                        <li class="breadcrumb-item active">Tunggakan</li>
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
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h6>Penerimaan dan Tunggakan (NOP)</h6>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-5 mb-2 col-md-4 col-sm-6">
                                        <select name="tahun_all[]" id="tahun-all"
                                            class="form-control btn-square col-sm-12" multiple="multiple">
                                            @foreach (array_combine(range(date('Y'), 1900), range(date('Y'), 1900)) as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-5 mb-2 col-md-4 col-sm-6">
                                        <select name="wilayah" id="wilayah"class="form-control btn-square "
                                            style="border: 1px solid #808080;border-radius:5px;">
                                            <option value="Kabupaten" class = "d-flex align-items-center">Pilih Kategori
                                                Wilayah</option>
                                            <option value="Kabupaten" class = "d-flex align-items-center">Kabupaten
                                            </option>
                                            <option value="Kecamatan" class = "d-flex align-items-center">Kecamatan
                                            </option>
                                            <option value="Kelurahan" class = "d-flex align-items-center">Kelurahan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-xl-2 mb-2 col-md-4 col-sm-6">
                                        <a class="btn btn-primary btn-square" type="button"
                                        onclick="filterWilayah()">Terapkan<span class="caret"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-tunggakan-nop">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Wilayah</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode Kecamatan</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Tahun SPPT
                                        </th>
                                        <th colspan="4" style="text-align: center;background-color:#f3e8ae">Berdasarkan
                                            NOP</th>
                                        <th colspan="6" style="text-align: center;background-color:#cecece">Berdasarkan
                                            Nominal</th>

                                    </tr>
                                    <tr>
                                        <th>NOP Baku</th>
                                        <th>NOP Bayar</th>
                                        <th>NOP Tunggakan</th>
                                        <th>Persen</th>
                                        <th>NOP Terbit</th>
                                        <th>Penerimaan</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Tunggakan</th>
                                        <th>Persen</th>
                                    </tr>
                                </thead>
                                <tfoot id="qty_nop_container">
                                    
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-8 col-md-6 col-lg-3">
                <div class="col-xl-12">
                    <div class="card o-hidden">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-xl-5">
                                    <h6>Tunggakan Bedasarkan Level</h6>
                                </div>
                                <div class="col-xl-7">
                                    <div class="mb-3 draggable">
                                        <div class="input-group">
                                            <div class="col-xl-7">
                                                <select name="wilayah-v" id="wilayah-v"class="form-control btn-square"
                                                    style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih
                                                        Kategori Wilayah</option>
                                                    <option value="Kabupaten" class = "d-flex align-items-center">Kabupaten
                                                    </option>
                                                    <option value="Kecamatan" class = "d-flex align-items-center">Kecamatan
                                                    </option>
                                                    <option value="Kelurahan" class = "d-flex align-items-center">Kelurahan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group-btn btn btn-square p-0">
                                                <a class="btn btn-primary btn-square" type="button"
                                                    onclick="filterWilayahV()">Terapkan<span class="caret"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-tunggakan-level">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Wilayah
                                            </th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Kode Kecamatan</th>
                                            <th colspan="2">Ringan (1) </th>
                                            <th colspan="2">Sedang (2-4)</th>
                                            <th colspan="2">Berat (>4)</th>
                                        </tr>
                                        <tr>
                                            <th>Nominal</th>
                                            <th>NOP</th>
                                            <th>Nominal</th>
                                            <th>NOP</th>
                                            <th>Nominal</th>
                                            <th>NOP</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 d-none">
                    <div class="card o-hidden">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h6>Tunggakan Buku</h6>
                                </div>
                                <div class="col-xl-12">
                                    <div class="mb-2">
                                        <div class="input-group">
                                            <div class="col-xl-6">
                                                <select name="tahun_b"
                                                    id="tahun_b"class="form-control btn-square js-example-basic-single col-sm-12"
                                                    style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih Tahun
                                                    </option>
                                                    @foreach (array_combine(range(date('Y'), 1900), range(date('Y'), 1900)) as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <select name="buku"
                                                    id="buku"class="form-control btn-square js-example-basic-single col-sm-12"
                                                    style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih
                                                        Kategori</option>
                                                    <option value="buku 1" class = "d-flex align-items-center">Buku 1
                                                    </option>
                                                    <option value="buku 2" class = "d-flex align-items-center">Buku 2
                                                    </option>
                                                    <option value="buku 3" class = "d-flex align-items-center">Buku 3
                                                    </option>
                                                    <option value="buku 4" class = "d-flex align-items-center">Buku 4
                                                    </option>
                                                    <option value="buku 5" class = "d-flex align-items-center">Buku 5
                                                    </option>
                                                </select>
                                            </div>
                                            {{-- <div class="col-xl-4">
                                            <select name="uptd" id="uptd"class="form-control btn-square js-example-basic-single col-sm-12" style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih UPTD</option>
                                                    <option value="UPTD WILAYAH BARAT" class = "d-flex align-items-center">UPTD Wilayah Barat</option>
                                                    <option value="UPTD WILAYAH TENGAH" class = "d-flex align-items-center">UPTD Wilayah Tengah</option>
                                                    <option value="UPTD WILAYAH TIMUR" class = "d-flex align-items-center">UPTD Wilayah Timur</option>
                                            </select>
                                        </div> --}}
                                            <div class="col-xl-6">
                                                <select name="kecamatan"
                                                    id="kecamatan"class="form-control btn-square js-example-basic-single col-sm-12"
                                                    style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih
                                                        Kecamatan</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <select name="kelurahan"
                                                    id="kelurahan"class="form-control btn-square js-example-basic-single col-sm-12"
                                                    style="border: 1px solid #808080;">
                                                    <option value="" class = "d-flex align-items-center">Pilih
                                                        Kelurahan</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="input-group-btn btn btn-square p-0">
                                                    <a class="btn btn-primary btn-square" type="button"
                                                        onclick="filterBuku()">Terapkan<span class="caret"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-tunggakan-buku">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Buku</th>
                                            <th>NOP Baku</th>
                                            <th>NOP Bayar</th>
                                            <th>Jumlah Tunggakan</th>
                                            <th>Nominal Baku</th>
                                            <th>Nominal Terima</th>
                                            <th>Nominal Pokok</th>
                                            <th>Nominal Denda</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div>
                    <div class="card o-hidden">
                        <div class="card-header pb-0">
                            <h6>Pembayaran Tunggakan</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 draggable">
                                <div class="input-group">
                                    <input type="hidden" id="tunggakan" value="tunggakan">
                                    <select name="role_code" id="tahun" class="form-control btn-square">
                                        <option value="">Pilih Tahun SPPT</option>
                                        {{-- <input type="text" id="default_date" value="{{ date('Y') - 1}}"> --}}
                                        @foreach (array_combine(range(date('Y') - 1, 1900), range(date('Y') - 1, 1900)) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-btn btn btn-square p-0">
                                        <a class="btn btn-primary btn-square" type="button"
                                            onclick="filterTahun()">Terapkan<span class="caret"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm dtTable">
                                    <thead>
                                        <tr>
                                            <th>Tahun Pembayaran</th>
                                            <th>Nominal Bayar</th>
                                            <th>NOP Bayar</th>
                                        </tr>
                                    </thead>
                                </table>
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
    <!-- Plugins JS Ends-->
    <script>
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

        const day = new Date();
        var currentYear = day.getFullYear();

        function formatRupiah(angka) {
            var options = {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
            };
            var formattedNumber = angka.toLocaleString('ID', options);
            return formattedNumber;
        }

        
        function show_qty_nop(wilayah = "Kabupaten", tahun = [currentYear]) {
            $('#qty_nop_container').empty();
            if(wilayah != "Kabupaten" && wilayah != "" && wilayah != "kabupaten"){
                // console.log("masuk");
                $.ajax({
                    url: '{{ route('pbb.tunggakan.show_qty_tunggakan_nop') }}',
                    type: 'GET',
                    cache: false,
                    contentType: false,
                    processData: true,
                    data: {
                        "wilayah": wilayah,
                        "tahun": tahun
                    },
                    success: function(response) {
                        var html_qty_nop = `<tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="qty_nop_baku">0</th>
                                            <th id="qty_nop_bayar">0</th>
                                            <th id="qty_nop_tunggakan">0</th>
                                            <th id="qty_nop_persen">0</th>
                                            <th id="qty_nop_terbit">0</th>
                                            <th id="qty_penerimaan">0</th>
                                            <th id="qty_pokok">0</th>
                                            <th id="qty_denda">0</th>
                                            <th id="qty_tunggakan">0</th>
                                            <th id="qty_persen">0</th>
                                        </tr>`;
                        $('#qty_nop_container').append(html_qty_nop);
                        $('#qty_nop_baku').text(response.qty_nop_baku);
                        $('#qty_nop_bayar').text(response.qty_nop_bayar);
                        $('#qty_nop_tunggakan').text(response.qty_nop_tunggakan);
                        $('#qty_nop_persen').text(response.qty_nop_persen);
                        $('#qty_nop_terbit').text(response.qty_nop_terbit);
                        $('#qty_penerimaan').text(response.qty_penerimaan);
                        $('#qty_pokok').text(response.qty_pokok);
                        $('#qty_denda').text(response.qty_denda);
                        $('#qty_tunggakan').text(response.qty_tunggakan);
                        $('#qty_persen').text(response.qty_persen);
                    }
                });
            }
        }

        function filterTahun() {
            var tahun = $('#tahun').val();
            if (tahun !== null) {
                $(".dtTable").DataTable().destroy();
                table_pembayaran_tunggakan(tahun);
            }
        }

        function filterWilayah() {
            var wilayah = $('#wilayah').val();
            var tahun_all = $('#tahun-all').val();
            // console.log(wilayah);
            if (wilayah !== null || tahun_all !== null) {
                $(".table-tunggakan-nop").DataTable().destroy();
                table_tunggakan_nop(wilayah, tahun_all);
                show_qty_nop(wilayah, tahun_all);
            }
        }

        function filterWilayahV() {
            var wilayah = $('#wilayah-v').val();
            // console.log(wilayah);
            if (wilayah !== null) {
                $(".table-tunggakan-level").DataTable().destroy();
                table_tunggakan_level(wilayah);
            }
        }

        function filterBuku() {
            var tahun = $('#tahun_b').val();
            var kecamatan = $('#kecamatan').val();
            var kelurahan = $('#kelurahan').val();
            var buku = $('#buku').val();
            if (tahun !== null || kecamatan !== null || kelurahan !== null || buku !== null) {
                $(".table-tunggakan-buku").DataTable().destroy();
                table_tunggakan_buku(tahun, kecamatan, kelurahan, buku);
            }
        }

        function filterWilayahBuku() {
            $("#kecamatan").html('');
            $.ajax({
                url: '{{ route('pbb.tunggakan.get_wilayah') }}',
                type: "GET",
                data: {
                    "wilayah": 'uptd',
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    $('#kecamatan').append(
                        '<option value="" "class = "d-flex align-items-center">Pilih Kecamatan</option>');
                    $.each(result, function(key, value) {
                        $("#kecamatan").append('<option value="' + value
                            .nama_kecamatan + '"class = "d-flex align-items-center">' + value
                            .nama_kecamatan + '</option>');
                    });
                }
            });
            $('#kecamatan').on('change', function() {
                var kecamatan = this.value;
                $("#kelurahan").html('');
                $.ajax({
                    url: '{{ route('pbb.tunggakan.get_wilayah') }}',
                    type: "GET",
                    data: {
                        "wilayah": 'kecamatan',
                        "data": kecamatan
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        $('#kelurahan').append(
                            '<option value="" "class = "d-flex align-items-center">Pilih Kelurahan</option>'
                        );
                        $.each(result, function(key, value) {
                            $("#kelurahan").append('<option value="' + value
                                .kelurahan + '"class = "d-flex align-items-center">' + value
                                .kelurahan + '</option>');
                        });
                    }
                });
            });
        }

        function table_tunggakan_buku(tahun = currentYear, kecamatan = null, kelurahan = null, buku = null) {
            var table = $(".table-tunggakan-buku").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                    // dengan Button
                    "<'row'<'col-sm-12'tr>>" + // Add table
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                    "titleAttr": 'Export to Excel',
                    "filename": 'Tunggakan PBB Berdasarkan Buku ',
                    "action": newexportaction
                }, ],
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: '{{ route('pbb.tunggakan.datatable_tunggakan_buku') }}',
                    type: 'GET',
                    data: {
                        "tahun": tahun,
                        "kecamatan": kecamatan,
                        "kelurahan": kelurahan,
                        "buku": buku,
                    }
                },
                columns: [{
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'kecamatan',
                        name: 'kecamatan'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan'
                    },
                    {
                        data: 'buku',
                        name: 'buku'
                    },
                    {
                        data: 'nop_baku',
                        name: 'nop_baku'
                    },
                    {
                        data: 'nop_bayar',
                        name: 'nop_bayar'
                    },
                    {
                        data: 'jumlah_tunggakan',
                        name: 'jumlah_tunggakan'
                    },
                    {
                        data: 'nominal_baku',
                        name: 'nominal_baku'
                    },
                    {
                        data: 'nominal_terima',
                        name: 'nominal_terima'
                    },
                    {
                        data: 'nominal_pokok',
                        name: 'nominal_pokok'
                    },
                    {
                        data: 'nominal_denda',
                        name: 'nominal_denda'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });
        }

        function table_tunggakan_nop(wilayah = "Kabupaten", tahun = [currentYear]) {

            var table = $(".table-tunggakan-nop").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                    // dengan Button
                    "<'row'<'col-sm-12'tr>>" + // Add table
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                    filename: 'Penerimaan dan Tunggakan (NOP) PBB ',
                    titleAttr: 'Export to Excel',
                    exportOptions: {
                        columns: ':visible:not(:eq(1))'
                    },
                    customize: function(xlsx) {
                        if(wilayah != "Kabupaten" && wilayah != "" && wilayah != "kabupaten"){
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var index_jumlah = $('row', sheet).length;
                            var row = '<row r="' + (index_jumlah + 1) + '">';
                            row += '<c t="inlineStr" r="A' + (index_jumlah + 1) +
                                '" s="22"><is><t></t></is></c>';
                            row += '<c t="inlineStr" r="B' + (index_jumlah + 1) +
                                '" s="22"><is><t>Jumlah</t></is></c>';
                            row += '<c t="inlineStr" r="C' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_nop_baku').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="D' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_nop_bayar').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="E' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_nop_tunggakan').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="F' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_nop_persen').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="G' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_nop_terbit').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="H' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_penerimaan').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="I' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_pokok').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="J' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_denda').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="K' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_tunggakan').text() + '</t></is></c>';
                            row += '<c t="inlineStr" r="L' + (index_jumlah + 1) + '" s="22"><is><t>' + $(
                                '#qty_persen').text() + '</t></is></c>';
                            row += '</row>';
                            $('sheetData', sheet).append(row);
                        }
                      
                    }
                }, 'print'],
                aLengthMenu: [
                    [-1, 10, 25, 50, 100, 200],
                    ["All", 10, 25, 50, 100, 200]
                ],
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: '{{ route('pbb.tunggakan.datatable_tunggakan_nop') }}',
                    type: 'GET',
                    data: {
                        "wilayah": wilayah,
                        "tahun": tahun
                    }
                },
                columns: [{
                        data: 'wilayah',
                        name: 'wilayah'
                    },
                    {
                        data: 'kode_kecamatan',
                        name: 'kode_kecamatan',
                        visible: false
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'nop_baku',
                        name: 'nop_baku'
                    },
                    {
                        data: 'nop_bayar',
                        name: 'nop_bayar'
                    },
                    {
                        data: 'nop_tunggakan',
                        name: 'nop_tunggakan'
                    },
                    {
                        data: 'persen_nop',
                        name: 'persen_nop'
                    },
                    {
                        data: 'nominal_baku',
                        name: 'nominal_baku'
                    },
                    {
                        data: 'nominal_terima',
                        name: 'nominal_terima'
                    },
                    {
                        data: 'nominal_pokok',
                        name: 'nominal_pokok'
                    },
                    {
                        data: 'nominal_denda',
                        name: 'nominal_denda'
                    },
                    {
                        data: 'nominal_tunggakan',
                        name: 'nominal_tunggakan'
                    },
                    {
                        data: 'persen_nominal',
                        name: 'persen_nominal'
                    }
                ],
                order: [
                    [1, 'ASC']
                ],
            });
        }

        function table_tunggakan_level(wilayah = 'Kabupaten') {
            var table = $(".table-tunggakan-level").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                    // dengan Button
                    "<'row'<'col-sm-12'tr>>" + // Add table
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                    "titleAttr": 'Export to Excel',
                    "filename": 'Tunggakan PBB Berdasarkan Level ',
                    exportOptions: {
                        columns: ':visible:not(:eq(1))'
                    },
                    "action": newexportaction
                }, ],
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: '{{ route('pbb.tunggakan.datatable_tunggakan_level') }}',
                    type: 'GET',
                    data: {
                        "wilayah": wilayah,
                    }
                },
                columns: [{
                        data: 'wilayah',
                        name: 'wilayah'
                    },
                    {
                        data: 'kode_kecamatan',
                        name: 'kode_kecamatan',
                        visible: false
                    },
                    {
                        data: 'nominal_ringan',
                        name: 'nominal_ringan'
                    },
                    {
                        data: 'nop_ringan',
                        name: 'nop_ringan'
                    },
                    {
                        data: 'nominal_sedang',
                        name: 'nominal_sedang'
                    },
                    {
                        data: 'nop_sedang',
                        name: 'nop_sedang'
                    },
                    {
                        data: 'nominal_berat',
                        name: 'nominal_berat'
                    },
                    {
                        data: 'nop_berat',
                        name: 'nop_berat'
                    }
                ],
                order: [
                    [1, 'asc']
                ],
            });
        }

        function table_pembayaran_tunggakan(tahun = null) {
            if (tahun !== null) {
                var selectedYear = parseInt(tahun);
                tahun = (selectedYear + 1).toString();
            }
            // else{
            //     var currentDate = new Date();
            //     tahun = currentDate.getFullYear() - 1;
            //     console.log(tahun);
            // }
            var id = $('#tunggakan').val();
            let table = $(".dtTable").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 text-center'B><'col-sm-12 col-md-3'>>" +
                    // dengan Button
                    "<'row'<'col-sm-12'tr>>" + // Add table
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o" style="color: white;"> Export Excel</i>',
                    "titleAttr": 'Export to Excel',
                    "filename": 'Pembayaran Tunggakan PBB ',
                    "action": newexportaction
                }, ],
                processing: true,
                serverSide: true,
                responsive: true,
                searchDelay: 2000,
                ajax: {
                    url: "{{ route('pbb.tunggakan.datatable_pembayaran_tunggakan') }}",
                    type: 'GET',
                    data: {
                        "tahun": tahun,
                        "id": id
                    }
                },
                columns: [{
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                    {
                        data: 'nop',
                        name: 'nop'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });
        }

        $(document).ready(function() {

            $("#tahun-all").select2({
                placeholder: "Pilih Tahun (Bisa Multi Tahun)"
            });

            table_tunggakan_nop();
            show_qty_nop();
            // table_tunggakan_nominal();
            table_pembayaran_tunggakan();
            table_tunggakan_level();
            table_tunggakan_buku();
            filterWilayahBuku();
            // filterWilayah();
        })
    </script>
@endsection
