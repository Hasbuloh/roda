<?php
class ZEN_Model extends CI_Model {
  protected $_tableName = '';
  protected $_primaryKey = 'id';
  // protected $_primaryFilter = 'stringval';
  protected $_orderBy = 'qty';
  public $rules = array();
  protected $_timestamps = FALSE;

  public function __construct() {
    parent::__construct();
  }


  public function array_form_post($fields) {
    $data = array();
    foreach ($fields as $field) {
      $data[$field] = $this->input->post($field);
    }

    return $data;
  }

  public function get($id = NULL,$single = FALSE) {
    if ($id != NULL) {
      $filter = $this->_primaryFilter;
      $id = $filter($id);
      $this->db->where($this->_primaryKey , $id);
      $method = 'row';
    }
    elseif ($single == TRUE) {
      $method = 'row';
    }else{
      $method = 'result';
    };
    if (!count($this->db->order_by($this->_orderBy))){
      $this->db->get($this->_tableName)->$method();
    };

    return $this->db->get($this->_tableName)->$method();
  }

  public function getBy($where, $single = FALSE) {
    $this->db->where($where);
    return $this->get(NULL,$single);
  }

  public function save($data,$id = NULL) {
    //insert
    if ($id == NULL) {
      !isset($data[$this->_primaryKey]) || $data[$this->_primaryKey] = NULL;
      $this->db->set($data);
      $this->db->insert($this->_tableName);
      $id = $this->db->insert_id();
    }else{
      // $filter = $this->_primaryFilter;
      // $id = $filter($id);
      $this->db->set($data);
      $this->db->where($this->_primaryKey,$id);
      $this->db->update($this->_tableName);
    }

    return $id;
  }

  public function delete($id) {
    $this->db->where($this->_primaryKey,$id);
    $this->db->limit(1);
    $this->db->delete($this->_tableName);
  }

  public function autocomplete($keyword) {
    return $this->db->query("SELECT * FROM {$this->_tableName} WHERE nama_part LIKE '%{$keyword}%'");
  }

}
