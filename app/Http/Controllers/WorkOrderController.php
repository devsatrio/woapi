<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class WorkOrderController extends Controller
{
    //====================================================================
    public function index(){
            $data = DB::table('work_order')
            ->where([['tujuan','=','EDP'],['hasil','!=','selesai']])
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
    public function store(Request $request)
    {
        DB::table('work_order')
        ->insert([
            'idwo'=>$request->idwo,
            'tgl_order'=>$request->tgl_order,
            'id_unit'=>$request->id_unit,
            'unit_order'=>$request->unit_order,
            'tujuan'=>$request->tujuan,
            'kategori'=>'onsite',
            'jenis'=>'perbaikan barang',
            'no_inventaris'=>'-',
            'nama_barang'=>$request->nama_barang,
            'detail_barang'=>$request->detail_barang,
            'permasalahan'=>$request->permasalahan,
            'tgl_execute'=>$request->tgl_execute,
            'pelaksana1'=>$request->pelaksana1,
            'pelaksana2'=>$request->pelaksana2,
            'pelaksana3'=>$request->pelaksana3,
            'pelaksana4'=>$request->pelaksana4,
            'tindakan'=>$request->tindakan,
            'hasil'=>$request->hasil,
            'tgl_finish'=>$request->tgl_finish,
            'catatan_petugas'=>$request->catatan_petugas,
            'tgl_in'=>$request->tgl_in,
            'user_in'=>$request->user_in,
        ]);

        $print = [
            'sts'=>'sukses',
            'msg'=>'Berhasil menyimpan data',
        ];
        return $print;
    }

    //====================================================================
    public function update(Request $request,$kode)
    {
        DB::table('work_order')
        ->where('idwo',$kode)
        ->update([
            'tgl_order'=>$request->tgl_order,
            'id_unit'=>$request->id_unit,
            'unit_order'=>$request->unit_order,
            'tujuan'=>$request->tujuan,
            'kategori'=>'onsite',
            'jenis'=>'perbaikan barang',
            'no_inventaris'=>'-',
            'nama_barang'=>$request->nama_barang,
            'detail_barang'=>$request->detail_barang,
            'permasalahan'=>$request->permasalahan,
            'tgl_execute'=>$request->tgl_execute,
            'pelaksana1'=>$request->pelaksana1,
            'pelaksana2'=>$request->pelaksana2,
            'pelaksana3'=>$request->pelaksana3,
            'pelaksana4'=>$request->pelaksana4,
            'tindakan'=>$request->tindakan,
            'hasil'=>'selesai',
            'tgl_finish'=>$request->tgl_finish,
            'catatan_petugas'=>$request->catatan_petugas,
            'tgl_up'=>$request->tgl_up,
            'user_up'=>$request->user_up,
        ]);

        $print = [
            'sts'=>'sukses',
            'msg'=>'Berhasil menyimpan data',
        ];
        return $print;
    }

    //====================================================================
    public function destroy($kode){
        $data = DB::table('work_order')
        ->where('idwo',$kode)
        ->delete();
        if(count($data)>0){
            $print = [
                'sts'=>'sukses',
                'msg'=>'Berhasil menghapus data',
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