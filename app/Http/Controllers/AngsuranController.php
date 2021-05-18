<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AngsuranController extends Controller
{
    public function getAngsuran(Request $request){
        $angsuran = DB::table('angsuran')->where('id_pinjaman','=',$request->id)->get();
        return json_encode([
            "data" => $angsuran
        ]);
    }
    public function bayarAngsuran(Request $request){
        DB::table('angsuran')->where('id_angsuran','=',$request->id_angsuran)->delete();
        $angsuran = DB::table('angsuran')->where('id_pinjaman','=',$request->id_pinjaman)->get();
        $dialog = "buka";
        $jumlah = $request->jumlah;
        if($angsuran->count() < 1){
            DB::table('pinjaman')->where('id_pinjaman','=',$request->id_pinjaman)->delete();
            $dialog = "tutup";
        }
        $dataAngsuran = DB::table('angsuran')->where('id_pinjaman','=',$request->id_pinjaman)->get();
        $pinjaman = DB::table('pinjaman')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->select('pinjaman.*','anggota.nama AS nama_anggota','user.nama')
                    ->get();
        DB::table('history')->insert([
            "kode_anggota" => $request->kode_anggota,
            "tanggal" => date("Y-m-d"),
            "jenis_pembayaran" => "Bayar angsuran",
            "jumlah" => $jumlah,
            "id_user" => $request->id_user
        ]);
        return json_encode([
            "message" => "berhasil",
            "data" => $pinjaman,
            "angsuran" => $dataAngsuran,
            "dialog" => $dialog
        ]);
    }
    public function getAngsuranById(Request $request){
        $kode_anggota = $request->id;
        $data  = DB::table('pinjaman')
                ->select('angsuran.tanggal AS start','angsuran.tanggal AS end')
                ->join('angsuran','pinjaman.id_pinjaman','=','angsuran.id_pinjaman')
                ->where('kode_anggota',$kode_anggota)->get();
        return json_encode([
            "data" => $data
        ]);
    }
}
