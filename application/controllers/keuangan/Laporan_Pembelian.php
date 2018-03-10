<?php
class Laporan_Pembelian extends ZEN_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Laporanpembelian_M','Laporan');
    $this->load->library('keuangan');
    $div = $this->session->userdata('div');
    $this->keuangan->auth($div);
  }

  public function index() {
      $this->_setNav('keuangan');
      $this->data['subview'] = 'keuangan/laporan_pembelian/index';
      $this->load->view('_layoutMain', $this->data);
  }

  public function table_index() {
	$where = array();
	$pembayaran = $this->input->post('pembayaran');
	$bulan = $this->input->post('bulan');
	$supplier = $this->input->post('supplier');
	$terima = $this->input->post('terima');
	$faktur = $this->input->post('faktur');

	if ($pembayaran != NULL) {
		$where = array('tbl_headerinvoice.status_bayar='=>$pembayaran);
	}

	if ($bulan != NULL) {
		$where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m')"=>$bulan));
	}

	if ($supplier != NULL) {
		$where = array_merge($where,array("tbl_headerinvoice.supplier"=>$supplier));
	}

	if ($terima['awal'] != NULL && $terima['akhir'] != NULL) {
//	    array('ar'=>'',)
        $where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m-%d') >="=>$terima['awal'],"DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m-%d') <="=>$terima['akhir']));
    }

    if ($faktur != NULL) {
        $where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_faktur,'%Y-%m')"=>$faktur));
    }

	 $this->data['items'] = $this->Laporan->table_index($where)->result();
	 $this->load->view('keuangan/laporan_pembelian/table_index',$this->data);
  }

   public function table_index_cetak() {
        $where = array();
        $pembayaran = $this->input->get('pembayaran');
        $bulan = $this->input->get('bulan');
        $supplier = $this->input->get('supplier');
        $terima = $this->input->get('terima');
        $faktur = $this->input->get('faktur');

        if ($pembayaran != NULL) {
          $where = array('tbl_headerinvoice.status_bayar='=>$pembayaran);
        }

        if ($bulan != NULL) {
          $where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m')"=>$bulan));
        }

        if ($supplier != NULL) {
          $where = array_merge($where,array("tbl_headerinvoice.supplier"=>$supplier));
        }

        if ($terima['awal'] != NULL && $terima['akhir'] != NULL) {
      //      array('ar'=>'',)
              $where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m-%d') >="=>$terima['awal'],"DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%Y-%m-%d') <="=>$terima['akhir']));
          }

          if ($faktur != NULL) {
              $where = array_merge($where,array("DATE_FORMAT(tbl_headerinvoice.tanggal_faktur,'%Y-%m')"=>$faktur));
          }

         $this->data['items'] = $this->Laporan->table_index($where)->result();
         $this->data['title'] = "Laporan Pembelian";
         $this->load->view('keuangan/laporan_excel/laporan_pembelian',$this->data);
  }

  function detail_pembelian() {
      $id = $this->input->get('id');
      $this->_setNav('keuangan');
      $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_faktur,'%d-%M-%Y') AS 'tanggal_faktur',DATE_FORMAT(tanggal_jt,'%d-%M-%Y') AS 'tanggal_jt' FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
      $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE nomor_invoice = '{$id}'")->result();
      $this->data['subview'] = 'keuangan/laporan_pembelian/index_detail_pembelian';
      $this->load->view('_layoutMain',$this->data);
  }

}
