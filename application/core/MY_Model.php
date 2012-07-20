<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
    // define attribute table_name
    public $table_name = "";
    public $id = "";

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
            $str_query = $this->build_query($method, 8, $length, "SELECT * FROM " . $this->table_name, $params);
            $query = $this->db->query($str_query . ' limit 0,1');
            return $query->row();
        } elseif (substr($method, 0, 8) == 'find_all') {
            $length = strlen($method);
            $query = $this->db->query('SELECT * FROM ' . $this->table_name);
            return $query->result();
        } elseif (substr($method, 0, 12) == 'find_all_by_'){
            $length = strlen($method);
            $str_query = $this->build_query($method, 12, $length, "SELECT * FROM " . $this->table_name, $params);
            $query = $this->db->query($str_query);
            return $query->result();
        } elseif (substr($method, 0, 13) == 'test_find_by_'){
            $length = strlen($method) + 1;
            echo $this->build_query($method, 13, $length, "SELECT * FROM " . $this->table_name, $params);
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
        $status = $this->db->insert($this->table_name, $data);
        $this->id = $this->db->insert_id();
        return $status;
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
        return $this->db->delete($this->table_name);
    }

    /*
    * Private method to generate query
    * @string string of method name
    * @start int string that will be invetigate to build query
    * @end int offset
    * @query string
    * @params array() 
    */ 
    private function build_query($string, $start, $end, $query, $params){
        $new_str = substr($string, $start, $end);
        $arr_str = $this->find_and($new_str);
        $before = 0;
        for($i = 0 ; $i < sizeof($arr_str) ; $i ++){
            if($i == 0){
                $field = substr($string, $start, $arr_str[$i]);
                $query = $query . " WHERE " . $this->table_name . "." . $field . " = '" . $params[$i] . "'";
            }
            $next = ($i + 1 < sizeof($arr_str) ? $arr_str[$i + 1] : strlen($string));
            $field = substr($new_str, $arr_str[$i] + 5 + $before, $next);
            $before = $arr_str[$i] + 5;
            $query = $query . " AND "  . $this->table_name . "." . $field . " = '" . $params[$i+1] . "'";
        }
        return $query;
    }

    /*
    * Private method to find _and_ in string
    * @string String of method
    * @arr array()
    */
    private function find_and($string, $arr = array()){
        $pos = strpos($string, '_and_');
        if($pos != false){
            array_push($arr, $pos);
            $arr = $this->find_and(substr($string, $pos + 5, strlen($string) + 1), $arr);
        }
        //TODO create find 'or' in method name
        return $arr;
    }

}
