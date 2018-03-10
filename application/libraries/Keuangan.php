<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Keuangan {
  public function auth($param) {
    if ($param != 'AC') {
      show_404();
    }
  }
}
