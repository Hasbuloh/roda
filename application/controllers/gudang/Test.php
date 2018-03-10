<?php
class Test extends ZEN_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->_setNav('gudang');
		$this->data['subview'] = 'gudang/test/index';
		$this->load->view('_layoutMain',$this->data);
	}

	public function post() {
		$nama = count($this->input->post('id'));
		for ($i = 0; $i < $nama; $i++) {
			echo $this->input->post('id')[$i];
		}
	}

	public function cek() {
		$id = 43;
		$qty = 3;
		$tanggal = $this->db->query("SELECT * FROM tbl_keluar WHERE tanggal_keluar NOT IN(SELECT tanggal_keluar FROM tbl_keluar WHERE id_barang = '{$id}')");
		if ($tanggal->num_rows < 1) {
			$query = "INSERT INTO tbl_stoktrace id_barang = '{$id}'";
			$query1 = "SELECT SUM(qty+{$qty}) FROM tbl_stok WHERE id='{$id}'";
			echo $query.$query1;
		}else{
			echo 1;
		}
	}

	public function tanggal() {
	    echo toIndo('10-12-2017');
    }

    public function unformated (){
        $jumlah=null;
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

        $config['upload_path'] = './excel/'; //buat folder dengan nama assets di root folder
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('userfile') )
            $this->upload->display_errors();

        $media = $this->upload->data('userfile');
        $data = $this->upload->data();
        $inputFileName = $data['full_path'];
        $bajaj = array();

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

            $bajaj[] = array('nomor_part'=>$rowData[0][1],'nama_part'=>$rowData[0][2],'qty'=>$rowData[0][3],'jenis'=>$rowData[0][4],'harga'=>$rowData[0][5]);

        }
        $data['items'] = $bajaj;
        $data['title'] = 'laporan';
        $this->load->view('gudang/test/unformated',$data);
//        print_r($bajaj);
    }
}
