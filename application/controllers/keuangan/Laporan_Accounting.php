<?php
class Laporan_Accounting extends  ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('keuangan');
        $div = $this->session->userdata('div');
        $this->keuangan->auth($div);
    }

    public function index()
    {
        $this->_setNav('keuangan');
        $this->data['subview'] = 'keuangan/laporan_accounting/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function table_accounting() {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $kategori = $this->input->post('klasifikasi');

        $data = $this->db->query("CALL PROC_ACOUNTING('{$awal}','{$akhir}','{$kategori}')");
        $this->data['items'] = $data->result();
        $this->load->view('keuangan/laporan_accounting/table_index',$this->data);
    }

    public function table_accounting_cetak() {
        $awal = $this->input->get('awal');
        $akhir = $this->input->get('akhir');
        $kategori = $this->input->get('klasifikasi');

        $data = $this->db->query("CALL PROC_ACOUNTING('{$awal}','{$akhir}','{$kategori}')");
        $this->data['items'] = $data->result();
        $this->data['title'] = 'Laporan Accounting Periode - '.$awal.' s/d '.$akhir.' '.$kategori;
        $this->load->view('keuangan/laporan_excel/laporan_accounting',$this->data);
    }
}
