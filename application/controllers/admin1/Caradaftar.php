<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caradaftar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('caradaftar_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/caradaftar/datacaradaftar',
                'variable'      => array('idx'=>'idx','caradaftar' => 'caradaftar','aktif'=>'aktif'),
                'field'         => array('caradaftar','aktif'),
                'function'      => 'getcaradaftar',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datacaradaftar',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'caradaftar', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/caradaftar', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/caradaftar.js'),
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

    function datacaradaftar()
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
                'row_count' => $this->caradaftar_model->countcaradaftar($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->caradaftar_model->getcaradaftar($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $aktif=$this->input->post('aktif');
            if($aktif!=1) $aktif=0;
            $data=array(
                'caradaftar'=>$this->input->post('caradaftar'),
                'aktif'=>$aktif
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->caradaftar_model->insertcaradaftar($data);
                $pesan="caradaftar berhasil disimpan";
            }
            else {
                $id=$this->caradaftar_model->updatecaradaftar($data,$idx);
                $pesan="caradaftar berhasil diupdate";
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
            $aktif=$this->input->post('aktif');
            if($aktif!=1) $aktif=0;
            $data=array(
                'caradaftar'=>$this->input->post('caradaftar'),
                'aktif'=>$aktif              
            );
            $this->caradaftar_model->updatecaradaftar($data,$idx);
            $response = array('status' => true, 'message' => 'Data caradaftar berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->caradaftar_model->getcaradaftarById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->caradaftar_model->hapuscaradaftar($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
