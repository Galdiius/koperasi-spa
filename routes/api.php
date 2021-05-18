<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AnggotaController;
use \App\Http\Controllers\SimpananController;
use \App\Http\Controllers\PinjamanController;
use \App\Http\Controllers\AngsuranController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/tambahUser', [AuthController::class, 'register']);
Route::post('updateUser',[UserController::class,'updateUser']);
Route::post('tambahAnggota',[AnggotaController::class,'tambah']);
Route::get('getAnggota',[AnggotaController::class,'getAnggota']);
Route::get('getAnggotaNamaId',[AnggotaController::class,'getAnggotaNamaId']);
Route::get('getAnggotaNamaIdFilter',[AnggotaController::class,'getAnggotaNamaIdFilter']);
Route::get('getAnggotaNamaIdFilterGang',[AnggotaController::class,'getAnggotaNamaIdFilterGang']);
Route::get('getAnggotaById',[AnggotaController::class,'getAnggotaById']);
Route::post('updateAnggota',[AnggotaController::class,'updateAnggota']);
Route::post('deleteAnggota',[AnggotaController::class,'deleteAnggota']);
Route::get('dataSimpanan',[SimpananController::class,'dataSimpanan']);
Route::get('getJenisSimpanan',[SimpananController::class,'getJenisSimpanan']);
Route::post('inputSimpanan',[SimpananController::class,'inputSimpanan']);
Route::get('getJumlahSimpanan',[SimpananController::class,'jumlahSimpanan']);
Route::post('inputPinjaman',[PinjamanController::class,'inputPinjaman']);
Route::get('getPinjaman',[PinjamanController::class,'getPinjaman']);
Route::get('printPinjaman',[PinjamanController::class,'print']);
Route::post('hapusPinjaman',[PinjamanController::class,'hapus']);
Route::get('getAngsuran',[AngsuranController::class,'getAngsuran']);
Route::post('bayarAngsuran',[AngsuranController::class,'bayarAngsuran']);
Route::group(['middleware' => ['web']],function(){
    Route::get('/getUser',[UserController::class,'getUser']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/loginAnggota', [AuthController::class, 'loginAnggota']);
Route::get('/getHistory',[SimpananController::class,'getHistory']);
Route::get('getAngsuranById',[AngsuranController::class,'getAngsuranById']);
Route::get('getSaldo',[SimpananController::class,'getSaldo']);
Route::post('penarikan',[SimpananController::class,'penarikan']);
Route::get('getPenarikan',[SimpananController::class,'getPenarikan']);
Route::get('userGet',[UserController::class,'User']);
Route::post('editUser',[UserController::class,'editUser']);
Route::get('hapusUser',[UserController::class,'hapusUser']);
Route::get('jenisSimpanan',[SimpananController::class,"jenisSimpanan"]);
Route::post('editJenisSimpanan',[SimpananController::class,"editJenisSimpanan"]);
Route::post('tambahJenisSimpanan',[SimpananController::class,"tambahJenisSimpanan"]);
Route::post('editAnggota',[AnggotaController::class,"editAnggota"]);
Route::get('historyTransaksi',[SimpananController::class,"historyTransaksi"]);
Route::get('laporan',[SimpananController::class,"generate"]);
Route::get('detailSimpanan',[SimpananController::class,"detailSimpanan"]);
Route::get('getSaldoById',[SimpananController::class,"getSaldoById"]);
Route::get('getJumlahAngsuranById',[SimpananController::class,"getJumlahAngsuranById"]);
Route::get('cekTransaksiAnggota',[AnggotaController::class,"cekTransaksiAnggota"]);
Route::post('getLaporanBetween',[SimpananController::class,"getLaporanBetween"]);
