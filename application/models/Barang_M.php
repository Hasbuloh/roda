<?php
class Barang_M extends ZEN_Model{
    public $_tableName = 'tbl_stok';
    public $_orderBy = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function table_index() {
        $this->db->select('*,(qty*harga_beli) AS "total_netto",(harga_jual*qty) AS "total_het"');
        $this->db->from('tbl_stok');
        $this->db->order_by('qty','DESC');
        $this->db->order_by('no_rak','ASC');
        return $this->db->get();
    }

}
