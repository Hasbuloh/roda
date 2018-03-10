<?php
class Laporan_Bulanan extends ZEN_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('gudang');
        $div = $this->session->userdata('div');
        $this->gudang->auth($div);
    }

    public function index() {
        $this->data['nav'] = 'gudang/page_navigation';
        $this->data['subview'] = 'gudang/laporan_bulanan/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function tableIndex() {
        $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id")->result();
        if ($this->input->post('kategori')) {
          if ($this->input->post('awal') && $this->input->post('akhir')) {
              $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tanggal_keluar > '{$this->input->post('awal')}' AND tanggal_keluar <= '{$this->input->post('akhir')}' AND tbl_stok.jenis_part = '{$this->input->post('kategori')}'")->result();
          }else{
            $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tbl_stok.jenis_part = '{$this->input->post('kategori')}'")->result();
          }
        }else{
          if ($this->input->post('awal') && $this->input->post('akhir')) {
              $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tanggal_keluar > '{$this->input->post('awal')}' AND tanggal_keluar <= '{$this->input->post('akhir')}'")->result();
          }else{
            $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id")->result();
          }
        }

        $this->load->view('gudang/laporan_bulanan/table_index',$this->data);
    }

    function tableIndex1() {
      $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang")->result();
      if ($this->input->post('kategori')) {
        if ($this->input->post('awal') && $this->input->post('akhir')) {
            $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tanggal_masuk > '{$this->input->post('awal')}' AND tanggal_masuk <= '{$this->input->post('akhir')}' AND tbl_stok.jenis_part = '{$this->input->post('kategori')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tbl_stok.jenis_part = '{$this->input->post('kategori')}'")->result();
        }
      }else{
        if ($this->input->post('awal') && $this->input->post('akhir')) {
            $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tanggal_masuk > '{$this->input->post('awal')}' AND tanggal_masuk <= '{$this->input->post('akhir')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang")->result();
        }
      }
      $this->load->view('gudang/laporan_bulanan/table_index_1',$this->data);
    }

    public function cetak_excel() {
      $this->data['items'] = $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id")->result();
      if ($this->input->get('kategori')) {
        if ($this->input->get('awal') && $this->input->get('akhir')) {
            $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tanggal_keluar > '{$this->input->get('awal')}' AND tanggal_keluar <= '{$this->input->get('akhir')}' AND tbl_stok.jenis_part = '{$this->input->get('kategori')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tbl_stok.nama_part = '{$this->input->get('kategori')}'")->result();
        }
      }else{
        if ($this->input->get('awal') && $this->input->get('akhir')) {
            $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id WHERE tanggal_keluar > '{$this->input->get('awal')}' AND tanggal_keluar <= '{$this->input->get('akhir')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("select tbl_keluar.*,DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part from tbl_keluar inner join tbl_stok on tbl_keluar.id_barang = tbl_stok.id")->result();
        }
      }
      $this->data['title'] = "Laporan Keluar Barang ".$this->input->get('awal')."s/d".$this->input->get('akhir');
      $this->load->view('gudang/laporan_excel/laporan_keluar_bulanan',$this->data);
    }

    public function cetak_excel_1() {
      $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang")->result();
      if ($this->input->get('kategori')) {
        if ($this->input->get('awal') && $this->input->get('akhir')) {
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tanggal_masuk > '{$this->input->get('awal')}' AND tanggal_masuk <= '{$this->input->get('akhir')}' AND  tbl_stok.jenis_part = '{$this->input->get('kategori')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tbl_stok.jenis_part = '{$this->input->get('kategori')}'")->result();
        }
      }else{
        if ($this->input->get('awal') && $this->input->get('akhir')) {
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang WHERE tanggal_masuk > '{$this->input->get('awal')}' AND tanggal_masuk <= '{$this->input->get('akhir')}'")->result();
        }else{
          $this->data['items'] = $this->db->query("SELECT tbl_pembelian.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_stok.jenis_part  AS 'het',DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk' FROM tbl_pembelian INNER JOIN tbl_stok ON tbl_stok.id = tbl_pembelian.id_barang")->result();
        }
      }
      $this->data['title'] = "Laporan Masuk Barang ".$this->input->get('awal')." sd ".$this->input->get('akhir');
      $this->load->view('gudang/laporan_excel/laporan_masuk_bulanan',$this->data);
    }
}
