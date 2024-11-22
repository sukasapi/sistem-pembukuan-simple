<?php

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
}


function stok_tahun($cap){
	$yearnow=date('Y');
	$tahunbelakang=$yearnow-$cap;
	$tahundepan=$yearnow+$cap;

	$stoktahun=array();
	for($i=$tahunbelakang;$i<=$tahundepan;$i++){
		array_push($stoktahun,$i);
	}
	return $stoktahun;
}

function stok_bulan(){
	return array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
}
?>