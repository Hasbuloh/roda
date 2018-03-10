<?php
/**
 * Created by PhpStorm.
 * User: castor
 * Date: 04/12/17
 * Time: 22:34
 */
class Stok_Barang extends ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->_setNav('kepala');
        $this->load->model('Barang_M','Stok');
        $this->load->library('kepala');
        $div = $this->session->userdata('div');
        $this->kepala->auth($div);
    }

    public function index() {
        $this->data['subview'] = 'kepala/stok_barang/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function table_barang() {
        $items = $this->Stok->table_index()->result();
        // $this->load->view('kepala/stok_barang/table_barang',$this->data);
        $data = array();
        $no=1;
        foreach ($items as $item) {

            $row = array();
            $row[] = $no;
            $row[] = $item->nomor_part;
            $row[] = $item->nama_part;
            $row[] = $item->qty;
            $row[] = $this->convert_jenis($item->jenis_part);
            $row[] = $this->cari_klasifikasi($item->id);
            $row[] = $this->cari_sod($item->id);
            $row[] = toRP($item->harga_jual);
            $row[] = toRP($item->harga_jual * $item->qty);
            $row[] = toRP($item->harga_beli);
            $row[] = toRP($item->harga_beli*$item->qty);
            $row[] = '<span class="label label-danger">'.$item->no_rak."</span>";
            $row[] = $this->tombol_aksi(
                        array(
                            'id'=>$item->id,
                            'nomor'=> $item->nomor_part,
                            'nama' => $item->nama_part,
                            'jenis' => $item->jenis_part,
                            'qty' => $item->qty,
                            'het' => $item->harga_jual,
                            'netto' => $item->harga_beli,
                            'disc1' => $item->disc1,
                            'disc2' => $item->disc2,
                            'rak' => $item->no_rak
                        )
                    );
            $row[] = $this->tombol_hapus(
                                array(
                                    'id' => $item->id,
                                    'nama' => $item->nama_part
                                )
                            );
            $row[] = $this->tombol_unlock($item->id,$item->status);
            $data[] = $row;
            $no++;
        }

        $output = array('data'=>$data);
        echo json_encode($output);
    }



    function convert_jenis($string) {
        $hasil_convert = null;
        switch ($string) {
            case 'O':
                $hasil_convert = 'Oli';
                break;

            case 'S':
                $hasil_convert = 'Sparepart';
                break;

            case 'O':
                $hasil_convert = 'Apparel';
                break;

            default:
                $hasil_convert = '-';
                break;
        }

        return (string) $hasil_convert;
    }

    function cari_klasifikasi($id) {
        $hasil_pencarian = null;
        $data = $this->db->query("SELECT NOW() AS 'tanggal_sekarang',NOW() - INTERVAL 1 MONTH AS 'tanggal_mundur'")->row();
        // print_r($data);
        $sql = $this->db->query("SELECT SUM(qty) AS 'jumlah' FROM tbl_keluar WHERE id_barang='{$id}' AND tanggal_keluar < '{$data->tanggal_sekarang}' AND tanggal_keluar > '{$data->tanggal_mundur}'")->row();
        $jumlah = $this->db->query("SELECT * FROM tbl_klasifikasi")->row();
        // echo $sql->jumlah/30;

        if ($sql->jumlah / 30 > $jumlah->jumlah / 30 || $sql->jumlah === $jumlah->jumlah / 30 ) {
          $hasil_pencarian = "<span class='label label-primary'>Fast Moving</span>";
        }else if($sql->jumlah / 30 > 0){
          $hasil_pencarian = "<span class='label label-warning'>Slow Moving</span>";
        }else{
          $hasil_pencarian = "<span class='label label-success'>Very Slow Moving</span>";
        }

        return (string) $hasil_pencarian;
    }

    function cari_sod($id) {
        $hasil_pencarian = null;

        $data = $this->db->query("SELECT SUM(tbl_stok.qty/tbl_keluar.qty/30) AS 'jumlah' FROM tbl_keluar INNER JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE tbl_keluar.id_barang = '{$id}' AND tbl_keluar.tanggal_keluar <= NOW() AND tbl_keluar.tanggal_keluar >= NOW() - INTERVAL 1 MONTH")->row();

        if ($data->jumlah > 0) {
            $hasil_pencarian = round($data->jumlah,2);
        }else{
            $hasil_pencarian = 0;
        }

        return (string) $hasil_pencarian;
    }

    function tombol_aksi($string) {
        $tombol = null;

        $tombol .= '<a href="javascript:void(0)" onclick="showModal(';
        $tombol .= $string['id'];
        $tombol .= ",'".$string['nomor']."'";
        $tombol .= ",'".$string['nama']."'";
        $tombol .= ",'".$string['jenis']."'";
        $tombol .= ",".$string['qty'];
        $tombol .= ",".$string['het'];
        $tombol .= ",".$string['netto'];
        $tombol .= ",".$string['disc1'];
        $tombol .= ",".$string['disc2'];
        $tombol .= ",'".$string['rak']."'";
        $tombol .= ')"><i class="fa fa-edit fa-fw"></i></a>';


        return (string) $tombol ;
    }

    function tombol_hapus($string) {
        $tombol = null;

        $tombol .= '<a href="javascript:void(0)" onclick="hapus(';
        $tombol .= $string['id'];
        $tombol .= ",'".$string['nama']."'";
        $tombol .= ')"><i class="fa fa-trash fa-fw"></i></a>';


        return (string) $tombol ;
    }

    public function edit() {
        $this->_validate();
        $id = $this->input->post('id');
        $data = $this->Stok->array_form_post(array('nomor_part','nama_part','disc1','disc2','jenis_part','no_rak','qty','harga_jual','harga_beli'));
        $this->Stok->save($data,$id);
        echo json_encode(array('status'=>TRUE));
    }

    public function hapus() {
        $id = $this->input->post('id');
        $this->Stok->delete($id);
        echo json_encode(array('status'=>TRUE));
    }

    function tombol_unlock($id,$status) {
        $string = '<i class="fa fa-lock fa-fw"></i>';
        if ($status == FALSE) {
            $string = '<a href="javascript:void(0)" onclick="unlock('.$id.')"><i class="fa fa-lock fa-fw"></i></a>';
        }

        return $string;
    }

    function unlock_barang() {
        $id = $this->input->post('id');
        $unlock = $this->db->query("UPDATE tbl_stok SET status = TRUE WHERE id = '{$id}'");
        echo json_encode(array('status'=>$unlock));
    }

    private function _validate()
    {
        //deklarasi variable untuk dikirimkan sebagai json response
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        //merubah form yang di post menjadi array asosiatif
        $jumlahField = array(
            'nomor_part' => $this->input->post('nomor_part'),
            'nama_part' => $this->input->post('nama_part'),
            'qty' => $this->input->post('qty'),
            'harga_jual' => $this->input->post('harga_jual'),
            'harga_beli' => $this->input->post('harga_beli'),
        );

        //menguraikan array jumlahField
        foreach ($jumlahField as $key => $value):
            if ($value == "")://kondisi untuk mengecek jika value atau inputan ada yang kosong
                $data['inputerror'][] = $key;
                $data['error_string'][] = str_replace("_", " ", $key).' tidak boleh kosong';
                $data['status'] = FALSE;
            endif;
        endforeach;

        if($data['status'] === FALSE):
            echo json_encode($data);
            exit();
        endif;
    }

}
