<?php
class Laporananalisis_M extends ZEN_Model {
    public $_tableName = '';
    public $_orderBy = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function detail_keluar($id=NULL,$tanggal=NULL) {
        $this->db->select('*,DATE_FORMAT(tanggal_keluar,"%d %M %Y") AS "tanggal_keluar",tbl_headerkeluar.nomor_sa');
        $this->db->from('tbl_keluar');
        $this->db->join('tbl_headerkeluar','tbl_keluar.nomor_keluar = tbl_headerkeluar.nomor_keluar');
        $this->db->where(array('id_barang'=>$id,'DATE_FORMAT(tanggal_keluar,\'%d-%m-%Y\')'=>$tanggal));
        return $this->db->get();
    }

    public function detail_masuk($id=NULL,$tanggal=NULL) {
        $this->db->select('*,DATE_FORMAT(tanggal_masuk,"%d %M %Y") AS "tanggal_masuk"');
        $this->db->from('tbl_pembelian');
        $this->db->where(array('id_barang'=>$id,'DATE_FORMAT(tanggal_masuk,\'%d-%m-%Y\')'=>$tanggal));
        return $this->db->get();
    }

    public function masuk_barang($where=NULL,$like=NULL,$urut=NULL) {
        $this->db->select("tbl_pembelian.*,SUM(tbl_pembelian.qty) AS 'jumlah_masuk',tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual  AS 'het',tbl_stok.disc1,tbl_stok.disc2,DATE_FORMAT(tanggal_masuk,'%d %M %Y') AS 'tanggal_masuk',DATE_FORMAT(tanggal_masuk,'%d-%m-%Y') AS 'tanggal_masuk_unformated'");
        $this->db->from('tbl_pembelian');
        $this->db->join('tbl_stok','tbl_stok.id = tbl_pembelian.id_barang','inner');
        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
        if ($urut != NULL) {
            if ($urut == 1) {
                $this->db->order_by('SUM(tbl_pembelian.qty)','DESC');
            }else{
                $this->db->order_by('SUM(tbl_pembelian.harga_jual*tbl_pembelian.qty)','DESC');
            }
        }
        $this->db->group_by('tbl_pembelian.id_barang,DATE_FORMAT(tbl_pembelian.tanggal_masuk,"%d-%m-%Y")');
        $query = $this->db->get();
        return $query;
    }

    public function keluar_barang($where=NULL,$like=NULL,$urut=NULL) {
        $this->db->select("tbl_keluar.*,SUM(tbl_keluar.qty) AS 'jumlah_keluar',DATE_FORMAT(tanggal_keluar,'%d %M %Y') AS 'tanggal_keluar',DATE_FORMAT(tanggal_keluar,'%d-%m-%Y') AS 'tanggal_keluar_unformated',tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_beli,tbl_stok.harga_jual,tbl_stok.jenis_part,tbl_stok.disc1,tbl_stok.disc2,tbl_stok.no_rak");
        $this->db->from('tbl_keluar');
        $this->db->join('tbl_stok','tbl_stok.id = tbl_keluar.id_barang','inner');
        if ($where != NULL) {
            $this->db->where($where);
        }
        if ($like != NULL) {
            $this->db->like($like);
        }
        if ($urut != NULL) {
            if ($urut == 1) {
                $this->db->order_by('SUM(tbl_keluar.qty)','DESC');
            }else{
                $this->db->order_by('SUM(tbl_keluar.qty*tbl_stok.harga_jual)','DESC');
            }
        }
        $this->db->order_by('tbl_stok.no_rak','ASC');
        $this->db->group_by('tbl_keluar.id_barang,DATE_FORMAT(tbl_keluar.tanggal_keluar,"%d-%m-%Y")');
        $query = $this->db->get();
        return $query;
    }

    public function stok_barang($where=NULL,$like=NULL,$urut=NULL) {
       $this->db->select('*,SUM(harga_jual*qty) AS "jumlah"');
       $this->db->from('tbl_stok');
       if ($where != NULL) {
           $this->db->where($where);
       }

       if ($like != NULL) {
           $this->db->like($like);
       }

       if ($urut != NULL) {
            if ($urut == 1) {
                $this->db->order_by('tbl_stok.qty','DESC');
            }else if($urut == 2){
                $this->db->order_by('jumlah','DESC');
            }
       }

       $this->db->order_by('no_rak','ASC');
       $this->db->group_by('nomor_part');
       return $this->db->get();
    }



}
