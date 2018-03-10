<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kepala {
  public function auth($param) {
    if ($param != 'KG') {
      show_404();
    }
  }
}
