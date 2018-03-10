<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Pemesanan_M','Pemesanan');
    $this->load->library('gudang');
    $div = $this->session->userdata('div');
    $this->gudang->auth($div);
  }

  function index()
  {
    $this->_setNav('gudang');
    $this->Pemesanan->_tableName = 'tbl_headerpemesanan';
    $this->data['pemesanan'] = $this->Pemesanan->get();
    $this->Pemesanan->_tableName = 'tbl_supplier';
    $this->data['supplier'] = $this->Pemesanan->get();
    $this->data['subview'] = 'gudang/pemesanan/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_pesan() {
      $data = array();
      $no = 1;
      $items = $this->Pemesanan->table_index()->result();
      foreach ($items as $item):
          $row = array();
          $row[] = $this->tombol_edit();
          $row[] = $this->tombol_hapus(array('id'=>$item->id,'item'=>$item->item));
          $row[] = $no;
          $row[] = $item->nopo;
          $row[] = $item->tanggal;
          $row[] = $item->item;
          $row[] = toRP($item->jumlah);
          $row[] = $this->cari_supplier(array('supplier'=>$item->supplier));
          $row[] = $this->tombol_cetak(array('nomor_po'=>$item->nopo));
          $row[] = $this->tombol_detail(array('nomor_po'=>$item->nopo));
          $row[] = $this->tombol_update(array('status'=>$item->status,'nopo'=>$item->nopo));
          $no++;
          $data[] = $row;
      endforeach;

      echo json_encode(array('data'=>$data));
  }

  function update_detail_pesan() {
    $this->_setNaV('gudang');
    $id = $this->input->get('id');
    $this->data['detail'] = $this->db->get_where('tbl_headerpemesanan',array('nopo'=>$id))->row();
    $this->data['subview'] = 'gudang/pemesanan/index_detail';
    $this->load->view('_layoutMain', $this->data);
  }

  function table_detail() {
    $nopo = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_pemesanan.id,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.disc1,tbl_stok.disc2,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_pemesanan.qty FROM tbl_stok,tbl_pemesanan WHERE
      tbl_pemesanan.nomor_po='{$nopo}' AND tbl_stok.id = tbl_pemesanan.id_barang
      ")->result();
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS tanggal FROM tbl_headerpemesanan")->row();
    $this->load->view('gudang/pemesanan/table_detail',$this->data);
  }


  function tambah_header() {
    $id = $this->input->post('id_supplier');
    $this->Pemesanan->_tableName = 'tbl_headerpemesanan';
    $data = $this->Pemesanan->array_form_post(array('nopo','supplier'));
    $this->Pemesanan->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function edit_detail() {
      $status = (bool) false;
      $cek = $this->db->query("SELECT * FROM tbl_pemesanan WHERE nomor_po = '{$this->input->post('nomor_po')}' AND id_barang = '{$this->input->post('id_barang')}'")->num_rows();
      if ($cek < 1) {
          $status = (bool) true;
          $id = $this->input->post('id');
          $this->Pemesanan->_tableName = 'tbl_pemesanan';
          $data = $this->Pemesanan->array_form_post(array('nomor_po','id_barang','qty','harga','id_header'));
          $this->Pemesanan->save($data,$id);
      }

      echo json_encode(array('status'=>$status));
  }

  function hapus() {
    $this->Pemesanan->_tableName = 'tbl_pemesanan';
    $id = $this->input->post('id');
    $nopo = $this->input->post('nomor_po');
    $this->Pemesanan->delete($nopo,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function hapus_header() {
      $id = $this->input->post('id');
      $status = (bool) false;
      $hapus = $this->db->delete('tbl_headerpemesanan',array('id'=>$id));
      if ($hapus) {
          $status = (bool) true;
      }

      echo json_encode(array('status'=>$status));
  }

  function cetak_nota()
  {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_pemesanan.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_stok.disc1,tbl_stok.disc2 FROM tbl_pemesanan INNER JOIN tbl_stok ON tbl_stok.id = tbl_pemesanan.id_barang WHERE nomor_po = '{$id}'")->result();
	$this->data['title'] = 'Nota Pemesanan - '.$id;
	$this->load->view('gudang/nota/pemesanan',$this->data);
  }

  public function generate_nourut() {
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
    $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_headerpemesanan")->row();
    $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
    if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
      $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nopo) AS 'nopo' FROM tbl_headerpemesanan WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
      $tmp = (int) substr($data->nopo,0,3);
      $tmp++;
      $nopo = sprintf('%03s',$tmp);
      $nopo .= '/PO/'.$kode.'/'.toRome($data->bulan).'/10108/'.$data->tahun;
    }else{
      $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
      $nopo = '001/PO/'.$kode.'/'.toRome($date->bulan).'/10108/'.$date->tahun;
    }
    echo json_encode(array('nopo'=>$nopo));
  }

  function detail_pemesanan() {
    $id = $this->input->get('id');
    $this->_setNav('gudang');
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal_pesan' FROM tbl_headerpemesanan WHERE nopo = '{$id}'")->row();
    $this->data['items'] = $this->db->query("SELECT tbl_pemesanan.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_stok.disc1,tbl_stok.disc2 FROM tbl_pemesanan INNER JOIN tbl_stok ON tbl_stok.id = tbl_pemesanan.id_barang WHERE nomor_po = '{$id}'")->result();
    $this->data['subview'] = 'gudang/pemesanan/index_detail_pemesanan';
    $this->load->view('_layoutMain',$this->data);
  }

  function cari_supplier($string) {
      return (string) $string['supplier'] == 1 ? "Daya Adi Cipta": "Non-Daya";
  }

  function tombol_cetak($string) {
      return (string) "<a href=".base_url('gudang/Pemesanan/cetak_nota?id=').$string['nomor_po']."><i class=\"fa fa-print fa-fw\"></i></a>";
  }

  function tombol_edit() {
    return (string) "<a href=\"#\" class=\"text text-success\"><i class=\"fa fa-pencil fa-fw\"></i></a>";
  }

  function tombol_hapus($string) {
    return (string) "<a href=\"javascript:void(0)\" onclick=\"hapusData({$string['id']},{$string['item']})\" class=\"text text-danger\"><i class=\"fa fa-trash fa-fw\"></i></a>";
  }

  function tombol_detail($string) {
    return (string) "<a href=".base_url('gudang/Pemesanan/detail_pemesanan?id=').$string['nomor_po']." target=\"_blank\" class=\"text text-primary\"><i class=\"fa fa-search fa-fw\"></i></a>";
  }

  function tombol_update($string){
      return (string) $string['status'] == 0 ? "<a href=\"".base_url('gudang/Pemesanan/update_detail_pesan?id=').$string['nopo']."\"><i class=\"fa fa-edit fa-fw\"></i></a>":"<i class=\"fa fa-lock fa-fw\"></i>";
  }
}
