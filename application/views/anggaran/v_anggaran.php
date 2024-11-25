<div class="container-fluid">
   
    <div class="row">
        <div class='col-12 my-2'>
            <div class='card' style='border-radius:20px'>
                <div class="card-header">
                    <div class="card-title">
                        Data Anggaran 
                        <div class="float-right">
                            <div class="row">
                                <div class="col-6">   
                                    <select class="float-right form-control" id="stoktahun" name="stoktahun">
                                        <?php
                                        $stoktahun=stok_tahun(5);
                                            foreach($stoktahun as $st){
                                                if(isset($tahunseleksi) && $tahunseleksi!=""){
                                                    if($tahunseleksi==$st){
                                                        echo "<option selected value='".$st."'>".$st."</option>";
                                                    }else{
                                                        echo "<option value='".$st."'>".$st."</option>";
                                                    }
                                                        
                                                }else{
                                                    if(date('Y')==$st){
                                                        echo "<option selected value='".$st."'>".$st."</option>";
                                                    }else{
                                                        echo "<option value='".$st."'>".$st."</option>";
                                                    }
                                                }         
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                <button id="btambah" class="btn btn-rounded btn-primary">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="table-responsive">
                        <table clas="table table-stripe" style="width:100%" id="tbanggaran">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Akun</th>
                                    <th>Anggaran</th>
                                    <th>Tahun</th>
                                    <th>Deskripsi Akun</th>
                                    <th>Tipe Akun</th>
                                    <th>Input Oleh</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---- MODAL --> 
        <div class="modal fade" id="mdTambah" tabindex="-1" role="dialog" aria-labelledby="mdTambah" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Anggaran</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning"> * Data dengan nomor akun yang sama akan menghapus inputan sebelumnya</div>
                        <input type='hidden' name="kodeanggaran" id="kodeanggaran">
                        <div class='row my-4'>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for='akun'>Akun</label>
                                    <select name="akun" id="akun" class="form-control">
                                        <option disabled >Pilih Akun</option>
                                        <?php 
                                            foreach($akunlist as $al){
                                                echo "<option value='".$al['category_id']."'>".$al['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for='tahun'>Tahun Anggaran</label>
                                    <select name="tahunanggaran" id="tahunanggaran" class="form-control">
                                        <option disabled selected>Pilih Tahun Anggaran</option>
                                        <?php 
                                            foreach($stoktahun as $st){
                                                if(isset($tahunseleksi) && $tahunseleksi!=""){
                                                    if($tahunseleksi==$st){
                                                        echo "<option selected value='".$st."'>".$st."</option>";
                                                    }else{
                                                        echo "<option value='".$st."'>".$st."</option>";
                                                    }
                                                        
                                                }else{
                                                    if(date('Y')==$st){
                                                        echo "<option selected value='".$st."'>".$st."</option>";
                                                    }else{
                                                        echo "<option value='".$st."'>".$st."</option>";
                                                    }
                                                }         
                                            }
                                        ?>
                                    </select>
                                
                                </div> 
                            </div>
                            <div class="col-12">
                            <label for='tahun'>Anggaran</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" name='anggaran' id='anggaran' class="form-control" aria-label="Amount (to the nearest rupiah)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="bInsert" type="button">Tambah</button></div>
                </div>
            </div>
        </div>

    <!--- END MODAL -->
</div>
<script>
    $(document).ready(function(){
        var angrTable = $('#tbanggaran').DataTable( {
                    dom:'trip',
                    paging:false,
                    info:false,
                    ajax: {
                        url: '<?=base_url('anggaran/get_dataajax')?>',
                        type: 'POST',
                        data: function (d) {
                            d.tahun = $("#stoktahun").val();
                        }
                    },
                processing: true,
                serverSide: true
				} );

        $("#stoktahun").on("change",function(e){
            angrTable.ajax.reload();
        });

        $("#btambah").on('click',function(e){
            $("#mdTambah").modal('show');
        });

        angrTable.on('click', '.bedit',function(e){
            var kode=$(this).data('token');

            alert(kode); 
        })

        $('#bInsert').on('click',function(e){
            var urladd='<?=base_url('anggaran/create')?>';
                    var data=new FormData();
                    data.append("tahun",$("#tahunanggaran").val());
                    data.append("akun",$("#akun").val());
                    data.append("anggaran",$("#anggaran").val());
                    data.append("ukode",'<?=$_SESSION['ukode']?>'); 
                    $.ajax({
                            type: "POST",
                            enctype: 'multipart/form-data',
                            url: urladd, 
                            data: data,
                            processData: false,
                            contentType: false,
                            asyn:false,
                            cache: false,
                            timeout: 800000,
                            success: function (response) {
                                var resp=JSON.parse(response);
                                
                                if(resp.stat=="ok"){
                                    angrTable.ajax.reload();
                                    $("#mdTambah").modal('hide');
                                }else{
                                    alert(resp.msg);
                                }
                            }
                        })

        });


        function clearinput(){
            $("#tahunanggaran").val("");
            $("#akun").val("");
            $("#anggaran").val(""); 
        }


       
    })
</script>