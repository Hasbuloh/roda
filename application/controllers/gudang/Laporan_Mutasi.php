<?php
class Laporan_Mutasi extends ZEN_Controller {
	public function __construct()
	{
	    parent::__construct();
			$this->load->model('Laporanmutasi_M','Laporan');
			$this->load->library('gudang');
			$div = $this->session->userdata('div');
			$this->gudang->auth($div);
	}

	public function index()
	{
	    $this->_setNav('gudang');
	    $this->data['subview'] = 'gudang/laporan_mutasi/index';
	    $this->load->view('_layoutMain',$this->data);
	}

	public function table_index() {
		$where = array();
        $like = array();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
		$nomor = $this->input->post('nomor');
		$jenis = $this->input->post('klasifikasi');

		if ($nomor != NULL) {
        $like = array('tbl_stoktrace.nomor_part'=>$nomor);
    }

    if ($awal && $akhir != NULL) {
        $where = array_merge($where,array('DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m-%d") <='=>$akhir));
	}

		if ($jenis != NULL) {
    		$where = array_merge($where,array('tbl_stok.jenis_part='=>$jenis));
    }

		$this->data['items'] = $this->Laporan->table_index($where,$like)->result();
		$this->load->view('gudang/laporan_mutasi/table_index',$this->data);
	}

    public function table_index_cetak() {
        $where = array();
        $like = array();
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $nomor = $this->input->get('nomor');
        $jenis = $this->input->get('klasifikasi');

        if ($nomor != NULL) {
            $like = array('tbl_stoktrace.nomor_part'=>$nomor);
        }

        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tbl_stoktrace.tanggal,"%Y-%m-%d") <='=>$akhir));
        }

        if ($jenis != NULL) {
            $where = array_merge($where,array('tbl_stok.jenis_part='=>$jenis));
        }

        $this->data['title'] = "Laporan Mutasi Stok ".$awal."-".$akhir;
        $this->data['items'] = $this->Laporan->table_index($where,$like)->result();
        $this->load->view('gudang/laporan_excel/laporan_mutasi',$this->data);
    }
}
