<?php
class Dashboard extends ZEN_Controller{
		public function __construct() {
			parent::__construct();
			$this->load->library('keuangan');
			$div = $this->session->userdata('div');
			$this->keuangan->auth($div);
		}

		public function index() {
			$this->_setNav('keuangan');
			$this->data['jenis'] = $this->db->query("SELECT * FROM tbl_jenis");
			$this->data['subview'] = 'keuangan/index';
			$this->load->view('_layoutMain', $this->data);
		}

}
