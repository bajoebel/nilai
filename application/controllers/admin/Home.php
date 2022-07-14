<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        //$this->load->model('nota_model');
    }
    function index()
    {
        $ses_state = session_id();
        if ($ses_state) {


            $data = array('contentTitle' => 'Home');
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array('index_menu'=>1,), true),
                'content' => $this->load->view('admin/index', $data, true),
                
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
}
