<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Dutawisata extends RestController {
    public function __construct()
    {
        parent:: __construct();
       $this->load->model('model_dutawisata', 'dwst');
       $this->methods['index_get']['limit'] = 2;
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $p =  $this->get('page');
            $p = (empty($p) ? 1 : $p);
            $total_data = $this -> dwst ->count();
            $total_page = ceil($total_data/5);
            $start=($p-1) * 5;
            $list=$this->dwst->get(null,5,$start);
            if ($list) {
            $data = [
                'status' => true,
                'page' => $p,
                'total_data' => $total_data,
                'total_page' => $total_page,
                'data' => $list 
            ];
            } else {
                $data=['status' => false,
                'msg' => 'Data Tidak Ditemukan'
            ];
            }
            $this->response($data,RestController::HTTP_OK);
        } else {
            $data = $this->dwst->get($id);
            if ($data) {
                $this->response(['status'=>true, 'data'=> $data],RestController::HTTP_OK);
            } else {
                $this->response(['status' => false, 'msg' => $id .'Tidak Ditemukan'], RestController::HTTP_NOT_FOUND);
            }
        }
        }
    
    public function index_post(){
        $data = [
            'id_peserta' => $this->post('id_peserta'),
            'nama_peserta' => $this->post('nama_peserta'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'usia' => $this->post('usia'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'tinggi' => $this->post('tinggi'),
            'berat' => $this->post('berat'),
            'agama' => $this->post('agama'),
            'alamat' => $this->post('alamat'),
            'nama_kota' => $this->post('nama_kota'),
            'pendidikan' => $this->post('pendidikan'),
            'nama_ortu' => $this->post('nama_ortu'),
            'id_datakota' => $this->post('id_datakota')
        ];
        $simpan=$this->dwst->add($data);
        if($simpan['status']){
            $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data Telah Ditambahkan'], RestController:: HTTP_CREATED);
        } else {
            $this->response(['status'=>false,'msg'=>$simpan['msg']], RestController:: HTTP_INTERNAL_ERROR);
        }
    }

    public function index_put(){
        $data = [
            'id_peserta' => $this->put('id_peserta', true),
            'nama_peserta' => $this->put('nama_peserta', true),
            'tanggal_lahir' => $this->put('tanggal_lahir', true),
            'usia' => $this->put('usia', true),
            'jenis_kelamin' => $this->put('jenis_kelamin', true),
            'tinggi' => $this->put('tinggi', true),
            'berat' => $this->put('berat', true),
            'agama' => $this->put('agama', true),
            'alamat' => $this->put('alamat', true),
            'nama_kota' => $this->put('nama_kota', true),
            'pendidikan' => $this->put('pendidikan', true),
            'nama_ortu' => $this->put('nama_ortu', true),
            'id_datakota' => $this->put('id_datakota', true)
        ];
        $id = $this->put('id');
        if($id === null) {
            $this->response(['status'=>false,'msg'=> 'Masukkan ID Peserta yang akan dirubah'], RestController:: HTTP_BAD_REQUEST);
        }
        $simpan=$this->dwst->update($id, $data);
        if($simpan['status']){
            $status = (int)$simpan['data'];
            if ($status > 0) 
            $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data Telah Dirubah'], RestController:: HTTP_OK);
            else
            $this->response(['status'=>true,'msg'=>$simpan['data']. ' Tidak ada Data yang Dirubah'], RestController:: HTTP_BAD_REQUEST);
        } else {
            $this->response(['status'=>false,'msg'=>$simpan['msg']], RestController:: HTTP_INTERNAL_ERROR);
        }
    }

    public function index_delete (){
        $id = $this->delete('id');
        if($id === null) {
            $this->response(['status'=>false,'msg'=> 'Masukkan ID Peserta yang akan dihapus'], RestController:: HTTP_BAD_REQUEST);
        }
        $delete=$this->dwst->delete($id);
        if($delete['status']){
            $status = (int)$delete['data'];
            if ($status > 0) 
            $this->response(['status'=>true,'msg'=> $id . ' Data Telah Dihapus'], RestController:: HTTP_OK);
            else
            $this->response(['status'=>true,'msg'=> ' Tidak ada Data yang Dihapus'], RestController:: HTTP_BAD_REQUEST);
        } else {
            $this->response(['status'=>false,'msg'=>$delete['msg']], RestController:: HTTP_INTERNAL_ERROR);
        }
    }

    }
    

?>