<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Anggaran_m','am');
		$this->load->model('Category_m','cm');
		
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
		$this->load->view('anggaran/v_anggaran', $data);
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

	function update(){

	}

	function get_data(){

	}

	function get_dataajax(){
		if(isset($_POST['tahun']) && $_POST['tahun']!=""){
			$tahun=$_POST['tahun'];
		}else{
			$tahun=date('Y');
		}

		$filter=array("ag.tahun_anggaran"=>$tahun,"ag.status"=>'1');
		$display="ag.kode_anggaran as kode,ag.tahun_anggaran as tahun,ag.total_anggaran, a.name as nama_akun,a.description as des_akun,a.type as tipe_akun,u.nama_user";
		$danggaran=$this->am->get_dataBudget($display,$filter);
		
		$result=array();
		$no=1;
		$jdata=0;
		if(count((array)$danggaran) > 0){
			foreach($danggaran as $da){
				$row=array();
				$row[]=$no;
				$row[]=$da['nama_akun'];
				$row[]=rupiah($da['total_anggaran']);
				//$row[]="<button class='btn btn-sm btn-rounded btn-warning bedit' data-token='".$da['kode']."'>edit</button>";$da['kode'];
				$row[]=$da['tahun'];
				$row[]=$da['des_akun'];
				$row[]=$da['tipe_akun'];
				$row[]=$da['nama_user'];
				
				$result[]=$row;
				$no++;
			}
			$jdata=count((array)$da);
		}else{

		}
		$output=array("recordsTotal" =>$jdata,
		"draw"=>$_POST['draw'],
		"data" => $result);

		echo json_encode($output);
	}

}
