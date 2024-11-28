<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
	{
		parent::__construct();
        $this->table_base = "ukdw_user";
		$this->page_base = "User";
        $this->load->model("User_m");
    }
     
	public function index()
	{
	
	}

    public function login(){
        $pesan="";
        if(isset($_POST['username']) || isset($_POST['pswd'])){
            if($_POST['username']!="" && $_POST['pswd']!=""){
                $filter=array("login_user"=>$_POST['username'],"status"=>"1");
                $display="id_user,login_user,nama_user,role,status,pass_user";
                $pass=$_POST['pswd'];
                $cekuser=$this->User_m->get_data($display,$filter);
                if(count((array)$cekuser['data'])> 0){
                    $cek=password_verify($pass, $cekuser['data'][0]['pass_user']);
                    if($cek){
                        $datauser=array("user"=>$cekuser['data'][0]['login_user'],"nama"=>$cekuser['data'][0]['nama_user'],"role"=>$cekuser['data'][0]['role'],"logat"=>date('Y-m-d H:i:s'),"ukode"=>"USR674068090fd396.43485430");
                        $this->session->set_userdata($datauser);
                        redirect('home');
                       
                    }else{
                        $pesan="Username tidak ditemukan";
                        $data['pesan']="Pastikan anda telah menginput nama dan password dengan benar";
                        $this->load->view('template/header_login');
                        $this->load->view('Auth/v_login',$data);
                    }
                  
                }else{
                $pesan="Username tidak ditemukan atau tidak aktif";
                $data['pesan']=$pesan;
                $this->load->view('template/header_login');
                $this->load->view('Auth/v_login',$data);
                }
            }else{
                $pesan="Pastikan anda telah menginput nama dan password";
                $data['pesan']=$pesan;
                $this->load->view('template/header_login');
                $this->load->view('Auth/v_login',$data);
            }
        }else{
          
            $this->load->view('template/header_login');
            $this->load->view('Auth/v_login');
        }
      
    }


    public function logout(){
        session_destroy();
        redirect('login');
    }
}
