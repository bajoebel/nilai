<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('kelas_model');
        $this->load->helper('ajaxdata');
    }
    function index()
    {
        if (!empty($this->session->userdata('username'))) {
            $data = array(
                'contentTitle' => 'Kelas',
                'sem'=>$this->kelas_model->getsemester(),
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array('index_menu'=>2), true),
                'content' => $this->load->view('admin/kelas', $data, true),
                'index_menu'=>2,
                'lib'           => array('js/kelas.js')
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

    function datakelas()
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
                'row_count' => $this->kelas_model->countkelas($keyword),
                'limit'     => $limit,
                'data'      => $this->kelas_model->getkelas($limit, $mulai, $keyword),
            );
        } else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    
    function insert(){
        if (!empty($this->session->userdata('username'))) {
            $status=$this->input->post('kelasstatus');
            if($status!=1) $status=0;
            $data=array(
                'kelasid'=>$this->input->post('kelasid'),
                'kelasnama'=>$this->input->post('kelasnama'),
                'kelasta'=>$this->input->post('kelasta'),
                'kelassemid'=>$this->input->post('kelassemid'),
                'kelasstatus'=>$status
            );
            $idx=$this->input->post('kelasid');
            $cek=$this->kelas_model->getkelasById($idx);
            if(empty($cek)) {
                $id=$this->kelas_model->insertkelas($data);
                $pesan="kelas berhasil disimpan";
            }
            else {
                $id=$this->kelas_model->updatekelas($data,$idx);
                $pesan="kelas berhasil diupdate";
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
            $data=$this->kelas_model->getkelasById($idx);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapus($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->hapuskelas($idx);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function addsiswa($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->getkelasById($idx);
            $response = array(
                'status' => true, 
                'message' => 'Ok',
                'data'=>$data,
                'siswa'=>$this->kelas_model->getSiswaByKelas($idx),
                'siswalain'=>$this->kelas_model->getSiswaLain($data->kelasta)
            );
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function insertsiswa(){
        if (!empty($this->session->userdata('username'))) {
            $nis=$this->input->post('nis');
            foreach ($nis as $n ) {
                $siswa[]=array(
                    'kskelasid'=>$this->input->post('kskelasid'),
                    'ksnis'=>$n
                );
            }
            if(empty($siswa)){
                $response = array('status' => false, 'message' => 'Tidak ada siswa yang diplih');
            }else{
                $this->db->insert_batch('kelassiswa',$siswa);
                $response = array('status' => true, 'message' => 'Data siswa berhasil ditambahkan');
            }
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapuspilihansiswa($id){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->hapusPilihaSiswa($id);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function addmpl($idx){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->getkelasById($idx);
            $response = array(
                'status' => true, 
                'message' => 'Ok',
                'data'=>$data,
                'mapel'=>$this->kelas_model->getMpl($idx),
                'mapellain'=>$this->kelas_model->getMplLain($idx)
            );
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function insertmapel(){
        if (!empty($this->session->userdata('username'))) {
            $mapelid=$this->input->post('mapelid');
            foreach ($mapelid as $m ) {
                $mapel[]=array(
                    'kmkelasid'=>$this->input->post('kmkelasid'),
                    'kmmapelid'=>$m
                );
            }
            if(empty($mapel)){
                $response = array('status' => false, 'message' => 'Tidak ada matapelajaran yang diplih');
            }else{
                $this->db->insert_batch('kelasmapel',$mapel);
                $response = array('status' => true, 'message' => 'Data siswa berhasil ditambahkan');
            }
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function hapuspilihanmapel($id){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->hapusPilihaMapel($id);
            $response = array('status' => true, 'message' => 'Data berhasil dihapus','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function nilai($kelasid){
        if (!empty($this->session->userdata('username'))) {
            $kelas=$this->kelas_model->getkelasById($kelasid);
            $data = array(
                'contentTitle' => 'Nilai',
                'kelas'=>$kelas,
                'mapel'=>$this->kelas_model->getMapelBykelas($kelasid),
                'siswa'=>$this->kelas_model->getSiswaByKelas($kelasid),
            );
            $view = array(
                'header' => $this->load->view('template/header', '', true),
                'nav_sidebar' => $this->load->view('template/nav_sidebar', array('index_menu'=>2), true),
                'content' => $this->load->view('admin/nilai', $data, true),
                'index_menu'=>2,
                'lib'           => array('js/kelas.js')
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
    function listnilai($kelasid,$mapelid){
        if (!empty($this->session->userdata('username'))) {
            $data=$this->kelas_model->getNilaiByKelas($kelasid,$mapelid);
            $response = array('status' => true, 'message' => 'Ok','data'=>$data);
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function insertnilai(){
        if (!empty($this->session->userdata('username'))) {
            $nis=$this->input->post('nis');
            foreach ($nis as $n ) {
                $nilaiid=$this->input->post('nilaiid'.$n);
                $nilai=$this->input->post('nilai'.$n);
                if($nilai<=50) $nilaihuruf="E";
                else if($nilai>50 && $nilai<=65) $nilaihuruf="D";
                else if($nilai>65 && $nilai<=75) $nilaihuruf="C";
                else if($nilai>75 && $nilai<=85) $nilaihuruf="B";
                else $nilaihuruf="A";
                if(empty($nilaiid)){
                    $nilaibaru[]=array(
                        'nilaikelasid'=>$this->input->post('nilaikelasid'),
                        'nilainis'=>$n,
                        'nilaimapelid'=>$this->input->post('nilaimapelid'),
                        'nilaiangka'=>$this->input->post('nilai'.$n),
                        'nilaihuruf'=>$nilaihuruf
                    );
                }else{
                    $nilaiupdate[]=array(
                        'nilaiid'=>$nilaiid,
                        'nilaiangka'=>$this->input->post('nilai'.$n),
                        'nilaihuruf'=>$nilaihuruf
                    );
                }
            }
            if(empty($nilaibaru)){
                if(empty($nilaiupdate)){
                    $response = array('status' => false, 'message' => 'Tidak ada matapelajaran yang diplih');
                }else{
                    $this->db->update_batch('nilai',$nilaiupdate,'nilaiid');
                    $response = array('status' => true, 'message' => 'Nilai siswa berhasil diperbaharui');
                }
            }else{
                $this->db->insert_batch('nilai',$nilaibaru);
                if(empty($nilaiupdate)){
                    $response = array('status' => true, 'message' => 'Nilai siswa berhasil ditambahkan');
                }else{
                    $this->db->update_batch('nilai',$nilaiupdate,'nilaiid');
                    $response = array('status' => true, 'message' => 'Nilai siswa berhasil diperbaharui');
                }
                
            }
        }else {
            $response = array('status' => false, 'message' => 'Session Expired');
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function rekapnilai($kelasid,$mapelid){
        $data=array(
            'kelas'=>$this->kelas_model->getkelasById($kelasid),
            'mapel'=>$this->kelas_model->getmapelById($mapelid),
            'nilai'=>$this->kelas_model->getNilaiByKelas($kelasid,$mapelid)
        );
        $html=$this->load->view('admin/rekapnilaiperkelas',$data,true);
        $pdfFilePath = "Rekap_nilai_per_kelas.pdf";
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D");

    }
}
