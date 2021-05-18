<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    public function tambah(Request $request){
        $user = Anggota::get();
        $t = $user->count();
        $kode_anggota;
        if($t == 0){
            $i = $t + 1;
            $kode_anggota = "KDA".$i;
        }else{
            $q = DB::table('anggota')->orderBy('timestamp','asc')->get()->last();
            $kd = explode("KDA",$q->kode_anggota)[1] + 1;
            $kode_anggota = "KDA".$kd;
            // return json_encode([
            //     "kode" => $kode_anggota
            // ]);
            // die;
        }
        $kd = $user->count();
        $kode = $kd + 1;
        $nama = $request->nama;
        $jk = $request->jenisKelamin;
        $tgl_lahir = $request->tgl_lahir;
        $alamat = $request->alamat;
        $kontak = $request->kontak;
        $status_anggota = 'Aktif';
        // $timestamp = time();
        // return json_encode([
        //     "t" => $timestamp
        // ]);
        $data = [
            "kode_anggota" => $kode_anggota,
            "nama" => $nama,
            "jenis_kelamin" => $jk,
            "tanggal_lahir" => $tgl_lahir,
            "alamat" => $alamat,
            "kontak" => $kontak,
            "status_anggota" => $status_anggota,
        ];
        Anggota::create($data);
        $anggota = Anggota::get()->all();
        return json_encode([
            "message" => "berhasil",
            "data" => $anggota
        ]);
    }

    public function getAnggota(Request $request){
        $anggota = Anggota::select("anggota.*","saldo.jumlah")
                    ->leftJoin('saldo','anggota.kode_anggota','=','saldo.kode_anggota')
                    ->get()
                    ->all();
        return json_encode([
            "data" => $anggota
        ]);
    }
    public function deleteAnggota(Request $request){
        Anggota::where('kode_anggota',$request->id)->delete();
        $anggota = Anggota::get()->all();
        return json_encode([
            "message" => "berhasil",
            "data" => $anggota
        ]);
    }
    public function getAnggotaById(Request $request){
        $anggota = Anggota::where('kode_anggota',$request->id)->first();
        return json_encode([
            "message" => "berhasil",
            "data" => $anggota
        ]);
    }
    public function updateAnggota(Request $request){
        $data = [
            "nama" => $request->nama,
            "jenis_kelamin" => $request->jk,
            "tanggal_lahir" => $request->tgl_lahir,
            "alamat" => $request->alamat,
            "kontak" => $request->kontak,
            "status_anggota" => $request->status
        ];
        Anggota::where('kode_anggota',$request->kode_anggota)->update($data);
        $anggota = Anggota::get()->all();
        return json_encode([
            "message" => "berhasil",
            "data" => $anggota
        ]);
    }
    public function getAnggotaNamaId(){
        $anggota = Anggota::select(DB::raw("CONCAT(nama,'#',kode_anggota) AS namaId"))->get()->all();
        return json_encode([
            "data" => $anggota
        ]);
    }
    public function getAnggotaNamaIdFilter(){
        $anggota = Anggota::select(DB::raw("CONCAT(anggota.nama,'#',anggota.kode_anggota) AS namaId"))
                    ->join('saldo','anggota.kode_anggota','=','saldo.kode_anggota')
                    ->where('saldo.jumlah','>','0')
                    ->get()->all();
        return json_encode([
            "data" => $anggota
        ]);
    }
    // public function getAnggotaNamaIdFilterGang(){
    //     $anggota = Anggota::select(DB::raw("CONCAT(anggota.nama,'#',anggota.kode_anggota) AS namaId"))
    //                 ->join('saldo','anggota.kode_anggota','=','saldo.kode_anggota')
    //                 ->join('pinjaman','anggota.kode_anggota','=','pinjaman.kode_anggota','left')
    //                 ->where('saldo.jumlah','>','0')
    //                 ->whereNotIn('pinjaman',['anggota.kode_anggota'])
    //                 ->get()->all();
    //     return json_encode([
    //         "data" => $anggota
    //     ]);
    // }
    public function editAnggota(Request $request){
        Anggota::where('kode_anggota',$request->kode_anggota)->update([
            "nama" => $request->nama,
            "kontak" => $request->kontak,
            "tanggal_lahir" => $request->tanggal
        ]);
        return json_encode([
            "message" => "berhasil"
        ]);
    }
    public function cekTransaksiAnggota(Request $request){
        $angsuran = DB::table('angsuran')
        ->select('angsuran.*')
        ->join('pinjaman','angsuran.id_pinjaman','=','pinjaman.id_pinjaman')
        ->where('kode_anggota',$request->id)
        ->get();
        if($angsuran->count() < 1){
            $saldo = DB::table("saldo")->where('kode_anggota',$request->id)->get();
            if($saldo->count() < 1 || $saldo[0]->jumlah == 0){
                return json_encode([
                    "message" => "Hapus diizinkan"
                ]);
            }else{
                return json_encode([
                    "message" => "Anggota masih memiliki saldo"
                ]);
            }
        }else{
            return json_encode([
                "message" => "Masih ada angsuran"
            ]);
        }
        
    }
}
