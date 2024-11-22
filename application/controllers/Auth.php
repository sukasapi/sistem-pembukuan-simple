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
	public function index()
	{
	
	}

    public function login(){
        $pesan="";
       
        if(isset($_POST['username']) || isset($_POST['pswd'])){
            if($_POST['username']!="" && $_POST['pswd']!=""){
                $us='admin';
                $ps='123456';
                if($_POST['username']==$us && $_POST['pswd']==$ps){
                    $datauser=array("user"=>$us,"role"=>"admin","logat"=>date('Y-m-d H:i:s'),"ukode"=>"USR674068090fd396.43485430");
                    $this->session->set_userdata($datauser);
                    redirect('home');
                }else{
                $pesan="Username atau password anda salah";
                $data['pesan']="Pastikan anda telah menginput nama dan password dengan benar";
                $this->load->view('template/header_login');
                $this->load->view('Auth/v_login',$data);
                $this->load->view('template/footer');
                }
            }else{
                $pesan="Pastikan anda telah menginput nama dan password";
                $data['pesan']="Pastikan anda telah menginput nama dan password";
                $this->load->view('template/header_login');
                $this->load->view('Auth/v_login',$data);
                $this->load->view('template/footer');
            }
        }else{
          
            $this->load->view('template/header_login');
            $this->load->view('Auth/v_login');
            $this->load->view('template/footer');
        }
      
    }


    public function logout(){
        session_destroy();
        redirect('login');
    }
}
