<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;


class ImportKepatuhanObjek implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $key => $value) {
            if ($key!=0) {
                // dd($value);
                // dd($this->getDate($value[6]));
                $insert['tahun']     = $value[1];
                $insert['nop_baku'] = $value[2];
                $insert['nop_bayar'] = $value[3];
                $insert['persen'] = $value[4];
                $insert['sumber_data'] = $value[5];
                $insert['tanggal_update'] =  $this->getDate($value[6]);
                $insert['kode_kecamatan'] = $value[7];
                $insert['kode_kelurahan'] = $value[8];
                $insert['kecamatan'] = $value[9];
                $insert['kelurahan'] = $value[10];

                // $cek_data = DB::table('data.kepatuhan_objek')->where('tahun', $value[1])->count();
                if ($key == 1) {
                    DB::table('data.kepatuhan_objek')->where('tahun', $value[1])->where("sumber_data",$value[5])->delete();
                }
                if (!is_null($insert['sumber_data'])) {
                    DB::table('data.kepatuhan_objek')->insert($insert);
                }
            }
        }

        return "sukses";
    }

    function getDate($value){
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
    }
}
