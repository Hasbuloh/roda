<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik_Penjualan extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Barang_M','Barang');
  }

  function index()
  {
    $this->data['nav'] = 'gudang/page_navigation';
    $this->data['subview'] = 'gudang/grafik_penjualan/index';
    $this->load->view('_layoutMain', $this->data);
  }

  function grafik() {
    $barang = $this->Barang->get();
    $data = array();
    foreach ($barang as $value) {
      $data[] = array('label'=>$value->nama_part,'y'=>$value->qty);
    }
    echo json_encode($data);
  }

}
