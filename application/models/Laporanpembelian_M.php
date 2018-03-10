<?php
class Laporanpembelian_M extends ZEN_Model {
    public $_tableName = '';
    public $_orderBy = '';

    public function __construct() {
        parent::__construct();
    }
    
    public function table_index($where = NULL) {
        $this->db->select("tbl_headerinvoice.*,SUM(tbl_pembelian.jumlah) AS 'jumlah',DATE_FORMAT(tbl_headerinvoice.tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk',DATE_FORMAT(tbl_headerinvoice.tanggal_faktur,'%d %M %Y') AS 'tanggal_faktur',DATE_FORMAT(tbl_headerinvoice.tanggal_jt,'%d %M %Y') AS 'tanggal_jt'");
        $this->db->from('tbl_headerinvoice');
        $this->db->join('tbl_pembelian','tbl_headerinvoice.nomor_invoice = tbl_pembelian.nomor_invoice');
		
		if (count($where) > 0) {
			$this->db->where($where);
		}

        $this->db->group_by('tbl_headerinvoice.nomor_invoice'); 
        return $this->db->get();
    }

    public function detail_pembelian($id) {

    }

}

