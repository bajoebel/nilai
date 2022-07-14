<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('pegawai_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if ($this->session->userdata('modul')==1) {
            $action = "<div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\\\"{{idx}}\\\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\\\"{{idx}}\\\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div>";
            $config = array(
                'url'           => 'admin/pegawai/datapegawai',
                'variable'      => array('idx'=>'nrp','pgwTmpLahir' => 'pgwTmpLahir','pgwTglLahir' => 'pgwTglLahir'),
                'field'         => array('nrp','nip','pgwNama','pgwJenkel','{{pgwTmpLahir}} / {{pgwTglLahir}}','pgwAgama','pgwAlmt','pgwTelp','profesi'),
                'function'      => 'getpegawai',
                'keyword_id'    => 'q',
                'param_id'      => 'param',
                'limit_id'      => 'limit',
                'data_id'       => 'datapegawai',
                'page_id'       => 'pagination',
                'number'        => true,
                'action'        => true,
                'load'          => true,
                'action_button' => $action,
            );
            $data = array(
                'contentTitle' => 'Pegawai', 
                'config' => $config,
                'profesi'=>$this->pegawai_model->getProfesi(),
                'agama'=>$this->pegawai_model->getAgama(),
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array(), true),
                'content' => $this->load->view('admin/master/pegawai', $data, true),
                'index_menu'=>2,
                'lib'           => array('javascript/pegawai.js'),
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

    function datapegawai()
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
                'row_count' => $this->pegawai_model->countpegawai($keyword, $param),
                'limit'     => $limit,
                'data'      => $this->pegawai_model->getpegawai($limit, $mulai, $keyword, $param),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function nrp(){
        echo $this->pegawai_model->generateNrp();
    }
    function insert(){
        if ($this->session->userdata('modul')==1) {
            
            
            $idx=$this->input->post('nrp');
            if(empty($idx)) {
                $data=array(
                    'nrp'=>$this->pegawai_model->generateNrp(),
                    'nip'=>$this->input->post('nip'),
                    'pgwNama'=>$this->input->post('pgwNama'),
                    'pgwJenkel'=>$this->input->post('pgwJenkel'),
                    'pgwTmpLahir'=>$this->input->post('pgwTmpLahir'),
                    'pgwTglLahir'=>$this->input->post('pgwTglLahir'),
                    'pgwAgama'=>$this->input->post('pgwAgama'),
                    'pgwAlmt'=>$this->input->post('pgwAlmt'),
                    'pgwTelp'=>$this->input->post('pgwTelp'),
                    'profId'=>$this->input->post('profId'),
                    'userPasw'=>md5('12345'),
                );
                $id=$this->pegawai_model->insertpegawai($data);
                $pesan="pegawai berhasil disimpan";
            }
            else {
                $data=array(
                    'nip'=>$this->input->post('nip'),
                    'pgwNama'=>$this->input->post('pgwNama'),
                    'pgwJenkel'=>$this->input->post('pgwJenkel'),
                    'pgwTmpLahir'=>$this->input->post('pgwTmpLahir'),
                    'pgwTglLahir'=>$this->input->post('pgwTglLahir'),
                    'pgwAgama'=>$this->input->post('pgwAgama'),
                    'pgwAlmt'=>$this->input->post('pgwAlmt'),
                    'pgwTelp'=>$this->input->post('pgwTelp'),
                    'profId'=>$this->input->post('profId'),
                );
                $id=$this->pegawai_model->updatepegawai($data,$idx);
                $pesan="pegawai berhasil diupdate";
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
            $idx=$this->input->post('nrp');
            $data=array(
                'nip'=>$this->input->post('nip'),
                'pgwNama'=>$this->input->post('pgwNama'),
                'pgwJenkel'=>$this->input->post('pgwJenkel'),
                'pgwTmpLahir'=>$this->input->post('pgwTmpLahir'),
                'pgwTglLahir'=>$this->input->post('pgwTglLahir'),
                'pgwAgama'=>$this->input->post('pgwAgama'),
                'pgwAlmt'=>$this->input->post('pgwAlmt'),
                'pgwTelp'=>$this->input->post('pgwTelp'),
                'profId'=>$this->input->post('profId'),
            );
            $this->pegawai_model->updatepegawai($data,$idx);
            $response = array('status' => true, 'message' => 'Data pegawai berhasil diupdate');
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function edit($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->pegawai_model->getpegawaiById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if ($this->session->userdata('modul')==1) {
            $data=$this->pegawai_model->hapuspegawai($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
