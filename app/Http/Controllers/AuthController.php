<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $nama = $request->nama;
        $username = $request->username;
        $password = password_hash($request->password, PASSWORD_DEFAULT);
        $level = $request->level;
        Users::create([
            'nama' => $nama,
            'username' => $username,
            'password' => $password,
            'level' => $level
        ]);
        $data = Users::get();
        return json_encode([
            "message" => 'berhasil',
            "data" => $data
        ]);
    }
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $user = Users::where('username', $username)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                // $request->session()->put('login',true);
                // $request->session()->put('id_user',$user->id_user);
                //return $user->createToken('my-token')->plainTextToken;
                return json_encode([
                    'data' => 'berhasil',
                    'id_user' => $user->id_user,
                    'level' => $user->level
                ]);
            } else {
                return json_encode([
                    'data' => 'password salah'
                ]);
            }
        } else {
            return json_encode([
                'data' => 'username salah'
            ]);
        }
    }

    public function cekLogin(Request $request){
        return true;
    }
    public function loginAnggota(Request $request){
        $username = $request->username;
        $password = $request->password;
        $user = DB::table('anggota')->where('kode_anggota',$username)->get()->first();
        if($user){
            $date = date_create($user->tanggal_lahir);
            $pw = date_format($date,"dmY");
            if($password == $pw){
                if($user->status_anggota == "Aktif"){
                    return json_encode([
                        "data" => $user,
                        "message" => "berhasil"
                    ]);
                }else{
                    return json_encode([
                        "message" => "tidak aktif"
                    ]);
                }
            }else{
                return json_encode([
                    "message" => "gagal"
                ]);
            }
        }else{
            return json_encode([
                "message" => "gagal"
            ]);
        }
    }
}
