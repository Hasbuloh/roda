<?php
class Laporanstok_M extends ZEN_Model {
	public function __construct()
	{
	    parent::__construct();
	}

	public function table_index($where=NULL) {
		//select tbl_stok.jenis_part,SUM(tbl_stok.harga_jual*tbl_stoktrace.stok_awal) AS 'stok_awal' from tbl_stokinner join tbl_stoktrace on tbl_stoktrace.id_barang = tbl_stok.id GROUP BY tbl_stok.jenis_part;
		$this->db->select('tbl_stok.jenis_part,SUM(tbl_stok.harga_jual*tbl_stoktrace.stok_akhir) AS "stok_akhir",DATE_FORMAT(tbl_stoktrace.tanggal,"%m-%Y") AS "tanggal"');
		$this->db->from('tbl_stok');
		$this->db->join('tbl_stoktrace','tbl_stoktrace.id_barang = tbl_stok.id','left');
		if ($where != NULL) {
			$this->db->where($where);
		}
		$this->db->group_by('tbl_stok.jenis_part');
		return $this->db->get();
	}

}
