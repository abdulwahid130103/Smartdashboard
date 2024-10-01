<?php

namespace App\Http\Controllers\Retribusi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class RekapRetribusiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.retribusi.rekap_retribusi");
    }

    public function datatable_rekap_retribusi(Request $request){

        // $session =  Session::get("user_app");
        // $id = decrypt($session['user_id']);
        $tahun = $request->tahun;
        $qr = "
        SELECT
            ROW_NUMBER() OVER() AS nomor,
            opd.nama_opd AS nama_opd,
            retribusi.nama_retribusi AS nama_retribusi,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'januari' THEN detail_realisasi.realisasi END), 0) AS januari,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'februari' THEN detail_realisasi.realisasi END), 0) AS februari,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'maret' THEN detail_realisasi.realisasi END), 0) AS maret,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'april' THEN detail_realisasi.realisasi END), 0) AS april,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'mei' THEN detail_realisasi.realisasi END), 0) AS mei,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'juni' THEN detail_realisasi.realisasi END), 0) AS juni,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'juli' THEN detail_realisasi.realisasi END), 0) AS juli,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'agustus' THEN detail_realisasi.realisasi END), 0) AS agustus,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'september' THEN detail_realisasi.realisasi END), 0) AS september,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'oktober' THEN detail_realisasi.realisasi END), 0) AS oktober,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'november' THEN detail_realisasi.realisasi END), 0) AS november,
            COALESCE(SUM(CASE WHEN LOWER(detail_realisasi.bulan) = 'desember' THEN detail_realisasi.realisasi END), 0) AS desember,
            COALESCE(SUM(detail_realisasi.realisasi), 0) as total_semua
        FROM
            data.detail_realisasi as detail_realisasi
        JOIN
            data.target_opd as target_opd ON detail_realisasi.target_opd_id = target_opd.id
        JOIN
            data.retribusi_opd as retribusi_opd ON target_opd.id_retribusi_opd = retribusi_opd.id
        JOIN
            data.opd as opd ON retribusi_opd.id_opd = opd.id_opd
        JOIN
            data.retribusi as retribusi ON retribusi_opd.id_retribusi = retribusi.id
        WHERE
            target_opd.tahun = $tahun
        GROUP BY
            opd.nama_opd,
            retribusi.nama_retribusi
        ORDER BY
            nomor;
        ";
        $query = DB::select($qr);

        // dd($query);
        $arr = array();
        if ($query) {
            $no = 0;
            foreach ($query as $key => $data) {
                $no += 1;
                $total_semua = 0;
                $arr[] = array(
                    "no" => $data->nomor,
                    "nama_opd" => $data->nama_opd,
                    "nama_retribusi" => $data->nama_retribusi,
                    "januari" => rupiahFormat($data->januari),
                    "februari" => rupiahFormat($data->februari),
                    "maret" => rupiahFormat($data->maret),
                    "april" => rupiahFormat($data->april),
                    "mei" => rupiahFormat($data->mei),
                    "juni" => rupiahFormat($data->juni),
                    "juli" => rupiahFormat($data->juli),
                    "agustus" => rupiahFormat($data->agustus),
                    "september" => rupiahFormat($data->september),
                    "oktober" => rupiahFormat($data->oktober),
                    "november" => rupiahFormat($data->november),
                    "desember" => rupiahFormat($data->desember),
                    "total_semua" => rupiahFormat($data->total_semua),
                );
            }
        }

        return Datatables::of($arr)
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
