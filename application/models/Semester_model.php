<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Semester_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function countsemester($keyword = "")
	{
		$this->db->group_start();
		$this->db->like('semnama', $keyword);
		$this->db->group_end();
		return $this->db->get('semester')->num_rows();
		//$this->db->limit($limit, $start);
	}
	function getsemester($limit = 0, $mulai = 1, $keyword = "")
	{
        $this->db->group_start();
		$this->db->like('semnama', $keyword);
		$this->db->group_end();
        $this->db->order_by('a.semid', 'desc');
		$this->db->limit($limit, $mulai);
		return $this->db->get('semester a')->result();
	}
	function getsemesterById($nomr)
	{
		$this->db->where('semid', $nomr);
		return $this->db->get('semester')->row();
	}

	
	function insertsemester($data){
		$this->db->insert('semester',$data);
		return $this->db->insert_id();
	}
	function updatesemester($data,$id){
		$this->db->where('semid',$id);
		$this->db->update('semester',$data);
	}

    function hapussemester($id){
		$this->db->where('semid',$id);
		$this->db->delete('semester');
	}
}
