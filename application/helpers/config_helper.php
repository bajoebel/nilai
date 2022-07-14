<?php
function getAppName()
{
    return "SIMKLINIK App";
}
function getSessionID()
{
    return session_id();
}
function getAppLgName()
{
    return "<b>SimKlinik</b> App";
}
function getAppMnName()
{
    return "<b>SIM</b>K";
}
function getCompany()
{
    return COMPANY_NAME;
}
function getRS()
{
    return COMPANY_NAME;
}
function getAddress1()
{
    return REPORT_ADDRESS_1;
}
function getAddress2()
{
    return REPORT_ADDRESS_2;
}
function getFooterRS()
{
    return FOOTER_APP;
}
function getVersion()
{
    return VERSION_APP;
}
function getFooter()
{
    return FOOTER . " [" . getFooterRS() . "]";
}
function getLoginLogo()
{
    return LOGO;
}
function getTimeUserLogin()
{
    $CI = &get_instance();
    $uid = $CI->session->userdata('userid');
    $CI->db->where('nrp', $uid);
    $cekQuery = $CI->db->get('pegawai');
    if ($cekQuery->num_rows() > 0) {
        $res = $cekQuery->row_array();
        return $res['last_login'];
    } else {
        return "";
    }
}
function getSkin($idx)
{
    $CI = &get_instance();
    $CI->db->where('idx', $idx);
    $cekQuery = $CI->db->get('acc_modul');
    if ($cekQuery->num_rows() > 0) {
        $res = $cekQuery->row_array();
        return $res['skin'];
    } else {
        return "";
    }
}
function longDate($tgl){
    $tgl=explode('-',$tgl);
    $bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    return $tgl[2]." " .$bulan[intval($tgl[1])]." " .$tgl[0];
}
function isJSON($string){
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}