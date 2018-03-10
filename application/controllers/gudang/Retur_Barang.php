<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_Barang extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->data['nav'] = 'gudang/page_navigation';
    $this->load->model('Retur_M','Retur');
    $this->load->library('gudang');
    $div = $this->session->userdata('div');
    $this->gudang->auth($div);
  }

  function index()
  {
    $this->data['nav'] = 'gudang/page_navigation';
    $this->data['subview'] = 'gudang/retur_barang/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_retur() {
    $data = array();
    $no=1;
    $items = $this->db->query("SELECT 
                        id,nomor_retur,
                        ifnull(rk.jumlah,0) AS jumlah,
                        ifnull(rk.item,0) AS item,
                        supplier,
                        status,
                        status_bayar,
                        DATE_FORMAT(tanggal_retur,'%d %M %y') AS 'tanggal_retur', 
                        DATE_FORMAT(tanggal_penggantian,'%d %M %y') AS 'tanggal_penggantian' 
                        FROM tbl_headerretur 
                        LEFT JOIN(
                            SELECT 
                                nomor_retur AS nomor,
                                SUM(harga*qty) AS jumlah,
                                (id_barang) AS item
                            FROM tbl_retur GROUP BY nomor_retur) 
                        AS rk ON tbl_headerretur.nomor_retur = rk.nomor ORDER BY tbl_headerretur.tanggal_retur DESC")->result();
    foreach ($items as $item):
      $row = array();
      $row[] = $this->tombol_edit();
      $row[] = $this->tombol_hapus();
      $row[] = $no;
      $row[] = $item->nomor_retur;
      $row[] = $item->tanggal_retur;
      $row[] = $item->tanggal_penggantian;
      $row[] = $item->item;
      $row[] = toRP($item->jumlah);
      $row[] = $this->tombol_penggantian(array('status'=>$item->status_bayar,'nomor_retur'=>$item->nomor_retur));
      $row[] = $this->tombol_cetak(array('nomor'=>$item->nomor_retur));
      $row[] = $this->tombol_detail(array('nomor'=>$item->nomor_retur));
      $row[] = $this->tombol_update(array('status'=>$item->status,'nomor'=>$item->nomor_retur));
      $no++;
      $data[] = $row;
    endforeach;

    echo json_encode(array('data'=>$data));
  }

  public function generate_nourut() {
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
    $this->load->view('gudang/retur_barang/table_index',$this->data);
  }

  function editHeader() {
    $this->Retur->_tableName = 'tbl_headerretur';
    $id = $this->input->post('id');
    $data = $this->Retur->array_form_post(array('nomor_retur','supplier'));
    $this->Retur->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function update_detail_retur() {
    $id = $this->input->get('id');
    $this->data['header'] = $this->db->query("SELECT * FROM tbl_headerretur WHERE nomor_retur = '{$id}'")->row();
    // print_r($this->data);
    $this->data['nav'] = 'gudang/page_navigation';
    $this->data['subview'] = 'gudang/retur_barang/index_detail';
    $this->load->view('_layoutMain',$this->data);
  }

  function table_detail() {
    $id = $this->input->get('id');
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_retur,'%d %M %Y') AS tanggal_retur FROM tbl_headerretur WHERE nomor_retur = '{$id}'")->row();
    $this->data['items'] = $this->db->query("SELECT tbl_retur.*,tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli FROM tbl_retur INNER JOIN tbl_stok ON id_barang = tbl_stok.id WHERE nomor_retur= '{$id}'")->result();
    $this->load->view('gudang/retur_barang/table_detail',$this->data);
  }

  function editDetail() {
    $id = $this->input->post('id');
    $status = (boolean) false;
    $cek = $this->db->query("SELECT * FROM tbl_retur WHERE nomor_retur = '{$this->input->post('nomor_retur')}' AND id_barang = '{$this->input->post('id_barang')}'")->num_rows();
    if ($cek == 0) {
      $this->Retur->_tableName = 'tbl_retur';
      $data = $this->Retur->array_form_post(array('nomor_retur','nomor_faktur','id_barang','harga','qty','disc1','disc2','keterangan'));
      $this->Retur->save($data,$id);
      $status = (boolean) true;
    }

    echo json_encode(array('status'=>$status));
    // echo $cek;
  }

  function cari_faktur() {
    $id_barang = $this->input->post('id_barang');
    $id_supplier = $this->input->post('id_supplier');
    $row = array();
    $data = $this->db->query("select p.nomor_invoice,p.nomor_faktur,p.id_barang,p.qty,c.supplier from tbl_pembelian as p left join (select nomor_invoice,nomor_faktur,supplier from tbl_headerinvoice) as c on c.nomor_faktur = p.nomor_faktur where c.supplier = '{$id_supplier}' and p.id_barang='{$id_barang}' ORDER BY tanggal_faktur DESC LIMIT 5")->result_array();
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
    $data = $this->db->query("SELECT tbl_pembelian.*,DATE_FORMAT(tanggal_faktur,'%d %M %Y') AS tanggal_faktur,SUM(tbl_pembelian.qty) AS 'qty_sum',tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_pembelian.id_barang = tbl_stok.id WHERE id_barang = '{$idbarang}' AND nomor_faktur = '{$nomorfaktur}'")->result_array();
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
    $html = $this->load->view('gudang/nota/retur_masukbarang', $data, true);
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
    $tanggal = $this->input->post('tanggal');
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

  public function detail_retur() {
  	$id = $this->input->get('id');
  	$this->data['subview'] = 'gudang/retur_barang/detail_retur';
    $this->db->select('tbl_headerretur.*,DATE_FORMAT(tbl_headerretur.tanggal_retur,"%d %M %Y") AS "tanggal_retur",SUM(tbl_retur.harga*tbl_retur.qty) AS "jumlah"');
    $this->db->from('tbl_headerretur');
    $this->db->join('tbl_retur','tbl_headerretur.nomor_retur = tbl_retur.nomor_retur','INNER');
    $this->db->where(array('tbl_retur.nomor_retur'=>$id));
  	$this->data['header'] = $this->db->get()->row();
    $this->data['items'] = $this->db->query("SELECT tbl_retur.*,tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli FROM tbl_retur INNER JOIN tbl_stok ON id_barang = tbl_stok.id WHERE nomor_retur= '{$id}'")->result();
  	$this->load->view('_layoutMain',$this->data);
  }

  public function tombol_hapus() {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-danger\" onclick=\"hapusData()\"><i class=\"fa fa-trash fa-fw\"></i></a>";
  }

  public function tombol_edit() {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-success\" onclick=\"modalEdit()\"><i class=\"fa fa-pencil fa-fw\"></i></a>";
  }

  public function tombol_detail($string) {
    return (string)  "<a href=".base_url('gudang/Retur_Barang/detail_retur?id=').$string['nomor']."><i class=\"fa fa-search fa-fw\"></i></a>";
  }

  public function tombol_penggantian($string) {
    return (string) $string['status'] == false ? "<a href=\"javascript:void(0)\" onclick=\"penggantian('{$string['nomor_retur']}')\">Belum Diganti</a>":"<i class=\"fa fa-check fa-fw\"></i>";
  }

  public function tombol_update($string) {
      return (string) $string['status'] == 0 ? "<a href=".base_url('gudang/Retur_Barang/update_detail_retur?id=').$string['nomor']."><i class=\"fa fa-edit fa-fw\"></i></a>":"<span><i class=\"fa fa-lock fa-fw\"></i></span>";
  }

  public function tombol_cetak($string) {
      return (string) "<a href=".base_url('gudang/Retur_Barang/cetakBerita?id=').$string['nomor']." target=\"_blank\"><i class=\"fa fa-print fa-fw\"></i> (PDF)</a>";
  }

}
