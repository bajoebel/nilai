<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rujukan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('rujukan_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/rujukan/datarujukan',
                'variable'      => array('idx'=>'idx','rujukan' => 'rujukan'),
                'field'         => array('rujukan','faskes','aktif'),
                'function'      => 'getrujukan',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datarujukan',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'Rujukan', 'config' => $config);
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/rujukan', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/masterrujukan.js'),
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

    function datarujukan()
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
                'row_count' => $this->rujukan_model->countrujukan($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->rujukan_model->getrujukan($limit, $mulai, $keyword, $param),
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
            $faskes=array(
                'Rujukan Manual'=>0,
                'Faskes Tingkat 1'=>1,
                'Faskes Tingkat 2'=>2,
                'Tidak Diketahui'=>3
            );
            $data=array(
                'rujukan'=>$this->input->post('rujukan'),
                'id_faskes'=>$faskes[$this->input->post('faskes')],
                'faskes'=>$this->input->post('faskes'),
                'aktif'=>$status
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->rujukan_model->insertrujukan($data);
                $pesan="rujukan berhasil disimpan";
            }
            else {
                $id=$this->rujukan_model->updaterujukan($data,$idx);
                $pesan="rujukan berhasil diupdate";
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
            $status=$this->input->post('aktif');
            if($status!=1) $status=0;
            $faskes=array(
                'Rujukan Manual'=>0,
                'Faskes Tingkat 1'=>1,
                'Faskes Tingkat 2'=>2,
                'Tidak Diketahui'=>3
            );
            $data=array(
                'rujukan'=>$this->input->post('rujukan'),
                'id_faskes'=>$faskes[$this->input->post('faskes')],
                'faskes'=>$this->input->post('faskes'),
                'aktif'=>$status
            );
            $this->rujukan_model->updaterujukan($data,$idx);
            $response = array('status' => true, 'message' => 'Data rujukan berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->rujukan_model->getrujukanById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->rujukan_model->hapusrujukan($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
