<?php
class Rak extends ZEN_Controller {
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Rak_M','Rak');
      //Codeigniter : Write Less Do More
    }

    function index()
    {
      $this->_setNav('gudang');
      // $this->data['barangs'] = $this->Barang->get();
      $this->data['subview'] = 'gudang/rak/index';
      $this->load->view('_layoutMain', $this->data);
    }

    function table() {
      $this->data['items'] = $this->db->query("select * from tbl_rak");
      $this->load->view('gudang/rak/table',$this->data);
    }
}
