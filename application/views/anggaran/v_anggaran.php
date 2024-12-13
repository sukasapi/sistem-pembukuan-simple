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
                                                echo "<option value='".$al['akun_id']."'>".$al['name']."</option>";
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
                            <div class="col-12">
                                <label for='desk'>Deskripsi</label>
                                <textarea class="form-control" id="desk"></textarea>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="bInsert" type="button">Tambah</button></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="mdEdit" tabindex="-1" role="dialog" aria-labelledby="mdTambah" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Anggaran</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning"> * Data dengan nomor akun yang sama akan menghapus inputan sebelumnya</div>
                        <input type='hidden' name="kodeanggaranedit" id="kodeanggaranedit">
                        <div class='row my-4'>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for='akun'>Akun</label>
                                    <select name="akunedit" id="akunedit" class="form-control">
                                        <option disabled >Pilih Akun</option>
                                        <?php 
                                            foreach($akunlist as $al){
                                                echo "<option value='".$al['akun_id']."'>".$al['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <small id="akuninfo"></small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for='tipe'>Tipe Akun</label>
                                    <input type="text" readonly class="form-control" id="infoakun">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for='tahun'>Tahun Anggaran</label>
                                    <select name="tahunanggaranedit" id="tahunanggaranedit" class="form-control">
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
                            <label for='anggaran'>Anggaran</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" name='anggaranedit' id='anggaranedit' class="form-control" aria-label="Amount (to the nearest rupiah)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-12">
                                <label for='deskEdit'>Deskripsi</label>
                                <textarea class="form-control" id="deskEdit"></textarea>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="bUpdate" type="button">Ubah</button></div>
                </div>
            </div>
        </div>

    <!--- END MODAL -->
</div>
<script>

    function init_datatable() {
        var serverSide = true;
        $('#tbanggaran').DataTable({
            serverSide: serverSide,
            destroy: true,
            searching: false,
            ordering: false,
            ajax: {
                url: '<?=base_url('anggaran/get_dataajax')?>',
                type: 'POST',
                data: function (d) {
                    d.tahun = $("#stoktahun").val();
                }
            },
            columns: [
                {
                    data: 'no',
                    title: 'No',
                },
                {
                    data: 'akun',
                    title: 'Nama Akun',
                },
                {
                    data: 'nominal',
                    title: 'Nominal',
                },
                {
                    data: 'tahun',
                    title: 'Tahun',
                },
                {
                    data: 'deskripsi',
                    title: 'Deskripsi',
                },
                {
                    data: 'tipe',
                    title: 'Tipe Akun',
                },
                {
                    data: 'inputby',
                    title: 'Input Oleh',
                },
                {
                    data: 'action',
                    title: '',
                },
            ]
        });
    }

    $("#stoktahun").on("change",function(e){
        init_datatable();
    });

    $("#btambah").on('click',function(e){
        $("#mdTambah").modal('show');
    });

    $('#tbanggaran').on('click', '.bedit',function(e){
            var kode=$(this).data('token');
            $("#kodeanggaranedit").val(kode);
            $("#mdEdit").modal("show");
            get_dtbudget(kode);
    })

    $('#tbanggaran').on('click', '.bhapus',function(e){
        var kode=$(this).data('token');
        update(kode,"hapus")
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
                                    $("#mdEdit").modal('hide');
                                }else{
                                    alert(resp.msg);
                                }
                            }
                        })

    });

    $('#bUpdate').on('click',function(e){
        var kode=$("#kodeanggaranedit").val();
        update(kode,"update");
    });


    function get_dtbudget(kode){
        var urlget='<?=base_url('anggaran/get_databudget')?>';
        var data=new FormData();
        data.append("token",kode);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: urlget, 
            data: data,
            processData: false,
            contentType: false,
            asyn:false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                var resp=JSON.parse(response);
                if(resp.stat=="ok"){
                    var data=resp.data.data[0];
                           $("#akunedit").val(data.akun);
                            $("#tahunanggaranedit").val(data.tahun);
                            $("#anggaranedit").val(data.total_anggaran);
                            $("#deskEdit").val(data.deskripsi);
                            $("#infoakun").val(data.tipe_akun+"("+data.jenis_akun+")");
                            $("#mdTambah").modal('hide');
                    }else{
                        alert(resp.msg);
                    } 
            }
        })

    }

    function update(kode,act){
        var urlupdate='<?=base_url('anggaran/update_budget')?>';
        var data=new FormData();
        data.append("token",kode);
        data.append("act",act);
        if(act=="hapus"){
            data.append("status",'inactive');
            
        }else{
            data.append("akun",$("#akunedit").val());
            data.append("tahun",$("#tahunanggaranedit").val());
            data.append("nominal",$("#anggaranedit").val());
            data.append("deskripsi",$("#deskEdit").val());
            data.append("token",kode);
        }
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: urlupdate, 
            data: data,
            processData: false,
            contentType: false,
            asyn:false,
            cache: false,
            timeout: 800000,
            success: function (response) {
                var resp=JSON.parse(response);
                    alert(resp.msg);
                    $("#mdEdit").modal('hide');
                    init_datatable();
            }
        })
    }

    function clearinput(){
            $("#tahunanggaran").val("");
            $("#akun").val("");
            $("#anggaran").val(""); 
            $("#desk").val(""); 
    }

  


    $(document).ready(function(){
        init_datatable();
    })
</script>