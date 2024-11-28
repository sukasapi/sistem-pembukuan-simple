<?php
class User_m extends CI_Model
{

public function __construct()
    {
        parent::__construct();
        $this->table = "ukdw_user";
        $this->post = $this->input->post();
    }


function get_data($display=null,$filter=null){
    $result=array();
    $this->db->select($display)
             ->from($this->table);
    if($filter!=""){
        $this->db->where($filter);
    }else{

    }
    $exe=$this->db->get()->result_array();
    $syn=$this->db->last_query();
    if(count((array)$exe)>0){
        $result=array("data"=>$exe,"total_res"=>count((array)$exe));
    }else{
        $result=array("data"=>[],"total_res"=>count((array)$exe));
    }

    return $result;
}

function insert_user($data=null){
    //check if exist
    $result=array();
    $filter=array("login_user"=>$data['login_user']);

    $this->db->select("*")
             ->from($this->table)
             ->where($filter)
             ->limit(1);
    $exe=$this->db->get()->result();
    $syn=$this->db->last_query();
    if(count((array)$exe) > 0){
        $result=array("stat"=>"fail","msg"=>"data username sudah digunakan. Silahkan gunakan username lain","data"=>$syn);
    }else{
        $insert=$this->db->insert($this->table,$data);
        if($insert){
            $result=array("stat"=>"ok","msg"=>"Penambahan user berhasil","data"=>$data['id_user']);
        }else{
            $result=array("stat"=>"fail","msg"=>"data username sudah digunakan. Silahkan gunakan username lain","data"=>$data['login_user']);
        }
    }

    return $result;
}

function update_user($filter=null,$data=null){
    $this->db->where($filter);
    $update=$this->db->update($this->table,$data);
    $syn=$this->db->last_query();
    if($update){
        $result=array("stat"=>"ok","msg"=>"pengubahan user berhasil","data"=>$syn);
    }else{
        $result=array("stat"=>"fail","msg"=>"Pengubahan user gagal.","data"=>$this->db->error());
    }

    return $result;
}

}
?>