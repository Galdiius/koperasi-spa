<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
class SimpananController extends Controller
{
    public function dataSimpanan(){
        $data = DB::table('simpanan')
                ->join('jenis_simpanan','simpanan.id_jenis','=','jenis_simpanan.id_jenis')
                ->join('anggota','simpanan.kode_anggota','=','anggota.kode_anggota')
                ->join('user','simpanan.id_user','=','user.id_user')
                ->select('simpanan.*','jenis_simpanan.jenis_simpanan','anggota.nama','user.nama AS nama_petugas')
                ->orderByRaw('simpanan.tanggal')
                ->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function getJenisSimpanan(){
        $data = DB::table('jenis_simpanan')->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function inputSimpanan(Request $request){
        $id_jenis = $request->id_jenis;
        $jumlah = $request->jumlah;
        $kode_anggota = explode("#",$request->kode_anggota);
        $id_user = $request->id_user;
        $user = DB::table('anggota')->where('kode_anggota',$kode_anggota[1])->get()->first();
        if($user->status_anggota == "Aktif"){
            $cekSimpanan = DB::table('simpanan')->where('kode_anggota',$kode_anggota[1])->where('id_jenis','1')->get();
            if($id_jenis == '1'){
                if($cekSimpanan->count() < 1){
                    $data = [
                        "id_jenis" => $id_jenis,
                        "jumlah" => $jumlah,
                        "kode_anggota" => $kode_anggota[1],
                        "id_user" => $id_user,
                        "hash" => password_hash($jumlah,PASSWORD_DEFAULT)
                    ];
                    DB::table('simpanan')->insert($data);
                    $this->insertHistory($kode_anggota[1],$id_jenis,$jumlah,$id_user);
                    return json_encode([
                        "message" => "berhasil",
                        "data" => $this->dataSimpanan()
                        ]);
                    }else{
                        return json_encode([
                            "message" => "sudah"
                            ]);
                        }
            }else{
                if($cekSimpanan->count() >= 1){
                    $data = [
                        "id_jenis" => $id_jenis,
                        "jumlah" => $jumlah,
                        "kode_anggota" => $kode_anggota[1],
                        "id_user" => $id_user,
                        "hash" => password_hash($jumlah,PASSWORD_DEFAULT)
                    ];
                    DB::table('simpanan')->insert($data);
                    $this->insertHistory($kode_anggota[1],$id_jenis,$jumlah,$id_user);
                    return json_encode([
                        "message" => "berhasil",
                        "data" => $this->dataSimpanan()
                    ]);
                }else{
                    return json_encode([
                        "message" => "belum membayara pokok"
                        ]);
                }
            }
        }else{
            return json_encode([
                "message" => "Anggota tidak aktif"
                ]);
        }
    }
    public function jumlahSimpanan(){
        $data = DB::table('saldo')
                ->select('jumlah')
                ->get();
        $jumlah = 0;
        for($i=0;$i<$data->count();$i++){
            $jumlah += $data[$i]->jumlah;
        }
        return json_encode([
            "data" => $jumlah
        ]);
    }
    public function getHistory(Request $request){
        $id = $request->id;
        $data = DB::table('history')
                ->join('user','history.id_user','=','user.id_user')
                ->select('history.*','user.nama')
                ->where('kode_anggota',$id)->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function insertHistory($kode_anggota,$id_jenis,$jumlah,$id_user){
        $jenis_pembayaran;
        if($id_jenis == '1'){
            $jenis_pembayaran = "simpanan pokok";
        }else if($id_jenis == '2'){
            $jenis_pembayaran = "simpanan wajib";
        }else if($id_jenis == '3'){
            $jenis_pembayaran = "simpanan sukarela";
        }
        $data = [
            "kode_anggota" => $kode_anggota,
            "tanggal" => date("Y-m-d"),
            "jenis_pembayaran" => "simpanan pokok",
            "jumlah" => $jumlah,
            "id_user" => $id_user
        ];
        DB::table('history')->insert($data);
    }
    public function getSaldo(Request $request){
        $id = $request->id;
        $data = DB::table('saldo')->where('kode_anggota',$id)->get()->first();
        return json_encode([
            "data" => $data
        ]);
    }
    public function penarikan(Request $request){
        $kode_anggota = $request->kode_anggota;
        $tanggal = $request->tanggal;
        $jumlah = $request->jumlah;
        $id_user = $request->id_user;
        $keterangan = $request->keterangan;
        $cekTagihan = DB::table('pinjaman')->where('kode_anggota',$kode_anggota)->get();
        if($cekTagihan->count() > 0){
            return json_encode([
                "message" => "masih ada tagihan"
            ]);
            die;
        }
        $data = [
            "kode_anggota" => $kode_anggota,
            "tanggal" => $tanggal,
            "jumlah" => $jumlah,
            "ket" => $keterangan,
            "id_user" => $id_user
        ];
        DB::table('penarikan')->insert($data);
        DB::table('saldo')->where('kode_anggota',$kode_anggota)->update([
            "jumlah" => "0" 
        ]);
        DB::table('anggota')->where('kode_anggota',$kode_anggota)->update([
            "status_anggota" => "Tidak aktif"
        ]);
        $penarikan = DB::table('penarikan')
        ->select('penarikan.*','anggota.nama','user.nama AS petugas')
        ->join('anggota','penarikan.kode_anggota','=','anggota.kode_anggota')
        ->join('user','penarikan.id_user','=','user.id_user')
        ->get();
        return json_encode([
            "message" => "berhasil",
            "data" => $penarikan
        ]);
    }
    public function getPenarikan(){
        $data = DB::table('penarikan')
                ->select('penarikan.*','anggota.nama','user.nama AS petugas')
                ->join('anggota','penarikan.kode_anggota','=','anggota.kode_anggota')
                ->join('user','penarikan.id_user','=','user.id_user')
                ->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function jenisSimpanan(){
        $data = DB::table('jenis_simpanan')->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function editJenisSimpanan(Request $request){
        $data = [
            "jenis_simpanan" => $request->jenis_simpanan,
            "jumlah" => $request->jumlah
        ];
        DB::table('jenis_simpanan')->where('id_jenis',$request->id_jenis)->update($data);
        $js = DB::table('jenis_simpanan')->get();
        return json_encode([
            "message" => "berhasil",
            "data" => $js
        ]);
    }
    public function tambahJenisSimpanan(Request $request){
        $data = [
            "jenis_simpanan" => $request->jenisSimpanan,
            "jumlah" => $request->jumlah
        ];
        DB::table("jenis_simpanan")->insert($data);
        $js = DB::table('jenis_simpanan')->get();
        return json_encode([
            "message" => "berhasil",
            "data" => $js
        ]);
    }
    public function historyTransaksi(){
        $data = DB::table('history')
                ->select("history.*","anggota.nama AS namaAnggota","user.nama AS petugas")
                ->join('anggota','history.kode_anggota','=','anggota.kode_anggota')
                ->join('user','history.id_user','=','user.id_user')
                ->get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function generate(Request $request){
        $mulai = $request->m;
        $akhir = $request->a;
        $pinjaman = DB::table('pinjaman')
                    ->select('pinjaman.*','anggota.nama AS anggota','user.nama AS petugas')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        $simpanan = DB::table('simpanan')
                    ->select('simpanan.*','anggota.nama AS anggota','user.nama AS petugas','jenis_simpanan.jenis_simpanan AS simpanan')
                    ->join('anggota','simpanan.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','simpanan.id_user','=','user.id_user')
                    ->join('jenis_simpanan','simpanan.id_jenis','=','jenis_simpanan.id_jenis')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        $penarikan = DB::table('penarikan')
                    ->select("penarikan.*",'anggota.nama AS anggota','user.nama AS petugas')
                    ->join('anggota','penarikan.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','penarikan.id_user','=','user.id_user')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        $data = [
            "mulai"=>$request->m,
            "akhir" => $request->a,
            "pinjaman" => $pinjaman,
            "simpanan" => $simpanan,
            "penarikan" => $penarikan
        ];
        $pdf = PDF::loadview('generate',["data" => $data]);
        return $pdf->download("Laporan");
    }
    public function detailSimpanan(Request $request){
        $data = DB::table('simpanan')
                    ->select('simpanan.*','jenis_simpanan.jenis_simpanan','anggota.nama AS anggota','user.nama AS petugas')
                    ->join('jenis_simpanan','simpanan.id_jenis','=','jenis_simpanan.id_jenis')
                    ->join('anggota','simpanan.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','simpanan.id_user','=','user.id_user')
                    ->where('simpanan.id_simpanan',$request->id)
                    ->get()->first();
        return json_encode([
            "data" => $data
        ]);
    }
    public function getSaldoById(Request $request){
        $saldo = DB::table('saldo')->where('kode_anggota',$request->id)->get();
        if($saldo->count() > 0){
            return json_encode([
                "data" => $saldo[0]
            ]);
        }else{
            return json_encode([
                "data" => [
                    "jumlah" => 0
                ]
            ]);
        }

    }
    public function getJumlahAngsuranById(Request $request){
        $jumlah = 0;
        $data = DB::table('angsuran')
                ->select('angsuran.*')
                ->join('pinjaman','angsuran.id_pinjaman','=','pinjaman.id_pinjaman')
                ->where('kode_anggota',$request->id)
                ->get();
        foreach($data as $a){
            $jumlah = $jumlah + $a->jumlah_bayar;
        }
        return json_encode([
            "data" => $jumlah
        ]);
    }
    public function getLaporanBetween(Request $request){
        $mulai = $request->awal;
        $akhir = $request->akhir;
        $simpanan = DB::table('simpanan')
                    ->select('simpanan.*','anggota.nama AS anggota','user.nama AS petugas','jenis_simpanan.jenis_simpanan AS simpanan')
                    ->join('anggota','simpanan.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','simpanan.id_user','=','user.id_user')
                    ->join('jenis_simpanan','simpanan.id_jenis','=','jenis_simpanan.id_jenis')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        $pinjaman = DB::table('pinjaman')
                    ->select('pinjaman.*','anggota.nama AS anggota','user.nama AS petugas')
                    ->join('anggota','pinjaman.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','pinjaman.id_user','=','user.id_user')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        $penarikan = DB::table('penarikan')
                    ->select("penarikan.*",'anggota.nama AS anggota','user.nama AS petugas')
                    ->join('anggota','penarikan.kode_anggota','=','anggota.kode_anggota')
                    ->join('user','penarikan.id_user','=','user.id_user')
                    ->whereBetween('tanggal',[$mulai,$akhir])
                    ->get();
        return json_encode([
            "dataSimpanan" => $simpanan,
            "dataPinjaman" => $pinjaman,
            "dataPenarikan" => $penarikan
        ]);
    }
}
