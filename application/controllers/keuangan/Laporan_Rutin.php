<?php
class Laporan_Rutin extends ZEN_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Laporanrutin_M','Laporan');
		$this->load->library('keuangan');
		$div = $this->session->userdata('div');
		$this->keuangan->auth($div);
	}

	public function index() {
		$this->_setNav('keuangan');
		$this->data['subview'] = 'keuangan/laporan_rutin/index';
		$this->load->view('_layoutMain',$this->data);
	}

	public function table_index_masuk() {
		$where = array();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $tanggal = $this->input->post('tanggal');


        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d") <='=>$akhir));
        }

        if ($tanggal != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d")='=>$tanggal));
        }


        $this->data['items'] = $this->Laporan->masuk_barang($where)->result();
		$this->load->view('keuangan/laporan_rutin/table_index_masuk',$this->data);
	}

	public function table_index_keluar() {
        $where = array();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $tanggal = $this->input->post('tanggal');


        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d") <='=>$akhir));
        }

        if ($tanggal != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d")='=>$tanggal));
        }

        $this->data['items'] = $this->Laporan->keluar_barang($where)->result();
        $this->load->view('keuangan/laporan_rutin/table_index_keluar',$this->data);
    }

    public function table_index_masuk_cetak() {
        $where = array();
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $tanggal = $this->input->get('tanggal');


        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d") <='=>$akhir));
        }

        if ($tanggal != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%Y-%m-%d")='=>$tanggal));
        }


        $this->data['items'] = $this->Laporan->masuk_barang($where)->result();
        $this->data['title'] = "Laporan Rutin Masuk ".$awal."-".$akhir."-".$tanggal;
        $this->load->view('keuangan/laporan_excel/laporan_rutin_masuk',$this->data);
    }

    public function table_index_keluar_cetak() {
        $where = array();
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $tanggal = $this->input->get('tanggal');


        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d") <='=>$akhir));
        }

        if ($tanggal != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_keluar.tanggal_keluar,"%Y-%m-%d")='=>$tanggal));
        }

        $this->data['items'] = $this->Laporan->keluar_barang($where)->result();
        $this->data['title'] = "Laporan Rutin Keluar ".$awal."-".$akhir."-".$tanggal;
        $this->load->view('keuangan/laporan_excel/laporan_rutin_keluar',$this->data);
    }

}
