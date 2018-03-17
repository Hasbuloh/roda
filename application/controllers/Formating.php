<?php
class Formating extends ZEN_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('formating/index');
    }

    public function fix_format() {
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $inputFileName = $_FILES['user_file']['tmp_name'];
        $inputFileType = IOFactory::identify($inputFileName);
        $objReader = IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++){
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $data[] = array(
                'No' => $rowData[0][0],
                'Nomor Part' => $rowData[0][1],
                'Nama Part' => $rowData[0][2],
                'Qty' => $rowData[0][3],
                'Jenis Part' => $rowData[0][4],
                'Het' => $rowData[0][5]*1000,
                'Netto' => $rowData[0][6]*1000
            );
        }
        $this->load->view('formating/table',array('title'=>'Laporan','data'=>$data));
    }

    function cari_jejak() {
    	
    }
}