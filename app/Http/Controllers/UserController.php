<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Users;
class UserController extends Controller
{
    public function getUser(Request $request){
        $user = Users::where('id_user',$request->id)->first();

        return json_encode([
            'data' => $user
        ]);
    }
    public function updateUser(Request $request){
        $nama = $request->nama;
        $username = $request->username;
        $password = $request->password;
        $user = Users::where('id_user',$request->id)->first();
        if($request->newPassword){
            if(password_verify($password,$user->password)){
                $data = [
                    "nama" => $nama,
                    "username" => $username,
                    "password" => password_hash($request->newPassword,PASSWORD_DEFAULT)
                ];
                Users::where('id_user',$request->id)->update($data);
                return json_encode([
                    "message" => "berhasil"
                    ]);
                }
            }else{
                if(password_verify($password,$user->password)){
                    $data = [
                        "nama" => $nama,
                        "username" => $username
                    ];
                    Users::where('id_user',$request->id)->update($data);
                    return json_encode([
                        "message" => "berhasil"
                    ]);
                }
        }
    }
    public function User(){
        $data = Users::get();
        return json_encode([
            "data" => $data
        ]);
    }
    public function editUser(Request $request){
        if($request->password != ''){
            Users::where('id_user',$request->id)->update([
                "nama" => $request->nama,
                "username" => $request->username,
                "level" => $request->level,
                "password" => password_hash($request->password,PASSWORD_DEFAULT)
            ]);
            $data = Users::get();
            return json_encode([
                "message" => "berhasil",
                "data" => $data
            ]);
        }else{
            Users::where('id_user',$request->id)->update([
                "nama" => $request->nama,
                "username" => $request->username,
                "level" => $request->level
            ]);
            $data = Users::get();
            return json_encode([
                "message" => "berhasil",
                "data" => $data
            ]);
        }
    }

    public function hapusUser(Request $request){
        Users::where('id_user',$request->id)->delete();
        $data = Users::get();
        return json_encode([
            "message" => "berhasil",
            "data" => $data
        ]);
    }
}
