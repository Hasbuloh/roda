<?php
class Laporan_Stok extends  ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('gudang');
        $div = $this->session->userdata('div');
        $this->gudang->auth($div);
    }

    public function index()
    {
        $this->_setNav('gudang');
        $this->data['subview'] = 'gudang/laporan_stok/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function table_stok() {
            $awal = $this->input->post('awal');
            $akhir = $this->input->post('akhir');
            $kategori = $this->input->post('klasifikasi');
            $string = "SELECT
                            tbl_stok.id,
                            tbl_stok.nomor_part,
                            tbl_stok.nama_part,
                            tbl_stok.jenis_part,
                            tbl_stok.qty,
                            tbl_stok.harga_jual,
                            (tbl_stok.qty - ((IFNULL(m.QTY_IN,0))-IFNULL(k.QTY_OUT,0))) AS 'STOK_AWAL',
                            (tbl_stok.qty - ((IFNULL(m.QTY_IN,0))-IFNULL(k.QTY_OUT,0))+IFNULL(m.QTY_IN,0)-IFNULL(rm.QTY_RIN,0)-IFNULL(k.QTY_OUT,0)+IFNULL(rk.QTY_ROUT,0)) AS 'STOK_AKHIR',
                            (IFNULL(m.QTY_IN,0)+IFNULL(rm.QTY_RIN,0)) AS QTY_IN,
                            (IFNULL(k.QTY_OUT,0)+IFNULL(rk.QTY_ROUT,0)) AS QTY_OUT,
                            IFNULL(rm.QTY_RIN,0) AS QTY_RM,
                            IFNULL(rk.QTY_ROUT,0) AS QTY_RK,
                            (tbl_stok.qty * harga_jual) AS TOTAL
                        FROM tbl_stok
                            LEFT JOIN (
                                SELECT
                                    tbl_pembelian.id_barang,
                                    tbl_pembelian.tanggal_masuk,
                                    SUM(tbl_pembelian.qty) AS QTY_IN
                                FROM tbl_headerinvoice
                                LEFT JOIN tbl_pembelian
                                ON tbl_headerinvoice.nomor_faktur = tbl_pembelian.nomor_faktur
                                WHERE tbl_headerinvoice.tanggal_masuk BETWEEN ";
            if ($awal && $akhir != null) {
                $string .= "'{$awal}' - INTERVAL 1 DAY AND '{$akhir}'
                            GROUP BY tbl_pembelian.id_barang ASC)
                            AS m ON m.id_barang = tbl_stok.id
                            LEFT JOIN(
                                SELECT
                                    tbl_keluar.id_barang,
                                    tbl_headerkeluar.tanggal,
                                    SUM(tbl_keluar.qty) AS QTY_OUT
                                FROM tbl_headerkeluar
                                LEFT JOIN tbl_keluar
                                ON tbl_keluar.nomor_keluar = tbl_headerkeluar.nomor_keluar
                                WHERE tbl_headerkeluar.tanggal BETWEEN
                                '{$awal}' - INTERVAL 1 DAY AND '{$akhir}' GROUP BY tbl_keluar.id_barang ASC) AS k ON k.id_barang = tbl_stok.id
                                LEFT JOIN (
                                    SELECT
                                        tbl_retur.id_barang,
                                        SUM(tbl_retur.qty) AS QTY_RIN
                    FROM tbl_headerretur
                        LEFT JOIN tbl_retur ON tbl_headerretur.nomor_retur = tbl_retur.nomor_retur
                    WHERE tbl_headerretur.tanggal_retur BETWEEN '{$awal}' - INTERVAL 1 DAY AND '{$akhir}' GROUP BY tbl_retur.id_barang ASC) AS rm ON rm.id_barang = tbl_stok.id LEFT JOIN (
                    SELECT
                        tbl_returkeluar.id_barang,
                        SUM(tbl_returkeluar.qty) AS QTY_ROUT
                    FROM tbl_headerreturkeluar
                        LEFT JOIN tbl_returkeluar ON tbl_headerreturkeluar.nomor_retur = tbl_returkeluar.nomor_retur
                    WHERE tbl_headerreturkeluar.tanggal BETWEEN '{$awal}' - INTERVAL 1 DAY AND '{$akhir}'
                    GROUP BY tbl_returkeluar.id_barang ASC) AS rk ON rk.id_barang = tbl_stok.id";
            }
            if ($kategori != null) {
                $string .= " WHERE tbl_stok.jenis_part = '".$kategori."'";
            }

            $string .= ' ORDER BY tbl_stok.nomor_part ASC';
            $data = $this->db->query($string);
            $this->data['items'] = $data->result();
            $this->load->view('gudang/laporan_stok/table_index',$this->data);
    }

    public function table_stok_cetak() {
            $awal = $this->input->get('awal');
            $akhir = $this->input->get('akhir');
            $kategori = $this->input->get('klasifikasi');
            $string = "SELECT
                            tbl_stok.id,
                            tbl_stok.nomor_part,
                            tbl_stok.nama_part,
                            tbl_stok.jenis_part,
                            tbl_stok.qty,
                            tbl_stok.harga_jual,
                            (tbl_stok.qty - ((IFNULL(m.QTY_IN,0))-IFNULL(k.QTY_OUT,0))) AS 'STOK_AWAL',
                            (tbl_stok.qty - ((IFNULL(m.QTY_IN,0))-IFNULL(k.QTY_OUT,0))+IFNULL(m.QTY_IN,0)-IFNULL(rm.QTY_RIN,0)-IFNULL(k.QTY_OUT,0)+IFNULL(rk.QTY_ROUT,0)) AS 'STOK_AKHIR',
                            (IFNULL(m.QTY_IN,0)+IFNULL(rm.QTY_RIN,0)) AS QTY_IN,
                            (IFNULL(k.QTY_OUT,0)+IFNULL(rk.QTY_ROUT,0)) AS QTY_OUT,
                            IFNULL(rm.QTY_RIN,0) AS QTY_RM,
                            IFNULL(rk.QTY_ROUT,0) AS QTY_RK,
                            (tbl_stok.qty * harga_jual) AS TOTAL
                        FROM tbl_stok
                            LEFT JOIN (
                                SELECT
                                    tbl_pembelian.id_barang,
                                    tbl_pembelian.tanggal_masuk,
                                    SUM(tbl_pembelian.qty) AS QTY_IN
                                FROM tbl_headerinvoice
                                LEFT JOIN tbl_pembelian
                                ON tbl_headerinvoice.nomor_faktur = tbl_pembelian.nomor_faktur
                                WHERE tbl_headerinvoice.tanggal_masuk BETWEEN ";
            if ($awal && $akhir != null) {
                $string .= "'".$awal."' - INTERVAL 1 DAY AND '".$akhir."'";
                $string .= "GROUP BY tbl_pembelian.id_barang ASC)
                            AS m ON m.id_barang = tbl_stok.id
                            LEFT JOIN(
                                SELECT
                                    tbl_keluar.id_barang,
                                    tbl_headerkeluar.tanggal,
                                    SUM(tbl_keluar.qty) AS QTY_OUT
                                FROM tbl_headerkeluar
                                LEFT JOIN tbl_keluar
                                ON tbl_keluar.nomor_keluar = tbl_headerkeluar.nomor_keluar
                                WHERE tbl_headerkeluar.tanggal BETWEEN ";
                $string .= "'".$awal."' - INTERVAL 1 DAY AND '".$akhir."'";
                $string .= " GROUP BY tbl_keluar.id_barang ASC) AS k ON k.id_barang = tbl_stok.id ";
                $string .= "LEFT JOIN (
                    SELECT
                        tbl_retur.id_barang,
                        SUM(tbl_retur.qty) AS QTY_RIN
                    FROM tbl_headerretur
                        LEFT JOIN tbl_retur ON tbl_headerretur.nomor_retur = tbl_retur.nomor_retur
                    WHERE tbl_headerretur.tanggal_retur BETWEEN";
                $string .= "'".$awal."' - INTERVAL 1 DAY AND '".$akhir."'";
                $string .= "GROUP BY tbl_retur.id_barang ASC) AS rm ON rm.id_barang = tbl_stok.id ";
                $string .= "LEFT JOIN (
                    SELECT
                        tbl_returkeluar.id_barang,
                        SUM(tbl_returkeluar.qty) AS QTY_ROUT
                    FROM tbl_headerreturkeluar
                        LEFT JOIN tbl_returkeluar ON tbl_headerreturkeluar.nomor_retur = tbl_returkeluar.nomor_retur
                    WHERE tbl_headerreturkeluar.tanggal BETWEEN ";
                $string .= "'".$awal."' - INTERVAL 1 DAY AND '".$akhir."'";
                $string .= "GROUP BY tbl_returkeluar.id_barang ASC) AS rk ON rk.id_barang = tbl_stok.id ";

            }
            if ($kategori != null) {
                $string .= "WHERE tbl_stok.jenis_part = '".$kategori."'";
            }

            $string .= ' ORDER BY tbl_stok.nomor_part ASC';

            $data = $this->db->query($string);
            $this->data['items'] = $data->result();
            $this->data['title'] = 'Laporan Stok Periode - '.$awal.' s/d '.$akhir.' '.$kategori;
            $this->load->view('gudang/laporan_excel/laporan_stok',$this->data);
    }
}
