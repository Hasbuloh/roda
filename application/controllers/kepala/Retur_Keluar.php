<?php
class Retur_Keluar extends ZEN_Controller {
  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Returkeluar_M','Returkeluar');
    $this->_setNav('kepala');
    $this->load->library('kepala');
    $div = $this->session->userdata('div');
    $this->kepala->auth($div);
  }

  function index()
  {
    $this->data['subview'] = 'kepala/retur_keluar/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function cekHeader() {
    $id = $this->input->post('id');
    $query = $this->db->query("SELECT * FROM tbl_headerreturkeluar WHERE nomor_retur = '{$id}'");
  }

  public function editHeader() {
    $this->Returkeluar->_tableName('tbl_headerreturkeluar');
  }

  public function indexTable() {
    $this->data['items'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal' FROM tbl_returkeluar GROUP BY nomor_retur ORDER BY nomor_retur DESC ")->result();
    $this->load->view('kepala/retur_keluar/table_index',$this->data);
  }

  public function indexDetail() {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_returkeluar.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_beli FROM tbl_returkeluar INNER JOIN tbl_stok ON tbl_stok.id = tbl_returkeluar.id_barang WHERE nomor_retur = '{$id}'")->result();
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tbl_returkeluar.tanggal,'%d %M %Y') AS 'tanggal', SUM(tbl_returkeluar.harga_jual * tbl_returkeluar.qty) AS 'jumlah' FROM tbl_headerkeluar INNER JOIN tbl_returkeluar ON tbl_headerkeluar.nomor_keluar = tbl_returkeluar.nomor_keluar WHERE tbl_returkeluar.nomor_retur = '{$id}' GROUP BY tbl_returkeluar.nomor_keluar")->row();
    // print_r($this->data);
    $this->data['subview'] = 'kepala/retur_keluar/index_detail';
    // print_r($this->data);
    $this->load->view('_layoutMain',$this->data);
  }

  public function editDetail() {
    $this->Returkeluar->_tableName = 'tbl_returkeluar';
    $id = $this->input->post('id');
    $data = $this->Returkeluar->array_form_post(array('nomor_retur','nomor_keluar','id_barang','qty','jumlah','disc1','disc2','harga_jual','keterangan'));
    $this->Returkeluar->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  public function cekNoRetur() {
    $id = $this->input->post('nomor_keluar');
    $query = $this->db->query("SELECT * FROM tbl_returkeluar WHERE nomor_keluar = '{$id}'");
    if ($query->num_rows() < 1) {
      $this->generateNoRetur();
    }else{
      $query = $this->db->query("SELECT * FROM tbl_returkeluar WHERE nomor_keluar = '{$id}'")->row();
      echo json_encode(array('noretur'=>$query->nomor_retur));
    }
  }

  public function generateNoRetur() {
    // $this->load->helper('date');
    $nopo = null;
    $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_returkeluar")->row();
    $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
    // echo $data1->tanggal1;
    // echo $data2->tanggal2;
    if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
      $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor_retur) AS 'nopo' FROM tbl_returkeluar WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
      $tmp = (int) substr($data->nopo,0,3);
      $tmp++;
      $nopo = sprintf('%03s',$tmp);
      $nopo .= '/RK/'.toRome($data->bulan).'/10108/'.$data->tahun;
    }else{
      $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
      $nopo = '001/RK/'.toRome($date->bulan).'/10108/'.$date->tahun;
    }
    echo json_encode(array('noretur'=>$nopo));
  }

  function kurangi_keluar() {
    $id = $this->input->post('id');
    $id_barang = $this->input->post('id_barang');
    $qty = $this->input->post('qty_batal');
    $query = $this->db->query("UPDATE tbl_keluar SET qty = qty - $qty WHERE id = $id");
    $masukstok = $this->db->query("UPDATE tbl_stok SET qty = qty + $qty WHERE id = $id_barang");

    if ($query && $masukstok) {
      echo json_encode(array('status'=>TRUE));
    }else{
      echo json_encode(array('status'=>FALSE));
    }
  }

  function cetakBerita()
  {
    $id = $this->input->get('id');
    $data['tanggal']=$this->db->query("SELECT DATE_FORMAT(NOW(),'%d %M %Y') AS 'tanggal'")->row();
    $this->load->library('pdfgenerator');
    $data['items'] = $this->db->query("SELECT tbl_returkeluar.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.disc1,tbl_stok.disc2,tbl_stok.harga_beli FROM tbl_returkeluar INNER JOIN tbl_stok ON tbl_stok.id = tbl_returkeluar.id_barang WHERE nomor_retur = '{$id}'")->result_array();
    $data['persons'] = $this->db->query("SELECT * FROM tbl_headerkeluar INNER JOIN tbl_returkeluar ON tbl_headerkeluar.nomor_keluar = tbl_returkeluar.nomor_keluar WHERE tbl_returkeluar.nomor_retur = '{$id}' GROUP BY tbl_returkeluar.nomor_keluar")->row();

    $html = $this->load->view('kepala/nota/retur_keluarbarang', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
    // $this->load->view('kepala/nota/retur_keluarbarang',$data);
    // // print_r($data);
  }

}
