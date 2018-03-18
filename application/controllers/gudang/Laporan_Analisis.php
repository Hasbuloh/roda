<?php
class Laporan_Analisis extends ZEN_Controller {
    function __construct() {
        parent::__construct();
        $this->load->Model('Laporananalisis_M','Laporan');
        $this->load->library('gudang');
        $div = $this->session->userdata('div');
        $this->gudang->auth($div);
    }

    public function index() {
        $this->_setNav('gudang');
        // $this->data['barangs'] = $this->Barang->get();
        $this->data['subview'] = 'gudang/laporan_analisis/index';
        $this->load->view('_layoutMain', $this->data);
    }

    public function masuk_barang() {
        $where = array();
        $like = array();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $kategori = $this->input->post('kategori');
        $nomor = $this->input->post('nomor');
        $urut = $this->input->post('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }

        if ($nomor != NULL) {
            $like = array('nomor_part'=>$nomor);
        }

        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tanggal_masuk,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tanggal_masuk,"%Y-%m-%d") <='=>$akhir));
        }

        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->masuk_barang($where,$like,$urut)->result();
        $this->load->view('gudang/laporan_analisis/table_index_masuk',$this->data);
    }


    public function keluar_barang() {
        $where = array();
        $like = array();
        $order = array();
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $kategori = $this->input->post('kategori');
        $nomor = $this->input->post('nomor');
        $urut = $this->input->post('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }

        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tanggal_keluar,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tanggal_keluar,"%Y-%m-%d") <='=>$akhir));
        }
        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->keluar_barang($where,$like,$urut)->result();
        $this->load->view('gudang/laporan_analisis/table_index_keluar',$this->data);
    }

    public function stok_barang () {
        $where = array();
        $like = array();
        $order = array();
        $kategori = $this->input->post('kategori');
        $nomor = $this->input->post('nomor');
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $urut = $this->input->post('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }
        if ($nomor != NULL) {
            $like = array('nomor_part'=>$nomor);
        }
        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->stok_barang($where,$like,$urut)->result();
        $this->load->view('gudang/laporan_analisis/table_index_stok',$this->data);
    }

    public function stok_barang_cetak () {
        $where = array();
        $like = array();
        $order = array();
        $kategori = $this->input->get('kategori');
        $nomor = $this->input->get('nomor');
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $urut = $this->input->get('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }
        if ($nomor != NULL) {
            $like = array('nomor_part'=>$nomor);
        }
        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->stok_barang($where,$like,$urut)->result();
        $this->data['title'] = 'Laporan Stok Barang';
        $this->load->view('gudang/laporan_excel/laporan_stok_barang',$this->data);
    }

    public function detail_keluar() {
        $this->_setNav('gudang');
        $id = $this->input->get('id');
        $tanggal = $this->input->get('date');
        $this->data['header'] = $this->db->query("SELECT * FROM tbl_stok WHERE id = '{$id}'")->row();
        $this->data['items'] = $this->Laporan->detail_keluar($id,$tanggal)->result();
        $this->data['subview'] = 'gudang/laporan_analisis/index_detail_keluar';
        $this->load->view('_layoutMain',$this->data);
    }

    public function detail_masuk() {
        $this->_setNav('gudang');
        $id = $this->input->get('id');
        $tanggal = $this->input->get('date');
        $this->data['header'] = $this->db->query("SELECT * FROM tbl_stok WHERE id = '{$id}'")->row();
        $this->data['items'] = $this->Laporan->detail_masuk($id,$tanggal)->result();
        $this->data['subview'] = 'gudang/laporan_analisis/index_detail_masuk';
        $this->load->view('_layoutMain',$this->data);
    }

    public function masuk_barang_cetak() {
        $where = array();
        $like = array();
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $kategori = $this->input->get('kategori');
        $nomor = $this->input->get('nomor');
        $urut = $this->input->get('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }

        if ($nomor != NULL) {
            $like = array('nomor_part'=>$nomor);
        }

        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tanggal_masuk,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tanggal_masuk,"%Y-%m-%d") <='=>$akhir));
        }

        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->masuk_barang($where,$like,$urut)->result();
        $this->data['title'] = 'Laporan Masuk Barang';
        $this->load->view('gudang/laporan_excel/laporan_masuk_bulanan.php',$this->data);
    }

    public function keluar_barang_cetak() {
        $where = array();
        $like = array();
        $order = array();
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $kategori = $this->input->get('kategori');
        $nomor = $this->input->get('nomor');
        $urut = $this->input->get('urut');

        if ($kategori != NULL && $kategori != ""){
            $where = array('jenis_part'=>$kategori);
        }
        if ($nomor != NULL) {
            $like = array('nomor_part'=>$nomor);
        }
        if ($awal && $akhir != NULL) {
            $where = array_merge($where,array('DATE_FORMAT(tanggal_keluar,"%Y-%m-%d") >='=>$awal,'DATE_FORMAT(tanggal_keluar,"%Y-%m-%d") <='=>$akhir));
        }
        if ($urut != NULL) {
            $order = $urut;
        }

        $this->data['items'] = $this->Laporan->keluar_barang($where,$like,$urut)->result();
        $this->data['title'] = 'Laporan Keluar Barang';
        $this->load->view('gudang/laporan_excel/laporan_keluar_bulanan.php',$this->data);
    }

    public function tidak_bermutasi() {
        $where = '';
        $like = '';
        $order = '';
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $kategori = $this->input->post('kategori');
        $nomor = $this->input->post('nomor');
        $urut = $this->input->post('urut');

        $string = "SELECT *
              FROM tbl_stok WHERE id NOT IN(SELECT id_barang FROM tbl_keluar WHERE tanggal_keluar BETWEEN '{$awal}' AND '{$akhir}') AND id NOT IN (SELECT id_barang FROM tbl_pembelian WHERE tanggal_masuk BETWEEN '{$awal}' AND '{$akhir}')";
        if ($kategori != null) {
            $string .= " AND jenis_part = '{$kategori}'";
        }
        $string .= " ORDER BY nomor_part ASC";
        $this->data['items'] = $this->db->query($string)->result();
        $this->load->view('gudang/laporan_analisis/table_index_tidakbermutasi',$this->data);
    }

    public function tidak_bermutasi_cetak() {
        $where = '';
        $like = '';
        $order = '';
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $kategori = $this->input->get('kategori');
        $nomor = $this->input->get('nomor');
        $urut = $this->input->get('urut');

        $query = "SELECT * FROM tbl_stok WHERE id NOT IN(SELECT id_barang FROM tbl_keluar) AND id NOT IN (SELECT id_barang FROM tbl_pembelian) ORDER BY qty DESC";
        $this->data['items'] = $this->db->query($query)->result();
        $this->data['title'] = "Laporan Tidak Bermutasi";
        $this->load->view('gudang/laporan_excel/laporan_tidakbermutasi',$this->data);
    }

}
