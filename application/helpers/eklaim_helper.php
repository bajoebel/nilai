<?php
/***
About  : EKlaim Config
Author : Dendi Ferdinal
Create : 17-09-2019
*/

function getHostIP(){return HOST_EC;}
function getKeyValue(){return ENCRYPT_KEY;}
function getRsID(){return RS_ID_EC;}


// Encryption Function
function inacbg_encrypt($data, $key) {
    /// make binary representasion of $key
    $key = hex2bin($key);
    /// check key length, must be 256 bit or 32 bytes
    if (mb_strlen($key, "8bit") !== 32) {
        throw new Exception("Needs a 256-bit key!");
    }
    /// create initialization vector
    $iv_size = openssl_cipher_iv_length("aes-256-cbc");
    $iv = openssl_random_pseudo_bytes($iv_size); // dengan catatan dibawah
    /// encrypt
    $encrypted = openssl_encrypt($data,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv);
    /// create signature, against padding oracle attacks
    $signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit"); 
    /// combine all, encode, and format
    $encoded = chunk_split(base64_encode($signature.$iv.$encrypted));
    return $encoded;
}
// Decryption Function
function inacbg_decrypt($str, $strkey){
    /// make binary representation of $key
    $key = hex2bin($strkey);
    /// check key length, must be 256 bit or 32 bytes
    if (mb_strlen($key, "8bit") !== 32) {
        throw new Exception("Needs a 256-bit key!");
    }
    /// calculate iv size
    $iv_size = openssl_cipher_iv_length("aes-256-cbc");
    /// breakdown parts
    $decoded = base64_decode($str);
    $signature = mb_substr($decoded,0,10,"8bit");
    $iv = mb_substr($decoded,10,$iv_size,"8bit");
    $encrypted = mb_substr($decoded,$iv_size+10,NULL,"8bit");
    /// check signature, against padding oracle attack
    $calc_signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit"); 
    if(!inacbg_compare($signature,$calc_signature)) {
        return "SIGNATURE_NOT_MATCH"; /// signature doesn't match
    }
    $decrypted = openssl_decrypt($encrypted,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv);
    return $decrypted;
}
/// Compare Function
function inacbg_compare($a, $b) {
    /// compare individually to prevent timing attacks
    /// compare length
    if (strlen($a) !== strlen($b)) return false;
    /// compare individual
    $result = 0;
    for($i = 0; $i < strlen($a); $i ++) {
        $result |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $result == 0;
}
function claim_print(){
// json query
$json_request = <<<EOT
{
    "metadata": {
        "method": "claim_print"
    },
    "data": {
        "nomor_sep": "0304R0010319V000128"
    }
}
EOT;

    $ws_query["metadata"]["method"] = "claim_print";
    $ws_query["data"]["nomor_sep"] = "0304R0010319V000128";
    $json_request = json_encode($ws_query);
    
    $key = $this->getKeyValue();
    $payload = inacbg_encrypt($json_request,$key);
    $header = array("Content-Type: application/x-www-form-urlencoded");

    $url = $this->getHostIP();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);

    // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
    // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
    $first  = strpos($response, "\n")+1;
    $last   = strrpos($response, "\n")-1;
    $response  = substr($response, 
                    $first, 
                    strlen($response) - $first - $last);
    // decrypt dengan fungsi inacbg_decrypt
    $response = inacbg_decrypt($response,$key);
    $msg = json_decode($response,true);
    $pdf = base64_decode($msg["data"]);
    file_put_contents("klaim.pdf",$pdf);
    header("Content-type:application/pdf");
    header("Content-Disposition:attachment;filename=klaim.pdf");
    echo $pdf;            
}

function initCURL_Eklaim($ws_query){
    $json_request = json_encode($ws_query);
    $key = getKeyValue();
    $payload = inacbg_encrypt($json_request,$key);

    $header = array("Content-Type: application/x-www-form-urlencoded");
    $url = getHostIP();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);

    // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
    // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
    $first  = strpos($response, "\n")+1;
    $last   = strrpos($response, "\n")-1;
    $response  = substr($response,$first,strlen($response)-$first-$last);
    // decrypt dengan fungsi inacbg_decrypt
    $response = inacbg_decrypt($response,$key);
    return $response;
}


/**
Pencarian diagnosa:
{
   "metadata": {
      "method": "search_diagnosis"
   },
   "data": {
     "keyword": "A00"
   }
}
Keterangan parameter :
keyword  : diisi dengan kode, sebagian dari kode, atau sebagian dari nama diagnosa
*/

function search_diagnosis($param1){
    return initCURL_Eklaim($param1);
} 

/**
Pencarian diagnosa:
{
   "metadata": {
      "method": "search_procedures"
   },
   "data": {
     "keyword": "74.9"
   }
}
Keterangan parameter :
keyword  : diisi dengan kode, sebagian dari kode, atau sebagian dari nama prosedur
*/

function search_procedures($param1){
    $ws_query = json_encode($param1);
    return initCURL_Eklaim($param1);
} 

function initJSON($ws_query){
    $key = getKeyValue();
    $payload = inacbg_encrypt($ws_query,$key);

    $header = array("Content-Type: application/x-www-form-urlencoded");
    $url = getHostIP();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = curl_exec($ch);
    // terlebih dahulu hilangkan "----BEGIN ENCRYPTED DATA----\r\n"
    // dan hilangkan "----END ENCRYPTED DATA----\r\n" dari response
    $first  = strpos($response, "\n")+1;
    $last   = strrpos($response, "\n")-1;
    $response  = substr($response,$first,strlen($response)-$first-$last);
    // decrypt dengan fungsi inacbg_decrypt
    $response = inacbg_decrypt($response,$key);
    return $response;
}


?>