<?php
/**
 * Created by PhpStorm.
 * User: castor
 * Date: 27/11/17
 * Time: 11:23
 */
class Keluar_Barang extends ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keluar_M','Keluar');
        $this->load->library('kepala');
        $div = $this->session->userdata('div');
        $this->kepala->auth($div);
    }

    public function index() {
        $this->_setNav('kepala');
        $this->data['subview'] = 'kepala/keluar_barang/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function table_keluar() {
        $data = array();
        $items = $this->Keluar->table_keluar()->result();
        $no=1;
        foreach ($items as $item) {
            $row = array();
            $row[] = $no;
            $row[] = $item->nomor_keluar;
            $row[] = $item->nomor_polisi;
            $row[] = $item->nomor_sa;
            $row[] = $item->tanggal_keluar;
            $row[] = $item->nama;
            $row[] = $item->item;
            $row[] = toRP($item->total);
            $row[] = $this->tombol_detail(array('nomor_keluar'=>$item->nomor_keluar));
            $row[] = $this->tombol_unlock(array('status'=>$item->status,'id'=>$item->id));
            $data[] = $row;
            $no++;
        }
        $output = array('data'=>$data);
        echo json_encode($output);
    }

    public function detail_keluar() {
        $this->_setNav('kepala');
        $id = $this->input->get('id');
        $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d-%M-%Y') AS 'tanggal' FROM tbl_headerkeluar WHERE nomor_keluar = '{$id}'")->row();
        $this->data['items'] = $this->db->query("SELECT tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_keluar.* FROM  tbl_keluar INNER JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE nomor_keluar = '{$id}'")->result();
        $this->data['subview'] = 'kepala/keluar_barang/index_detail';
        $this->load->view('_layoutMain',$this->data);
    }

    public function update_status() {
        $id = $this->input->post('id');
        $status = (bool) false;
        $query = $this->db->query("UPDATE tbl_headerkeluar SET status=FALSE WHERE id = '{$id}'");
        if ($query) {
            $status = (bool) true;
        }

        echo json_encode(array('status'=>$status));
    }

    public function tombol_detail($string) {
        return (string) "<a href=".base_url('kepala/Keluar_Barang/detail_keluar?id=').$string['nomor_keluar']." target=\"_blank\"><i class=\"fa fa-search fa-fw\"></i></a>";
    }

    public function tombol_unlock($string) {
        return (string) $string['status'] == 0 ? "<span><i class=\"fa fa-lock fa-fw\"></i></span>":"<a href=\"javascript:void(0)\" onclick=\"Unlock('{$tring['id']}')\"><i class=\"fa fa-lock fa-fw\"></i></a>";  
    }
}
