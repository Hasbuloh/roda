<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan_M extends ZEN_Model{

  public $_tableName = '';
  protected $_orderBy = '';

  public function __construct()
  {
    parent::__construct();
  }

  public function table_index() {
      return $this->db->query("SELECT
            id,
            nopo,
            DATE_FORMAT(tanggal, '%d %M %Y') AS tanggal,
            IFNULL(p.item,0) AS item,
            IFNULL(p.jumlah,0) AS jumlah,
            supplier,
            status
        FROM tbl_headerpemesanan
        LEFT JOIN (
                SELECT 
                    nomor_po,
                    SUM(qty*harga) AS jumlah,
                    SUM(qty) AS item
                FROM tbl_pemesanan GROUP BY nomor_po
                ) AS p 
        ON p.nomor_po = tbl_headerpemesanan.nopo 
        ORDER BY id DESC");
  }
  public function getItem($nopo=NULL,$idbarang=NULL) {
    return $this->db->get_where('tbl_pemesanan',array('nomor_po'=>$nopo,'id_barang'=>$idbarang));
  }

  public function updateQty($id,$qty,$newQty,$noPO) {
    $this->db->set('qty',$qty+$newQty);
    $this->db->where(array('id_barang'=>$id,'nomor_po'=>$noPO));
    $this->db->update('tbl_pemesanan');
  }

  public function ambilPemesanan() {
    return $this->db->query("SELECT * FROM tbl_stok,tbl_pemesanan WHERE tbl_stok.nomor_part = tbl_pemesanan.nomor_part");
  }

  public function hapusItem($nopo=NULL,$idbarang=NULL) {
    $this->db->where(array('nomor_po'=>$nopo,'id_barang'=>$idbarang));
    $this->db->limit();
    $this->db->delete('tbl_pemesanan');
  }

}
