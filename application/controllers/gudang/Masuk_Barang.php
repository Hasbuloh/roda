<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk_Barang extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('gudang');
    $div = $this->session->userdata('div');
    $this->gudang->auth($div);
    //Codeigniter : Write Less Do More
    $this->load->model('Barangmasuk_M','Masuk');
  }

  function index() {
    $this->data['items'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk',DATE_FORMAT(tanggal_jt,'%d %M %Y') AS 'tanggal_jt'   FROM tbl_headerinvoice ORDER BY tanggal_masuk DESC")->result();
    $this->data['nav'] = 'gudang/page_navigation';
    $this->data['subview'] = 'gudang/masuk_barang/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_masuk() {
      $data = array();
      $no = 1;
      $items = $this->Masuk->table_masuk()->result();
      foreach ($items as $item) {
          $row = array();
          $row[] = $this->tombol_edit(array('id'=>$item->id,'no_urut'=>$item->nomor_invoice,'no_faktur'=>$item->nomor_faktur,'tanggal_masuk'=>$item->tanggal_masuk_nonformated,'tanggal_faktur'=>$item->tanggal_faktur_nonformated,'tanggal_jt'=>$item->tanggal_jt_nonformated,'supplier'=>$item->supplier));
          $row[] = $this->tombol_hapus(array('id'=>$item->id,'item'=>$item->item));
          $row[] = $no;
          $row[] = $item->nomor_faktur;
          $row[] = $item->tanggal_masuk;
          $row[] = toRP($item->jumlah);
          $row[] = $item->tanggal_faktur;
          $row[] = $item->tanggal_jt;
          $row[] = $this->cari_supplier(array('supplier'=>$item->supplier));
          $row[] = $this->tombol_bayar(array('status_bayar'=>$item->status_bayar,'nomor_invoice'=>$item->nomor_invoice,'jumlah'=>$item->jumlah));
          $row[] = $this->tombol_detail(array('nomor_invoice'=>$item->nomor_invoice));
          $row[] = $this->tombol_update(array('status'=>$item->status,'nomor_invoice'=>$item->nomor_invoice));
          $no++;
          $data[] = $row;
      }

      echo json_encode(array('data'=>$data));
  }

  function tambah_header() {
    $this->Masuk->_tableName = 'tbl_headerinvoice';
    $id = $this->input->post('id');
    $data = array(
        'nomor_invoice' => $this->input->post('nomor_invoice'),
        'nomor_faktur' => $this->input->post('nomor_faktur'),
        'tanggal_masuk' => $this->input->post('tanggal_masuk'),
        'tanggal_faktur' => $this->input->post('tanggal_faktur'),
        'tanggal_jt' => $this->input->post('tanggal_jt'),
        'supplier' => $this->input->post('supplier'),
    );
    $this->Masuk->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function table_detail() {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual AS 'het' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE nomor_invoice = '{$id}'")->result();
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_faktur,'%d %M %Y') AS 'tanggal_faktur',
      DATE_FORMAT(tanggal_jt,'%d %M %Y') AS 'tanggal_jt', DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
    $this->load->view('gudang/masuk_barang/table_detail',$this->data);
  }

  function edit_detail() {
    $this->Masuk->_tableName = 'tbl_pembelian';
    $status = (boolean) false;
    $id = $this->input->post('id');
    $cek = $this->db->query("SELECT * FROM tbl_pembelian WHERE nomor_invoice = '{$this->input->post('nomor_invoice')}' AND id_barang = '{$this->input->post('id_barang')}'")->num_rows();

    if ($cek < 1) {
        $data = $this->Masuk->array_form_post(array('nomor_invoice','tanggal_masuk','tanggal_faktur','tanggal_jt','nomor_faktur','id_barang','harga_jual','harga_beli','disc1','disc2','qty','jumlah'));
        $this->Masuk->save($data,$id);
        $status = (boolean) true;
    }

    echo json_encode(array('status'=>$status));
  }

  function hapus() {
    $id = $this->input->post('id');
    $this->Masuk->_tableName = 'tbl_pembelian';
    $this->Masuk->delete($id);
    echo json_encode(array('status'=>TRUE));
  }

  function update_detail_masuk() {
    $id = $this->input->get('id');
    $this->_setNav('gudang');
    $this->data['header'] = $this->db->query("SELECT * FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
    $this->_setNav('gudang');
    // print_r($this->data);
    $this->data['subview'] = 'gudang/masuk_barang/index_detail';
    $this->load->view('_layoutMain', $this->data);
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
    $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_headerinvoice")->row();
    $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
    if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
      $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor_invoice) AS 'nopo' FROM tbl_headerinvoice WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
      $tmp = (int) substr($data->nopo,0,3);
      $tmp++;
      $nopo = sprintf('%03s',$tmp);
      $nopo .= '/INV/'.$kode.'/'.toRome($data->bulan).'/10108/'.$data->tahun;
    }else{
      $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
      $nopo = '001/INV/'.$kode.'/'.toRome($date->bulan).'/10108/'.$date->tahun;
    }
    echo json_encode(array('noinv'=>$nopo));
  }

  function bayar_faktur() {
    $this->Masuk->_tableName = 'tbl_pembayaran';
    $id = $this->input->post('id');
    $data = $this->Masuk->array_form_post(array('nomor_invoice','tanggal_pembayaran','jumlah'));
    $query = $this->db->query("UPDATE tbl_headerinvoice SET status_bayar=1 WHERE nomor_invoice = '{$this->input->post('nomor_invoice')}'");
    $this->Masuk->save($data,$id);
    echo json_encode(array('status'=>TRUE));
  }

  function update_status() {
      $status = (bool) false;
      $id = $this->input->post('id');
      $query = $this->db->query("UPDATE tbl_headerinvoice SET status = TRUE WHERE nomor_invoice = '{$id}'");
      if ($query) {
          $status = (bool) true;
      }

      echo json_encode(array('status'=>$status));
  }

  function cek_tanggal() {
    $tanggal = $this->input->post('tgl');
    $tanggal = $this->db->query("SELECT '{$tanggal}' + INTERVAL 1 WEEK AS 'tanggal_jt'")->row();
    echo json_encode(array('tanggal_jt'=>$tanggal->tanggal_jt));
  }

  function detail_masuk() {
    $id = $this->input->get('id');
    $this->_setNav('gudang');
    $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_faktur,'%d-%M-%Y') AS 'tanggal_faktur',DATE_FORMAT(tanggal_jt,'%d-%M-%Y') AS 'tanggal_jt' FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
    $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE nomor_invoice = '{$id}'")->result();
    $this->data['subview'] = 'gudang/masuk_barang/index_detail_masuk';
    $this->load->view('_layoutMain',$this->data);
  }

  function update_jatuhtempo() {
    $id = $this->input->post('id');
    $tanggal = $this->input->post('tanggal');
    $update = $this->db->query("UPDATE tbl_headerinvoice SET tanggal_jt = '{$tanggal}' WHERE nomor_invoice = '{$id}'");
    $update_detail = $this->db->query("UPDATE tbl_pembelian SET tanggal_jt = '{$tanggal}' WHERE nomor_invoice = '{$id}'");
    $data = $this->db->query("SELECT DATE_FORMAT(tanggal_jt,'%d %M %Y') AS 'tanggal_jt' FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
    echo json_encode(array('status'=>$update,'tanggal'=>$data->tanggal_jt));
  }

  public function cek_nomorfaktur() {
    $status = (bool) false;
    $id = $this->input->post('nomor_faktur');
    $cek = $this->db->query("SELECT * FROM tbl_headerinvoice WHERE nomor_faktur = '{$id}'");
    if ($cek->num_rows() > 0) {
      $status = (bool) true;
    }

    echo json_encode(array('status'=>$status));
  }

  public function hapus_header() {
    $id = $this->input->post('id');
    $status = (boolean) false;
    $hapus = $this->db->delete('tbl_headerinvoice',array('id'=>$id));
    if ($hapus) {
        $status = (boolean) true;
    }

    echo json_encode(array('status'=>$status));
  }


  public function edit_header() {
    $status = (boolean) false;
    $id = $this->input->post('id');
    $data = array(
        // nomor_invoice
        'nomor_faktur'=>$this->input->post('nomor_faktur'),
        'tanggal_masuk'=>$this->input->post('tanggal_masuk'),
        'tanggal_faktur'=>$this->input->post('tanggal_faktur'),
        'tanggal_jt'=>$this->input->post('tanggal_jt'),
    );
    $this->db->where('id',$id);
    $update = $this->db->update('tbl_headerinvoice',$data);
    if ($update) {
        $this->db->query("UPDATE tbl_pembelian SET nomor_faktur='{$data['nomor_faktur']}',tanggal_masuk='{$data['tanggal_masuk']}',tanggal_faktur='{$data['tanggal_faktur']}',tanggal_jt='{$data['tanggal_jt']}' WHERE nomor_invoice = '{$this->input->post('nomor_invoice')}'");
        $status = (boolean) true;
    }

    echo json_encode(array('status'=>$status));
  }

  public function cari_supplier($string) {
    return (string) $string['supplier'] == 1?'Daya Adi Cipta':'Non-Daya';
  }

  public function tombol_bayar($string) {
    return (string) $string['status_bayar'] == 1 ? "<i class=\"fa fa-check fa-fw text-primary\"></i>":"<a href=\"javascript:void(0)\" onclick=\"modalBayar('{$string['nomor_invoice']}',{$string['jumlah']})\">Belum Dibayar</button>";
  }

  public function tombol_hapus($string) {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-danger\" onclick=\"hapusData({$string['id']},'{$string['item']}')\"><i class=\"fa fa-trash fa-fw\"></i></a>";
  }

  public function tombol_edit($string) {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-success\" onclick=\"modalEdit({$string['id']},'{$string['no_urut']}','{$string['no_faktur']}','{$string['tanggal_masuk']}','{$string['tanggal_faktur']}','{$string['tanggal_jt']}',{$string['supplier']})\"><i class=\"fa fa-pencil fa-fw\"></i></a>";
//    print_r($string);
  }

  public function tombol_detail($string) {
    return (string)  "<a href=".base_url('gudang/Masuk_Barang/detail_masuk?id=').$string['nomor_invoice']."><i class=\"fa fa-search fa-fw\"></i></a>";
  }

  public function tombol_update($string) {
      return (string) $string['status'] == 0 ? "<a href=".base_url('gudang/Masuk_Barang/update_detail_masuk?id=').$string['nomor_invoice']."><i class=\"fa fa-edit fa-fw\"></i></a>":"<span><i class=\"fa fa-lock fa-fw\"></i></span>";
  }

}
