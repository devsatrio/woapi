<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class MasterDataController extends Controller
{
    //====================================================================
    public function work_list(){
            $data = DB::table('work_list')
            ->get();
            if(count($data)>0){
                $print = [
                    'data'=>$data,
                    'sts'=>'sukses',
                ];
            }else{
                $print = [
                    'sts'=>'gagal',
                    'msg'=>'Error'
                ];
            }
            return $print;
    }

    //====================================================================
    public function work_pelaksana(){
        $data = DB::table('work_pelaksana')
        ->where('kategori','EDP')
        ->get();
        if(count($data)>0){
            $print = [
                'data'=>$data,
                'sts'=>'sukses',
            ];
        }else{
            $print = [
                'sts'=>'gagal',
                'msg'=>'Error'
            ];
        }
        return $print;
    }

    //====================================================================
    public function unit(){
        $data = DB::table('mas_unit')
        ->get();
        if(count($data)>0){
            $print = [
                'data'=>$data,
                'sts'=>'sukses',
            ];
        }else{
            $print = [
                'sts'=>'gagal',
                'msg'=>'Error'
            ];
        }
        return $print;
    }
}