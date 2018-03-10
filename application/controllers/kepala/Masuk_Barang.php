<?php
/**
 * Created by PhpStorm.
 * User: castor
 * Date: 04/12/17
 * Time: 22:34
 */
class Masuk_Barang extends ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->_setNav('kepala');
        $this->load->model('Barangmasuk_M','Masuk');
        $this->Masuk->_tableName = 'tbl_headerinvoice';
        $this->load->library('kepala');
        $div = $this->session->userdata('div');
        $this->kepala->auth($div);
    }

    public function index() {
        $this->data['subview'] = 'kepala/masuk_barang/index';
        $this->load->view('_layoutMain',$this->data);
    }
    
    public function table_masuk1() {
      $data = array();
      $no = 1;
      $items = $this->Masuk->table_masuk()->result();
      foreach ($items as $item) {
          $row = array();
          $row[] = $no;
          $row[] = $item->nomor_faktur;
          $row[] = $item->tanggal_masuk;
          $row[] = toRP($item->jumlah);
          $row[] = $item->tanggal_faktur;
          $row[] = $item->tanggal_jt;
          $row[] = $this->cari_supplier(array('supplier'=>$item->supplier));
          $row[] = $item->status == 1  ? 'Dibayar':'Belum Dibayar';
          $row[] = $this->tombol_detail(array('nomor_invoice'=>$item->nomor_invoice));
          $row[] = $this->tombol_unlock(array('status'=>$item->status,'nomor_invoice'=>$item->nomor_invoice));
          $no++;
          $data[] = $row;
      }

      echo json_encode(array('data'=>$data));
    }

    public function table_masuk() {
        $this->data['items'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_faktur,'%d %M %Y') AS 'tanggal_faktur',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk',DATE_FORMAT(tanggal_jt,'%d %M %Y') AS 'tanggal_jt' FROM tbl_headerinvoice INNER JOIN tbl_supplier ON tbl_headerinvoice.supplier = tbl_supplier.id ORDER BY tbl_headerinvoice.id DESC")->result();
        $this->load->view('kepala/masuk_barang/table_masuk',$this->data);
    }

    public function update_status() {
        $id = $this->input->post('id');
        $status = (bool) false;
        $query = $this->db->query("UPDATE tbl_headerinvoice SET status=FALSE WHERE nomor_invoice = '{$id}'");
        if ($query) {
            $status = (bool) true;
        }

        echo json_encode(array('status'=>$status));
    }

    public function detail_masuk() {
        $id = $this->input->get('id');
        $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal_faktur,'%d-%M-%Y') AS 'tanggal_faktur',DATE_FORMAT(tanggal_jt,'%d-%M-%Y') AS 'tanggal_jt' FROM tbl_headerinvoice WHERE nomor_invoice = '{$id}'")->row();
        $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE nomor_invoice = '{$id}'")->result();
        $this->data['subview'] = 'kepala/masuk_barang/detail_masuk';
        $this->load->view('_layoutMain',$this->data);
    }

    public function tombol_detail($string) {
        return (string) "<a href=".base_url('kepala/Masuk_Barang/detail_masuk?id=').$string['nomor_invoice']."><i class=\"fa fa-search fa-fw\"></i></a>";
    }

    public function tombol_unlock($string) {
        return (string) $string['status'] == 1 ? "<a href=\"javascript:void(0)\" onclick=\"updateStatus(
          '{$string['nomor_invoice']}')\"><i class=\"fa fa-lock fa-fw\"></i></a>":"<span><i class=\"fa fa-lock fa-fw\"></i></span>";
    }


    public function cari_supplier($string) {
      return (string) $string['supplier'] == 1?'Daya Adi Cipta':'Non-Daya';
    }

}
