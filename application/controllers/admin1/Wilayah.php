<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('wilayah_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{wilayah_id}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{wilayah_id}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/wilayah/datawilayah',
                'variable'      => array('wilayah_id'=>'wilayah_id','provinsi' => 'provinsi','kabkota' => 'kabkota','nama_kabkota' => 'nama_kabkota'),
                'field'         => array('provinsi','{{kabkota}} {{nama_kabkota}}','kecamatan','desa','kode_pos'),
                'function'      => 'getwilayah',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datawilayah',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'Wilayah', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/wilayah', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/wilayah.js'),
                'ajaxdata'  => getData($config)
            );
            $this->load->view('template/theme', $view);
        } else {
            $sid = getSessionID();
            $url_login = base_url() . '?sid=' . $sid;
            echo "<script>alert('Ops. Sesi anda telah berubah! Silahkan login kembali');
                window.location.href = '$url_login'
                </script>";
        }
    }

    function datawilayah()
    {
        if ($this->session->userdata('modul')==1) {
            $keyword = urldecode($this->input->get('keyword', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $param = urldecode($this->input->get('param', TRUE));
            $mulai = ($start * $limit) - $limit;
            $response = array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $mulai,
                'row_count' => $this->wilayah_model->countwilayah($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->wilayah_model->getwilayah($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function propinsi(){
        $param=urldecode($this->input->get('param'));
        $response=array(
            'status'=>true,
            'message'=>'Ok',
            'res'=>$this->wilayah_model->getProvinsi($param)
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function kabkota(){
        $param=urldecode($this->input->get('param'));
        $provinsi=urldecode($this->input->get('provinsi'));
        $response=array(
            'status'=>true,
            'message'=>'Ok',
            'res'=>$this->wilayah_model->getKabKota($provinsi,$param)
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function kecamatan(){
        $param=urldecode($this->input->get('param'));
        $nama_kabkota=urldecode($this->input->get('nama_kabkota'));
        $response=array(
            'status'=>true,
            'message'=>'Ok',
            'res'=>$this->wilayah_model->getKecamatan($nama_kabkota,$param)
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            if($this->input->post('nama_kabkota')=="Padang Panjang") $luar_kota=0; else $luar_kota=1;
            
            $wilayah_id=$this->input->post('wilayah_id');
            if(empty($wilayah_id)) {
                $data=array(
                    'wilayah_id'=>$this->wilayah_model->generateKode(),
                    'provinsi'=>$this->input->post('provinsi'),
                    'kabkota'=>$this->input->post('kabkota'),
                    'nama_kabkota'=>$this->input->post('nama_kabkota'),
                    'kecamatan'=>$this->input->post('kecamatan'),
                    'desa'=>$this->input->post('desa'),
                    'kode_pos'=>$this->input->post('kode_pos'),
                    'luar_kota'=>$luar_kota
                );
                $id=$this->wilayah_model->insertwilayah($data);
                $pesan="wilayah berhasil disimpan";
            }
            else {
                $data=array(
                    'provinsi'=>$this->input->post('provinsi'),
                    'kabkota'=>$this->input->post('kabkota'),
                    'nama_kabkota'=>$this->input->post('nama_kabkota'),
                    'kecamatan'=>$this->input->post('kecamatan'),
                    'desa'=>$this->input->post('desa'),
                    'kode_pos'=>$this->input->post('kode_pos'),
                    'luar_kota'=>$luar_kota
                );
                $id=$this->wilayah_model->updatewilayah($data,$wilayah_id);
                $pesan="wilayah berhasil diupdate";
            }
            $response = array('status' => true, 'message' => $pesan);
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function pad(){
        $str=12;
        echo str_pad($str,5,"0",STR_PAD_LEFT);
    }
    function update(){
        if ($this->session->userdata('modul')==1) {
            $id=$this->input->post('wilayah_id');
            $data=array(
                'provinsi'=>$this->input->post('provinsi')              
            );
            $this->wilayah_model->updatewilayah($data,$wilayah_id);
            $response = array('status' => true, 'message' => 'Data wilayah berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($wilayah_id){
        if ($this->session->userdata('modul')==1) {
            $data=$this->wilayah_model->getwilayahById($wilayah_id);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($wilayah_id){
        if ($this->session->userdata('modul')==1) {
            $data=$this->wilayah_model->hapuswilayah($wilayah_id);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
