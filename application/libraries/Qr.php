<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qr {
    public function __construct() {
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
    }
    
}

?>