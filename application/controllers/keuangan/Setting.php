<?php
class Setting extends ZEN_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('keuangan');
        $div = $this->session->userdata('div');
        $this->keuangan->auth($div);
    }

    public function index() {
        $this->data['user'] = $this->db->get_where('tbl_user',array('id'=>$this->session->userdata('id')))->row();
        $this->data['nav'] = 'keuangan/page_navigation';
        $this->data['subview'] = 'keuangan/setting/index';
        $this->load->view('_layoutMain',$this->data);
    }

    public function ambil_user() {
        $data = $this->db->get_where('tbl_user',array('id'=>$this->session->userdata('id')))->row();
        echo json_encode($data);
    }

    public function update_user() {
        $config['upload_path']          = './gambar/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['file_name']            = $this->input->post('username').'-foto';

        $this->load->library('upload', $config);
        $this->upload->do_upload('foto');
        
        $id = $this->session->userdata('id');
        $password = $this->input->post('password');
        $cek = $this->db->query("SELECT * FROM tbl_user WHERE password = '{$this->input->post('password')}'");
        if ($cek->num_rows() < 1) {
            $password = $this->hash($this->input->post('password'));
        }

        $data = array(
            'nama' => $this->input->post('nama'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'username' => $this->input->post('username'),
            'password' => $password,
            'foto' => $this->upload->data('file_name')
        );

       
        $update = (bool) $this->db->update('tbl_user',$data,array('id'=>$id));

        echo json_encode(array('status'=>$update));
    }

    public function load_profil() {
        $data = $this->db->get_where('tbl_user',array('id'=>$this->session->userdata('id')))->row();
        $this->load->view('keuangan/setting/profile',array('user'=>$data));
    }

    public function hash($string=null) {
        return hash('sha512',$string. config_item('encryption_key'));
    }
}
