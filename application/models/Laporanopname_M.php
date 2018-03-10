<?php
class Laporanopname_M extends ZEN_Model {
  public $_tableName = '';
  public $_orderBy = 'id';
  function __construct() {
    parent::__construct();
  }

//   function table_index($where=NULL,$grup=NULL) {
//     $this->db->select('tbl_opname.*,DATE_FORMAT(tanggal,"%d %M %Y") AS "tanggal",tbl_stok.nama_part,tbl_stok.disc1,tbl_stok.disc2,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_stok.no_rak');
//     $this->db->from('tbl_stok');
//     $this->db->join('tbl_opname','tbl_opname.id_barang = tbl_stok.id','inner');
//     if($where != NULL) {
//         $this->db->where($where);
//     }

//     if ($grup == TRUE) {
//         $this->db->where('tbl_opname.qty_fisik <> tbl_opname.qty_teori');
//         $this->db->where('tbl_opname.qty_teori <> tbl_opname.qty_fisik');
//     }

//     $this->db->order_by('tbl_opname.nomor_part','ASC');
//     return $this->db->get();
//   }


  function table_index($where) {
    $string = "SELECT 
                    id,nomor_part,qty,nomor_part,nama_part,
                    IFNULL(fisik,0) AS fisik,
                    IFNULL(teori,0) AS teori,
                    IFNULL(m.masuk,0) AS masuk,
                    IFNULL(k.keluar,0) AS keluar,
                    IFNULL(rm.retur_masuk,0) AS retur_masuk,
                    IFNULL(rk.retur_keluar,0) AS retur_keluar,
                    o.tanggal,
                    o.no_rak
                FROM tbl_stok
                    LEFT JOIN(
                        SELECT 
                            id_barang,qty_fisik AS fisik,qty_teori AS teori,tanggal AS tanggal,nomor_rak AS no_rak
                        FROM tbl_opname WHERE nomor = '{$where['nomor']}') 
                    AS o ON o.id_barang = tbl_stok.id 
                    LEFT JOIN(
                        SELECT 
                            id_barang,SUM(qty) AS keluar
                        FROM tbl_keluar WHERE tanggal_keluar >= '{$where['tanggal']}' GROUP BY id_barang ) AS k ON k.id_barang = tbl_stok.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS masuk
                        FROM tbl_pembelian WHERE tanggal_masuk >= '{$where['tanggal']}' GROUP BY id_barang ) AS m ON m.id_barang = tbl_stok.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS retur_masuk
                        FROM tbl_retur WHERE tanggal >= '{$where['tanggal']}' GROUP BY id_barang ) AS rm ON rm.id_barang = tbl_stok.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS retur_keluar
                        FROM tbl_returkeluar WHERE tanggal >= '{$where['tanggal']}' GROUP BY id_barang ) AS rk ON rk.id_barang = tbl_stok.id ORDER BY nomor_part ASC";
      return $this->db->query($string);
  }

}