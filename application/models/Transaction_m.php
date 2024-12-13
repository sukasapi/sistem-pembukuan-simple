<?php
class Transaction_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "ukdw_transaksi";
        $this->post = $this->input->post();
    }

    public function get_total_by_type($type)
    {
        $this->db->select_sum('nominal');
        $this->db->where('a.status', 'active'); //only active item
        $this->db->where('b.tipe', $type);
        $this->db->join('ukdw_akun b', 'a.category_id = b.akun_id', 'left'); 
        $this->db->from($this->table.' a');
        $query = $this->db->get();

        $nominal = $query->row()->nominal;

        return $nominal;
    }

    public function get_detail($id)
    {
        $this->db->where('transaction_id', $id);
        $this->db->from($this->table);
        $query = $this->db->get();

        $data = $query->row_array();

        return $data;
    }

    function get_datanom($filter=null,$display=null){
        $this->db->select($display)
                 ->from('ukdw_transaksi t')
                 ->join('ukdw_akun a','a.akun_id=t.category_id')
                 ->where($filter);
        $exe=$this->db->get();
        $sql=$this->db->last_query();
        $data = $exe->result_array();
        if(count((array)$data)>0){
            return $data;
        }else{
            return array();
        }
    }   

    public function get_data()
    {
        $server_side = $this->post['server_side'];
        parse_str($this->post['filter'], $filter);
        if ($filter['tipe'] != '') {
            $this->db->where('b.tipe', $filter['tipe']);
        }

        if ($filter['jenis'] != '') {
            $this->db->where('b.jenis', $filter['jenis']);
        }


        if ($filter['range_start'] != '') {
            $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m-%d') >=", $filter['range_start']);
        }

        if ($filter['range_end'] != '') {
            $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m-%d') <=", $filter['range_end']);
        }

        // if ($filter['range_start'] == '' && $filter['range_end'] == '') {
        //     $current_mount = date("Y-m");
        //     $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m')", $current_mount);
        // }

        $this->db->where('a.status', 'active'); //onli active item
        $this->db->join('ukdw_akun b', 'a.category_id = b.akun_id', 'left'); 
        $this->db->select("SQL_CALC_FOUND_ROWS a.*, b.name category_name, b.tipe category_type", false);
        $this->db->from($this->table.' a');
        $this->db->order_by('create_date', 'ASC');

        if ($server_side == true) {
            $this->db->limit($this->post['length'], $this->post['start']);
        }
        $query = $this->db->get();
        $sql=$this->db->last_query();
        $data = $query->result_array();

        // var_dump($this->db->last_query());exit;

        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        $total_res = $query->row()->Count; //count total data

        return [
            "data" => $data,
            "total_res" => $total_res,
            "sql"=>$sql
        ];
    }


    public function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function update($data, $id)
    {
        $this->db->update($this->table, $data, array('transaction_id' => $id));
    }

    function upload_lpj($kode=null,$file=null){

        $pathlpj='./media/lpj/';
        $name=str_replace(".","_",uniqid("LPJ",true)).".pdf";
        $config = array(
        'upload_path' => $pathlpj,
        "file_name"=>$name,
        'allowed_types' => "pdf",
        'overwrite' => TRUE,
        );
        $this->load->library('upload', $config);  
            $this->upload->initialize($config);
           
            if(!$this->upload->do_upload('lpj'))  
            {  
                return array('stat'=>'fail','msg'=>'upload gagal dilakukan','data'=>$this->upload->display_errors());
            }  
            else  
            {  
                $this->update(array('lpj_file'=>$name,'lpj_date'=>date('Y-m-d')),$kode);
                return array('stat'=>'ok','msg'=>'upload berhasil','data'=>$name);
            }  
    }

    public function get_databyakun()
    {
        $fl=array();
        $server_side = $this->post['server_side'];
        parse_str($this->post['filter'], $filter);
        if ($filter['akun'] != '') {
           // $this->db->where('a.akun_induk', $filter['akun']);
            $fl['a.akun_induk']=$filter['akun'];
        }



        if ($filter['range_start'] != '') {
            $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m-%d') >=", $filter['range_start']);
            $fl["DATE_FORMAT(a.create_date,'%Y-%m-%d') >="]=$filter['range_start'];
        }

        if ($filter['range_end'] != '') {
            $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m-%d') <=", $filter['range_end']);
            $fl["DATE_FORMAT(a.create_date,'%Y-%m-%d') >="]=$filter['range_end'];
        }

        // if ($filter['range_start'] == '' && $filter['range_end'] == '') {
        //     $current_mount = date("Y-m");
        //     $this->db->where("DATE_FORMAT(a.create_date,'%Y-%m')", $current_mount);
        // }
        $filter['a.status']="active";
        $this->db->select("")
                 ->from("ukdw_transaksi t")
                 ->join("ukdw_akun a","a.akun_id=t.category_id","left")
                 ->where($fl)
                 ->order_by('create_date', 'ASC');
     
        if ($server_side == true) {
            $this->db->limit($this->post['length'], $this->post['start']);
        }
        $query = $this->db->get();
        $sql=$this->db->last_query();
        $data = $query->result_array();

        // var_dump($this->db->last_query());exit;

        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        $total_res = $query->row()->Count; //count total data

        return [
            "data" => $data,
            "total_res" => $total_res,
            "sql"=>$sql
        ];
    }


    
  
}
