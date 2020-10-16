<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pages';
    }

    public function get_pages($limit = FALSE, $offset = FALSE)
    {
        $query = $this->db->get($this->table);
        if ($limit) {

            if ($offset == FALSE)
                $this->db->limit($limit);
            else
                $this->db->limit($limit, $offset);
        }


        return ($query->num_rows() > 0) ? $query->result() : FALSE;

    }

    public function get_page($id)
    {
        $query = $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function get_last_rec(){


        return $this->db->select('id')->order_by('id','desc')->limit(1)->get('table_name')->row('id');


    }

    public function add_page($data){

        return ($this->db->insert($this->table,$data))? $this->db->insert_id() : FALSE;
    }

    public function update_page($id, $data){
        $this->db->where('id', $id);

        return ($this->db->update($this->table,$data))? TRUE : FALSE;

    }

    public function delete_page($id){
        $this->db->where('id', $id);

        return ($this->db->delete($this->table))? TRUE : FALSE;
    }
}