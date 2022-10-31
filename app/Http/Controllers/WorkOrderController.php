<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class WorkOrderController extends Controller
{

    //====================================================================
    public function today_order_list()
    {
        $data = DB::table('work_order')
        ->where('tujuan','=','EDP')
        ->wheredate('tgl_order',date('Y-m-d'))
        ->get();
        $print = [
                'data'=>$data,
                'sts'=>'sukses',
            ];
        return $print;
    }

    //====================================================================
    public function dashboard()
    {
        $date_now=date('Y-m-d');
        $order_today = DB::table('work_order')
        ->whereDate('tgl_order', '=', date('Y-m-d'))
        ->count();

        $order_finish_today = DB::table('work_order')
        ->where('hasil','selesai')
        ->whereDate('tgl_order', '=', date('Y-m-d'))
        ->count();

        $print = [
            'order_today'=>$order_today,
            'order_finish_today'=>$order_finish_today,
            'sts'=>'sukses',
        ];
        return($print);
    }

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
        $pelaksana1 = '';
        $pelaksana2 = '';
        $pelaksana3 = '';
        $pelaksana4 = '';
        $new_pelaksana = substr($request->pelaksana,1);
        $final_pelaksana = explode(',',$new_pelaksana);
        for ($i=0; $i < count($final_pelaksana) ; $i++) { 
            if($i==0){
                $pelaksana1 = $final_pelaksana[$i];
            }elseif ($i==1) {
                $pelaksana2 = $final_pelaksana[$i];
            }elseif ($i==2)  {
                $pelaksana3 = $final_pelaksana[$i];
            }elseif ($i==3) {
                $pelaksana4 = $final_pelaksana[$i];
            }
        }

        $final_unit_tujuan = explode('-',$request->tujuan);
        $final_unit_order = explode('-',$request->id_unit);
        $kode_wo = $this->getkode();
        DB::table('work_order')
        ->insert([
            'idwo'=>$kode_wo,
            'tgl_order'=>$request->tgl_order,
            'id_unit'=>$final_unit_order[0],
            'unit_order'=>$final_unit_order[1],
            'tujuan'=>$final_unit_tujuan[1],
            'kategori'=>'onsite',
            'jenis'=>'perbaikan barang',
            'no_inventaris'=>'-',
            'nama_barang'=>$request->nama_barang,
            'detail_barang'=>$request->detail_barang,
            'permasalahan'=>$request->permasalahan,
            'tgl_execute'=>$request->tgl_execute,
            'pelaksana1'=>$pelaksana1,
            'pelaksana2'=>$pelaksana2,
            'pelaksana3'=>$pelaksana3,
            'pelaksana4'=>$pelaksana4,
            'tindakan'=>$request->tindakan,
            'hasil'=>$request->hasil,
            'tgl_finish'=>$request->tgl_finish,
            'catatan_petugas'=>$request->catatan_petugas,
            'tgl_in'=>date('Y-m-d H:i:s'),
            'user_in'=>'edp',
            'tgl_up'=>date('Y-m-d H:i:s'),
            'user_up'=>'',
        ]);

        $print = [
            'sts'=>'sukses',
            'msg'=>'Berhasil menyimpan data',
        ];
        return $print;
    }

    //====================================================================
    public function getkode()
    {
        $m_now = date('m');
        $y_now = date('y');
        $get_now = 'WOR'.$m_now.''.$y_now.'.';
        $get_kode = DB::table('work_order')
        ->where('idwo', 'like', '%' . $get_now . '%')
        ->max('idwo');

        if($get_kode!=''){
            $explode_kode = explode('.',$get_kode);
            $nomor_urut = $explode_kode[1]+1;
            $final_kode = $explode_kode[0].'.'.sprintf('%04d', $nomor_urut);
        }else{
            $final_kode = $get_now.'0001';
        }
        return $final_kode;
    }

    //====================================================================
    public function update(Request $request)
    {
            
        $final_unit_tujuan = explode('-',$request->tujuan);
        $final_unit_order = explode('-',$request->id_unit);
        if($request->pelaksana!=''){
            $pelaksana1 = '';
            $pelaksana2 = '';
            $pelaksana3 = '';
            $pelaksana4 = '';
            $new_pelaksana = substr($request->pelaksana,1);
            $final_pelaksana = explode(',',$new_pelaksana);
            for ($i=0; $i < count($final_pelaksana) ; $i++) { 
                if($i==0){
                    $pelaksana1 = $final_pelaksana[$i];
                }elseif ($i==1) {
                    $pelaksana2 = $final_pelaksana[$i];
                }elseif ($i==2)  {
                    $pelaksana3 = $final_pelaksana[$i];
                }elseif ($i==3) {
                    $pelaksana4 = $final_pelaksana[$i];
                }
            }
            DB::table('work_order')
            ->where('idwo',$request->kode_wo)
            ->update([
                'tgl_order'=>$request->tgl_order,
                'id_unit'=>$final_unit_order[0],
                'unit_order'=>$final_unit_order[1],
                'tujuan'=>$final_unit_tujuan[1],
                'nama_barang'=>$request->nama_barang,
                'detail_barang'=>$request->detail_barang,
                'permasalahan'=>$request->permasalahan,
                'tgl_execute'=>$request->tgl_execute,
                'pelaksana1'=>$pelaksana1,
                'pelaksana2'=>$pelaksana2,
                'pelaksana3'=>$pelaksana3,
                'pelaksana4'=>$pelaksana4,
                'tindakan'=>$request->tindakan,
                'hasil'=>$request->hasil,
                'tgl_finish'=>$request->tgl_finish,
                'catatan_petugas'=>$request->catatan_petugas,
                'tgl_up'=>date('Y-m-d H:i:s'),
                'user_up'=>'edp',
            ]);
        }else{
            DB::table('work_order')
            ->where('idwo',$request->kode_wo)
            ->update([
                'tgl_order'=>$request->tgl_order,
                'id_unit'=>$final_unit_order[0],
                'unit_order'=>$final_unit_order[1],
                'tujuan'=>$final_unit_tujuan[1],
                'nama_barang'=>$request->nama_barang,
                'detail_barang'=>$request->detail_barang,
                'permasalahan'=>$request->permasalahan,
                'tgl_execute'=>$request->tgl_execute,
                'tindakan'=>$request->tindakan,
                'hasil'=>$request->hasil,
                'tgl_finish'=>$request->tgl_finish,
                'catatan_petugas'=>$request->catatan_petugas,
                'tgl_up'=>date('Y-m-d H:i:s'),
                'user_up'=>'edp',
            ]);
        }
        
        $print = [
            'sts'=>'sukses',
            'msg'=>'Berhasil menyimpan data',
        ];
        return $print;
    }

    //====================================================================
    public function destroy(Request $request){
        $data = DB::table('work_order')
        ->where('idwo',$request->idwo)
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