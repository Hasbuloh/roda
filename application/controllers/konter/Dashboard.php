<?php
/**
 * Created by PhpStorm.
 * User: castor
 * Date: 23/11/17
 * Time: 11:31
 */
class Dashboard extends ZEN_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('konter');
        $div = $this->session->userdata('div');
        $this->konter->auth($div);
    }

    public function index() {
        $this->_setNav('konter');
        $this->data['subview'] = 'konter/index';
        $this->load->view('_layoutMain',$this->data);
    }
}
