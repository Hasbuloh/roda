<?php
class Keluar_Barang extends ZEN_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('Keluar_M','Keluar');
      $this->load->library('konter');
      $div = $this->session->userdata('div');
      $this->konter->auth($div);
  }
  public function index() {
    $this->_setNav('konter');
    // $this->data['barangs'] = $this->Barang->get();
    $this->data['subview'] = 'konter/keluar_barang/index';
    $this->load->view('_layoutMain', $this->data);
  }

    public function autocomplete_nomor_polisi() {
        $param = $this->input->post('query');
        $output=array();
        $data = $this->db->query("SELECT * FROM tbl_headerkeluar WHERE nomor_polisi LIKE '%{$param}%'");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nomor_polisi'],
                'id' => $item['id'],
                'nama' => $item['nama']
            );
        endforeach;
        echo json_encode($output);
    }

  public function table_keluar() {
    $data = array();
    $items = $this->db->query("
            SELECT *,IFNULL(k.qty,0) as 'item',
              IFNULL(k.jumlah,0) AS 'total',
              DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal_keluar'
              FROM tbl_headerkeluar 
                LEFT JOIN  (SELECT nomor_keluar AS nomor,SUM(qty) AS qty,SUM(qty*harga) AS jumlah FROM tbl_keluar GROUP BY nomor_keluar) AS k 
              ON k.nomor = tbl_headerkeluar.nomor_keluar WHERE DATE_FORMAT(tanggal,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
 ORDER BY id DESC")->result();
    $no=1;
    foreach ($items as $item) {
        $row = array();
        $row[] = $this->tombol_edit(array(
            'id'=>$item->id,
            'nomor_keluar'=>$item->nomor_keluar,
            'nomor_sa'=>$item->nomor_sa,
            'nomor_polisi'=>$item->nomor_polisi,
            'nama' =>$item->nama,
            'jenis' =>$item->jenis
        ));
        $row[] = $this->tombol_hapus(array('id'=>$item->id,'item'=>$item->item));
        $row[] = $no;
        $row[] = $item->nomor_keluar;
        $row[] = $item->nomor_polisi;
        $row[] = $item->nomor_sa;
        $row[] = $item->tanggal_keluar;
        $row[] = $item->nama;
        $row[] = $item->item;
        $row[] = toRP($item->total);
        $row[] = $this->tombol_detail(array('nomor_keluar'=>$item->nomor_keluar));
        $row[] = $this->tombol_update(array('status'=>$item->status,'nomor_keluar'=>$item->nomor_keluar));
        $data[] = $row;
        $no++;
    }
    $output = array('data'=>$data);
    echo json_encode($output);
  }

    function tambah_header() {
      $this->Keluar->_tableName = 'tbl_headerkeluar';
      $status = (boolean) false;
      $no_urut = $this->db->query("SELECT * FROM tbl_headerkeluar WHERE nomor_keluar = '{$this->input->post('nomor_keluar')}'")->num_rows();
      $no_sa = $this->db->query("SELECT * FROM tbl_headerkeluar WHERE nomor_sa = '{$this->input->post('nomor_sa')}'")->num_rows();
      if ($no_urut < 1) {
          $id = $this->input->post('id');
          $data = $this->Keluar->array_form_post(array('nomor_keluar','jenis','nomor_sa','nomor_polisi','nama'));
          $this->Keluar->save($data,$id);
          $status = (boolean) true;
      }
      echo json_encode(array('status'=>$status));
    }

    public function edit_header() {
        $status = (boolean) false;
        $id = $this->input->post('id');
        $data = array(
            'nomor_sa' => $this->input->post('nomor_sa'),
            'nomor_polisi' => $this->input->post('nomor_polisi'),
            'nama' => $this->input->post('nama')
        );
        $this->db->where('id',$id);
        $update = $this->db->update('tbl_headerkeluar',$data);
        if ($update) {
            $status = (boolean) true;
        }

        echo json_encode(array('status'=>$status));
    }

    public function cetak_nota_keluar() {
       $id = $this->input->get('id');
      $data['header']=$this->db->query("SELECT *,DATE_FORMAT(NOW(),'%d %M %Y') AS 'tanggal' FROM tbl_headerkeluar WHERE nomor_keluar = '{$id}'")->row();
      $this->load->library('pdfgenerator');
      $data['items'] = $this->db->query("SELECT tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.harga_jual,tbl_keluar.qty FROM tbl_keluar LEFT JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE tbl_keluar.nomor_keluar = '{$id}'")->result_object();

      $html = $this->load->view('konter/nota/keluar_barang', $data, true);
      $filename = 'report_'.time();
      $this->pdfgenerator->generate($html, $filename, true, 'A4', 'potrait');
      // $this->load->view('konter/nota/keluar_barang',$data);
    }

    public function generate_nourut() {
        $kode = null;
        switch ($this->input->post('kode')) {
            case 1:
                $kode = "NSC";
                break;

            default:
                $kode = "NJB";
                break;
        }

        $nopo = null;
        $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_headerkeluar")->row();
        $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
        if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
            $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor_keluar) AS 'nopo' FROM tbl_headerkeluar WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
            $tmp = (int) substr($data->nopo,0,3);
            $tmp++;
            $nopo = sprintf('%03s',$tmp);
            $nopo .= '/KEL/'.$kode.'/'.toRome($data->bulan).'/10108/'.$data->tahun;
        }else{
            $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
            $nopo = '001/KEL/'.$kode.'/'.toRome($date->bulan).'/10108/'.$date->tahun;
        }
        echo json_encode(array('nokel'=>$nopo));
    }

  function edit_detail() {
    $this->Keluar->_tableName = 'tbl_keluar';
    $id = $this->input->post('id');
    $status = (boolean) false;
    $cek = $this->db->query("SELECT * FROM tbl_keluar WHERE nomor_keluar = '{$this->input->post('nomor_keluar')}' AND id_barang = '{$this->input->post('id_barang')}'")->num_rows();
    if ($cek < 1) {
        $data = $this->Keluar->array_form_post(array('id_barang','id_header','disc1','disc2','qty','nomor_keluar','jenis_keluar','harga','jumlah_harga'));
        $this->Keluar->save($data,$id);
        $status = (boolean) true;
    }

    echo json_encode(array('status'=>$status));
  }


  public function update_detail_keluar() {
    $this->_setNav('konter');
    $id = $this->input->get('id');
    $this->data['detail'] = $this->db->get_where('tbl_headerkeluar',array('nomor_keluar'=>$id))->row();
    $this->data['subview'] = 'konter/keluar_barang/index_detail';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_detail() {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_keluar.* FROM  tbl_keluar INNER JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE nomor_keluar = '{$id}'")->result();
    $this->load->view('konter/keluar_barang/table_detail',$this->data);
  }

  function hapus_detail() {
      $this->Keluar->_tableName = 'tbl_keluar';
      $id = $this->input->post('id');
    $this->Keluar->delete($id);
    echo json_encode(array('status'=>TRUE));
  }

  function update_detail() {
    $id = $this->input->post('id');
    $qty = $this->input->post('qty');
    $query = $this->db->query("UPDATE tbl_keluar SET qty = $qty WHERE id = $id");
    if ($query) {
      echo json_encode(array('status'=>TRUE));
    }else{
      echo json_encode(array('status'=>FALSE));
    }
  }

  function cek_stok() {
    $id = $this->input->post('id');
    $jumlah = $this->input->post('jumlah');
    $query = $this->db->query("SELECT * FROM tbl_stok WHERE id = '{$id}' AND qty  < '{$jumlah}' ");
    echo json_encode(array('status'=>$query->num_rows()));
  }

  function update_status() {
      $tatus = (bool) false;
      $id = $this->input->post('id');
      $query = $this->db->query("UPDATE tbl_headerkeluar SET status = TRUE WHERE nomor_keluar = '{$id}'");
      if ($query) {
          $status = (bool) true;
      }

      echo json_encode(array('status'=>$status));


  }

  function simpan_batal() {
    $id = $this->input->post('id_barang');
    $nomor = $this->input->post('nomor_keluar_batal');
    $qty = $this->input->post('qty_batal');
    $status = (bool) false;
    $query = $this->db->query("INSERT INTO tbl_batal (nomor_keluar,id_barang,qty) VALUES ('{$nomor}','{$id}','{$qty}')");
    if ($query) {
        $status = (bool) true;
    }

    echo json_encode(array('status'=>true));
  }

  function detail_keluar() {
      $id = $this->input->get('id');
      $this->_setNav('konter');
      $this->data['header'] = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal' FROM tbl_headerkeluar WHERE nomor_keluar = '{$id}'")->row();
      $this->data['items'] = $this->db->query("SELECT tbl_stok.nama_part,tbl_stok.nomor_part,tbl_stok.harga_jual,tbl_stok.harga_beli,tbl_keluar.* FROM  tbl_keluar INNER JOIN tbl_stok ON tbl_keluar.id_barang = tbl_stok.id WHERE nomor_keluar = '{$id}'")->result();
      $this->data['subview'] = 'konter/keluar_barang/index_detail_keluar';
      $this->load->view('_layoutMain',$this->data);
  }

  public function tombol_detail($string) {
      return (string) "<a href=".base_url('konter/Keluar_Barang/detail_keluar?id=').$string['nomor_keluar']."><i class=\"fa fa-search fa-fw\"></i></a>";
  }

  public function tombol_update($string) {
        $tombol = null;
        if ($string['status']==FALSE) {
            $tombol = "<a href=".base_url('konter/Keluar_Barang/update_detail_keluar?id=').$string['nomor_keluar']."><i class=\"fa fa-edit fa-fw\"></i></a>";
        }else{
            $tombol = "<span><i class='fa fa-lock fa-fw'></i></span>";
        }

        return $tombol;
  }

    public function tombol_hapus($string) {
        return (string) "<a href=\"javascript:void(0)\" class=\"text text-danger\" onclick=\"hapusData({$string['id']},'{$string['item']}')\"><i class=\"fa fa-trash fa-fw\"></i></a>";
    }

    public function tombol_edit($string) {
        return (string) "<a href=\"javascript:void(0)\" class=\"text text-success\" onclick=\"modalEdit({$string['id']},'{$string['nomor_keluar']}','{$string['nomor_sa']}','{$string['nomor_polisi']}','{$string['nama']}',{$string['jenis']})\"><i class=\"fa fa-pencil fa-fw\"></i></a>";
    }

    public function cek_detail($string) {

    }

    public function hapus() {
      $id = $this->input->post('id');
      $status = (boolean) false;
      $hapus = $this->db->delete('tbl_headerkeluar',array('id'=>$id));
      if ($hapus) {
          $status = (boolean) true;
      }
      echo json_encode(array('status'=>$status));
    }



}
