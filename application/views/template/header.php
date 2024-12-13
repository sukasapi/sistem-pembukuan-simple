<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Catatan keuangan programmer">
    <meta name="author" content="kurniafedora">

    <title> - Aplikasi Pencatatan Keuangan</title>

    <!-- Custom fonts for this template-->
    <link href="<?=site_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template-->
    <link href="<?=site_url('assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

    <link rel="stylesheet" href="<?=site_url('assets/css/dataTables.dataTables.css')?>">
    <link rel='<?=base_url('assets/css/bootstrap_datepicker.min.css')?>'>

    <script src="<?=site_url('assets/vendor/jquery/jquery.min.js')?>"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Aplikasi Pencatatan Keuangan</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?=base_url()?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <?php 
                    if($_SESSION['role']=="admin"){
            ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Master Data
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('Akun')?>">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Akun</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('User')?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            <?php
                    }else{

                    }

            ?>
         
          
            <?php 
                    if($_SESSION['role']=="admin" || $_SESSION['role']=="kasir"){
            ?>
  <hr class="sidebar-divider d-none d-md-block">
              <!-- Heading -->
              <div class="sidebar-heading">
                Transaksi
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?=base_url('anggaran')?>">
                <i class="fas fa-fw fa-cog"></i>
                    <span>Anggaran</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?=site_url('transaction')?>">Daftar Transaksi</a>
                        <a class="collapse-item" href="<?=site_url('transaction/create')?>">Tambah Transaksi</a>
                    </div>
                </div>
            </li>
            <?php
                    }else{
                        
                    }
            ?>

          

             <!-- Divider -->
             <hr class="sidebar-divider d-none d-md-block">
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menulaporan"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Laporan</span>
                </a>
                <div id="menulaporan" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?=base_url('anggaran')?>">Laporan Anggaran</a>
                        <a class="collapse-item" href="<?=base_url('transaction')?>">Laporan Transaksi</a>
                        <a class="collapse-item" href="<?=base_url('Report')?>">Laporan Penggunaan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item active">
                <a class="nav-link" href="<?=base_url('Auth/logout')?>">
                <i class="fas fa-sign-out-alt"></i>
                    <span>logout</span></a>
            </li>
                <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?=ucwords($title)?></h1>
                    </div>