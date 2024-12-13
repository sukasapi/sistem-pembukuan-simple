<div class="container-fluid">
    <div class="row my-4 p-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="data-form">
                      
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Akun</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" disabled value="<?=$detail['name']?>" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Deskripsi</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?=$detail['description']?>" name="description">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Akun Induk</label>
                            <div class="col-sm-10">
                            <select class="form-control" name="akun_induk" id="induk">
                                <option selected value="">Pilih Akun Induk</option>
                                <?php foreach ($akuninduk as $ind) :?>
                                    <?php 
                                        if($detail['akun_induk'] == $ind['akun_id']){
                                    ?>
                                        <option selected value='<?=$ind['akun_id']?>'><?=$ind['name']." (".$ind['description'].")"?></option>
                                    <?php
                                        }else{
                                    ?>
                                        <option value='<?=$ind['akun_id']?>'><?=$ind['name']." (".$ind['description'].")"?></option>
                                    <?php
                                        }
                                    ?>
                                  
                                <?php endforeach?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis</label>
                            <div class="col-sm-10">
                            <select class="form-control" name="jenis">
                                <?php foreach ($this->typeJenis as $key => $value) :?>
                                    <option value='<?=$key?>' <?=($detail['jenis']==$key?'selected':'')?>><?=$value?></option>
                                <?php endforeach?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tipe</label>
                            <div class="col-sm-10">
                            <select class="form-control" name="tipe">
                                <?php foreach ($this->typeTipe as $key => $value) :?>
                                    <option value='<?=$key?>' <?=($detail['tipe']==$key?'selected':'')?>><?=$value?></option>
                                <?php endforeach?>
                            </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer float-right">
               
                    <button type="button" onclick="save()" class="btn btn-primary">Save</button>
        
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("template/footer");?>
<script>
    $(document).ready(function() {
    });
    function save(){
        $.ajax({
            url : '<?=site_url('/Akun/process_update/'. $id);?>',
            type: "POST",
            data: {
                'data-form' :$("#data-form").serialize(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: "JSON",
            success: function(data)
            {
              window.location='<?=site_url('/Akun');?>';
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });
    }
</script>