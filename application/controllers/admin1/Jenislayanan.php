<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenislayanan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('jenislayanan_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/jenislayanan/datajenislayanan',
                'variable'      => array('idx'=>'idx','jenislayanan' => 'jenislayanan'),
                'field'         => array('jenislayanan','kodejkn','aktif'),
                'function'      => 'getjenislayanan',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datajenislayanan',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'Jenis Layanan', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/jenislayanan', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/jenislayanan.js'),
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

    function datajenislayanan()
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
                'row_count' => $this->jenislayanan_model->countjenislayanan($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->jenislayanan_model->getjenislayanan($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $status=$this->input->post('aktif');
            if($status!=1) $status=0;
            $data=array(
                'jenislayanan'=>$this->input->post('jenislayanan'),
                'kodejkn'=>$this->input->post('kodejkn'),
                'aktif'=>$status
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->jenislayanan_model->insertjenislayanan($data);
                $pesan="jenislayanan berhasil disimpan";
            }
            else {
                $id=$this->jenislayanan_model->updatejenislayanan($data,$idx);
                $pesan="jenislayanan berhasil diupdate";
            }
            $response = array('status' => true, 'message' => $pesan);
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function update(){
        if ($this->session->userdata('modul')==1) {
            $id=$this->input->post('idx');
            $data=array(
                'jenis_layanan'=>$this->input->post('jenis_layanan')
            );
            $this->jenislayanan_model->updatejenislayanan($data,$idx);
            $response = array('status' => true, 'message' => 'Data jenislayanan berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->jenislayanan_model->getjenislayananById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->jenislayanan_model->hapusjenislayanan($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
