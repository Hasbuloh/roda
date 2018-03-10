<?php
class Laporan_Opname extends ZEN_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('Laporanopname_M','Laporan');
      $this->load->library('keuangan');
      $div = $this->session->userdata('div');
      $this->keuangan->auth($div);
  }

  public function index() {
      $this->data['nav'] = 'keuangan/page_navigation';
      $this->data['subview'] = 'keuangan/laporan_opname/index';
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

  public function table_index() {
      $where = array();
      (bool) $grup = FALSE;
      $bulan = $this->input->post('bulan');
      $jenis = $this->input->post('grup');

      if ($jenis != NULL) {
          if ($jenis == 2)  {
              $grup = TRUE;
          }
      }

      if ($bulan != NULL) {
          $where = array_merge($where,array('DATE_FORMAT(tanggal,"%Y-%m")='=>$bulan));
      }
      $this->data['items'] = $this->Laporan->table_index($where,$grup)->result();
        // print_r($this->data);
      $this->load->view('keuangan/laporan_opname/table_index',$this->data);

  }

}
