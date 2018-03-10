<?php
class ZEN_Controller extends CI_Controller{
  public function __construct() {
    parent::__construct();
    $this->load->model('User_M','User');
    $data = array();
    $exception_uris = array(
      'user/login',
      'user/logout',
      'reset/reset',
      'gudang/barang/autocomplete'
    );

    if (in_array(uri_string(), $exception_uris) == FALSE) {
      if ($this->User->loggedin() == FALSE) {
        redirect('user/login');
      }
    }
  }

  public function index() {

  }

  public function _setNav($bag = null) {
    $this->data['nav'] = $bag.'/page_navigation';
  }


}
