<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['user'])){

		}else{
			redirect("login");
		}
		$table_base = "ukdw_akun";
		$page_base = "Akun";
		$info = [
			"page_title" => ["Kategori"],
			"nav_ids" => [$table_base],
			"table_base" => $table_base,
		];

		$this->pageInfo = $info;
		$this->post = $this->input->post();

        $this->load->model("Akun_m");
        
        $this->typeJenis = [
            "in" => "Pemasukan",
            "out" => "Pengeluaran",
        ];

		$this->typeTipe = [
            "program" => "Program",
            "rutin" => "Rutin",
        ];
	}

	public function index()
	{
		$this->pageInfo['nav_ids'][] = "Akun_list";
		$this->pageInfo['page_title'][] = "List";
		$data['title'] = "List Akun";
		$this->load->view('template/header',$data);
		$this->load->view("Akun/lists");
	}

	public function create()
	{
		$this->pageInfo['nav_ids'][] = "Akun_create";
		$this->pageInfo['page_title'][] = "Create";
		$data['title'] = "Create Kategori";
		$this->load->view('template/header',$data);
		$this->load->view("Akun/create");
    }
    
	public function update($id)
	{
		$this->pageInfo['nav_ids'][] = "Akun_list";
        $this->pageInfo['page_title'][] = "Update";
        $data = [
            'detail' => $this->Akun_m->get_detail($id),
            'id' => $id,
        ];
		$data['title'] = "Buat Akun";
		$this->load->view('template/header',$data);
		$this->load->view("Akun/update", $data);
	}

	public function get_datatable(){	
		$result = $this->Akun_m->get_data();
        $i = 0;
        $table= [];
		foreach ($result['data'] as $key) {
			$table[$i]['nama']=$key['name'];
			$table[$i]['description']=ucwords($key['description']);
			$table[$i]['jenis']=$key['jenis']=="in"?"pemasukan":"pengeluaran";
			$table[$i]['tipe']=$key['tipe'];
			$table[$i]['action'] = "<a href='".site_url('akun/update/'.$key['akun_id'])."' type='button' class='btn btn-update btn-primary'>Update</a>";
			$table[$i]['action'] .= " <button type='button' class='btn update-status btn-danger' data-id=".site_url('akun/update/'.$key['akun_id'])." data-status='inactive'>Delete</button>";

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
        $process = $this->Akun_m->insert($data);
        echo json_encode($process);
    }
    public function process_update($id){
        parse_str($this->post['data-form'], $data);
        $process = $this->Akun_m->update($data,$id);
        echo json_encode($process);
    }

    public function update_status(){
        $data = [
            'status' => $this->post['status'],
        ];
        $process = $this->Akun_m->update($data,$this->post['id']);
        echo json_encode($process);
    }

}
