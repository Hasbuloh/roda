<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends ZEN_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_M','Stok');
        $this->load->library('konter');
        $div = $this->session->userdata('div');
        $this->konter->auth($div);
    }

    function index()
    {
        $this->_setNav('konter');
        $this->data['subview'] = 'konter/barang/index';
        $this->load->view('_layoutMain', $this->data);
    }

    
    public function autocomplete_nomor() {
        $param = $this->input->post('query');
        $output=array();
        $data = $this->db->query("SELECT * FROM tbl_stok WHERE nomor_part LIKE '%{$param}%'");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nomor_part'],
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'harga_beli' => $item['harga_beli'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'nomor_rak' => $item['no_rak']
            );
        endforeach;
        echo json_encode($output);
    }

    public function autocomplete_nama() {
        $param = $this->input->post('query');
        $output=array();
        $data = $this->db->query("SELECT * FROM tbl_stok WHERE nama_part LIKE '%{$param}%' AND qty > 0");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nama_part'].'- ('.toRP($item['harga_jual']).')',
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'harga_beli' => $item['harga_beli'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'nomor_rak' => $item['no_rak']
            );
        endforeach;
        echo json_encode($output);
    }

    public function table_barang() {
        $items = $this->Stok->table_index()->result();
        // $this->load->view('kepala/stok_barang/table_barang',$this->data);
        $data = array();
        $no=1;
        foreach ($items as $item) {

            $row = array();
            $row[] = $no;
            $row[] = $item->nomor_part;
            $row[] = $item->nama_part;
            $row[] = $item->qty;
            $row[] = $this->convert_jenis($item->jenis_part);
            $row[] = $this->cari_klasifikasi($item->id);
            $row[] = $this->cari_sod($item->id);
            $row[] = toRP($item->harga_jual);
            $row[] = toRP($item->harga_jual * $item->qty);
            $row[] = $item->disc1;
            $row[] = $item->disc2;
            $row[] = toRP($item->harga_beli);
            $row[] = toRP($item->harga_beli*$item->qty);
            $row[] = '<span class="label label-danger">'.$item->no_rak."</span>";
            $data[] = $row;
            $no++;
        }

        $output = array('data'=>$data);
        echo json_encode($output);
    }

    function convert_jenis($string) {
        $hasil_convert = null;
        switch ($string) {
            case 'O':
                $hasil_convert = 'Oli';
                break;

            case 'S':
                $hasil_convert = 'Sparepart';
                break;

            case 'O':
                $hasil_convert = 'Apparel';
                break;

            default:
                $hasil_convert = '-';
                break;
        }

        return (string) $hasil_convert;
    }

    function cari_klasifikasi($id) {
        $hasil_pencarian = null;
        $data = $this->db->query("SELECT NOW() AS 'tanggal_sekarang',NOW() - INTERVAL 1 MONTH AS 'tanggal_mundur'")->row();
        // print_r($data);
        $sql = $this->db->query("SELECT SUM(qty) AS 'jumlah' FROM tbl_keluar WHERE id_barang='{$id}' AND tanggal_keluar < '{$data->tanggal_sekarang}' AND tanggal_keluar > '{$data->tanggal_mundur}'")->row();
        $jumlah = $this->db->query("SELECT * FROM tbl_klasifikasi")->row();
        // echo $sql->jumlah/30;

        if ($sql->jumlah / 30 > $jumlah->jumlah / 30 || $sql->jumlah === $jumlah->jumlah / 30 ) {
            $hasil_pencarian = "<span class='label label-primary'>Fast Moving</span>";
        }else if($sql->jumlah / 30 > 0){
            $hasil_pencarian = "<span class='label label-warning'>Slow Moving</span>";
        }else{
            $hasil_pencarian = "<span class='label label-success'>Very Slow Moving</span>";
        }

        return (string) $hasil_pencarian;
    }

    function cari_sod($id) {
        $hasil_pencarian = null;

        $data = $this->db->query("SELECT SUM(tbl_stok.qty/tbl_keluar.qty/30) AS 'jumlah' FROM tbl_keluar INNER JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE tbl_keluar.id_barang = '{$id}' AND tbl_keluar.tanggal_keluar <= NOW() AND tbl_keluar.tanggal_keluar >= NOW() - INTERVAL 1 MONTH")->row();

        if ($data->jumlah > 0) {
            $hasil_pencarian = round($data->jumlah,2);
        }else{
            $hasil_pencarian = 0;
        }

        return (string) $hasil_pencarian;
    }


  public function autocomplete() {
    $data = $this->Barang->get();
    $row = array();
    foreach ($data as $value) {
        $row[] = array('nama'=>$value->nama_part,'id'=>$value->id,'nomor'=>$value->nomor_part,'qty'=>$value->qty,'harga_beli'=>$value->harga_beli,'harga_jual'=>$value->harga_jual,'disc1'=>$value->disc1,'disc2'=>$value->disc2);
    }

    echo json_encode($row);
}
}
