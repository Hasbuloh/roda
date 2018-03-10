<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
  private $data;
  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('User_M','User');
  }

  function login()
  {
    // print_r($this->session->userdata());

    $dashboard = '';
    $divisi = $this->session->userdata('div');
    switch ($divisi) {
      case 'KG':
        $dashboard = 'kepala/dashboard';
        break;
      case 'GD':
        $dashboard = 'gudang/dashboard';
        break;
      case 'CP':
        $dashboard = 'konter/dashboard';
        break;
      case 'AC':
        $dashboard = 'keuangan/dashboard';
    }

    echo $divisi;


    $this->User->loggedin() == FALSE || redirect($dashboard);

    $rules = $this->User->rules;
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			$this->User->login();
			if($this->User->login() == TRUE) {
				redirect($dashboard);
			}else{
				$this->session->set_flashdata('error','Kombinasi email atau password tidak terdaftar');
			}
		}

    $this->data = array(
      'nav' => 'components/page_navigation',
      'subview' => '_modalLogin'
    );
    $this->load->view('_layoutMain',$this->data);
  }

  public function logout() {
    $this->User->logout();
    redirect('user/login');
  }

  public function hash() {
    echo hash('sha512','gudang'. config_item('encryption_key'));
  }

}
