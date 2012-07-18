<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

class MY_Model extends CI_Model {
    // define attribute table_name
    public $table_name = "";

    /*
    *
    * Constructor method
    *
    * load codeigniter database library
    *
    */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
    * Overloading php __call method ( http://www.php.net/manual/en/language.oop5.overloading.php#object.call )
    *
    * @method name of method
    * @params array of parameter passed
    */
    public function __call($method, $params) {
        if (substr($method, 0, 8) == 'find_by_') {
            $length = strlen($method);
            $query = $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE ' . $this->table_name . '.' . substr($method, 8, $length + 1) . ' = "' . $params[0] . '" limit 0,1');
            return $query->row();
        } elseif (substr($method, 0, 8) == 'find_all') {
            $length = strlen($method);
            $query = $this->db->query('SELECT * FROM ' . $this->table_name);
            return $query->result();
        } elseif (substr($method, 0, 12) == 'find_all_by_'){
            $length = strlen($method);
            $query = $this->db->query('SELECT * FROM ' . $this->table_name . ' WHERE ' . $this->table_name . '.' . substr($method, 12, $length + 1) . ' = "' . $params[0] . '"');
            return $query->result();
        } else {
            return null;
        }
    }

    /*
    * Save method
    *
    * @data array of data to be saved
    *
    */
    public function save($data){
        return $this->db->insert($this->tablename, $data);
    }

    /*
    *
    * Update method
    * @data array of data to be updated
    * @param condition value
    * @updated_by condition key (default will updated by id)
    *
    */
    public function update($data, $param, $update_by = 'id'){
        $this->db->where($update_by,$param);
        return $this->db->update($this->table_name,$data);
    }

    /*
    *
    * Update method
    * @data array of data to be updated
    * @param condition value
    * @delete_by condition key (default will deleted by id)
    *
    */
    public function delete($param, $delete_by = 'id'){
        $this->db->where($delete_by,$param);
        return $this->db->update($this->table_name);
    }
}