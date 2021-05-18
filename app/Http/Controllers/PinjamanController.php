<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    public function inputPinjaman(Request $request){
        $tanggal = $request->tanggal;
        $kode_anggota = explode("#",$request->kode_anggota)[1];
        $jumlah = $request->jumlah;
        $bunga = explode("%",$request->bunga)[0];
        $lama_pinjam = explode(" ",$request->lama_pinjam)[0];
        $jumlah_bayar = explode(".",$request->jumlah_bayar)[1];
        $id_user = $request->id_user;
        $t = DB::table('pinjaman')->get()->count();
        $id_pinjaman;
        if($t == 0){
            $i = $t + 1;
            $id_pinjaman = "IPJ".$i;
        }else{
            $q = DB::table('pinjaman')->orderBy('timestamp','asc')->get()->last();
            $kd = explode("IPJ",$q->id_pinjaman)[1] + 1;
            $id_pinjaman = "IPJ".$kd;
        }
        $data = [
            "id_pinjaman" => $id_pinjaman,
            "tanggal" => $tanggal,
            "kode_anggota" => $kode_anggota,
            "jumlah" => $jumlah,
            "bunga" => $bunga,
            "lama_pinjam" => $lama_pinjam,
            "jumlah_bayar" => $jumlah_bayar,
            "id_user" => $id_user,
            "timestamp" => time(),
            "hash" => password_hash($jumlah,PASSWORD_DEFAULT)
        ];
        DB::table('pinjaman')->insert($data);
        $date = date_create($tanggal);
        for($i=1;$i<=$lama_pinjam;$i++){
            $bulan = 30;
            date_add($date,date_interval_create_from_date_string($bulan." days"));
            $k = date_format($date,"Y-m-d");
            $l = [
                "tanggal" => $k,
                "id_pinjaman" => $id_pinjaman,
                "jumlah_bayar" => $jumlah_bayar,
                "id_user" => $id_user
            ];
            DB::table('angsuran')->insert($l);
        }
        $pinjaman = DB::table('pinjaman')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->select('pinjaman.*','anggota.nama AS nama_anggota','user.nama')
                    ->get();
        DB::table('history')->insert([
            "kode_anggota" => $kode_anggota,
            "tanggal" => date("Y-m-d"),
            "jenis_pembayaran" => "Melakukan pinjaman",
            "jumlah" => $jumlah_bayar,
            "id_user" => $id_user
        ]);
        return json_encode([
            "message" => "berhasil",
            "data" => $pinjaman,
            "kode" => $id_pinjaman
        ]);
    }

    public function getPinjaman(){
        $pinjaman = DB::table('pinjaman')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->select('pinjaman.*','anggota.nama AS nama_anggota','user.nama')
                    ->get();
        return json_encode([
            "data" => $pinjaman
        ]);
    }
    public function print(Request $request){
        $pinjaman = DB::table('pinjaman')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->select('pinjaman.*','anggota.nama AS nama_anggota','user.nama')
                    ->where('id_pinjaman',$request->id)
                    ->get();
        return json_encode([
            "data" => $pinjaman
        ]);
    }
    public function hapus(Request $request){
        DB::table('pinjaman')->where('id_pinjaman','=',$request->id)->delete();
        DB::table('angsuran')->where('id_pinjaman','=',$request->id)->delete();
        $pinjaman = DB::table('pinjaman')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->select('pinjaman.*','anggota.nama AS nama_anggota','user.nama')
                    ->get();
        return json_encode([
            "message" => "berhasil",
            "data" => $pinjaman
        ]);

    }
}
