<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carabayar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('carabayar_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/carabayar/datacarabayar',
                'variable'      => array('idx'=>'idx','cara_bayar' => 'cara_bayar','jkn'=>'jkn'),
                'field'         => array('cara_bayar','jkn'),
                'function'      => 'getcarabayar',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datacarabayar',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'carabayar', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/carabayar', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/carabayar.js'),
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

    function datacarabayar()
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
                'row_count' => $this->carabayar_model->countcarabayar($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->carabayar_model->getcarabayar($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $jkn=$this->input->post('jkn');
            if($jkn!=1) $jkn=0;
            $data=array(
                'cara_bayar'=>$this->input->post('cara_bayar'),
                'jkn'=>$jkn
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->carabayar_model->insertcarabayar($data);
                $pesan="carabayar berhasil disimpan";
            }
            else {
                $id=$this->carabayar_model->updatecarabayar($data,$idx);
                $pesan="carabayar berhasil diupdate";
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
            $jkn=$this->input->post('jkn');
            if($jkn!=1) $jkn=0;
            $data=array(
                'cara_bayar'=>$this->input->post('cara_bayar'),
                'jkn'=>$jkn              
            );
            $this->carabayar_model->updatecarabayar($data,$idx);
            $response = array('status' => true, 'message' => 'Data carabayar berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->carabayar_model->getcarabayarById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->carabayar_model->hapuscarabayar($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
