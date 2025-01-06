<?php
class Akun_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "ukdw_akun";
        $this->post = $this->input->post();
    }

    public function get_detail($id)
    {
        $this->db->where('akun_id', $id);
        $this->db->from($this->table);
        $query = $this->db->get();

        $data = $query->row_array();

        return $data;
    }

    public function get_name($id)
    {
        $this->db->where('akun_id', $id);
        $this->db->from($this->table);
        $query = $this->db->get();

        $data = $query->row();

        return $data->name;
    }

    public function get_akunlist($filter,$display)
    {
        $this->db->select($display);
        $this->db->where($filter);
        $this->db->from($this->table);
        $query = $this->db->get();
        $data = $query->result_array();
        $sql=$this->db->last_query();
        return $data;
    }

    function get_akuninduk($display){
        $query="select ".$display." FROM ukdw_akun WHERE akun_id=akun_induk";
        $exe=$this->db->query($query);
        $data=$exe->result_array();
        $sql=$this->db->last_query();
        return $data;
    }

    public function get_datalist($status){
        $this->db->where('status', $status); //onli active item
        $this->db->select("*", false);
        $this->db->from($this->table);
        $this->db->order_by('jenis', 'ASC');
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get();

        $data = $query->result_array();

        return $data;
    }

    public function get_data()
    {
        $server_side = $this->post['server_side'];
        parse_str($this->post['filter'], $filter);
        if ($filter['jenis'] != '') {
            $this->db->where('jenis', $filter['jenis']);
        }else{

        }

        if ($filter['tipe'] != '') {
            $this->db->where('tipe', $filter['tipe']);
        }else{

        }

        $this->db->where('status', 'active'); //onli active item
        $this->db->select("SQL_CALC_FOUND_ROWS *", false);
        $this->db->from($this->table);

        $this->db->order_by('jenis', 'ASC');
        $this->db->order_by('name', 'ASC');
       
        if ($server_side == true) {
            $this->db->limit($this->post['length'], $this->post['start']);
        }
        $query = $this->db->get();
        $sql=$this->db->last_query();
        $data = $query->result_array();
      
        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        $total_res = $query->row()->Count; //count total data

        return [
            "data" => $data,
            "total_res" => $total_res,
            "query"=>$sql,
            "jenis"=>$filter['jenis'],
            "tipe"=>$filter['tipe']
        ];
    }

    

    public function insert($data)
    {
        $this->db->insert("ukdw_akun", $data);
    }

    public function update($filter=null, $data=null)
    {
        $this->db->where($filter);
        $this->db->update("ukdw_akun", $data);
    }

}
