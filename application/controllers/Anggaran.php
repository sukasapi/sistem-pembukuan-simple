<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['user'])){

		}else{
			redirect("login");
		}
		$this->load->model('Anggaran_m','am');
		$this->load->model('Akun_m','cm');
		
	}

	public function index()
	{
		if(isset($_POST['tahun'])&&$_POST['tahun']!=""){
			$tahun=$_POST['tahun'];
		}else{
			$tahun=date('Y');
		}
		
		$akunlist=$this->cm->get_datalist('active');

		$data[]=array();
		$data['akunlist']=$akunlist;
		$data['title']="Halaman Penganggaran";
		$this->load->view('template/header',$data);
		$this->load->view('Anggaran/v_anggaran', $data);
		$this->load->view('template/footer');
	}

	function create(){
		$result=array();
		if(isset($_POST)){
			///update all
			$filter=array('kode_akun'=>$_POST['akun'],'status'=>'1');
			$data=array('status'=>'0');
			$offOther=$this->am->update_anggaran($filter,$data);
			//insertnew
			$kodeanggaran=uniqid("AGRN",true);
			$datainput=array("kode_anggaran"=>$kodeanggaran,"kode_akun"=>$_POST['akun'],"total_anggaran"=>$_POST['anggaran'],"tahun_anggaran"=>$_POST['tahun'],"create_date"=>date('Y-m-d H:i:s'),"status"=>'1',"kode_user"=>$_POST['ukode']);
			$inputagrn=$this->am->insert_anggaran($datainput);
			if($inputagrn){
				$result = array("stat"=>"ok","msg"=>"Data berhasil dimasukkan","data"=>$kodeanggaran);	
			}else{
				$result = array("stat"=>"ok","msg"=>"gagal memasukkan data","data"=>[]);
			}
		}else{
			$result = array("stat"=>"fail","msg"=>"tidak ada data terposting","data"=>[]);
		}

		echo json_encode($result);
	}

	

	function get_dataajax(){
		if(isset($_POST['tahun']) && $_POST['tahun']!=""){
			$tahun=$_POST['tahun'];
		}else{
			$tahun=date('Y');
		}

		$filter=array("ag.tahun_anggaran"=>$tahun,"ag.status"=>'1');
		$display="ag.kode_anggaran as kode,ag.tahun_anggaran as tahun,ag.total_anggaran,ag.deskripsi_anggaran deskripsi, 
				  a.name as nama_akun,a.description as des_akun,a.tipe as tipe_akun,a.jenis as jenis_akun,u.nama_user";
		$danggaran=$this->am->get_dataBudget($display,$filter);
		
		$result=array();
		$no=1;
		$jdata=0;
		$i=0;
		foreach ($danggaran['data'] as $key) {
			$table[$i]['no']= $no;
			$table[$i]['akun']= $key['nama_akun'];
			$table[$i]['nominal']= rupiah($key['total_anggaran']);
			$table[$i]['tipe']= $key['jenis_akun']."(".$key['tipe_akun'].")";
			$table[$i]['tahun']= $key['tahun'];
			$table[$i]['deskripsi']= $key['deskripsi'];
			$table[$i]['inputby']= $key['nama_user'];
			$table[$i]['action'] = " <button type='button' class='btn btn-danger bhapus' data-token='{$key['kode']}'><i class='fa fa-trash' aria-hidden='true'></i></button> ";
			$table[$i]['action'] .= " <button type='button' class='btn btn-warning bedit' data-token='{$key['kode']}'><i class='fa fa-edit' aria-hidden='true'></i></button> ";
			$i++;
			$no++;
		}
		$datatable = [
			"data" => $table,
			"draw" => $_POST['draw'],
			"recordsTotal" =>$danggaran['total_res'],
			"recordsFiltered" =>$danggaran['total_res'],
			"sql"=>$danggaran['sql'],
			"post"=>  $_POST['tahun']
		];
		$result=$datatable;
		echo json_encode($result);
	}

	function get_databudget(){
		$result=array();
		if(isset($_POST['token']) && $_POST['token']!=""){
			$filter=array("ag.kode_anggaran"=>$_POST['token']);
			$display="ag.kode_anggaran as kode,ag.tahun_anggaran as tahun,ag.total_anggaran,ag.deskripsi_anggaran deskripsi, 
					  a.akun_id as akun,a.name as nama_akun,a.description as des_akun,a.tipe as tipe_akun,a.jenis as jenis_akun,u.nama_user";
			$danggaran=$this->am->get_dataBudget($display,$filter);
			$result=array("stat"=>"ok","msg"=>"data ditemukan","data"=>$danggaran);
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada parameter","data"=>[]);
		}
		echo json_encode($result);
	}

	function update_budget(){
		$result=array();
		if(isset($_POST['token']) && $_POST['token']!=""){
			switch($_POST['act']){
				case 'hapus':
					$filter=array("kode_anggaran"=>$_POST['token']);
					$data=array("status"=>"inactive");
					$hapus=$this->am->update_anggaran($filter,$data);
					if($hapus){
						$result=array("stat"=>"ok","msg"=>"anggaran telah dihapus","data"=>$_POST['token']);
					}else{
						$result=array("stat"=>"fail","msg"=>"anggaran gagal dihapus","data"=>$_POST['token']);
					}
				break;
				case 'update':
					$filter=array("kode_anggaran"=>$_POST['token']);
					$data=array(
								"kode_akun"=>$_POST['akun'],
								"tahun_anggaran"=>$_POST['tahun'],
								"total_anggaran"=>$_POST['nominal'],
								"deskripsi_anggaran"=>$_POST['deskripsi']
							);
					$update=$this->am->update_anggaran($filter,$data);
					if($update){
						$result=array("stat"=>"ok","msg"=>"anggaran telah diubah","data"=>$_POST['token']);
					}else{
						$result=array("stat"=>"fail","msg"=>"anggaran gagal diubah","data"=>$_POST['token']);
					}
				break;
				default:
					$result=array("stat"=>"fail","msg"=>"aktivitas tidak dikenali","data"=>$_POST['act']);
				break;
			}
		}else{
			$result=array("stat"=>"fail","msg"=>"tidak ada parameter","data"=>[]);
		}
		echo json_encode($result);
	}

}
