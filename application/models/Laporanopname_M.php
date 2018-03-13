<?php
class Laporanopname_M extends ZEN_Model {
  public $_tableName = '';
  public $_orderBy = 'id';
  function __construct() {
    parent::__construct();
  }

  function table_index($where) {
    $string = "SELECT 
                    s.id,s.nomor_part,s.qty,s.nomor_part,s.nama_part,
                    IFNULL(fisik,0) AS fisik,
                    IFNULL(teori,0) AS teori,
                    IFNULL(m.masuk,0) AS masuk,
                    IFNULL(k.keluar,0) AS keluar,
                    IFNULL(rm.retur_masuk,0) AS retur_masuk,
                    IFNULL(rk.retur_keluar,0) AS retur_keluar,
                    o.tanggal,
                    IFNULL(o.no_rak,s.no_rak) AS no_rak
                FROM tbl_stok AS s
                    LEFT JOIN(
                        SELECT 
                            id_barang,qty_fisik AS fisik,qty_teori AS teori,tanggal AS tanggal,nomor_rak AS no_rak
                        FROM tbl_opname WHERE nomor = '{$where['nomor']}') 
                    AS o ON o.id_barang = s.id 
                    LEFT JOIN(
                        SELECT 
                            id_barang,SUM(qty) AS keluar
                        FROM tbl_keluar WHERE tanggal_keluar >= '{$where['tanggal']}' GROUP BY id_barang ) AS k ON k.id_barang = s.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS masuk
                        FROM tbl_pembelian WHERE tanggal_masuk >= '{$where['tanggal']}' GROUP BY id_barang ) AS m ON m.id_barang = s.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS retur_masuk
                        FROM tbl_retur WHERE tanggal >= '{$where['tanggal']}' GROUP BY id_barang ) AS rm ON rm.id_barang = s.id
                    LEFT JOIN(
                        SELECT
                            id_barang,SUM(qty) AS retur_keluar
                        FROM tbl_returkeluar WHERE tanggal >= '{$where['tanggal']}' GROUP BY id_barang ) AS rk ON rk.id_barang = s.id ORDER BY s.no_rak ASC";
      return $this->db->query($string);
  }

}
