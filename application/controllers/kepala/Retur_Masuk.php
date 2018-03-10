<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_Masuk extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Retur_M','Retur');
        $this->_setNav('kepala');
        $this->load->library('kepala');
        $div = $this->session->userdata('div');
        $this->kepala->auth($div);
  }

  function index()
  {
    $this->data['subview'] = 'kepala/retur_masuk/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function generateNoRetur() {
    // $this->load->helper('date');
    $kode = null;
    switch ($this->input->post('kode')) {
      case 1:
        $kode = "DA";
        break;

      default:
        $kode = "ND";
        break;
    }

    $nopo = null;
    $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal_retur,'%y %m')) AS 'tanggal1' FROM tbl_headerretur")->row();
    $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
    // echo $data1->tanggal1;
    // echo $data2->tanggal2;
    if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
      $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor_retur) AS 'nopo' FROM tbl_headerretur WHERE DATE_FORMAT(tanggal_retur,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
      $tmp = (int) substr($data->nopo,0,3);
      $tmp++;
      $nopo = sprintf('%03s',$tmp);
      $nopo .= '/RM/'.$kode.'/'.toRome($data->bulan).'/10108/'.$data->tahun;
    }else{
      $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
      $nopo = '001/RM/'.$kode.'/'.toRome($date->bulan).'/10108/'.$date->tahun;
    }
    echo json_encode(array('noretur'=>$nopo));
  }

  function tableIndex() {
    $this->data['items'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_retur,'%d %M %y') AS 'tanggal_retur', DATE_FORMAT(tanggal_penggantian,'%d %M %y') AS 'tanggal_penggantian' FROM tbl_headerretur ORDER BY tbl_headerretur.nomor_retur DESC")->result();
    $this->load->view('kepala/retur_masuk/table_index',$this->data);
  }

  function editHeader() {
    $this->Retur->_tableName = 'tbl_headerretur';
    $id = $this->input->post('id');
    $data = $this->Retur->array_form_post(array('nomor_retur','supplier'));
    $this->Retur->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function detailRetur() {
    $this->data['subview'] = 'kepala/retur_masuk/index_detail';
    $this->load->view('_layoutMain',$this->data);
  }

  function tableDetail() {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_retur.*,tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli FROM tbl_retur INNER JOIN tbl_stok ON id_barang = tbl_stok.id WHERE nomor_retur= '{$id}'")->result();
    $this->load->view('kepala/retur_masuk/table_detail',$this->data);
  }

  function editDetail() {
    $id = $this->input->post('id');
    $this->Retur->_tableName = 'tbl_retur';
    $data = $this->Retur->array_form_post(array('nomor_retur','nomor_faktur','id_barang','harga','qty','disc1','disc2','keterangan'));

    $this->Retur->save($data,$id);
    // redirect('kepala/Pemesanan');
    echo json_encode(array('status'=>TRUE));
  }

  function cariFaktur() {
    $id = $this->input->post('id');
    $row = array();
    $tanggal = $this->db->query("SELECT NOW() AS 'sekarang', NOW()-INTERVAL 1 MONTH AS 'sebelum'")->row();
  $data = $this->db->query("SELECT * FROM tbl_pembelian WHERE id_barang = '{$id}' GROUP BY nomor_faktur ORDER BY tanggal_faktur DESC LIMIT 5")->result_array();
    // print_r($data);
    foreach($data as $item) {
      $row[] = array('nomor_faktur'=>$item['nomor_faktur']);
    }
    echo json_encode($row);

  }

  function cariBarang() {
    $idbarang = $this->input->post('id_barang');
    $nomorfaktur = $this->input->post('nomor_faktur');
    $row = array();
    $data = $this->db->query("SELECT tbl_pembelian.*,SUM(tbl_pembelian.qty) AS 'qty_sum',tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_pembelian.id_barang = tbl_stok.id WHERE id_barang = '{$idbarang}' AND nomor_faktur = '{$nomorfaktur}'")->result_array();
    // print_r($data);
    // echo $data['nomor_part'];
    foreach ($data as $item) {
      $row[] = array('nomor_part'=>$item['nomor_part'],'nama_part'=>$item['nama_part'],'qty'=>$item['qty_sum'],'disc1'=>$item['disc1'],'disc2'=>$item['disc2'],'het'=>$item['harga_beli'],'tanggal'=>$item['tanggal_faktur']);
    }

    echo json_encode($row);
  }

  function cetakBerita()
  {
    $id = $this->input->get('id');
    $data['tanggal']=$this->db->query("SELECT DATE_FORMAT(NOW(),'%d %M %Y') AS 'tanggal'")->row();
    $this->load->library('pdfgenerator');
    $data['items'] = $this->db->query("SELECT tbl_retur.*,tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli FROM tbl_retur INNER JOIN tbl_stok ON id_barang = tbl_stok.id WHERE nomor_retur= '{$id}'")->result_array();
    $html = $this->load->view('kepala/nota/retur_masukbarang', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
  }

  function hapusDetail() {
    $id = $this->input->post('id');
    $this->Retur->_tableName = 'tbl_retur';
    $this->Retur->delete($id);
    echo json_encode(array('status'=>TRUE));
  }

  function bayar_penggantian() {
    $id = $this->input->post('nomor_retur');
    $tanggal = toIndo((string) $this->input->post('tanggal'));
    $op = $this->db->query("UPDATE tbl_headerretur SET tanggal_penggantian = '{$tanggal}',status_bayar = TRUE WHERE nomor_retur = '{$id}'");
    if ($op) {
      echo json_encode(array('status'=>TRUE));
    }
  }

  function update_status() {
      $id = $this->input->post('id');
      $status = (bool) false;
      $query = $this->db->query("UPDATE tbl_headerretur SET status = TRUE WHERE nomor_retur = '{$id}'");
      if ($query) {
          $status = (bool) true;
      }

      echo json_encode(array('status'=>$status));
  }

  function detail_retur() {
  	$id = $this->input->get('id');
  	$this->data['subview'] = 'kepala/retur_masuk/detail_retur';
    $this->db->select('tbl_headerretur.*,DATE_FORMAT(tbl_headerretur.tanggal_retur,"%d %M %Y") AS "tanggal_retur",SUM(tbl_retur.harga*tbl_retur.qty) AS "jumlah"');
    $this->db->from('tbl_headerretur');
    $this->db->join('tbl_retur','tbl_headerretur.nomor_retur = tbl_retur.nomor_retur','INNER');
    $this->db->where(array('tbl_retur.nomor_retur'=>$id));
  	$this->data['header'] = $this->db->get()->row();
    // print_r($this->data);
    $this->data['items'] = $this->db->query("SELECT tbl_retur.*,tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli FROM tbl_retur INNER JOIN tbl_stok ON id_barang = tbl_stok.id WHERE nomor_retur= '{$id}'")->result();
    // print_r($this->data);
  	$this->load->view('_layoutMain',$this->data);
  }

  function update_status_1() {
    $id = $this->input->post('id');
    $status = (bool) false;

    $update = $this->db->query("UPDATE tbl_headerretur SET status = FALSE WHERE nomor_retur = '{$id}'");
    if ($update) {
      $status = (bool) true;
    }

    echo json_encode(array('status'=>$status));
  }
}
