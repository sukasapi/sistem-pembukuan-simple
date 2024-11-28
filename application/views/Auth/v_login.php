<style>
    .stickyfooter{
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px; /* Set the fixed height of the footer here */
        line-height: 60px; /* Vertically center the text there */
        background-color: #f5f5f5;
    }
</style>
<body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <?php 
                                            if(isset($pesan) && $pesan!=""){
                                                echo "<div class='alert alert-info'>".$pesan."</div>";
                                            }else{

                                            }
                                        ?>
                                        <!-- Login form-->
                                        <form action='<?=base_url('Auth/login')?>' method="POST" enctype='multipart/form-data'>
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="username">Username</label>
                                                <input class="form-control" name="username" id="username" type="text" placeholder="Masukkan Nama User">
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="pswd">Password</label>
                                                <input class="form-control" id="pswd" name="pswd" type="pswd" placeholder="Masukkan kata Kunci">
                                            </div>
                                           
                                            <!-- Form Group (login box)-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <input type="submit" class="btn btn-primary" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
            <footer class="stickyfooter mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright © sukasapi 2024</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="<?=base_url('assets/')?>js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src='<?=base_url('assets/')?>js/scripts.js'></script>

        <script src="<?=base_url('assets/')?>js/sb-customizer.js"></script>
   
</body>