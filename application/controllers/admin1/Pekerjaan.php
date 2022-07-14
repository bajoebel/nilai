<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pekerjaan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('pekerjaan_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{pekerjaan_id}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{pekerjaan_id}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/pekerjaan/datapekerjaan',
                'variable'      => array('pekerjaan_id'=>'pekerjaan_id','pekerjaan_nama' => 'pekerjaan_nama'),
                'field'         => array('pekerjaan_nama'),
                'function'      => 'getpekerjaan',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datapekerjaan',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'pekerjaan', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/pekerjaan', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/pekerjaan.js'),
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

    function datapekerjaan()
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
                'row_count' => $this->pekerjaan_model->countpekerjaan($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->pekerjaan_model->getpekerjaan($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $data=array(
                'pekerjaan_nama'=>$this->input->post('pekerjaan_nama'),
            );
            $pekerjaan_id=$this->input->post('pekerjaan_id');
            if(empty($pekerjaan_id)) {
                $id=$this->pekerjaan_model->insertpekerjaan($data);
                $pesan="pekerjaan berhasil disimpan";
            }
            else {
                $id=$this->pekerjaan_model->updatepekerjaan($data,$pekerjaan_id);
                $pesan="pekerjaan berhasil diupdate";
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
            $id=$this->input->post('pekerjaan_id');
            $data=array(
                'pekerjaan_nama'=>$this->input->post('pekerjaan_nama')              
            );
            $this->pekerjaan_model->updatepekerjaan($data,$pekerjaan_id);
            $response = array('status' => true, 'message' => 'Data pekerjaan berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($pekerjaan_id){
        if ($this->session->userdata('modul')==1) {
            $data=$this->pekerjaan_model->getpekerjaanById($pekerjaan_id);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($pekerjaan_id){
        if ($this->session->userdata('modul')==1) {
            $data=$this->pekerjaan_model->hapuspekerjaan($pekerjaan_id);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
