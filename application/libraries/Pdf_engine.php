<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pdf_engine
 *
 * @author ian
 */
class Pdf_engine {
  //put your code here
  
  public function __construct() {    
    require_once APPPATH . "/third_party/mpdf/vendor/autoload.php";
  }
}
