<?php
class Dashboard extends ZEN_Controller{
		public function __construct() {
			parent::__construct();
			$this->load->library('gudang');
			$div = $this->session->userdata('div');
			$this->gudang->auth($div);
		}

		public function index() {
			$this->_setNav('gudang');
			$this->data['jenis'] = $this->db->query("SELECT * FROM tbl_jenis");
			$this->data['subview'] = 'gudang/index';
			$this->load->view('_layoutMain', $this->data);
		}

}
