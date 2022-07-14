<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Semester extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('semester_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if (!empty($this->session->userdata('username'))) {
            $data = array(
                'contentTitle' => 'Semester',
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array('index_menu'=>2), true),
                'content' => $this->load->view('admin/semester', $data, true),
                'index_menu'=>2,
                'lib'           => array('js/semester.js')
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

    function datasemester()
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
                'row_count' => $this->semester_model->countsemester($keyword),
                'limit'     => $limit,
                'data'      => $this->semester_model->getsemester($limit, $mulai, $keyword),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if (!empty($this->session->userdata('username'))) {
            $status=$this->input->post('semstatus');
            if($status!=1) $status=0;
            $data=array(
                'semid'=>$this->input->post('semid'),
                'semnama'=>$this->input->post('semnama'),
                'semstatus'=>$status
            );
            $idx=$this->input->post('semid');
            $cek=$this->semester_model->getsemesterById($idx);
            if(empty($cek)) {
                $id=$this->semester_model->insertsemester($data);
                $pesan="semester berhasil disimpan";
            }
            else {
                $id=$this->semester_model->updatesemester($data,$idx);
                $pesan="semester berhasil diupdate";
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
            $data=$this->semester_model->getsemesterById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->semester_model->hapussemester($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
