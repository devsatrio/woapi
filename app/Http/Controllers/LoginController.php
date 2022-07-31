<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
    //====================================================================
    public function login_act(Request $request){
        if($request->has('username') && $request->has('password')){
            $data = DB::table('user')
            ->select(DB::raw('id,bagian,unit,user,pass'))->where([
                ['user','=',$request->username],
                ['pass','=',$request->password],
            ])->get();
            if(count($data)>0){
                $print = [
                    'data'=>$data,
                    'sts'=>'sukses',
                ];
            }else{
                $print = [
                    'sts'=>'gagal',
                    'msg'=>'Username / Password salah'
                ];
            }
            return $print;
        }else{
            $print = [
                'sts'=>'gagal',
                'msg'=>'Username / Password harus diisi'
            ];
            return $print;
        }
    }
}
