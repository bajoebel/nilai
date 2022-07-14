<?php
defined('BASEPATH') or exit('No direct script access allowed');

class siswa extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('siswa_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if (!empty($this->session->userdata('username'))) {
            $data = array(
                'contentTitle' => 'Siswa',
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array('index_menu'=>2), true),
                'content' => $this->load->view('admin/siswa', $data, true),
                'lib'           => array('js/siswa.js')
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

    function datasiswa()
    {
        if (!empty($this->session->userdata('username'))) {
            $keyword = urldecode($this->input->get('keyword', TRUE));
            $start = intval($this->input->get('start'));
            $limit = intval($this->input->get('limit'));
            $mulai = ($start * $limit) - $limit;
            $response = array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $mulai,
                'row_count' => $this->siswa_model->countsiswa($keyword),
                'limit'     => $limit,
                'data'      => $this->siswa_model->getsiswa($limit, $mulai, $keyword),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if (!empty($this->session->userdata('username'))) {
            $status=$this->input->post('siswastatus');
            if($status!=1) $status=0;
            $data=array(
                'nis'=>$this->input->post('nis'),
                'siswanama'=>$this->input->post('siswanama'),
                'siswajekel'=>$this->input->post('siswajekel'),
                'siswatmplahir'=>$this->input->post('siswatmplahir'),
                'siswatgllahir'=>$this->input->post('siswatgllahir'),
                'siswastatus'=>$status
            );
            $idx=$this->input->post('nis');
            $cek=$this->siswa_model->getsiswaById($idx);
            if(empty($cek)) {
                $id=$this->siswa_model->insertsiswa($data);
                $pesan="siswa berhasil disimpan";
            }
            else {
                $id=$this->siswa_model->updatesiswa($data,$idx);
                $pesan="siswa berhasil diupdate";
            }
            $response = array('status' => true, 'message' => $pesan);
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    function edit($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->siswa_model->getsiswaById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->siswa_model->hapussiswa($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
