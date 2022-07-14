<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('usersmodel');
        $this->load->model('usersmodel');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\\\"{{idx}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\\\"{{idx}}\\\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/users/datausers',
                'variable'      => array('idx'=>'idx','nrp'=>'nrp','pgwTmpLahir' => 'pgwTmpLahir','pgwTglLahir' => 'pgwTglLahir'),
                'field'         => array('nrp','nip','pgwNama','pgwJenkel','{{pgwTmpLahir}} / {{pgwTglLahir}}','pgwAgama','pgwAlmt','pgwTelp','profesi','level'),
                'function'      => 'getusers',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datausers',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array(
                'contentTitle' => 'Users', 
                'config' => $config,
                'pegawai'=>$this->usersmodel->getPegawai(),
                'level'=>$this->usersmodel->getLevel(),
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/pengaturan/users', $data, true),
                'index_menu'=>5,
                'lib'           => array('javascript/users.js'),
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

    function datausers()
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
                'row_count' => $this->usersmodel->countusers($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->usersmodel->getusers($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function nrp(){
        echo $this->usersmodel->generateNrp();
    }
    function insert(){
        if ($this->session->userdata('modul')==1) {
            
            
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $data=array(
                    'nrp'=>$this->input->post('nrp'),
                    'levelid'=>$this->input->post('levelid'),
                );
                $id=$this->usersmodel->insertusers($data);
                $pesan="users berhasil disimpan";
            }
            else {
                $data=array(
                    'nrp'=>$this->input->post('nrp'),
                    'levelid'=>$this->input->post('levelid'),
                );
                $id=$this->usersmodel->updateusers($data,$idx);
                $pesan="users berhasil diupdate";
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
            $idx=$this->input->post('idx');
            $data=array(
                'nrp'=>$this->input->post('nrp'),
                'levelid'=>$this->input->post('levelid'),
            );
            $this->usersmodel->updateusers($data,$idx);
            $response = array('status' => true, 'message' => 'Data users berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->usersmodel->getusersById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->usersmodel->hapususers($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
