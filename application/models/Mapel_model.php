<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function countmapel($keyword = "")
	{
		$this->db->group_start();
		$this->db->like('mapelnama', $keyword);
        $this->db->or_like('mapelkkm', $keyword);
		$this->db->group_end();
		return $this->db->get('mapel')->num_rows();
		//$this->db->limit($limit, $start);
	}
	function getmapel($limit = 0, $mulai = 1, $keyword = "")
	{
        $this->db->group_start();
		$this->db->like('mapelnama', $keyword);
        $this->db->or_like('mapelkkm', $keyword);
		$this->db->group_end();
        $this->db->order_by('a.mapelid', 'desc');
		$this->db->limit($limit, $mulai);
		return $this->db->get('mapel a')->result();
	}
	function getmapelById($nomr)
	{
		$this->db->where('mapelid', $nomr);
		return $this->db->get('mapel')->row();
	}

	
	function insertmapel($data){
		$this->db->insert('mapel',$data);
		return $this->db->insert_id();
	}
	function updatemapel($data,$id){
		$this->db->where('mapelid',$id);
		$this->db->update('mapel',$data);
	}

    function hapusmapel($id){
		$this->db->where('mapelid',$id);
		$this->db->delete('mapel');
	}
}
