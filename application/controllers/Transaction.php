<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$table_base = "transaction";
		$info = [
			"page_title" => ["Transaksi"],
			"nav_ids" => [$table_base],
			"table_base" => $table_base,
		];

		$this->pageInfo = $info;
		$this->post = $this->input->post();

        $this->load->model("transaction_m");
        $this->load->model("Akun_m");
	}

	public function index()
	{
		$this->pageInfo['nav_ids'][] = "transaction_list";
		$this->pageInfo['page_title'][] = "List";
		$data['title'] = "List Transaksi";
		$this->load->view('template/header',$data);
		$this->load->view("transaction/lists");
	}

	public function create()
	{
		$this->pageInfo['nav_ids'][] = "transaction_create";
        $this->pageInfo['page_title'][] = "Create";
        $data = [
            'category' => $this->Akun_m->get_datalist('active'),
        ];
		$data['title'] = "Create Transaksi";
		$this->load->view('template/header',$data);
		$this->load->view("transaction/create", $data);
    }
    
	public function update($id)
	{
		$this->pageInfo['nav_ids'][] = "{$this->pageInfo['table_base']}_list";
        $this->pageInfo['page_title'][] = "Update";
        $data = [
            'detail' => $this->transaction_m->get_detail($id),
            'id' => $id,
            'category' => $this->Akun_m->get_datalist('active'),
        ];
		$data['title'] = "Update Transaksi";
		$this->load->view('template/header',$data);
		$this->load->view("{$this->pageInfo['table_base']}/update", $data);
	}

	public function get_datatable(){
		$result = $this->transaction_m->get_data();
        $i = 0;
        $table= [];
		foreach ($result['data'] as $key) {
			$table[$i] = $key;
			$table[$i]['action'] = " <button type='button' class='btn uploadLPJ btn-warning' data-token='{$key['transaksi_id']}'><i class='fa fa-upload' aria-hidden='true'></i></button> ";
			$table[$i]['action'] .= "<a href='".site_url($this->pageInfo['table_base'].'/update/'.$key['transaksi_id'])."' type='button' class='btn btn-update btn-primary'><i class='fa fa-edit' aria-hidden='true'></i></a>";
			$table[$i]['action'] .= " <button type='button' class='btn update-status btn-danger' data-id='{$key['transaksi_id']}' data-status='inactive'><i class='fa fa-trash' aria-hidden='true'></i></button>";

			$i++;
		}
		$datatable = [
			"data" => $table,
			"draw" => $this->post['draw'],
			"recordsTotal" =>$result['total_res'],
			"recordsFiltered" =>$result['total_res'],
		];

		echo json_encode($datatable);
    }
    
    public function process_insert(){
        parse_str($this->post['data-form'], $data);
        $data['create_date'] = date("Y-m-d H:i:s");
        $process = $this->transaction_m->insert($data);
        echo json_encode($process);
    }
    public function process_update($id){
        parse_str($this->post['data-form'], $data);
        $process = $this->transaction_m->update($data,$id);
        echo json_encode($process);
    }

    public function update_status(){
        $data = [
            'status' => $this->post['status'],
        ];
        $process = $this->transaction_m->update($data,$this->post['id']);
        echo json_encode($process);
    }

	function upload_lpj(){
		$return=array();
		
		  if(isset($_FILES["lpj"]["name"]))  
           {  
			$return=$this->transaction_m->upload_lpj($_POST['kodetransaksi'],$_FILES);
           }  else{
			$return="tidak ditemukan";
		   }
		
		
		echo json_encode($return);
	}

}
