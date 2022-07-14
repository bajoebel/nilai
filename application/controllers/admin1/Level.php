<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('level_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit({{idx}},\\\"{{cb}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus({{idx}})' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/level/datalevel',
                'variable'      => array('idx'=>'idx','level' => 'level'),
                'field'         => array('level','modul_akses','status'),
                'function'      => 'getlevel',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datalevel',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array('contentTitle' => 'Level', 'config' => $config,'modul'=>$this->level_model->getModul());
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/pengaturan/level', $data, true),
                'index_menu'=>5,
                'lib'           => array('javascript/level.js'),
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

    function datalevel()
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
                'row_count' => $this->level_model->countlevel($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->level_model->getlevel($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if ($this->session->userdata('modul')==1) {
            $modulidx=$this->input->post('modulidx');
            $status=$this->input->post('status');
            if($status!=1) $status=0;
            foreach ($modulidx as $idx ) {
                $akses=$this->input->post('modul_akses'.$idx);
                if($akses) $arr_idx[]=$akses;
            }
            if(!empty($arr_idx)) $str_idx=implode(',',$arr_idx);
            else $str_idx='';
            $data=array(
                'level'=>$this->input->post('level'),
                'modul_akses'=>$str_idx,
                'status'=>$status
            );
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $id=$this->level_model->insertlevel($data);
                $pesan="level berhasil disimpan";
            }
            else {
                $id=$this->level_model->updatelevel($data,$idx);
                $pesan="level berhasil diupdate";
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
            $modulidx=$this->input->post('modulidx');
            $status=$this->input->post('status');
            if($status!=1) $status=0;
            foreach ($modulidx as $idx ) {
                $akses=$this->input->post('modul_akses'.$idx);
                if($akses) $arr_idx[]=$akses;
            }
            if(!empty($arr_idx)) $str_idx=implode(',',$arr_idx);
            else $str_idx='';
            $data=array(
                'level'=>$this->input->post('level'),
                'modul_akses'=>$str_idx,
                'status'=>$status
            );
            $idx=$this->input->post('idx');
            $this->level_model->updatelevel($data,$idx);
            $response = array('status' => true, 'message' => 'Data level berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->level_model->getlevelById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->level_model->hapuslevel($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
