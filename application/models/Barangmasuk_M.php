<?php
class Barangmasuk_M extends ZEN_Model {
  public $_tableName = '';
  public $_orderBy = '';

  public function __construct() {
      parent::__construct();
  }


  public function table_masuk() {
    $query = $this->db->query("
        SELECT 
        *,
        DATE_FORMAT(tanggal_faktur,'%d %M %Y') AS 'tanggal_faktur',
        DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk',
        DATE_FORMAT(tanggal_jt,'%d %M %Y') AS 'tanggal_jt',
        DATE_FORMAT(tanggal_faktur,'%Y-%m-%d') AS 'tanggal_faktur_nonformated',
        DATE_FORMAT(tanggal_masuk,'%Y-%m-%d') AS 'tanggal_masuk_nonformated',
        DATE_FORMAT(tanggal_jt,'%Y-%m-%d') AS 'tanggal_jt_nonformated',
        IFNULL(m.jumlah,0) AS 'jumlah',
        IFNULL(m.item,0) AS 'item' 
        FROM tbl_headerinvoice 
          LEFT JOIN (SELECT nomor_invoice AS nomor,SUM(qty*harga_beli) AS jumlah,SUM(qty) AS item FROM tbl_pembelian GROUP BY nomor_invoice) AS m 
        ON m.nomor = tbl_headerinvoice.nomor_invoice 
        ORDER BY id DESC");
    return $query;
  }
}
