<?php

/***
About  : VClaim Config
Author : Dendi Ferdinal
Create : 21-01-2019
 */

function getConsID()
{
    return CONS_ID_VC;
}
function getScretID()
{
    return SECREET_ID_VC;
}
function webServiceURL()
{
    return HOST_VC;
}

function simleCURL($urlGET)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlGET);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Verifikasi');
    $x = json_decode(curl_exec($ch));
    return $x;
}
function initCURL($url)
{
    $CI = &get_instance();
    $result = getResult();
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array($result));
    $json_response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);
    if (!empty($error_msg)) {
        $error = array('metaData' => array('code' => 201, 'message' => $error_msg));
        $json_response = json_encode($error);
    }
    return $json_response;
}
function postCURL($url, $jsonData)
{
    $contentType = "application/x-www-form-urlencoded";
    $consID = getConsID();
    $tStamp = getTimestamp();
    $encodedSignature = getSignature();

    $result = "";
    $result .= "Content-Type: " . $contentType . "\r\n";
    $result .= "X-cons-id: " . $consID . "\r\n";
    $result .= "X-timestamp: " . $tStamp . "\r\n";
    $result .= "X-signature: " . $encodedSignature;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array($result));
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    $return = curl_exec($curl);
    curl_close($curl);
    return $return;
}
function putCURL($url, $jsonData)
{
    $contentType = "application/x-www-form-urlencoded";
    $consID = getConsID();
    $tStamp = getTimestamp();
    $encodedSignature = getSignature();

    $result = "";
    $result .= "Content-Type: " . $contentType . "\r\n";
    $result .= "X-cons-id: " . $consID . "\r\n";
    $result .= "X-timestamp: " . $tStamp . "\r\n";
    $result .= "X-signature: " . $encodedSignature;

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array($result));
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    $return = curl_exec($curl);
    curl_close($curl);
    echo $return;
}
function deleteCURL($url, $jsonData)
{
    $contentType = "application/x-www-form-urlencoded";
    $consID = getConsID();
    $tStamp = getTimestamp();
    $encodedSignature = getSignature();

    $result = "";
    $result .= "Content-Type: " . $contentType . "\r\n";
    $result .= "X-cons-id: " . $consID . "\r\n";
    $result .= "X-timestamp: " . $tStamp . "\r\n";
    $result .= "X-signature: " . $encodedSignature;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array($result));
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    $return = curl_exec($curl);
    curl_close($curl);
    echo $return;
}
function showSignature()
{
    $data = getConsID();
    $secretKey = getScretID();
    date_default_timezone_set('UTC');
    $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
    $signature = hash_hmac('sha256', $data . "&" . $tStamp, $secretKey, true);
    $encodedSignature = base64_encode($signature);
    $result = "";
    $result .= "X-cons-id: " . $data . "\r\n";
    $result .= "X-timestamp: " . $tStamp . "\r\n";
    $result .= "X-signature: " . $encodedSignature;
    echo "<textarea rows=4 style=width:500px;border:none;margin:100px auto>$result</textarea>";
}
function getSignature()
{
    $scretId = getConsID();
    $scretKey = getScretID();
    date_default_timezone_set('UTC');
    $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
    $signature = hash_hmac('sha256', $scretId . "&" . $tStamp, $scretKey, true);
    $encodedSignature = base64_encode($signature);
    return $encodedSignature;
}
function getTimestamp()
{
    $scretId = getConsID();
    $scretKey = getScretID();
    date_default_timezone_set('UTC');
    $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
    return $tStamp;
}
function getResult()
{
    $data = getConsID();
    $tStamp = getTimestamp();
    $encodedSignature = getSignature();
    $result = "";
    $result .= "X-cons-id: " . $data . "\r\n";
    $result .= "X-timestamp: " . $tStamp . "\r\n";
    $result .= "X-signature: " . $encodedSignature;
    return $result;
}

/**
Bridging : VClaim 
About    : Referensi
 */
function getDiagnosa($param1)
{
    $url = webServiceURL() . "referensi/diagnosa/$param1";
    return initCURL($url);
}
function getPoli($param1)
{
    $url = webServiceURL() . "referensi/poli/$param1";
    return initCURL($url);
}
function getFaskes($param1, $param2)
{
    $url = webServiceURL() . "referensi/faskes/$param1/$param2";
    return initCURL($url);
}
function getDPJP($param1, $param2, $param3)
{
    $url = webServiceURL() . "referensi/dokter/pelayanan/$param1/tglPelayanan/$param2/Spesialis/$param3";
    return initCURL($url);
}
function getProvinsi()
{
    $url = webServiceURL() . "referensi/propinsi";
    return initCURL($url);
}
function getKabupaten($param1)
{
    $url = webServiceURL() . "referensi/kabupaten/propinsi/$param1";
    return initCURL($url);
}
function getKecamatan($param1)
{
    $url = webServiceURL() . "referensi/kecamatan/kabupaten/$param1";
    return initCURL($url);
}
function getProcedure($param1)
{
    $url = webServiceURL() . "referensi/procedure/$param1";
    return initCURL($url);
}
function getKelasRawat()
{
    $url = webServiceURL() . "referensi/kelasrawat";
    return initCURL($url);
}
function getDokter($param1)
{
    $url = webServiceURL() . "referensi/dokter/$param1";
    return initCURL($url);
}
function getSpesialistik()
{
    $url = webServiceURL() . "referensi/spesialistik";
    return initCURL($url);
}
function getRuangRawat()
{
    $url = webServiceURL() . "referensi/ruangrawat";
    return initCURL($url);
}
function getCaraKeluar()
{
    $url = webServiceURL() . "referensi/carakeluar";
    return initCURL($url);
}
function getPascaPulang()
{
    $url = webServiceURL() . "referensi/pascapulang";
    return initCURL($url);
}

/**
Bridging : VClaim 
About    : Peserta
 */
function getPesertaByKartuBPJS($param1, $param2)
{
    $tglSEP = date("Y-M-d", strtotime($param2));
    $url = webServiceURL() . "Peserta/nokartu/$param1/tglSEP/$tglSEP";
    echo initCURL($url);
}
function getPesertaByKartuNIK($param1, $param2)
{
    $tglSEP = date("Y-M-d", strtotime($param2));
    $url = webServiceURL() . "Peserta/nik/$param1/tglSEP/$tglSEP";
    echo initCURL($url);
}

/**
Bridging : VClaim 
About    : SEP - Pembuatan SEP
 */
function insertSEP($param1)
{
    /*
    Method   : POST
    Format   : JSON
    Content-Type: Application/x-www-form-urlencoded
    */
    $url = webServiceURL() . "SEP/1.1/insert";
    return postCURL($url, $param1);
}
function updateSEP($param1)
{
    /*
    Method   : PUT
    Format   : JSON
    Content-Type: Application/x-www-form-urlencoded
    */
    $url = webServiceURL() . "SEP/1.1/Update";
    echo putCURL($url, $param1);
}

function hapusSEP($param1)
{
    /*
    Method   : DELETE
    Format   : JSON
    Content-Type: Application/x-www-form-urlencoded
    */
    $url = webServiceURL() . "SEP/Delete";
    echo deleteCURL($url, $param1);
}
function cariSEP($param1)
{
    /*
    Method   : GET
    Format   : JSON
    Content-Type: Application/x-www-form-urlencoded
    */
    $url = webServiceURL() . "SEP/$param1";
    echo initCURL($url);
}

/**
Bridging : VClaim 
About    : SEP - Potensi Suplesi Jasa Raharja
 */
function suplesiJasaRaharja($param1, $param2)
{
    /*
    Base URL}/{Service Name}/sep/JasaRaharja/Suplesi/{Parameter 1}/tglPelayanan/{Parameter 2}
    Fungsi : Pencarian data potensi SEP Sebagai Suplesi Jasa Raharja
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter 1 : No.Kartu Peserta
    Parameter 2 : Tgl.Pelayanan/SEP (yyyy-mm-dd)
    */
    $tglPelayanan = date('Y-m-d', strtotime($param2));
    $url = webServiceURL() . "sep/JasaRaharja/Suplesi/$param1/tglPelayanan/$tglPelayanan";
    echo initCURL($url);
}

/**
Bridging : VClaim 
About    : SEP - Approval Penjaminan SEP
 */
function pengajuan($param1)
{
    /*
    {BASE URL}/{Service Name}/Sep/pengajuanSEP
    Fungsi : Pengajuan SEP
    Method : POST
    Format : Json
    Content-Type: Application/x-www-form-urlencoded
    {
       "request": {
          "t_sep": {
             "noKartu": "0003814312013",
             "tglSep": "2017-10-26",
             "jnsPelayanan": "1",
             "keterangan": "Hari libur",
             "user": "Coba Ws"
          }
       }
    } 
    */

    $url = webServiceURL() . "Sep/pengajuanSEP";
    return postCURL($url, $param1);
}
function aprovalPengajuanSEP($param1)
{
    /*
    {BASE URL}/{Service Name}/Sep/aprovalSEP
    Fungsi : Pengajuan SEP
    Method : POST
    Format : Json
    Content-Type: Application/x-www-form-urlencoded
    {
       "request": {
          "t_sep": {
             "noKartu": "0003814312013",
             "tglSep": "2017-10-26",
             "jnsPelayanan": "1",
             "keterangan": "Hari libur",
             "user": "Coba Ws"
          }
       }
    }    
    */

    $url = webServiceURL() . "Sep/aprovalSEP";
    echo postCURL($url, $param1);
}
/**
Bridging : VClaim 
About    : SEP - Update Tgl Pulang SEP
 */
function updateTanggalPulang($param1)
{
    /*
    {BASE URL}/{Service Name}/Sep/updtglplg
    Fungsi : Update tanggal pulang SEP
    Method : PUT
    Format : Json
    Content-Type: Application/x-www-form-urlencoded
    {  
        "request": 
            {    
            "t_sep":
                {
                    "noSep":"0301R00105160000569",
                    "tglPulang":"2016-06-12 09:00:00",
                    "user":"cobaws" 
                }
            }
    }                   
    */
    $url = webServiceURL() . "Sep/updtglplg";
    echo putCURL($url, $param1);
}

/**
Bridging : VClaim 
About    : Rujukan - Cari Rujukan
 */
function rujukanBerdasarkanNomorRujukanPCare($param1)
{
    /*
    {{BASE URL}/{Service Name}/Rujukan/{parameter}
    Fungsi : Pencarian data rujukan dari Pcare berdasarkan nomor rujukan
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor Rujukan
    */
    $url = webServiceURL() . "Rujukan/$param1";
    return initCURL($url);
}
function rujukanBerdasarkanNomorRujukanRS($param1)
{
    /*
    {BASE URL}/{Service Name}/Rujukan/RS/{parameter}
    Fungsi : Pencarian data rujukan dari rumah sakit berdasarkan nomor rujukan
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor Rujukan
    */
    $url = webServiceURL() . "Rujukan/$param1";
    return initCURL($url);
}

function rujukanBerdasarkanNomorKartuPCare($param1)
{
    /*
    BASE URL}/{Service Name}/Rujukan/Peserta/{parameter}
    Fungsi : Pencarian data rujukan dari PCare berdasarkan nomor kartu
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor kartu
    */
    $url = webServiceURL() . "Rujukan/Peserta/$param1";
    return initCURL($url);
}
function rujukanBerdasarkanNomorKartuRS($param1)
{
    /*
    {BASE URL}/{Service Name}/Rujukan/RS/Peserta/{parameter}
    Fungsi : Pencarian data rujukan dari rumah sakit berdasarkan nomor kartu
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor kartu
    */
    $url = webServiceURL() . "Rujukan/RS/Peserta/$param1";
    return initCURL($url);
}

function listRujukanBerdasarkanNomorKartuPCare($param1)
{
    /*
    {BASE URL}/{Service Name}/Rujukan/List/Peserta/{parameter}
    Fungsi : Pencarian data rujukan dari PCare berdasarkan nomor kartu
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor kartu
    */
    $url = webServiceURL() . "Rujukan/List/Peserta/$param1";
    return initCURL($url);
}
function listRujukanBerdasarkanNomorKartuRS($param1)
{
    /*
    {BASE URL}/{Service Name}/Rujukan/RS/List/Peserta/{parameter}
    Fungsi : Pencarian data rujukan dari rumah sakit berdasarkan nomor kartu
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter : Nomor kartu
    */
    $url = webServiceURL() . "Rujukan/RS/List/Peserta/$param1";
    return initCURL($url);
}


/**
Bridging : VClaim 
About    : Monitoring
 */
function dataKunjungan($param1, $param2)
{
    /*
    {Base URL}/{Service Name}/Monitoring/Kunjungan/Tanggal/{Parameter 1}/JnsPelayanan/{Parameter 2}
    Fungsi : Data Kunjungan
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter 1 : Tanggal SEP format: yyyy-mm-dd
    Parameter 2 : Jenis Pelayanan (1. Inap 2. Jalan)
    */
    $tglPelayanan = date('Y-m-d', strtotime($param1));
    $url = webServiceURL() . "Monitoring/Kunjungan/Tanggal/$tglPelayanan/JnsPelayanan/$param2";
    echo initCURL($url);
}
function dataKlaim($param1, $param2, $param3)
{
    /*
    {Base URL}/{Service Name}/Monitoring/Klaim/Tanggal/{Parameter 1}/JnsPelayanan/{Parameter 2}/Status/{Parameter 3}
    Fungsi : Data Klaim
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter 1 : Tanggal Pulang format: yyyy-mm-dd
    Parameter 2 : Jenis Pelayanan (1. Inap 2. Jalan)
    Parameter 3 : Status Klaim (1. Proses Verifikasi 2. Pending Verifikasi 3. Klaim)
    */
    $tglPulang = date('Y-m-d', strtotime($param1));
    $url = webServiceURL() . "Monitoring/Klaim/Tanggal/$tglPulang/JnsPelayanan/$param2/Status/$param3";
    echo initCURL($url);
}
function dataHistoriPelayananPeserta($param1, $param2, $param3)
{
    /*
    {Base URL}/{Service Name}/monitoring/HistoriPelayanan/NoKartu/{Parameter 1}/tglMulai/{Parameter 2}/tglAkhir/{Parameter 3}
    Fungsi : Histori Pelayanan Per Peserta
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter 1 : No.Kartu Peserta
    Parameter 2 : Tgl Mulai Pencarian (yyyy-mmdd)
    Parameter 3 : Tgl Akhir Pencarian (yyyy-mmdd)
    */
    $tglAwal = date('Y-md', strtotime($param2));
    $tglAkhir = date('Y-md', strtotime($param3));
    $url = webServiceURL() . "monitoring/HistoriPelayanan/NoKartu/$param1/tglMulai/$tglAwal/tglAkhir/$tglAkhir";
    echo initCURL($url);
}
function dataKlaimJaminanJasaRaharja($param1, $param2)
{
    /*
    {Base URL}/{Service Name}/monitoring/JasaRaharja/tglMulai/{Parameter 1}/tglAkhir/{Parameter 2}
    Fungsi : Monitoring Klaim Jasa Raharja
    Method : GET
    Format : Json
    Content-Type: application/json; charset=utf-8
    Parameter 1 : Tgl Mulai Pencarian (yyyy-mmdd)
    Parameter 2 : Tgl Akhir Pencarian (yyyy-mmdd)
    */
    $tglAwal = date('Y-md', strtotime($param1));
    $tglAkhir = date('Y-md', strtotime($param2));
    $url = webServiceURL() . "monitoring/JasaRaharja/tglMulai/$tglAwal/tglAkhir/$tglAkhir";
    echo initCURL($url);
}
