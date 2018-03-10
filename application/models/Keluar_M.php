<?php
class Keluar_M extends ZEN_Model{
    public $_tableName = '';
    public $_orderBy = '';

    public function __construct() {
        parent::__construct();
    }

    public function table_keluar() {
        return $this->db->query("
            SELECT *,IFNULL(k.qty,0) as 'item',
              IFNULL(k.jumlah,0) AS 'total',
              DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal_keluar'
              FROM tbl_headerkeluar 
                LEFT JOIN  (SELECT nomor_keluar AS nomor,SUM(qty) AS qty,SUM(qty*harga) AS jumlah FROM tbl_keluar GROUP BY nomor_keluar) AS k 
              ON k.nomor = tbl_headerkeluar.nomor_keluar ORDER BY id DESC
        ");

    }
}
