<?php
class Laporan_Accounting extends ZEN_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Laporanaccounting_M','Laporan');
		$this->load->library('gudang');
		$div = $this->session->userdata('div');
		$this->gudang->auth($div);
	}

	public function index()
	{
	    $this->_setNav('gudang');
	    $this->data['subview'] = 'gudang/laporan_accounting/index';
	    $this->load->view('_layoutMain',$this->data);
	}

	public function table_index() {
		$where = array();
		$bulan = $this->input->post('bulan');
		if ($bulan) {
			$where['DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m")=']=$bulan;
		}
		$this->data['items'] = $this->Laporan->table_index($where)->result();
		$this->load->view('gudang/laporan_accounting/table_index',$this->data);
	}

	public function table_index_cetak() {
		$where = array();
		$bulan = $this->input->get('bulan');
		if ($bulan) {
			$where['DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m")=']=$bulan;
		}
		$this->data['items'] = $this->Laporan->table_index($where)->result();
		$this->data['title'] = 'Laporan Accounting Bulan '.$bulan;
		$this->load->view('gudang/laporan_excel/laporan_accounting',$this->data);
	}
}
