<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(isadmin()){
			
		}else{
			$urlback=urlback();
			echo "<h1>Anda tidak memiliki akses ke halaman ini. Silahkan <a href='".base_url('Auth/logout')."'>login ulang</a></h1>";
		}
		$this->table_base = "ukdw_user";
		$this->page_base = "User";
		$info = [
			"page_title" => "Pengguna",
			"nav_ids" => [$this->table_base],
			"table_base" => $this->table_base,
		];

		$this->pageInfo = $info;
		$this->post = $this->input->post();

        $this->load->model("User_m");
        
        $this->Urole = [
            "admin" => "Administrator",
            "kasir" => "Kasir",
			"manager" => "Manajer",
        ];

	}

	public function index()
	{
		$this->pageInfo['nav_ids'][] = $this->page_base."_list";
		$this->pageInfo['page_title'] = "User_List";
		$data['title'] = "List Akun";
		
		$this->load->view('template/header',$data);
		$this->load->view("User/lists");
	}

	public function create()
	{
		$this->pageInfo['nav_ids'][] = $this->page_base."create";
		$this->pageInfo['page_title'][] = "Create";
		$data['title'] = "Create User";
		$this->load->view('template/header',$data);
		$this->load->view("Akun/create");
    }
    
	public function update($id)
	{
		$this->pageInfo['nav_ids'][] = $this->page_base."_list";
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
		$filter ='';
		$display="nama_user,login_user,create_date as registered,id_user as kode,role,status";
		$result = $this->User_m->get_data($display,$filter);
        $i = 0;
        $table= [];
		foreach ($result['data'] as $r) {
			$table[$i]['nama']=ucwords($r['nama_user']);
			$table[$i]['login']=ucwords($r['login_user']);
			$table[$i]['kode']=$r['kode'];
			$table[$i]['role']=$r['role'];
			$table[$i]['status']=$r['status']=="1"?"<span class='badge badge-success'>on</span>":"<span class='badge badge-secondary'>off</span>";
			$table[$i]['registered']=date('d-m-Y',strtotime($r['registered']));
			$table[$i]['action'] = "<button class='btn btn-warning btn-sm btn-rounded btnEdit' data-kode='".$r['kode']."'><i class='fas fa-edit'></i></button>";
			if($r['status']>0){
				$table[$i]['action'] .= "<button class='btn btn-secondary btn-sm btn-rounded btnHapus' data-kode='".$r['kode']."'><i class='fas fa-toggle-off'></i></button>";
			}else{
				$table[$i]['action'] .= "<button class='btn btn-success btn-sm btn-rounded btnAktif' data-kode='".$r['kode']."'><i class='fas fa-toggle-on'></i></button>";
			}
		
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
		$result=array();
        if(isset($_POST)){
			$id_user=uniqid("USR",true);
			$dateinsert=date('Y-m-d H:i:s');
			$pass=$_POST['password']!=""?$_POST['password']:"123456";
			$data=array(
						"id_user"=>$id_user,
						"nama_user"=>$_POST['nama'],
						"login_user"=>$_POST['username'],
						"pass_user"=>password_hash($pass, PASSWORD_DEFAULT),
						"role"=>$_POST['role'],
						"create_date"=>$dateinsert,
						"status"=>"1");
			$process = $this->User_m->insert_user($data);
			$result=$process;
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada data","data"=>[]);
		}
        //$process = $this->User_m->insert($data);
        echo json_encode($result);
    }

    public function process_update(){
		$result=array();
        if(isset($_POST)){
			$id_user=$_POST['kode'];
			$dateinsert=date('Y-m-d H:i:s');
			$pass=$_POST['password']!=""?$_POST['password']:"123456";
			$filter=array("id_user"=>$id_user);
			if($_POST['password']!=""){
				$data=array(
					"nama_user"=>$_POST['nama'],
					"pass_user"=>password_hash($pass, PASSWORD_DEFAULT),
					"role"=>$_POST['role']);
			}else{
				$data=array(
					"nama_user"=>$_POST['nama'],
					"role"=>$_POST['role'],
					"status"=>"1");
			}
			
			$process = $this->User_m->update_user($filter,$data);
			$result=$process;
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada data","data"=>[]);
		}
        //$process = $this->User_m->insert($data);
        echo json_encode($result);
    }

    public function update_status(){
		$result=array();
        if(isset($_POST)){
			$id_user=$_POST['kode'];
			if($_POST['status']!=""){
				$data=array(
					"status"=>$_POST['status']);
				$filter=array("id_user"=>$id_user);
				$process = $this->User_m->update_user($filter,$data);
				$result=$process;
			}else{
				$result=array("stat"=>"fail","msg"=>"status tidak tersedia","data"=>[]);
			}
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada data","data"=>[]);
		}
		
		echo json_encode($result);
    }

	function get_data(){
		$result=array();

		if(isset($_POST)){
			$filter =array("id_user"=>$_POST['kode']);
			$display="id_user as token,nama_user,login_user,role,status";
			$getdata = $this->User_m->get_data($display,$filter);
			$result=array("stat"=>"ok","msg"=>"data ditemukan","data"=>$getdata["data"]);
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada data","data"=>[]);
		}
	
		echo json_encode($result);
	}

}
