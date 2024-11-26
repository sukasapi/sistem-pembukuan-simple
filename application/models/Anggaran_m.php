<?php
class Anggaran_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "ukdw_anggaran as ag";
        $this->ori="ukdw_anggaran";
    }


    function get_dataBudget($display=null,$filter=null){
        if(count((array)$filter)>0){
            $this->db->select($display)
            ->from($this->table)
            ->join('ukdw_akun as a','a.akun_id=ag.kode_akun','LEFT')
            ->join('ukdw_user as u','u.id_user=ag.kode_user','LEFT')
            ->where($filter)
            ->order_by('a.name','ASC');
        }else{
            $this->db->select($display)
            ->from($this->table)
            ->join('ukdw_akun as a','a.akun_id=ag.kode_akun','LEFT')
            ->order_by('ag.name');
        }
       
        $exe=$this->db->get()->result_array();
        $syn=$this->db->last_query();
        if(count((array)$exe)>0){
            return $exe;
        }else{
            return array();
        }
    }

    function insert_anggaran($data=null){
        $exe=$this->db->insert($this->ori,$data);
        if($exe){
            return "ok";
        }else{
            return "false";
        }
    }

    function update_anggaran($filter=null,$data=null){
        $this->db->where($filter);
        $exe=$this->db->update($this->ori,$data);
        if($exe){
            return "ok";
        }else{
            return "false";
        }
    }

}
