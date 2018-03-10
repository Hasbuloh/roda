<?php
class Opname extends ZEN_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Opname_M','Opname');
		$this->load->library('kepala');
		$div = $this->session->userdata('div');
		$this->kepala->auth($div);
	}

	public function index() {
		$this->_setNav('kepala');
		$this->data['subview'] = 'kepala/opname/index';
		$this->load->view('_layoutMain',$this->data);
	}

	public function table_index() {
		$this->data['items'] = $this->Opname->table_index()->result();
		$this->load->view('kepala/opname/table_index',$this->data);
	}

	public function update_status() {
		$id = $this->input->post('id');
		(bool) $status = FALSE;
		$update = $this->db->query("UPDATE tbl_headeropname SET status = FALSE WHERE nomor = '{$id}'");
		if ($update) {
			$status = TRUE;
		}

		echo json_encode(array('status'=>$status));
	}

	public function detail_opname() {
        $id = $this->input->get('id');
        $this->data['header'] = '';
        $this->data['items'] = '';
        $this->data['subview'] = 'kepala/opname/detail_opname';
        $this->load->view('_layoutMain',$this->data);
    }
}
