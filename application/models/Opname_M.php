<?php
class Opname_M extends ZEN_Model {

	public $_tableName = '';
	public $_orderBy = '';
	
	function __construct() {
		parent::__construct();
	}
	
	function table_index() {
		$this->db->select('nomor,DATE_FORMAT(tanggal,"%d %M %Y") AS "tanggal",status')
				 ->from('tbl_headeropname')
				 ->order_by('nomor','DESC');
		return $this->db->get();			 
	}
	
	function table_detail($id) {
		$this->db->select('tbl_opname.*,tbl_stok.nama_part')
				 ->from('tbl_opname')
				 ->join('tbl_stok','tbl_stok.id = tbl_opname.id_barang','inner')
				 ->where(array('nomor'=>$id))
				 ->order_by('id','DESC');
		return $this->db->get();
		
	}

	function  insert_header($data) {
		$insert = $this->db->insert('tbl_headeropname',$data);
		if ($insert) {
			return (TRUE);
		}else{
			return (FALSE);
		}
	}
	
	function insert_detail($data) {
		$insert = $this->db->insert('tbl_opname',$data);
		if ($insert) {
			return (TRUE);
		}else{
			return (FALSE);
		}
	}

	function update_detail($data) {
		$update = $this->db->query("UPDATE tbl_opname SET qty_fisik = qty_fisik + '{$data['qty']}'");
	}

}
