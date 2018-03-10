<?php
class Laporanmutasi_M extends ZEN_Model {
	public function __construct()
	{
	    parent::__construct();
	}

	public function table_index($where = NULL,$like = NULL)
	{
		$this->db->select('tbl_stoktrace.*,DATE_FORMAT(tbl_stoktrace.tanggal,"%d %M %Y")AS "tanggal",tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_beli,tbl_stok.harga_jual');
		$this->db->from('tbl_stoktrace');
		$this->db->join('tbl_stok','tbl_stok.id=tbl_stoktrace.id_barang','inner');
		if ($where != NULL) {
            $this->db->where($where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
		// $this->db->where(array('tbl_stok.qty!='=>0));
		return $this->db->get();
	}
}
