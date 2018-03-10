<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_M extends ZEN_Model{

  protected $_tableName = 'tbl_user';
  protected $_orderBy = 'id';
  public $rules = array(
    'username' => array(
      'field' => 'username',
      'label' => 'Username',
      'rules' => 'trim|required|xss_clean'
    ),
    'password' => array(
      'field' => 'password',
      'label' => 'password',
      'rules' => 'trim|required'
    )
  );

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function login() {
    $tanggal = $this->db->query("SELECT DATE_FORMAT(NOW(),'%d %M %Y') AS 'tanggal'")->row();
    $user = $this->getBy(
      array (
        'username' => $this->input->post('username'),
        'password' => $this->hash($this->input->post('password')),
      ),TRUE
    );

    if (count($user)) {
        $data = array(
          'username' => $user->username,
          'nama' => $user->nama,
          'id' => $user->id,
          'div' => $user->bagian,
          'loggedin' => TRUE,
          'tanggal' => $tanggal->tanggal,
        );

        $this->session->set_userdata($data);

        return TRUE;
    }
  }

  public function logout() {
    $this->session->sess_destroy();
  }

  public function loggedin() {
    return (bool) $this->session->userdata('loggedin');
  }

  public function hash($string) {
    return hash('sha512',$string . config_item('encryption_key'));
  }

}
