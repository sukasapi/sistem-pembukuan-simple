<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
		if(isset($_SESSION['user'])){

		}else{
			redirect("login");
		}
		$this->load->model("Transaction_m","tm");
        $this->load->model("Akun_m","am");
		$this->load->model("Anggaran_m","agm");

	}

	public function index()
	{	
		$tahun=date('Y');
		$data['tipe']=tipe_laporan();
		$data['title'] = "Laporan Penggunaan Anggaran";
		$this->load->view('template/header',$data);
		$this->load->view('Report/main', $data);
		$this->load->view('template/footer');  
	}


	function transaction_detail_report(){
		$akunid=$this->uri->segment(3)!=""?$this->uri->segment(3):"";
		$filter=array("status"=>"active","akun_induk=akun_id");
		$display="*";
		$akuninduk=$this->am->get_akunlist($filter,$display);
		$data['title'] = "Detail Transaksi";
		$data['idakun']=$akunid;
		$data['induk']=$akuninduk;
		$this->load->view('template/header',$data);
		$this->load->view("Report/detail");
	}

	function get_data(){
		$result=array();
		if(isset($_POST['tahun']) &&  $_POST['tahun']!=""){
			$tahun=$_POST['tahun'];
			if(isset($_POST['tipe']) && $_POST['tipe']!=""){
				$filter=array("ag.tahun_anggaran"=>$tahun,"a.tipe"=>$_POST['tipe']);
			}else{
				$filter=array("ag.tahun_anggaran"=>$tahun);
			}
		}else{
			$tahun=date('Y');
			if(isset($_POST['tipe']) && $_POST['tipe']!=""){
				$filter=array("ag.tahun_anggaran"=>$tahun,"a.tipe"=>$_POST['tipe']);
			}else{
				$filter=array("ag.tahun_anggaran"=>$tahun);
			}
		}

		$display="a.akun_id as idakun,a.name as akun,a.tipe,a.description,ag.total_anggaran as nominal";
		$dataanggaran=$this->agm->get_dataBudget($display,$filter);
		
		$dtmp=array();
		foreach($dataanggaran['data'] as $dag){
			$filter2=array("t.category_id"=>$dag['idakun'],'t.status'=>'active');
			$display_t="SUM(t.nominal) as nominal";
			$dtrans=$this->tm->get_datanom($filter2,$display_t);
			$sisa=$dag['nominal'] - $dtrans[0]["nominal"];
			$dtmp[]=array("akun"=>$dag['akun'],"idakun"=>$dag['idakun'],"deskripsi"=>$dag['description'],"anggaran"=>rupiah($dag['nominal']),"terpakai"=>rupiah($dtrans[0]['nominal']),"sisa"=>rupiah($sisa));
		}

		$no=1;
		$i=0;
		$table= [];
		foreach($dtmp as $d){
			$table[$i]['no']=$no;
			$table[$i]['akun']="<button class='btn btn-primary btn-sm bdetail' data-token='".$d['idakun']."'>".$d['akun']."</button>";
			$table[$i]['deskripsi']=$d['deskripsi'];
			$table[$i]['anggaran']=$d['anggaran'];
			$table[$i]['transaksi']=$d['terpakai'];
			$table[$i]['sisa']=$d['sisa'];
			$i++;
			$no++;
		}
		$total_data=count((array)$table);

		$datatable = [
			"data" => $table,
			"draw" => $_POST['draw'],
			"recordsTotal" =>$total_data,
			"recordsFiltered" =>$total_data,
			"filter"=>$_POST
		];
		echo json_encode($datatable);
		exit;
	}

	function get_databyakun(){
		parse_str($_POST['filter'], $filter);
		$result=$this->tm->get_databyakun();
		$i = 0;
        $table= [];
		$no=1;
		foreach ($result['data'] as $key) {
			$table[$i]['no']= $no;
			$table[$i]['akun']= $key['name'];
			$table[$i]['tanggal_transaksi']= date('d-m-Y',strtotime($key['create_date']));
			$table[$i]['deskripsi']= $key['description'];
			$table[$i]['tipe']= $key['tipe'];
			$table[$i]['tanggal_lpj']= $key['lpj_date']!=""?date('d-m-Y',strtotime($key['lpj_date'])):"-";
			$table[$i]['nominal']= rupiah($key['nominal']);
			$table[$i]['action'] = " <button type='button' class='btn uploadLPJ btn-warning' data-token='{$key['transaction_id']}'><i class='fa fa-upload' aria-hidden='true'></i></button> ";
			if($key['lpj_date']!=""){
				$table[$i]['action'] .= "<button type='button' class='btn viewLPJ btn-success' data-token='{$key['transaction_id']}'><i class='fa fa-file' aria-hidden='true'></i></button> ";
			}else{
				
			}
			$table[$i]['action'] .= "<a href='".base_url('Transaction/update/'.$key['transaction_id'])."' type='button' class='btn btn-update btn-primary'><i class='fa fa-edit' aria-hidden='true'></i></a>";
			$table[$i]['action'] .= " <button type='button' class='btn update-status btn-danger' data-id='{$key['transaction_id']}' data-status='inactive'><i class='fa fa-trash' aria-hidden='true'></i></button>";
			$i++;
			$no++;
		}
		$datatable = [
			"data" => $table,
			"draw" =>$_POST['draw'],
			"recordsTotal" =>$result['total_res'],
			"recordsFiltered" =>$result['total_res'],
			"sql"=>$result['sql'],
			"post"=>  $_POST['filter']
		];

		echo json_encode($datatable);
	
		exit;
	}

	function get_anggaran(){
		$result=array();
		if(isset($_POST['akun']) && $_POST['akun']!=""){
			if($_POST['start']==""){
				$filter=array("ag.kode_akun"=>$_POST['akun'],"ag.tahun_anggaran"=>date("Y"));
			}else{
				$tahun=date("Y",strtotime($_POST['start']));
				$filter=array("ag.kode_akun"=>$_POST['akun'],"ag.tahun_anggaran"=>$tahun);
			}
			
			$display="ag.kode_anggaran as kode,ag.tahun_anggaran as tahun,ag.total_anggaran,ag.deskripsi_anggaran deskripsi, 
					  a.akun_id as akun,a.name as nama_akun,a.description as des_akun,a.tipe as tipe_akun,a.jenis as jenis_akun,u.nama_user";
            $danggaran=$this->agm->get_dataBudget($display,$filter);
			$result=array("stat"=>"ok","msg"=>"data ditemukan","data"=>$danggaran);
		}else{
			$result=array("stat"=>"fail","msg"=>"data tidak ditemukan","data"=>$_POST);
		}
		echo json_encode($result);
		exit;
	}
	
}
