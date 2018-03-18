<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends ZEN_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Barang_M','Barang');
  }

  function index()
  {
    $this->_setNav('gudang');
    $this->data['subview'] = 'gudang/barang/index';
    $this->load->view('_layoutMain', $this->data);
  }

  public function table_barang() {
    $items = $this->Barang->table_index()->result();
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
        $row[] = $item->disc1;
        $row[] = $item->disc2;
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
                        'rak' => $item->no_rak,
                        'status' => $item->status,
                    )
                );
        $row[] = $this->tombol_hapus(
                            array(
                                'id' => $item->id,
                                'nama' => $item->nama_part
                            )
                        );
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

            case 'A':
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

        $sql = $this->db->query("SELECT SUM(qty) AS 'jumlah' FROM tbl_keluar WHERE id_barang='{$id}' AND tanggal_keluar < '{$data->tanggal_sekarang}' AND tanggal_keluar > '{$data->tanggal_mundur}'")->row();
        $jumlah = $this->db->query("SELECT * FROM tbl_klasifikasi")->row();
        

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
        return "<a href=\"javascript:void(0)\" onclick=\"showModal({$string['id']},'{$string['nomor']}','{$string['nama']}','{$string['jenis']}',
        '{$string['qty']}','{$string['het']}','{$string['netto']}','{$string['disc1']}','{$string['disc2']}','{$string['rak']}','{$string['status']}',
        )\"><i class=\"fa fa-edit fa-fw\"></i></a>";
    }

    function tombol_hapus($string) {
          return "<a href=\"javascript:void(0)\" onclick=\"hapus('{$string['id']}','{$string['nama']}')\"><i class=\"fa fa-trash fa-fw\"></i></a>";
    }


      public function edit() {
        $id = $this->input->post('id');
        $data = $this->Barang->array_form_post(array('nomor_part','nama_part','disc1','disc2','jenis_part','no_rak','qty','harga_jual','harga_beli'));
        $this->Barang->save($data,$id);
        echo json_encode(array('status'=>TRUE));
      }

      public function hapus() {
        $id = $this->input->post('id');
            $this->Barang->delete($id);
            echo json_encode(array('status'=>TRUE));
      }


    public function stok_awal() {
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $inputFileName = $_FILES['excel_stok_file']['tmp_name'];

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);

                $bajaj[] = array('id'=>$rowData[0][0],'nomor_part'=>$rowData[0][1],'nama_part'=>$rowData[0][2],'jenis'=>$rowData[0][3],'qty'=>$rowData[0][4],'het'=>$rowData[0][5],'disc1'=>$rowData[0][6],'disc2'=>$rowData[0][7],'no_rak'=>$rowData[0][8],'netto'=>$rowData[0][9]);

            }

            foreach ($bajaj as $value) {
                $this->db->query("INSERT INTO tbl_stok (id,nomor_part,nama_part,jenis_part,qty,harga_beli,harga_jual,disc1,disc2,no_rak) VALUES ('{$value['id']}','{$value['nomor_part']}','{$value['nama_part']}','{$value['jenis']}','{$value['qty']}','{$value['netto']}','{$value['het']}','{$value['disc1']}','{$value['disc2']}','{$value['no_rak']}')");
            }

            echo json_encode(array('status'=>TRUE,'jumlah'=>count($bajaj)));
    }

    public function update_het() {
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $inputFileName = $_FILES['excel_het_file']['tmp_name'];

        $inputFileType = IOFactory::identify($inputFileName);
        $objReader = IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

          for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
            // $bajaj[] = array('nomor_part'=>$rowData[0][1],'nama_part'=>$rowData[0][2],'harga_jual'=>$rowData[0][4]);
            $cek = $this->db->query("SELECT * FROM tbl_stok WHERE nomor_part = '{$rowData[0][1]}'");
            // if ()
            if ($cek->num_rows() < 1) {
                $this->db->query("INSERT INTO tbl_stok (nomor_part,nama_part,qty,harga_jual,harga_beli) VALUES ('{$rowData[0][1]}','{$rowData[0][2]}',0,'{$rowData[0][4]}',{$rowData[0][4]})");
            }else{
                $this->db->query("UPDATE tbl_stok SET nama_part = '{$rowData[0][2]}',harga_jual='{$rowData[0][4]}' WHERE nomor_part = '{$rowData[0][1]}'");
            }
        }
    }

    public function update_rak() {
      $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
      $inputFileName = $_FILES['excel_rak_file']['tmp_name'];

      $inputFileType = IOFactory::identify($inputFileName);
      $objReader = IOFactory::createReader($inputFileType);
      $objPHPExcel = $objReader->load($inputFileName);
      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
          $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
          $this->db->query("UPDATE tbl_stok SET no_rak = '{$this->fix_format($rowData[0][1])}' WHERE nomor_part = '{$rowData[0][2]}'");
      }
    }


    public function setting_fast_moving() {
      $this->Barang->_tableName = 'tbl_klasifikasi';
      $id = $this->input->post('id');
      $data = $this->Barang->array_form_post(array('jumlah'));
      $this->Barang->save($data,$id);
      echo json_encode(array('status'=>TRUE));
    }

    public function fix_format($string) {
      return (string) str_replace('.','',$string);
    }

    public function cek_barang() {
      $nomor_part = $this->input->post('nomor_part');
      $data = $this->db->get('tbl_stok',array('nomor_part'=>$nomor_part));
      print_r($data->result());
    }

    public function autocomplete_nomor() {
        $param = $this->input->post('query');
        $output=array();
        $data = $this->db->query("SELECT * FROM tbl_stok WHERE nomor_part LIKE '%{$param}%'");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nomor_part'],
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'harga_beli' => $item['harga_beli'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'nomor_rak' => $item['no_rak']
            );
        endforeach;
        echo json_encode($output);
    }

    public function autocomplete_nama() {
        $param = $this->input->post('query');
        $output=array();
        $data = $this->db->query("SELECT * FROM tbl_stok WHERE nama_part LIKE '%{$param}%' AND qty > 0");
        foreach($data->result_array() as $item):
            $output['query'] = $param;
            $output['suggestions'][] = array(
                'value' => $item['nama_part'].'- ('.toRP($item['harga_jual']).')',
                'id' => $item['id'],
                'nomor_part' => $item['nomor_part'],
                'nama_part' => $item['nama_part'],
                'qty' => $item['qty'],
                'harga_jual' => $item['harga_jual'],
                'harga_beli' => $item['harga_beli'],
                'disc1' => $item['disc1'],
                'disc2' => $item['disc2'],
                'nomor_rak' => $item['no_rak']
            );
        endforeach;
        echo json_encode($output);
    }

    public function cek_nomor_part() {
      $id = $this->input->post('nomor_part');
      $cek = $this->db->query("SELECT * FROM tbl_stok WHERE nomor_part = '{$id}'")->num_rows();
      echo json_encode(array('status'=>$cek));
    }

}
