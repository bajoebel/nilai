<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function countkelas($keyword = "")
	{
        $this->db->join('semester','kelassemid=semid');
		$this->db->group_start();
		$this->db->like('kelasnama', $keyword);
        $this->db->or_like('semnama', $keyword);
        $this->db->or_like('kelasta', $keyword);
		$this->db->group_end();
		return $this->db->get('kelas')->num_rows();
		//$this->db->limit($limit, $start);
	}
	function getkelas($limit = 0, $mulai = 1, $keyword = "")
	{
        $this->db->join('semester','kelassemid=semid');
        $this->db->group_start();
		$this->db->like('kelasnama', $keyword);
        $this->db->or_like('semnama', $keyword);
        $this->db->or_like('kelasta', $keyword);
		$this->db->group_end();
        $this->db->order_by('a.kelasid', 'desc');
		$this->db->limit($limit, $mulai);
		return $this->db->get('kelas a')->result();
	}
	function getkelasById($nomr)
	{
		$this->db->where('kelasid', $nomr);
		return $this->db->get('kelas')->row();
	}

	
	function insertkelas($data){
		$this->db->insert('kelas',$data);
		return $this->db->insert_id();
	}
	function updatekelas($data,$id){
		$this->db->where('kelasid',$id);
		$this->db->update('kelas',$data);
	}

    function hapuskelas($id){
		$this->db->where('kelasid',$id);
		$this->db->delete('kelas');
	}
    function getsemester(){
        return $this->db->where('semstatus',1)->get('semester')->result();
    }
	function getSiswaByKelas($kelas){
		return $this->db->where('kskelasid',$kelas)
		->join('siswa','ksnis=nis')
		->get('kelassiswa')->result();
	}
	function getSiswaLain($ta){
		return $this->db->where("nis NOT IN (SELECT ksnis FROM kelassiswa JOIN kelas ON kskelasid=kelasid WHERE kelasta='$ta')")
		->get('siswa')->result();
	}
	function hapusPilihaSiswa($id){
		$this->db->where('ksid',$id)
		->delete('kelassiswa');
	}
	function getMpl($kelas){
		return $this->db->where('kmkelasid',$kelas)
		->join('mapel','kmmapelid=mapelid')
		->get('kelasmapel')->result();
	}
	function getMplLain($kelas){
		return $this->db->where("mapelid NOT IN (SELECT kmmapelid FROM kelasmapel WHERE kmkelasid='$kelas')")
		->get('mapel')->result();
	}
	function hapusPilihaMapel($id){
		$this->db->where('kmid',$id)
		->delete('kelasmapel');
	}
	function getMapelBykelas($kelasid){
		return $this->db->where('kmkelasid',$kelasid)
		->join('mapel','kmmapelid=mapelid')
		->get("kelasmapel")->result();
	}
	function getNilaiByKelas($kelasid,$mapel){
		return $this->db->where('kskelasid',$kelasid)
		->join("siswa","ksnis=nis")
		->join("(SELECT * FROM nilai WHERE nilaikelasid=$kelasid AND nilaimapelid=$mapel) AS c","nis=nilainis","LEFT")
		->get("kelassiswa")->result();
	}
	function getmapelById($mapelid){
		return $this->db->where('mapelid',$mapelid)->get('mapel')->row();
	}
	
}
