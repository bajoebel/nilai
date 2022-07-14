<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function countsiswa($keyword = "")
	{
		$this->db->group_start();
		$this->db->like('siswanama', $keyword);
        $this->db->or_like('siswajekel', $keyword);
        $this->db->or_like('siswatmplahir', $keyword);
		$this->db->group_end();
		return $this->db->get('siswa')->num_rows();
		//$this->db->limit($limit, $start);
	}
	function getsiswa($limit = 0, $mulai = 1, $keyword = "")
	{
        $this->db->group_start();
		$this->db->like('siswanama', $keyword);
        $this->db->or_like('siswajekel', $keyword);
        $this->db->or_like('siswatmplahir', $keyword);
		$this->db->group_end();
        $this->db->order_by('a.nis', 'desc');
		$this->db->limit($limit, $mulai);
		return $this->db->get('siswa a')->result();
	}
	function getsiswaById($nomr)
	{
		$this->db->where('nis', $nomr);
		return $this->db->get('siswa')->row();
	}

	
	function insertsiswa($data){
		$this->db->insert('siswa',$data);
		return $this->db->insert_id();
	}
	function updatesiswa($data,$id){
		$this->db->where('nis',$id);
		$this->db->update('siswa',$data);
	}

    function hapussiswa($id){
		$this->db->where('nis',$id);
		$this->db->delete('siswa');
	}
}
