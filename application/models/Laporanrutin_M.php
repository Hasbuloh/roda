<?php
class Laporanrutin_M extends ZEN_Model {
    public $_tableName = '';
    public $_orderBy = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function masuk_barang($where=NULL,$like=NULL,$urut=NULL) {
        $this->db->select("tbl_pembelian.*,SUM(tbl_pembelian.qty) AS 'jumlah_masuk',tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual  AS 'het',tbl_stok.disc1,tbl_stok.disc2,DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk'");
        $this->db->from('tbl_pembelian');
        $this->db->join('tbl_stok','tbl_stok.id = tbl_pembelian.id_barang','inner');
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->group_by('tbl_pembelian.id_barang,DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%d-%m-%Y")');
        $this->db->order_by('tbl_stok.nomor_part','ASC');
        $query = $this->db->get();
        return $query;
    }

    public function keluar_barang($where=NULL,$like=NULL,$urut=NULL) {
        $this->db->select("tbl_keluar.*,SUM(tbl_keluar.qty) AS 'jumlah_keluar',DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.jenis_part,tbl_keluar.harga AS 'harga_jual',tbl_stok.disc1,tbl_stok.disc2");
        $this->db->from('tbl_keluar');
        $this->db->join('tbl_stok','tbl_stok.id = tbl_keluar.id_barang','inner');
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->group_by('tbl_keluar.id_barang,DATE_FORMAT(tbl_keluar.tanggal_keluar,"%d-%m-%Y")');
        $this->db->order_by('tbl_stok.nomor_part','ASC');
        $query = $this->db->get();
        return $query;
    }

}
