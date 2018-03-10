<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller{
  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }
  function index()
  {
    $this->load->library('pdfgenerator');
		$data['users']=array(
			array('firstname'=>'I am','lastname'=>'Programmer','email'=>'iam@programmer.com'),
			array('firstname'=>'I am','lastname'=>'Designer','email'=>'iam@designer.com'),
			array('firstname'=>'I am','lastname'=>'User','email'=>'iam@user.com'),
			array('firstname'=>'I am','lastname'=>'Quality Assurance','email'=>'iam@qualityassurance.com')
		);
    $html = $this->load->view('table_report', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
  }
}
