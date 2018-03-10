<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Konter {
  public function auth($param) {
    if ($param != 'CP') {
      show_404();
    }
  }
}
