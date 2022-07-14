<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('dokter_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\\\"{{idx}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\\\"{{idx}}\\\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/dokter/datadokter',
                'variable'      => array('idx'=>'idx','nrp'=>'nrp','pgwTmpLahir' => 'pgwTmpLahir','pgwTglLahir' => 'pgwTglLahir'),
                'field'         => array('nrp','nip','pgwNama','pgwJenkel','{{pgwTmpLahir}} / {{pgwTglLahir}}','pgwAgama','pgwAlmt','pgwTelp','profesi','ruang'),
                'function'      => 'getdokter',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datadokter',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array(
                'contentTitle' => 'dokter', 
                'config' => $config,
                'pegawai'=>$this->dokter_model->getPegawai(),
                'ruang'=>$this->dokter_model->getRuang(),
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/dokter', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/dokter.js'),
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

    function datadokter()
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
                'row_count' => $this->dokter_model->countdokter($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->dokter_model->getdokter($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function nrp(){
        echo $this->dokter_model->generateNrp();
    }
    function insert(){
        if ($this->session->userdata('modul')==1) {
            
            
            $idx=$this->input->post('idx');
            if(empty($idx)) {
                $dokter=$this->input->post('dokter');
                if($dokter!=1) $dokter=0;
                $data=array(
                    'nrp'=>$this->input->post('nrp'),
                    'idruang'=>$this->input->post('idruang'),
                    'dokter'=>$dokter,
                );
                $id=$this->dokter_model->insertdokter($data);
                $pesan="dokter berhasil disimpan";
            }
            else {
                $dokter=$this->input->post('dokter');
                if($dokter!=1) $dokter=0;
                $data=array(
                    'nrp'=>$this->input->post('nrp'),
                    'idruang'=>$this->input->post('idruang'),
                    'dokter'=>$dokter,
                );
                $id=$this->dokter_model->updatedokter($data,$idx);
                $pesan="dokter berhasil diupdate";
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
                'idruang'=>$this->input->post('idruang'),
                'dokter'=>$dokter,
            );
            $this->dokter_model->updatedokter($data,$idx);
            $response = array('status' => true, 'message' => 'Data dokter berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->dokter_model->getdokterById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->dokter_model->hapusdokter($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
