<?php
class Retur_Keluar extends ZEN_Controller {
  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->data['nav'] = 'gudang/page_navigation';
    $this->load->model('Returkeluar_M','Returkeluar');
    $this->load->library('gudang');
    $div = $this->session->userdata('div');
    $this->gudang->auth($div);
  }

  public function index()
  {
    $this->data['nav'] = 'gudang/page_navigation';
    $this->data['subview'] = 'gudang/retur_keluar/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_retur() {
    $items = $this->db->query(
        "SELECT h.nomor_retur,h.nomor_keluar,DATE_FORMAT(h.tanggal,'%d %M %Y') AS tanggal,IFNULL(d.item,0) AS item,IFNULL(d.jumlah,0) AS jumlah FROM tbl_headerreturkeluar AS h LEFT JOIN(
          SELECT nomor_retur AS nomor_retur,SUM(qty) AS item,SUM(qty*harga_jual) AS jumlah FROM tbl_returkeluar
        ) AS d ON d.nomor_retur = h.nomor_retur ORDER BY h.tanggal DESC
        "
    )->result();
    $no = 1;
    $data = array();
    foreach ($items as $item):
      $row = array();
      $row[] = $this->tombol_edit();
      $row[] = $this->tombol_hapus();
      $row[] = $no;
      $row[] = $item->nomor_retur;
      $row[] = $item->nomor_keluar;
      $row[] = $item->tanggal;
      $row[] = $item->item;
      $row[] = toRP($item->jumlah);
      $row[] = $this->tombol_cetak(array('nomor_retur'=>$item->nomor_retur));
      $row[] = $this->tombol_detail(array('nomor_retur'=>$item->nomor_retur));
      $row[] = $this->tombol_update(array('nomor_retur'=>$item->nomor_retur));
      $no++;
      $data[] = $row;
    endforeach;

    echo json_encode(array('data'=>$data));
  }

  public function cek_header() {
    $id = $this->input->post('id');
    $query = $this->db->query("SELECT * FROM tbl_headerreturkeluar WHERE nomor_retur = '{$id}'");
  }

    public function autocomplete_nomor() {
        $param = $this->input->post('query');
        $param1 = $this->input->post('nomor');
        $param2 = $this->input->post('tanggal');
        $output=array();
        $data = $this->db->query("
            SELECT *,k.qty AS qty,k.harga AS harga_jual FROM tbl_keluar AS k LEFT JOIN (SELECT id AS id,nomor_part AS nomor_part,nama_part AS nama_part FROM tbl_stok) AS s ON s.id = k.id_barang WHERE k.nomor_keluar = '{$param1}' AND s.nomor_part LIKE '%{$param}%' AND DATE_FORMAT(tanggal_keluar,'%Y-%m-%d') = '{$param2}'
        ");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nomor_part'],
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'tanggal' => $item['tanggal_keluar']
            );
        endforeach;
        echo json_encode($output);
    }

    public function autocomplete_nama() {
        $param = $this->input->post('query');
        $param1 = $this->input->post('param');
        $param2 = $this->input->post('tanggal');
        $output=array();
        $data = $this->db->query("
            SELECT *,k.qty AS qty,k.harga AS harga_jual FROM tbl_keluar AS k LEFT JOIN (SELECT id AS id,nomor_part AS nomor_part,nama_part AS nama_part FROM tbl_stok) AS s ON s.id = k.id_barang WHERE k.nomor_keluar = '{$param1}' AND s.nama_part LIKE '%{$param}%' AND DATE_FORMAT(tanggal_keluar,'%Y-%m-%d') = '{$param2}' 
        ");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nama_part'],
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'tanggal' => $item['tanggal_keluar']
            );
        endforeach;
        echo json_encode($output);
    }



  function edit_header() {
     $this->Returkeluar->_tableName = 'tbl_headerreturkeluar';
     $id = $this->input->post('id');
     $data = $this->Returkeluar->array_form_post(array('nomor_retur','nomor_keluar','tanggal'));
     $this->Returkeluar->save($data,$id);
     echo json_encode(array('status'=>TRUE));
  }


  public function update_detail_retur() {
    $id = $this->input->get('id');
    $this->data['header'] = $this->db->query(
        "SELECT *,DATE_FORMAT(h.tanggal,'%d %M %Y') AS tanggal,h.tanggal AS tanggal_nonformat,DATE_FORMAT(hk.tanggal,'%Y-%m-%d') AS 'tanggal_keluar' FROM tbl_headerreturkeluar AS h LEFT JOIN tbl_headerkeluar AS hk ON h.nomor_keluar = hk.nomor_keluar WHERE h.nomor_retur = '{$id}'"
    )->row();
    $this->data['subview'] = 'gudang/retur_keluar/index_detail';
    $this->load->view('_layoutMain',$this->data);
  }

  public function table_detail() {
    $id = $this->input->get('id');
    $this->data['items'] = $this->db->query("SELECT tbl_returkeluar.*,tbl_stok.nomor_part,tbl_stok.nama_part FROM tbl_returkeluar INNER JOIN tbl_stok ON tbl_stok.id = tbl_returkeluar.id_barang WHERE nomor_retur = '{$id}'")->result();
    $this->load->view('gudang/retur_keluar/table_detail',$this->data);
  }

  public function autocomplete_nsc() {
      $param = $this->input->post('query');
      $output=array();
      $data = $this->db->query("SELECT *,DATE_FORMAT(tanggal,'%d %M %Y') AS 'tanggal' FROM tbl_headerkeluar WHERE nama LIKE '%{$param}%' AND jenis = 1");
      foreach($data->result_array() as $item):
          $output['query'] = $param;
          $output['suggestions'][] = array(
              'value' => $item['nama']." [".$item['tanggal']."]",
              'nomor_keluar' => $item['nomor_keluar'],
              'nama' => $item['nama'],
              'tanggal' => $item['tanggal']
          );
      endforeach;
      echo json_encode($output);
  }

  public function edit_detail() {
      $status = (boolean) false;
      $cek = $this->db->query("SELECT * FROM tbl_returkeluar WHERE nomor_keluar = '{$this->input->post('nomor_keluar')}' AND id_barang = '{$this->input->post('id_barang')}'")->num_rows();
      if ($cek < 1) {
        $this->Returkeluar->_tableName = 'tbl_returkeluar';
        $data = $this->Returkeluar->array_form_post(array('nomor_retur','nomor_keluar','id_barang','qty','jumlah','disc1','disc2','harga_jual','keterangan'));
        $this->Returkeluar->save($data,$id);
        $status = (boolean) true;
      }
      echo json_encode(array('status'=>$status));
  }


  public function generate_nourut() {
    $nopo = null;
    $data1 = $this->db->query("SELECT MAX(DATE_FORMAT(tanggal,'%y %m')) AS 'tanggal1' FROM tbl_headerreturkeluar")->row();
    $data2 = $this->db->query("SELECT DATE_FORMAT(NOW(),'%y %m') AS 'tanggal2'")->row();
    if (isset($data1->tanggal1) && isset($data2->tanggal2) && $data1->tanggal1 == $data2->tanggal2 ) {
      $data = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun',DATE_FORMAT(NOW(),'%m') AS 'bulan', MAX(nomor_retur) AS 'nopo' FROM tbl_headerreturkeluar WHERE DATE_FORMAT(tanggal,'%y %m')=DATE_FORMAT(NOW(),'%y %m')")->row();
      $tmp = (int) substr($data->nopo,0,3);
      $tmp++;
      $nopo = sprintf('%03s',$tmp);
      $nopo .= '/RK/'.toRome($data->bulan).'/10108/'.$data->tahun;
    }else{
      $date = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y') AS 'tahun', DATE_FORMAT(NOW(),'%m') AS 'bulan'")->row();
      $nopo = '001/RK/'.toRome($date->bulan).'/10108/'.$date->tahun;
    }
    echo json_encode(array('noretur'=>$nopo));
  }

  function tambah_header() {

  }

  function kurangi_keluar() {
    $id = $this->input->post('id');
    $id_barang = $this->input->post('id_barang');
    $qty = $this->input->post('qty_batal');
    $query = $this->db->query("UPDATE tbl_keluar SET qty = qty - $qty WHERE id = $id");
    $masukstok = $this->db->query("UPDATE tbl_stok SET qty = qty + $qty WHERE id = $id_barang");

    if ($query && $masukstok) {
      echo json_encode(array('status'=>TRUE));
    }else{
      echo json_encode(array('status'=>FALSE));
    }
  }

  function cetak_berita()
  {
    $id = $this->input->get('id');
    $data['tanggal']=$this->db->query("SELECT DATE_FORMAT(NOW(),'%d %M %Y') AS 'tanggal'")->row();
    $this->load->library('pdfgenerator');
    $data['items'] = $this->db->query("SELECT tbl_returkeluar.*,tbl_stok.nomor_part,tbl_stok.nama_part,tbl_stok.disc1,tbl_stok.disc2,tbl_stok.harga_beli FROM tbl_returkeluar INNER JOIN tbl_stok ON tbl_stok.id = tbl_returkeluar.id_barang WHERE nomor_retur = '{$id}'")->result_array();
    $data['persons'] = $this->db->query("SELECT * FROM tbl_headerkeluar INNER JOIN tbl_returkeluar ON tbl_headerkeluar.nomor_keluar = tbl_returkeluar.nomor_keluar WHERE tbl_returkeluar.nomor_retur = '{$id}' GROUP BY tbl_returkeluar.nomor_keluar")->row();

    $html = $this->load->view('gudang/nota/retur_keluarbarang', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'landscape');
  }

  public function tombol_cetak($string) {
      return (string) "<a href=".base_url('gudang/Retur_Keluar/cetak_berita?id=').$string['nomor_retur']." target=\"_blank\" class=\"btn btn-link btn-xs\"><i class=\"fa fa-print fa-fw\"></i> (PDF)</a>";
  }

  public function tombol_detail($string) {
      return (string) "<a href=".base_url('gudang/Retur_Keluar/index_detail?id=').$string['nomor_retur']."><i class=\"fa fa-search fa-fw\"></i></a>";
  }

  public function tombol_update($string) {
      return (string) "<a href=".base_url('gudang/Retur_Keluar/update_detail_retur?id=').$string['nomor_retur']."><i class=\"fa fa-edit fa-fw\"></i></a>";
  }

  public function tombol_hapus() {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-danger\" onclick=\"hapusData()\"><i class=\"fa fa-trash fa-fw\"></i></a>";
  }

  public function tombol_edit() {
      return (string) "<a href=\"javascript:void(0)\" class=\"text text-success\" onclick=\"modalEdit()\"><i class=\"fa fa-pencil fa-fw\"></i></a>";
  }


}
