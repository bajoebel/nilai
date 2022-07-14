<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
	}

	public function index()
	{
		$this->load->view('template/login');
	}
	function logout(){
		$this->session->sess_destroy();
        $this->session->unset_userdata('userid');
        redirect(base_url());
	}
	function cek()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$response = $this->users_model->cekUser($username, $password);
		$users = $response["users"];
		if (!empty($users)) {
			$data = array(
				'username'	=> $username,
				'nama'  	=> $users->nama_lengkap
			);
			$this->session->set_userdata($data);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}
