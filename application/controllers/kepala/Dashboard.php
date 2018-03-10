<?php
class Dashboard extends ZEN_Controller{
		public function __construct() {
			parent::__construct();
			$this->load->library('kepala');
			$div = $this->session->userdata('div');
			$this->kepala->auth($div);
		}

		public function index() {
			$this->_setNav('kepala');
			$this->data['subview'] = 'gudang/index';
			$this->load->view('_layoutMain', $this->data);
		}

}
