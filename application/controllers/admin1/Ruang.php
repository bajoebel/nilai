<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruang extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('ruang_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/ruang/dataruang',
                'variable'      => array('idx'=>'idx','ruang' => 'ruang'),
                'field'         => array('kode_jkn','ruang','jenislayanan','status_ruang'),
                'function'      => 'getruang',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'dataruang',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'Ruang', 'config' => $config,'jnslayanan'=>$this->ruang_model->getJnsLayanan());
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/ruang', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/ruang.js'),
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

    function dataruang()
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
                'row_count' => $this->ruang_model->countruang($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->ruang_model->getruang($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $status=$this->input->post('status_ruang');
            if($status!=1) $status=0;
            $data=array(
                'kode_jkn'=>$this->input->post('kode_jkn'),
                'ruang'=>$this->input->post('ruang'),
                'jns_layanan'=>$this->input->post('jns_layanan'),
                'status_ruang'=>$status
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->ruang_model->insertruang($data);
                $pesan="ruang berhasil disimpan";
            }
            else {
                $id=$this->ruang_model->updateruang($data,$idx);
                $pesan="ruang berhasil diupdate";
            }
            $response = array('status' => true, 'message' => $pesan);
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->ruang_model->getruangById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->ruang_model->hapusruang($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
