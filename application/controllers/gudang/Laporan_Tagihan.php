<?php
class Laporan_Tagihan extends ZEN_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('gudang');
        $div = $this->session->userdata('div');
        $this->gudang->auth($div);
    }

    function index()
    {
      $this->_setNav('gudang');
      $this->data['subview'] = 'gudang/laporan_tagihan/index';
      $this->load->view('_layoutMain', $this->data);
    }

    public function cetak_excel() {
      $this->data['items'] = $this->db->query("SELECT tbl_headerinvoice.*,SUM(tbl_pembelian.jumlah) AS 'jumlah' from tbl_headerinvoice inner join tbl_pembelian on tbl_headerinvoice.nomor_invoice = tbl_pembelian.nomor_invoice WHERE tbl_headerinvoice.status_bayar = 0 GROUP BY tbl_headerinvoice.nomor_invoice")->result();
      $this->data['title'] = "Laporan Tagihan";
      $this->load->view('gudang/laporan_excel/laporan_tagihan',$this->data);
    }


}
