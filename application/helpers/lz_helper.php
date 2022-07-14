<?php
// namespace src\LZCompressor;
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'helpers/src/LZCompressor/LZString.php');
require_once(APPPATH.'helpers/src/LZCompressor/LZContext.php');
require_once(APPPATH.'helpers/src/LZCompressor/LZData.php');
require_once(APPPATH.'helpers/src/LZCompressor/LZReverseDictionary.php');
require_once(APPPATH.'helpers/src/LZCompressor/LZUtil.php');
require_once(APPPATH.'helpers/src/LZCompressor/LZUtil16.php');
function hasil($string){
    $CI =& get_instance();
    // $data = new LZString::decompressFromEncodedURIComponent($string);
    $data=new LZCompressor\LZString();
    return $data::decompressFromEncodedURIComponent($string);
}
