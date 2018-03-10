<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gudang {
  public function auth($param) {
    if ($param != 'GD') {
      show_404();
    }
  }
}
