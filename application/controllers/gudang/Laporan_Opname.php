<?php
class Laporan_Opname extends ZEN_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('Laporanopname_M','Laporan');
      $this->load->library('gudang');
      $div = $this->session->userdata('div');
      $this->gudang->auth($div);
  }

  public function index() {
      $this->data['nav'] = 'gudang/page_navigation';
      $this->data['subview'] = 'gudang/laporan_opname/index';
      $this->load->view('_layoutMain',$this->data);
  }


  public function edit_detail() {
    $id_barang = $this->input->post('id_barang');
    $nomor_part = $this->input->post('nomor_part');
    $qty = $this->input->post('qty');
    $query = $this->db->query("INSERT INTO tbl_opname (id_barang,qty,nomor_part,qty) VALUES ('{$id_barang}','{$nomor_part}','{$qty}')");
    if ($query)  {
        echo json_encode(array('status'=>TRUE));
    }
  }

  public function cetak_laporan_opname() {
      $id = $this->input->get('id');
      $tanggal = $this->input->get('date');
      $this->data['items'] = $this->Laporan->table_index(array('nomor'=>$id,'tanggal'=>$tanggal))->result();
      $this->data['title'] = 'Laporan Opname - '.$id;
      $this->load->view('gudang/laporan_excel/laporan_opname',$this->data);
  }


}
