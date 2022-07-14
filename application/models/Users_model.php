<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	function cekUser($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('aktif', 1);
		$this->db->where('password', md5($password));
		$users = $this->db->get('users a')->row();
		if (empty($users)) return array('status' => false, 'users' => array(), 'message' => 'User Anda Belum Aktif Atau Belum Terdaftar Silahkan HUbingi Administrator');
		else {
			return array('status' => true, 'users' => $users, 'message' => 'Anda Berhasil Login');
		}
	}
	
}
